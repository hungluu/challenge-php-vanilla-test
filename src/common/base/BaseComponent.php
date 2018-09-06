<?php
namespace app\common\base;

/**
 * Class BaseComponent
 * @package app\common\base
 */
abstract class BaseComponent {
  /**
   * component options
   * @var array
   */
  protected $_options;

  /**
   * Create a component
   * @param array $options component options
   */
  public function __construct (array $options = []) {
    $this->_options = $options;
  }

  /**
   * Get component class name
   * @return string
   */
  public function getClassName () {
    return get_class($this);
  }
}
