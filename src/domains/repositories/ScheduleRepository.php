<?php
namespace app\domains\repositories;

use app\common\base\BaseRepository;
use app\common\interfaces\RepositoryInterface;
use app\models\ScheduleModel;
use Exception;

/**
 * Class ScheduleRepository
 * @package app\domains\repositories
 */
class ScheduleRepository extends BaseRepository implements RepositoryInterface {
  /**
   * Find a collection
   *
   * @param array $conditions search conditions
   * @return array[]
   * @throws Exception when search failed
   */
  public function find (array $conditions = []) {
    return ScheduleModel::find($conditions, ['ORDER BY id']);
  }

  /**
   * Find a collection item
   *
   * @param array $conditions search conditions
   * @return array|null null when no item found by conditions
   */
  public function findOne (array $conditions = []) {
    return null;
  }

  /**
   * Update all collection items
   *
   * @param array $conditions search conditions
   * @param array $attributes new item attributes
   * @return int how many item updated
   * @throws Exception when update failed
   */
  public function update (array $conditions = [], array $attributes = []) {
    return ScheduleModel::findAndUpdate($conditions, $attributes);
  }

  /**
   * Create a new item
   *
   * @param array $attributes new item attributes
   * @return int how many item created
   * @throws Exception when creation failed
   */
  public function create (array $attributes = []) {
    $schedule = new ScheduleModel();
    $schedule->setAttributes($attributes);
    return $schedule->save() ? 1 : 0;
  }

  /**
   * Delete collection items
   *
   * @param array $conditions search conditions
   * @return int how many item deleted
   * @throws Exception When delete failed
   */
  public function delete (array $conditions = []) {
    return ScheduleModel::findAndDelete($conditions);
  }
}
