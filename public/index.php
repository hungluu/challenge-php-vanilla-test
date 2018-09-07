<?php
// Init composer autoloader
require __DIR__ . '/../vendor/autoload.php';

use app\common\App;
use app\common\components\Router;
use app\schedule\ScheduleModule;

try {
  // Load dot env config
  $env = new Dotenv\Dotenv(__DIR__ . '/../config');
  $env->load();

  if (getenv('DEBUG')) {
    // Debug on
    ini_set( 'display_errors', 1 );
    ini_set( 'error_reporting', E_ALL );
  }

  // Build params
  $servers = filter_var_array($_SERVER, FILTER_SANITIZE_STRING);
  $method = isset($servers['REQUEST_METHOD'])
    ? filter_var($servers['REQUEST_METHOD'], FILTER_UNSAFE_RAW)
    : 'GET';
  $contentType = isset($servers['HTTP_CONTENT_TYPE'])
    ? filter_var($servers['HTTP_CONTENT_TYPE'], FILTER_UNSAFE_RAW)
    : 'text/plain';
  if ($method === 'GET') {
    $params = filter_input_array(INPUT_GET, FILTER_UNSAFE_RAW);
  } elseif ($contentType === 'application/json') {
    $params = filter_var_array(json_decode(file_get_contents('php://input'), true), FILTER_UNSAFE_RAW);
  } else {
    $params = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW );
  }
  $params = $params ? $params : [];
  $full_uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING);
  $uri = explode('?', $full_uri)[0];
  $server_protocal = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL', FILTER_SANITIZE_STRING);

  // Init router
  $router = new Router();
  $router->initRoutes([
    '/' => new ScheduleModule()
  ]);

  // Init App
  $app = App::instance();
  $app->addComponent('router', $router);
  
  $app->router->resolve($uri, $method, $params, $servers);
} catch (Exception $ex) {
  header($server_protocal . ' 500 Internal Server Error', true, 500);
}
