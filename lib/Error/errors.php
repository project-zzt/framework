<?php

declare(strict_types=1);

namespace zzt;

class ConfigError extends \Exception
{
  private string $output = 'Looks like a config is not set up correctly. [Param: %s]';

  public function __construct(string $config)
  {
    $this->message = sprintf($this->output, $config);
  }
}