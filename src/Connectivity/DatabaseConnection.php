<?php

namespace   Webonise\Connectivity;
use \PDO;
//use Webonise\Connectivity\Interface\;



class  DatabaseConnection {

  private static $instance;
  private $pdo_connection;

  public static $db_name;
  public static  $user_name;
  public static $password;
  public static $host;


  private function __construct($options =[]) {

  }

  public static function connect() {
    if( self::$instance == null) {
      $className =  __CLASS__;
      self::$instance = new $className();
      self::$instance->initConnection();

    }

    return self::$instance->getConnection();
  }

  private function initConnection($options = []) {
    $defaults = ['host' => 'localhost', 'db_name' => 'weboniseapis', 'password' => 'bric_123', 'user_name' => 'root'];
    $params = array_merge($defaults, $options);
    $connection_string = "mysql:host={$params['host']};port=3306;dbname={$params['db_name']}";
    try {
      $this->pdo_connection = new PDO($connection_string, $params['user_name'], $params['password']);
      $this->pdo_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->pdo_connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    } catch( PDOException $e) {
      print "Error" . $e->getMessage(). "<br/>";
    }
  }

  public function getConnection() {

    return $this->pdo_connection;
  }

  public function  closeConnection() {
    $this->pdo_connection = null;
  }

  public function __clone() {
      throw new Exception("Can't clone a singleton");
  }

}
