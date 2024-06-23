<?php

declare(strict_types=1);

namespace zzt\globals\render;

use zzt\Core\Application;

function output(string $template, array $params = []): string
{
  return Application::getInstance()->template->renderToString($template, $params);
}
