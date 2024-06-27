<?php

declare(strict_types=1);

namespace zzt\Core;

use Exception;
use zzt\Http;
use zzt\globals\router;
use Latte;

final class Application
{
  private static Application $instance;
  public readonly Latte\Engine $template;

  private function __construct(private readonly array $config)
  {
  }

  public static function getInstance(): self
  {
    if (self::$instance === null) {
      throw new Exception("Application not initialized. Something went wrong on bootstrap.");
    }
    return self::$instance;
  }

  public static function init(array $config): self
  {
    if (self::$instance !== null) {
      throw new Exception("Application already initialized. Something went wrong.");
    }

    self::$instance = new self($config);
    return self::$instance;
  }
}
