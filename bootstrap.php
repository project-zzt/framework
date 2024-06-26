<?php

use zzt\Core\Application;

function run(array $config, array $modules)
{
  chirp("zzt booting ...");

  $app = Application::init($config, $modules);
  $app->run();
}
