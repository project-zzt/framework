<?php

// require __DIR__ . "/core/application.php";
require __DIR__ . '/vendor/autoload.php';

use zzt\Core\Application;

function run(array $config, array $modules)
{
  $app = Application::init($config, $modules);
  $app->fromGlobals();
}