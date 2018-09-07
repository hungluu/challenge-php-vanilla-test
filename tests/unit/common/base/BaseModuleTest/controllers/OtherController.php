<?php
namespace app\common\base\BaseModuleTest\controllers;

use app\common\base\BaseController;
use app\common\interfaces\ControllerInterface;
use app\common\interfaces\ModuleInterface;

class OtherController extends BaseController implements ControllerInterface {
  public function actionTest () {
    return 'tested';
  }
  
  public function actionIndex () {
    return 'index';
  }
}
