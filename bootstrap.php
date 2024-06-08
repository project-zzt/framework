<?php

use zzt\Core\Application;

function run(array $config, array $modules)
{
  $app = Application::init($config, $modules);
  $app->fromGlobals();
}
