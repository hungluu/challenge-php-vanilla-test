<?php
namespace app\common\interfaces;

/**
 * Interface RepositoryInterface
 * @package app\common\interfaces
 */
interface RepositoryInterface {
  /**
   * Find a collection
   * 
   * @param array $conditions search conditions
   * @return array[]
   */
  public function find (array $conditions = []);

  /**
   * Find a collection item
   * 
   * @param array $conditions search conditions
   * @return array|null null when no item found by conditions
   */
  public function findOne (array $conditions = []);

  /**
   * Update all collection items
   * 
   * @param array $conditions search conditions
   * @param array $attributes new item attributes
   * @return int how many item updated
   */
  public function update (array $conditions = [], array $attributes = []);

  /**
   * Create a new item
   * 
   * @param array $attributes new item attributes
   * @return int how many item created
   */
  public function create (array $attributes = []);

  /**
   * Delete collection items
   * 
   * @param array $conditions search conditions
   * @return int how many item deleted
   */
  public function delete (array $conditions = []);
}
