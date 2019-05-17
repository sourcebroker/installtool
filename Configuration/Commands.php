<?php
/**
 * Commands to be executed by typo3, where the key of the array
 * is the name of the command (to be called as the first argument after typo3).
 * Required parameter is the "class" of the command which needs to be a subclass
 * of Symfony/Console/Command.
 */
return [
    'installtool:enable' => [
        'class' => \SourceBroker\Installtool\Command\EnableCommand::class
    ],
    'installtool:disable' => [
        'class' => \SourceBroker\Installtool\Command\DisableCommand::class
    ]
];
