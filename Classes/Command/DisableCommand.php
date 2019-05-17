<?php

namespace SourceBroker\Installtool\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Install\Service\EnableFileService;

class DisableCommand extends Command
{
    protected function configure()
    {
        $this->setDescription('Lock Install Tool');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        EnableFileService::removeInstallToolEnableFile();
    }
}
