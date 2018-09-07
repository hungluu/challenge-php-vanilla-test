<?php
namespace app\common\components;

use app\common\base\BaseView;
use app\common\interfaces\ComponentInterface;
use app\common\interfaces\ViewInterface;
use Exception;

/**
 * Class View
 * 
 * Manage view file path and view data / options
 * @package app\common\components
 */
class View extends BaseView implements ViewInterface, ComponentInterface {
  /**
   * Create a View
   * @param array $options view options
   * @throws Exception When view file not found
   */
  public function __construct (array $options = []) {
    if (!isset($options['path']) || !is_file($options['path'])) {
      throw new Exception('Invalid view file path');
    }
    
    parent::__construct($options);
  }

  /**
   * Get view file path
   * @return string
   */
  public function getViewPath () {
    return $this->_options['path'];
  }

  /**
   * Get view contents
   * @param array $options options
   * @return string
   */
  public function getContents (array $options = []) {
    return file_get_contents($this->getViewPath());
  }
}
