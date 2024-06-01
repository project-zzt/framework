<?php

declare(strict_types=1);

namespace zzt\tools;

use zzt\ConfigError;

function build_module_path(array $config): array
{
  // $basePath = $config['base_path'] ?? throw new ConfigError('base_path');
  $basePath = $config['base_path'];
  // $modulePath = $config['module_path'] ?? throw new ConfigError('module_path');
  $moduleFolder = $config['base']['modules_folder'];

  $folders = scandir($basePath . '/' . $moduleFolder);

  $result = [];
  foreach ($folders as $folder) {
    if ($folder === '.' || $folder === '..')
      continue;

    $result[$folder] = $basePath . '/' . $moduleFolder . '/' . $folder . '/module.php';
  }

  return $result;
}