<?php
namespace app\common\base\BaseModuleTest\controllers;

use app\common\base\BaseController;
use app\common\interfaces\ControllerInterface;
use app\common\interfaces\ModuleInterface;

class IndexController extends BaseController implements ControllerInterface {
  protected $_module;

  public function actionIndex () {
    return 'index-index';
  }

  public function actionTest () {
    return 'index-test';
  }

  public function setModule (ModuleInterface $module) {
    $this->_module = $module;
  }

  public function getModule () {
    return $this->_module;
  }
}
