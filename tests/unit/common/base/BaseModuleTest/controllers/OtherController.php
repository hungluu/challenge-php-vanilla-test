<?php
namespace app\common\base\BaseModuleTest\controllers;

use app\common\base\BaseController;
use app\common\interfaces\ControllerInterface;

class OtherController extends BaseController implements ControllerInterface {
  protected $_module;

  public function actionTest () {
    return 'tested';
  }
  
  public function actionIndex () {
    return 'index';
  }

  public function setModule ($module) {
    $this->_module = $module;
  }

  public function getModule () {
    return $this->_module;
  }
}
