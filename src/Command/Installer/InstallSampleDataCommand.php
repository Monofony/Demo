<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Command\Installer;

use App\Command\Helper\CommandsRunner;
use App\Command\Helper\DirectoryChecker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

final class InstallSampleDataCommand extends Command
{
    protected static $defaultName = 'app:install:sample-data';

    public function __construct(
        private DirectoryChecker $directoryChecker,
        private CommandsRunner $commandsRunner,
        private string $publicDir,
        private string $environment
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Install sample data into Monofony.')
            ->setHelp(
                <<<EOT
The <info>%command.name%</info> command loads the sample data for Monofony.
EOT
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        $outputStyle = new SymfonyStyle($input, $output);
        $outputStyle->newLine();
        $outputStyle->writeln(sprintf(
            'Loading sample data for environment <info>%s</info>.',
            $this->environment
        ));

        $outputStyle->writeln('<error>Warning! This action will erase your database.</error>');

        if (!$questionHelper->ask($input, $output, new ConfirmationQuestion('Continue? (y/N) ', false))) {
            $outputStyle->writeln('Cancelled loading sample data.');

            return 0;
        }

        try {
            $this->directoryChecker->ensureDirectoryExistsAndIsWritable($this->publicDir.'/media/', $output, $this->getName());
            $this->directoryChecker->ensureDirectoryExistsAndIsWritable($this->publicDir.'/media/image/', $output, $this->getName());
        } catch (\RuntimeException $exception) {
            $outputStyle->writeln($exception->getMessage());

            return 1;
        }

        $commands = [
            'sylius:fixtures:load' => ['--no-interaction' => true],
        ];

        $this->commandsRunner->run($commands, $input, $output, $this->getApplication());
        $outputStyle->newLine(2);

        return 0;
    }
}
