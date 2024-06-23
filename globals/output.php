<?php

declare(strict_types=1);

namespace zzt\globals\output;

use zzt\Core\Application;
use zzt\Http;

function template(string $template, array $params = []): Http\Response
{
  $body = Application::getInstance()->template->renderToString($template, $params);
  return Http\Response::new($body);
}

function json(): string
{
  return '';
}
