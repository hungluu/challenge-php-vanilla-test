<?php
namespace app\common\base;

use app\common\components\View;
use app\common\interfaces\ModuleInterface;
use app\common\interfaces\RequestInterface;
use app\common\interfaces\ResponseInterface;
use Exception;

/**
 * Class BaseController
 * @package app\common\base
 */
abstract class BaseController extends BaseComponent {
  /**
   * module
   * @var ModuleInterface
   */
  private $_module;

  /**
   * Set module
   * @param ModuleInterface $module
   */
  public function setModule (ModuleInterface $module) {
    $this->_module = $module;
  }

  /**
   * Get module
   * @return ModuleInterface
   */
  public function getModule () {
    return $this->_module;
  }

  /**
   * Create a view
   * @param string $view_path view path
   * @return View
   * @throws Exception when error occurs during View creation
   */
  public function getView (string $view_path) {
    return new View($this->getModule()->resolveView($view_path));
  }

  /**
   * Handle action
   * @param string $action_name name of action
   * @param RequestInterface $request request
   * @param ResponseInterface $response response
   * @return mixed
   * @throws Exception When action not found
   */
  public function handleAction ($action_name, RequestInterface $request, ResponseInterface $response) {
    $action_method = $action_name ? 'action' . ucfirst($action_name) : 'actionIndex';
    if (!method_exists($this, $action_method)) {
      throw new Exception('Action ' . $this->getClassName() . '::' . $action_method . ' not found');
    }
    
    // Trigger action
    return $this->$action_method($request, $response);
  }
}
