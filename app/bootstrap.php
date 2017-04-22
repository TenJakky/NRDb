<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

$configurator->setDebugMode(TRUE);
$configurator->enableDebugger(__DIR__ . '/../log');
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();
$configurator->addConfig(__DIR__ . '/config/config.neon');

\Nette\Forms\Rules::$defaultMessages[\Nette\Application\UI\Form::FILLED] = "%label is required.";

return $configurator->createContainer();
