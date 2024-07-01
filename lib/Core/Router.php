<?php

declare(strict_types=1);

namespace zzt\Core;

use Exception;
use zzt\Exception\RouterException;
use zzt\globals\router\Type;

/**
 * Http router
 *
 * @author Cristian Cornea <contact@corneascorner.dev>
 */
class Router
{
  private static $instance;

  private $routes = [
    'GET' => [],
    'POST' => [],
    'DELETE' => [],
    'PUT' => [],
    'PATCH' => [],
  ];
  
  /**
  * Returns the router instance
  *
  * @return self
  */
  public static function getInstance(): self
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
  * Add an http route
  *
  * @param Type $type The http request type
  * @param string $route Name of the route
  * @param string $handler Name of the handler file with the callback function
  * @param string $module Optional module name (the framework knows how to find it on its own during bootsrap)
  * @return void
  */
  public function add(Type $type, string $route, string $handler, string $module= ''): void
  {
    if (!array_key_exists($type->name, $this->routes)) {
      throw new RouterException('Http type not supported: ' . $type->name);
    }

    $app = Application::getInstance();
    if (empty($module)) {
      $module = $app->getCurrentModule();
    }

    $config = $app->config;
    $fullPath = $config->basePath . '/' . $config->modulesFolder . '/' . $module . '/' . $handler;
    if (! $callbackPath = realpath($fullPath)) {
      throw new Exception('Path to module not found...' . $fullPath);
    }

    $this->routes[$type->name][$route] = [
      'callback' => $callbackPath,
      'module' => $module,
    ];
  }

  /**
  * Returns the callback path or null
  *
  * @param Type $type Http request type
  * @param string $route Name of the request route
  * @return string|null
  */
  public function get(Type $type, string $route): ?string
  {
    return $this->routes[$type->name][$route]['callback'];
  }
}
