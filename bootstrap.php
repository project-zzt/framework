<?php
/**
 * Bootstrap the request - response lifecycle.
 * This should get required last in the public/index.php
 *
 * REQUIRES: $config & $modules arry to be present
 */

use zzt\Chirphp\ChirpConfig;
use zzt\Chirphp\Chirphp;
use zzt\Http;
use zzt\Core\Application;
use zzt\globals\router;

// Initialize Chirper
if (ZZT_ENV === 'dev') $chirphp = Chirphp::new(new ChirpConfig()); //TODO: The 'real' ChirpConfig is needed somehow
chirp("zzt booting ...", ChirpColor::BLUE);

// Initialize template engine
$template = new Latte\Engine;
$template->setTempDirectory($config['base']['cache']['template_dir']);
$template->setLoader(new Latte\Loaders\FileLoader($config['base_path']));
// Auto refresh in dev mode 
ZZT_ENV === 'dev' ? $template->setAutoRefresh(true) : $template->setAutoRefresh(false);
// Base template paths
define('ZZT_BASE_TEMPLATE', "../../../templates/base.latte");

// Initialize app
$app = Application::init($config, $modules, $template);

// Initialize request
$request = Http\Request::fromGlobals();
// Get handler based on route
$handler = router\find($request);
$handler = require $handler;
// Get response from handler
$response = $handler($request);
// Build response
http_response_code($response->status);
foreach ($response->headers as $name => $value) {
  header("$name: $value");
}
echo $response->body;
