<?php
namespace app\common\base;

use app\common\interfaces\ControllerInterface;
use app\common\interfaces\RequestInterface;
use app\common\interfaces\ResponseInterface;
use Exception;

/**
 * Class BaseModule
 * 
 * @package app\common\base
 * @method string getPath(string $sub_path) get module path
 */
abstract class BaseModule extends BaseComponent {
  /**
   * Resolve controller by path
   * @param string $controller_path controller path
   * @return array
   */
  public function resolveController (string $controller_path) {
    $base_path = dirname($this->getPath('controllers/' . $controller_path));
    $controller_class_name = ucfirst(basename($controller_path)) . 'Controller';
    $controller_file_path = $base_path . '/' . $controller_class_name . '.php';
    $controller_sub_path = '\\';
    if (strpos($controller_path, '/') !== false) {
      $controller_sub_path = '\\' . str_replace('/', '\\', dirname($controller_path)) . '\\';
    }
    $module_class_name = $this->getClassName();
    $module_namespace = preg_replace('/\\\\\w+$/', '', $module_class_name);
    $controller_class_path = $module_namespace . '\\controllers' . $controller_sub_path . $controller_class_name;
    
    return [
      'path' => $controller_file_path,
      'className' => $controller_class_path
    ];
  }

  /**
   * @param string $view_path view path
   * @return array resolved view
   */
  public function resolveView (string $view_path) {
    $view_file_path = $this->getPath('views/' . $view_path);

    return [
      'path' => $view_file_path
    ];
  }

  /**
   * Trigger an action
   * @param string $route route path
   * @param string $uri full uri, contains module/controller/action
   * @param RequestInterface $request request
   * @param ResponseInterface $response response
   * @throws Exception when controller not found
   * @throws Exception when controller class undefined
   * @throws Exception when action not found
   * @return ControllerInterface
   */
  public function __invoke (string $route, string $uri, RequestInterface $request, ResponseInterface $response) {
    // remove the route from uri
    $sub_uri = trim(substr($uri, strlen($route)), '/');

    // get controller path
    $controller_path = dirname($sub_uri);
    $controller_path = $controller_path !== '.' && $controller_path !== '' ? $controller_path : 'index';
    $controller_config = $this->resolveController($controller_path);

    // get action name
    $action_name = basename(str_replace($controller_path, '', $sub_uri));

    if (!is_file($controller_config['path'])) {
      throw new Exception('Controller ' . $controller_path . ' not found');
    }

    require_once($controller_config['path']);
    if (!class_exists($controller_config['className'])) {
      throw new Exception('Controller class ' . $controller_config['className'] . ' not found');
    }
    

    $controller_class = $controller_config['className'];
    /** @var ControllerInterface $controller */
    $controller = new $controller_class();

    $controller->setModule($this);
    $controller->handleAction($action_name, $request, $response);
    return $controller;
  }
}
