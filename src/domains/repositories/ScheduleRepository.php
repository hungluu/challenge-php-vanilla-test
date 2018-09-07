<?php
namespace app\domains\repositories;

use app\common\base\BaseRepository;
use app\common\interfaces\RepositoryInterface;
use Faker\Factory;

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
   */
  public function find (array $conditions = []) {
    $faker = Factory::create();
    $events = [];
    $min_date = '-15 days';
    $max_date = '+5 days';
    for ($i = 1; $i < 100; $i++) {
      $start_date = $faker->dateTimeBetween($min_date, $max_date);
      $end_date = clone $start_date;
      $end_date->modify('+' . $faker->numberBetween(1, 5) . ' hours');
      $name = $faker->name;
      $events[] = [
        'id' => $i,
        'name' => $name,
        'text' => $name,
        'start_date' => $start_date->format('Y-m-d H:i'),
        'end_date' => $end_date->format('Y-m-d H:i'),
        'status' => $faker->randomElement(['cancelled', 'scheduled'])
      ];
    }
    
    return $events;
  }

  /**
   * Find a collection item
   *
   * @param array $conditions search conditions
   * @return array|null null when no item found by conditions
   */
  public function findOne (array $conditions = []) {
    return [
      'id' => 1,
      'name' => '',
      'text' => '',
      'start_date' => $start_date->format('Y-m-d H:i'),
      'end_date' => $end_date->format('Y-m-d H:i'),
      'status' => '',
      'status_color' => '#069'
    ];
  }

  /**
   * Update all collection items
   *
   * @param array $conditions search conditions
   * @param array $attributes new item attributes
   * @return int how many item updated
   */
  public function update (array $conditions = [], array $attributes = []) {
    return 1;
  }

  /**
   * Create a new item
   *
   * @param array $attributes new item attributes
   * @return int how many item created
   */
  public function create (array $attributes = []) {
    return 1;
  }

  /**
   * Delete collection items
   *
   * @param array $conditions search conditions
   * @return int how many item deleted
   */
  public function delete (array $conditions = []) {
    return 1;
  }
}
