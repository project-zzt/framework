<?php

declare(strict_types=1);

namespace zzt\globals\tools;

use zzt\Exception\ConfigException;

function build_module_path(array $config): array
{
  $basePath = $config['base_path'] ?? throw new ConfigException('base_path');
  $moduleDir = $config['base']['module_dir'] ?? throw new ConfigException('module_dir');

  $folders = scandir($basePath . '/' . $moduleDir);

  $result = [];
  foreach ($folders as $folder) {
    if ($folder === '.' || $folder === '..')
      continue;

    $result[$folder] = $basePath . '/' . $moduleDir . '/' . $folder . '/module.php';
  }

  return $result;
}