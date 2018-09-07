<?php
namespace app\common\base\BaseModuleTest;

use app\common\base\BaseModule;
use app\common\interfaces\ModuleInterface;

class BaseModuleChild extends BaseModule implements ModuleInterface {
  public function getPath (string $sub_path = null) {
    return rtrim(str_replace('\\', '/', __DIR__) . '/' . $sub_path, '/');
  }

  public function resolveController (string $controller_path) {
    return parent::resolveController($controller_path);
  }
}
