<?php

declare(strict_types=1);

namespace zzt\Core;

use zzt\Http\Request;
use zzt\router;
use Latte;

final readonly class Application
{
  private function __construct(private array $config, private array $modules)
  {
    foreach ($modules as $module) {
      require $module;
    }

    $this->initTemplateEngine();
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
      echo $route($request);
    }
  }

  private function initTemplateEngine(): void
  {
    $latte = new Latte\Engine;
    $latte->setTempDirectory($this->config['base']['cache']['template_dir']);
  }
}
