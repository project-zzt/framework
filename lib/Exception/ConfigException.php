<?php

declare(strict_types=1);

namespace zzt\Exception;

/**
 * Config parameter exception
 *
 * @author Cristian Cornea <contact@corneascorner.dev>
 */
class ConfigException extends \Exception
{
  private string $output = 'Looks like a config is not set up correctly. [Param: %s]';

  public function __construct(string $paramName)
  {
    $this->message = sprintf($this->output, $paramName);
  }
}
