<?php

declare(strict_types=1);

namespace zzt\Core;

use Exception;
use zzt\Http\Request;
use zzt\globals\router;
use Latte;

final class Application
{
  private static Application $instance;
  public readonly Latte\Engine $template;

  private function __construct(private readonly array $config, private readonly array $modules)
  {
    // Initialize modules
    foreach ($modules as $module) {
      require $module;
    }

    // Initialize template engine
    $this->template = new Latte\Engine;
    $this->template->setTempDirectory($this->config['base']['cache']['template_dir']);
  }

  public static function getInstance(): self
  {
    if (self::$instance === null) {
      throw new Exception("Application not initialized. Something went wrong on bootstrap.");
    }
    return self::$instance;
  }

  public static function init(array $config, array $modules): self
  {
    self::$instance = new self($config, $modules);
    return self::$instance;
  }

  public function run(): void
  {
    //$method = $_SERVER['REQUEST_METHOD'];
    $request = Request::fromGlobals();

    if ($route = router\find($request)) {
      echo $route($request);
    }
  }
}
