#!/usr/bin/env php
<?php

namespace console;

require __DIR__ . '/dcr/bootstrap/init.php';

use Symfony\Component\Console\Application;
use dcr\Console;

$inputs = $argv;
$command = $inputs[1];
$className = Console::_consoleNameToClassName($command);

$className = "app\\Console\\{$className}";
$application = new Application();
$application->add(new $className());
$application->run();