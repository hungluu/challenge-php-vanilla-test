<?php
namespace app\models;

use app\common\db\BaseModel;
use app\common\db\interfaces\ModelInterface;

/**
 * Model ScheduleModel
 * Table schedule
 * @package app\models
 */
class ScheduleModel extends BaseModel implements ModelInterface {
  public static function getTableName () {
    return 'schedule';
  }
}
