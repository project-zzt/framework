<?php

declare(strict_types=1);

namespace zzt\Core;

use zzt\router;

final readonly class Application
{
  private array $routes;

  private function __construct(private array $config, private array $modules)
  {
    foreach ($modules as $module) {
      require $module;
    }
  }

  public static function init(array $config, array $modules): self
  {
    return new self($config, $modules);
  }

  public function fromGlobals(): void
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $path = $_SERVER['PATH_INFO'] ?? '/';

    if ($route = router\find(router\Type::GET, $path)) {
      $route();
    }
  }

  private function registerRoutes(): void
  {

  }
}