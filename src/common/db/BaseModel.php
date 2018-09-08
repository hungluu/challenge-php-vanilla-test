<?php
namespace app\common\db;

use app\common\App;
use app\common\base\BaseComponent;
use app\common\db\errors\DBException;
use app\common\db\errors\ModelException;
use app\common\db\errors\ValidationException;
use app\common\db\interfaces\ConnectionInterface;
use Exception;
use PDOException;
use PDO;

/**
 * Class BaseModel
 * @package app\common\base
 */
abstract class BaseModel extends BaseComponent {
  /**
   * Protected attributes, not modifiable
   * @var array 
   */
  protected $_protected_attributes = [
    'id'
  ];

  /**
   * Current attributes
   * @var array 
   */
  protected $_attributes = [];

  /**
   * Filter attributes
   * @param array $attributes
   * @return array
   */
  public function filterAttributes (array $attributes) {
    $filtered_attributes = [];
    foreach ($attributes as $key => $value) {
      if (!in_array($key, $this->_protected_attributes)) {
        $filtered_attributes[$key] = $value;
      }
    }
    
    return $filtered_attributes;
  }

  /**
   * Validate model attributes
   * @return bool
   */
  public function validate () {
    return true;
  }

  /**
   * Set model attributes
   * @param $attributes
   */
  public function setAttributes (array $attributes) {
    $this->_attributes = $this->filterAttributes($attributes);
  }

  /**
   * Get model attributes
   * @return array
   */
  public function getAttributes () {
    return $this->_attributes;
  }

  /**
   * Get an attribute
   * @param string $attribute
   * @return mixed
   */
  public function getAttribute (string $attribute) {
    return isset($this->_attributes[$attribute])
      ? $this->_attributes[$attribute]
      : null;
  }

  /**
   * Save model to database
   * @return boolean where save success
   * @throws ValidationException when validation fails
   * @throws ModelException when save fails
   * @throws DBException when database interaction fails
   * @throws Exception if connection not found
   */
  public function save () {
    try {
      if ($this->validate() === false) {
        throw new ValidationException('Model validation failed');
      }

      // Gather command assets
      $attributes = $this->_attributes;
      unset($attributes['id']);
      $fields = filter_var_array(array_keys($attributes), FILTER_SANITIZE_STRING);
      $value_placeholders = preg_filter('/^/', ':', $fields);
      
      // Create commands
      $save_sql = sprintf(
        'INSERT INTO %s (%s) VALUES (%s)',
        static::getTableName(),
        implode(', ', $fields),
        implode(', ', $value_placeholders)
      );
      $update_sql = $save_sql . ' WHERE id = :id';
      
      $connection = static::getConnection();
      $new_record = true;
      /** @var \PDOStatement $command */
      /** @var \PDO $connection */
      if (!empty($this->_attributes['id'])) {
        $command = $connection->prepare($update_sql);
        $command->bindParam('id', $this->_attributes['id']);
        $new_record = false;
      } else {
        $command = $connection->prepare($save_sql);
      }

      foreach ($attributes as $key => &$value) {
        $command->bindParam(':' . $key, $value);
      }
      
      if (!$command->execute()) {
        throw new ModelException($command->errorInfo());
      }
      
      if ($new_record) {
        $this->__setAttributesDangerously(['id' => $connection->lastInsertId()]);
      }
      
      return true;
    } catch (PDOException $pdo_ex) {
      throw new DBException($pdo_ex->getMessage());
    }
  }

  /**
   * Get attribute alias
   * @param string $attribute
   * @return mixed
   */
  public function __get ($attribute) {
    return $this->getAttribute($attribute);
  }
  
  /**
   * Search models by conditions
   * 
   * @param array $conditions search conditions
   * @param array $others other parts of query
   * @return array $models
   *
   * @throws ModelException when search fails
   * @throws DBException When failing to interface with database
   * @throws Exception When failing to get connection
   */
  public static function find (array $conditions, array $others = []) {
    try {
      $where_assets = [];
      $params = [];
      foreach ($conditions as $key => $condition) {
        if (is_string($key)) {
          $param_key = ':' . $key;
          $params[$param_key] = $condition;
          $where_assets[] = $key . ' = ' . $param_key;
        } else {
          $where_assets[] = $condition;
        }
      }
      
      // Create command
      $search_sql = sprintf(
        'SELECT * FROM %s %s %s',
        static::getTableName(),
        count($where_assets) ? implode(' AND ', $where_assets) : '',
        implode(' ', $others)
      );
      
      $connection = static::getConnection();
      /** @var \PDOStatement $command */
      /** @var \PDO $connection */
      $command = $connection->prepare($search_sql);
      foreach ($params as $key => &$value) {
        $command->bindParam($key,$value);
      }
      
      // Run command
      $results = [];
      if (!$command->execute()) {
        throw new ModelException($connection->errorInfo());
      }
      
      while ($result = $command->fetch(PDO::FETCH_ASSOC)) {
        $results[] = $result;
      }
      
      return $results;
    } catch (PDOException $pdo_ex) {
      throw new DBException($pdo_ex->getMessage());
    }
  }

  /**
   * Search a single model by conditions
   * 
   * @param array $conditions search conditions
   * @param array $others other parts of query
   * @return array|null model attributes
   * 
   * @throws DBException When failing to interface with database
   * @throws Exception When failing to get connection
   */
  public static function findOne (array $conditions, array $others = []) {
    $results = static::find($conditions, array_merge($others, ['LIMIT 1']));
    return count($results) ? $results[0] : null;
  }

  /**
   * Search models by conditions and update them
   * CAUTION: Unlike normal models, protected attributes will not be protected by this method
   *
   * @param array $conditions search conditions
   * @param array $attributes new attributes
   * @return int number of update count
   *
   * @throws DBException When failing to interface with database
   * @throws ModelException When failing to update records
   * @throws Exception When failing to get connection
   */
  public static function findAndUpdate (array $conditions, array $attributes) {
    try {
      if (!count($attributes)) {
        throw new ValidationException('No attributes found');
      }
      
      // query params
      $params = [];
      
      // Gather where assets
      $where_assets = [];
      foreach ($conditions as $key => $condition) {
        if (is_string($key)) {
          $param_key = ':where_' . $key;
          $params[$param_key] = $condition;
          $where_assets[] = $key . ' = ' . $param_key;
        } else {
          $where_assets[] = $condition;
        }
      }
      
      // Gather attribute assets
      $attribute_assets = [];
      foreach ($attributes as $key => $value) {
        if (is_string($key)) {
          $param_key = ':attribute_' . $key;
          $params[$param_key] = $value;
          $attribute_assets[] = $key . ' = ' . $param_key;
        } else {
          $attribute_assets[] = $value;
        }
      }

      // Create command
      $update_sql = sprintf(
        'UPDATE %s SET %s %s',
        static::getTableName(),
        implode(', ', $attribute_assets),
        count($where_assets) ? 'WHERE ' . implode(' AND ', $where_assets) : ''
      );

      $connection = static::getConnection();
      /** @var \PDOStatement $command */
      /** @var \PDO $connection */
      $command = $connection->prepare($update_sql);
      foreach ($params as $key => &$value) {
        $command->bindParam($key,$value);
      }

      // Run command
      if (!$command->execute()) {
        throw new ModelException($command->errorInfo());
      }

      return $command->rowCount();
    } catch (PDOException $pdo_ex) {
      throw new DBException($pdo_ex->getMessage());
    }
  }

  /**
   * Search models by conditions and delete them
   *
   * @param array $conditions search conditions
   * @return int number of delete count
   *
   * @throws DBException When failing to interface with database
   * @throws ModelException When failing to update records
   * @throws Exception When failing to get connection
   */
  public static function findAndDelete (array $conditions) {
    try {
      // query params
      $params = [];

      // Gather where assets
      $where_assets = [];
      foreach ($conditions as $key => $condition) {
        if (is_string($key)) {
          $param_key = ':where_' . $key;
          $params[$param_key] = $condition;
          $where_assets[] = $key . ' = ' . $param_key;
        } else {
          $where_assets[] = $condition;
        }
      }

      // Create command
      $delete_sql = sprintf(
        'DELETE FROM %s %s',
        static::getTableName(),
        count($where_assets) ? 'WHERE ' . implode(' AND ', $where_assets) : ''
      );

      $connection = static::getConnection();
      /** @var \PDOStatement $command */
      /** @var \PDO $connection */
      $command = $connection->prepare($delete_sql);
      foreach ($params as $key => &$value) {
        $command->bindParam($key,$value);
      }

      // Run command
      if (!$command->execute()) {
        throw new ModelException($command->errorInfo());
      }

      return $command->rowCount();
    } catch (PDOException $pdo_ex) {
      throw new DBException($pdo_ex->getMessage());
    }
  }

  /**
   * Get db connection
   * @return ConnectionInterface
   * @throws Exception When component can not be get
   */
  static public function getConnection () {
    return App::instance()->getComponent('db');
  }

  /**
   * Get table name
   * @return string
   */
  abstract static function getTableName ();

  /**
   * Set attributes in danger mode
   * @param $attributes
   */
  public function __setAttributesDangerously (array $attributes) {
    $this->_attributes = $attributes;
  }
}
