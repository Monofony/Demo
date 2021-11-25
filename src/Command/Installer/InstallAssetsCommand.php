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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallAssetsCommand extends Command
{
    protected static $defaultName = 'app:install:assets';

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
        $this->setDescription('Installs all Monofony assets.')
            ->setHelp(
                <<<EOT
The <info>%command.name%</info> command downloads and installs all Monofony media assets.
EOT
            )
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(sprintf('Installing Monofony assets for environment <info>%s</info>.', $this->environment));

        try {
            $this->directoryChecker->ensureDirectoryExistsAndIsWritable($this->publicDir.'/assets/', $output, $this->getName());
            $this->directoryChecker->ensureDirectoryExistsAndIsWritable($this->publicDir.'/bundles/', $output, $this->getName());
        } catch (\RuntimeException $exception) {
            return 1;
        }

        $commands = [
            'assets:install',
        ];

        $this->commandsRunner->run($commands, $input, $output, $this->getApplication());

        return 0;
    }
}
