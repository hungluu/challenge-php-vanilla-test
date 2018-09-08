<?php
namespace app\common\db;

use app\common\interfaces\ComponentInterface;
use app\common\db\interfaces\ConnectionInterface;
use PDO;

/**
 * Class Connection
 * 
 * PDO Connection
 * @package app\db
 */
class Connection extends PDO implements ComponentInterface, ConnectionInterface {
  public function __construct ($options) {
    $supported_driver = 'pgsql';
    $sanitize_options = filter_var_array($options, [
      'host' => FILTER_SANITIZE_STRING,
      'port' => FILTER_VALIDATE_INT,
      'username' => FILTER_SANITIZE_STRING,
      'password' => FILTER_SANITIZE_STRING,
      'database' => FILTER_SANITIZE_STRING
    ]);
    
    $host = $sanitize_options['host'] ? $sanitize_options['host'] : 'localhost';
    $port = $sanitize_options['port'] ? $sanitize_options['port'] : '5432';
    $username = $sanitize_options['username'];
    $password = $sanitize_options['password'];

    $dsn = sprintf(
      '%s:host=%s;port=%s;dbname=%s',
      $supported_driver,
      $host,
      $port,
      $sanitize_options['database']
    );
    
    parent::__construct($dsn, $username, $password);
  }
}
