<?php
namespace app\domains;

use app\common\base\BaseService;
use app\common\interfaces\ServiceInterface;
use app\common\interfaces\SingletonInterface;
use app\domains\repositories\ScheduleRepository;

/**
 * Class ScheduleService
 * @package app\domains
 */
class ScheduleService extends BaseService implements ServiceInterface, SingletonInterface {
  /**
   * Schedule repository
   * @var ScheduleRepository
   */
  private $schedule;

  /**
   * ScheduleService instance
   */
  private function __construct () {
    $this->schedule = new ScheduleRepository();
  }
  
  public function getSchedules (array $conditions = []) {
    return [
      'first_hour' => 8,
      'last_hour' => 19,
      'events' => $this->schedule->find($conditions)
    ];
  }

  public function createSchedule (array $attributes = []) {
    return [
      'create_count' => $this->schedule->create($attributes)
    ];
  }
  
  public function deleteSchedules (array $conditions = []) {
    return [
      'delete_count' => $this->schedule->delete($conditions)
    ];
  }

  public function updateSchedules (array $conditions = [], array $attributes = []) {
    return [
      'update_count' => $this->schedule->update($conditions, $attributes)
    ];
  }

  /**
   * Singleton instance
   * @var ScheduleService
   */
  private static $instance;
  public static function instance () {
    if (!isset(self::$instance)) {
      self::$instance = new ScheduleService();
    }
    
    return self::$instance;
  }
}
