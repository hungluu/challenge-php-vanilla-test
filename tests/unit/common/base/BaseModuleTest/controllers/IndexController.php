<?php
namespace app\common\base\BaseModuleTest\controllers;

use app\common\base\BaseController;
use app\common\interfaces\ControllerInterface;

class IndexController extends BaseController implements ControllerInterface {
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
