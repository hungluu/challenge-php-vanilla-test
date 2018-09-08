<?php
// Init composer autoloader
require __DIR__ . '/../vendor/autoload.php';

use app\common\App;
use app\common\components\Router;
use app\schedule\ScheduleModule;
use app\common\db\Connection;

try {
  // Load dot env config
  $env = new Dotenv\Dotenv(__DIR__ . '/../config');
  $env->load();

  if (getenv('DEBUG') === 'true') {
    // Debug on
    ini_set( 'display_errors', 1 );
    ini_set( 'error_reporting', E_ALL );
  }

  // TODO: Implement into Request
  // Build params
  $servers = filter_var_array($_SERVER, FILTER_SANITIZE_STRING);
  $method = isset($servers['REQUEST_METHOD'])
    ? filter_var($servers['REQUEST_METHOD'], FILTER_UNSAFE_RAW)
    : 'GET';
  $contentType = isset($servers['HTTP_CONTENT_TYPE'])
    ? filter_var($servers['HTTP_CONTENT_TYPE'], FILTER_UNSAFE_RAW)
    : 'text/plain';
  $json_mime_types = ['application/vnd.api+json', 'application/json'];
  $is_json_request = false;
  foreach ($json_mime_types as $mime_type) {
    if (strpos($contentType, $mime_type) !== false) {
      $is_json_request = true;
      break;
    } elseif (strpos($contentType, $mime_type) !== false) {
      $is_json_request = true;
      break;
    }
  }
  if ($method === 'GET') {
    $params = filter_input_array(INPUT_GET, FILTER_UNSAFE_RAW);
  } elseif ($is_json_request) {
    $params = filter_var_array(json_decode(file_get_contents('php://input'), true), FILTER_UNSAFE_RAW);
  } else {
    $params = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW );
  }
  $params = $params ? $params : [];
  $full_uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING);
  $uri = explode('?', $full_uri)[0];
  $server_protocal = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL', FILTER_SANITIZE_STRING);

  // Init App
  $app = App::instance();
  
  // TODO: Implment into App::run
  // Init router
  $router = new Router();
  $router->initRoutes([
    '/' => new ScheduleModule()
  ]);
  $app->addComponent('router', $router);
  
  // Init db
  $db = new Connection([
    'host' => 'db',
    'username' => 'postgres',
    'password' => 'admin',
    'database' => 'test'
  ]);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $app->addComponent('db', $db);
  
  $app->router->resolve($uri, $method, $params, $servers);
} catch (PDOException $ex) {
  header($server_protocal . ' 500 Internal Server Error', true, 500);
} catch (Exception $ex) {
  header($server_protocal . ' 500 Internal Server Error', true, 500);
}
