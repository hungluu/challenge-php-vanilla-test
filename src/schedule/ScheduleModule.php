<?php
namespace app\schedule;

use app\common\base\BaseModule;
use app\common\interfaces\ActionTriggerInterface;
use app\common\interfaces\ModuleInterface;

/**
 * Class ScheduleModule
 * @package app\schedule
 */
class ScheduleModule extends BaseModule implements ModuleInterface, ActionTriggerInterface {
  /**
   * Get module path
   *
   * @param string $sub_path sub path
   * @return string
   */
  public function getPath (string $sub_path = null) {
    return rtrim(str_replace('\\', '/', __DIR__) . '/' . $sub_path, '/');
  }
}
