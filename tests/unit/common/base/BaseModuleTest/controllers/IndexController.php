<?php
namespace app\common\base\BaseModuleTest\controllers;

class IndexController {
  protected $_module;

  public function actionIndex () {
    return 'index-index';
  }

  public function actionTest () {
    return 'index-test';
  }

  public function setModule ($module) {
    $this->_module = $module;
  }

  public function getModule () {
    return $this->_module;
  }
}
