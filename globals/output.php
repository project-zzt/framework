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
  $app = Application::getInstance();
  $viewFolder = $app->config->viewsFolder;
  $moduleFolder = $app->config->modulesFolder;
  $templatePath = $moduleFolder . '/home/' . $viewFolder . '/' . $template;

  $params['ZZT_BASE_TEMPLATE'] = ZZT_BASE_TEMPLATE;
  $params['IS_DEV'] = ZZT_ENV === 'dev';
  $params['IS_DEBUG'] = ZZT_DEBUG;

  $body = Application::getInstance()->template->renderToString($templatePath, $params);
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
