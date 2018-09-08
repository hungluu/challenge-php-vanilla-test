<?php
namespace app\db;

use app\common\App;
use app\db\interfaces\ConnectionInterface;
use Exception;

/**
 * Class BaseModel
 * @package app\common\base
 */
abstract class BaseModel {
  /**
   * Get db connection
   * @return ConnectionInterface
   * @throws Exception When component can not be get
   */
  public function getConnection () {
    return App::instance()->getComponent('db');
  }
}
