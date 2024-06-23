<?php

declare(strict_types=1);

namespace zzt\Core;

use Exception;
<<<<<<< HEAD
use zzt\Http;
=======
use zzt\Http\Request;
>>>>>>> b85ec4f353f5780cf1e10d84b071d752465de664
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
<<<<<<< HEAD
    $this->template->setLoader(new Latte\Loaders\FileLoader($this->config['base']['template_dir']));

   // Auto refresh in dev mode 
    ZZT_ENV === 'dev' ? $this->template->setAutoRefresh(true) : $this->template->setAutoRefresh(false);
=======
>>>>>>> b85ec4f353f5780cf1e10d84b071d752465de664
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
    $request = Http\Request::fromGlobals();

    if ($route = router\find($request)) {
      $response = $route($request);
    }
<<<<<<< HEAD
  
    /* @var Http\Response $response */
    http_response_code($response->status);
    foreach ($response->headers as $name => $value) {
      header("$name: $value");
    }
    echo $response->body;
=======
>>>>>>> b85ec4f353f5780cf1e10d84b071d752465de664
  }
}
