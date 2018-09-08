<?php
namespace app\common;

use app\common\base\BaseService;
use app\common\interfaces\ComponentInterface;
use app\common\interfaces\SingletonInterface;
use Exception;

/**
 * Class App
 * @package app\common
 */
class App extends BaseService implements SingletonInterface {
  /**
   * App components
   * @var array 
   */
  protected $_components = [];

  /**
   * Add a component
   * @param string $component_name
   * @param ComponentInterface $component
   */
  public function addComponent (string $component_name, ComponentInterface $component) {
    $this->_components[$component_name] = $component;
  }

  /**
   * Get component by name
   * @param string $component_name component name
   * @return ComponentInterface
   * @throws Exception When component not found
   */
  public function getComponent (string $component_name) {
    if (isset($this->_components[$component_name])) {
      return $this->_components[$component_name];
    } else {
      throw new Exception('Component ' . $component_name . ' not found'); 
    }
  }

    /**
   * Run app
   * @param string $root_dir app root dir
   * @throws Exception When root dir not found
   */
  public function run (string $root_dir) {
    if (!is_dir($root_dir)) {
      throw new Exception('root dir not found');
    }
  }

  /**
   * Getter method to get component by name
   * 
   * @alias getComponent
   * @param string $component_name component name
   * @return ComponentInterface
   * @throws Exception When component not found
   */
  public function __get (string $component_name) {
    return $this->getComponent($component_name);
  }

  /**
   * Create App singleton instance
   * @return App
   */
  public static function instance () {
    if (!isset(self::$instance)) {
      self::$instance = new App();
    }
    
    return self::$instance;
  }

  /**
   * Hold App service instance
   * @var App
   */
  private static $instance;
}
