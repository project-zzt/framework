<?php

declare(strict_types=1);

namespace zzt\Core;

use Exception;
use zzt\Exception\RouterException;
use zzt\globals\router\Type;

class Router
{
  private static $instance;

  private $routes = [
    'GET' => [],
    'POST' => []
  ];

  private function __construct()
  {
  }

  public static function getInstance(): Router
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function add(Type $type, string $route, string $callback, string $moduleName = ''): void
  {
    if (!array_key_exists($type->name, $this->routes)) {
      throw new RouterException('Http type not supported: ' . $type->name);
    }
    if (empty($moduleName)) {

    }
    $app = Application::getInstance();
    $config = $app->config;
    $currentModule = $app->getCurrentModule();
    $fullPath = $config->basePath . '/' . $config->modulesFolder . '/' . $currentModule . '/' . $callback;
    if (! $callbackPath = realpath($fullPath)) {
      throw new Exception('Path to module not found...' . $fullPath);
    }

    $this->routes[$type->name][$route] = [
      'callback' => $callbackPath,
      'module' => $currentModule,
    ];
  }

  public function get(Type $type, string $route): ?string
  {
    return $this->routes[$type->name][$route]['callback'];
  }
}
