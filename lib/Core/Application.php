<?php

declare(strict_types=1);

namespace zzt\Core;

use zzt\Http\Request;
use zzt\router;

final readonly class Application
{
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

  public function run(): void
  {
    //$method = $_SERVER['REQUEST_METHOD'];
    $request = Request::fromGlobals();

    if ($route = router\find($request)) {
      $route($request);
    }
  }
}
