<?php

/*
 * This file is part of the Monofony demo project.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Command\Installer;

use App\Command\Helper\CommandsRunner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InstallAssetsCommand extends Command
{
    protected static $defaultName = 'app:install:assets';

    public function __construct(
        private CommandsRunner $commandsRunner,
        private string $environment,
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setDescription('Installs all AppName assets.')
            ->setHelp(
                <<<EOT
The <info>%command.name%</info> command downloads and installs all AppName media assets.
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
        $io = new SymfonyStyle($input, $output);
        $io->title(sprintf('Installing AppName assets for environment <info>%s</info>.', $this->environment));

        $commands = [
            'assets:install',
        ];

        $this->commandsRunner->run($commands, $input, $output, $this->getApplication());

        return 0;
    }
}
