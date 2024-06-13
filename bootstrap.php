<?php

use zzt\Core\Application;

<<<<<<< HEAD
use function zzt\web\init;

init();
=======
function run(array $config, array $modules)
{
  $app = Application::init($config, $modules);
  $app->run();
}
>>>>>>> 59183569d48757b04822acf7fe6b0d25bd17f626
