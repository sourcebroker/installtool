<?php

namespace SourceBroker\Installtool\Command;

use Helhum\Typo3Console\Mvc\Cli\Symfony\Input\ArgvInput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Service\EnableFileService;

class EnableCommand extends Command
{
    protected function configure()
    {
        $this->setDescription('Unlock the Install Tool and generate random password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $password = md5(uniqid() . time());

        EnableFileService::createInstallToolEnableFile();

        if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) < 9005000) {
            $saltFactory = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance(null, 'BE');
            $hashedPassword = $saltFactory->getHashedPassword($password);
        } else {
            $hashInstance = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory::class)->getDefaultHashInstance('BE');
            $hashedPassword = $hashInstance->getHashedPassword($password);
        }

        $arguments = [
            '',
            'configuration:set',
            'BE/installToolPassword',
            $hashedPassword
        ];

        $command = $this->getApplication()->find($arguments[1]);
        $input = new ArgvInput($arguments);
        $command->run($input, $output);

        $output->writeln($password);
    }
}
