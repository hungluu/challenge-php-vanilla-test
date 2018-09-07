<?php
namespace app\common\base;

use app\common\components\View;
use app\common\interfaces\ModuleInterface;
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
}
