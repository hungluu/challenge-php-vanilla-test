<?php
namespace app\common\base\BaseControllerTest;

use app\common\base\BaseController;
use app\common\interfaces\ControllerInterface;

class BaseControllerChild extends BaseController implements ControllerInterface {
  public function actionTest () {
    return 'tested-action';
  }
}
