<?php

namespace   Webonise\Connectivity;
use \PDO;
//use Webonise\Connectivity\Interface\;



class  DatabaseConnection {


  private $pdo_connection;

  public static $db_name;
  public static  $user_name;
  public static $password;
  public static $host;


  function __construct($options =[]) {
    $defaults = ['host' => 'localhost', 'db_name' => 'weboniseapis', 'password' => 'bric_123', 'user_name' => 'root'];
    $params = array_merge($defaults, $options);
    $connection_string = "mysql:host={$params['host']};port=3306;dbname={$params['db_name']}";
    try {
      $this->pdo_connection = new PDO($connection_string, $params['user_name'], $params['password']);
      $this->pdo_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch( PDOException $e) {
      print "Error" . $e->getMessage(). "<br/>";
    }
  }


  public function getConnection() {

    return $this->pdo_connection;
  }

  public function closeConnection() {
    $this->pdo_connection = null;
  }



}
