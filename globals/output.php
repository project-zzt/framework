<?php

declare(strict_types=1);

namespace zzt\globals\output;

use zzt\Core\Application;
use zzt\Http;

/**
* Create template response.
*
* @param string $template Template name
* @param mixed[] $params Template parameters
* @return Http\Response
*/
function template(string $template, array $params = []): Http\Response
{
  $body = Application::getInstance()->template->renderToString($template, $params);
  return Http\Response::new($body);
}

/**
* Create json response.
*
* @return Http\Response
*/
function json(): string
{
  return '';
}
