<?php

namespace Webonise\Models\Interfaces;

use Webonise\Connectivity\DatabaseConnection;


abstract class CrudAbstract implements CRUD
{

  protected $db_connect;

  protected $fillable;

  protected $table_name;


  public function __construct()
  {
        $this->setDatabaseConnection();


  }

  protected function setDatabaseConnection()
  {

    $this->db_connect = DatabaseConnection::connect();
  }

  public function create(array $data)
  {

    $column_names = '('. implode(',', array_values($this->fillable)) .')';
    $colunm_values =  '('. implode(',', array_map(function($value) {
                              if(!is_numeric($value)) {
                                  return '"' . $value . '"';

                              } else {
                              return $value;
                              }
                      }, $data)) .')';

    $stmt = "INSERT INTO {$this->table_name} {$column_names} VALUES {$colunm_values}";

    try {
      $query = $this->db_connect->prepare($stmt);

      $result = $query->execute();
      $lastInsertId = $this->db_connect->lastInsertId();
      $result = $this->findBy(array('id' => $lastInsertId));
    }
    catch(PDOException $e) {
    echo  "<br>" . $e->getMessage();
    }
    return $result ;
  }

  public function update($id, $data)
  {

    //$data = $data['args'];
    $set_values ="";
    foreach ($data as $column_name => $column_value) {
        if(!is_numeric($column_value)) {
          $column_value =  '"' . $column_value . '"';
        }
      $set_values .= "`$column_name`=$column_value,";
    }
    $set_values = rtrim($set_values, ',');
    $stmt = "UPDATE {$this->table_name} set {$set_values} where id=$id";
    try {
      $query = $this->db_connect->prepare($stmt);

      $result = $query->execute();

    }
    catch(PDOException $e) {
    echo  "<br>" . $e->getMessage();
    }
    return $result = "Updated Record Succesfully";;
  }

  public function delete($id)
  {

    $stmt = "DELETE from {$this->table_name} where id = $id";

    try {
      $query = $this->db_connect->prepare($stmt);

      $result = $query->execute();

    }
    catch(PDOException $e) {
    echo  "<br>" . $e->getMessage();
    }
    return $result = "Deleted Record Succesfully";
  }

  public function retrieve($matches = array())
  {

    //@Todo integration of matches
    $stmt = "select * from {$this->table_name}";
    var_dump($this->db_connect);
    try {
      $query = $this->db_connect->query($stmt);

      $result = $query->fetchAll();

    }
    catch(PDOException $e) {
    echo  "<br>" . $e->getMessage();
    }
    return $result;
  }

  public function findBy($options) {
    $and_or_select = false;
    $first = isset($option['first']) ? true : false;

    if ($first) {
      unset($option['first']);
    }

    if (!isset($options['or'])|| !isset($options['and'])) {
      $defaults = array_merge([], ['and' => $options]);
    } else {
      $and_or_select = true;
    }

    $stmt = "select * from {$this->table_name} where ";
    if (!$and_or_select) {
      foreach ($defaults['and'] as $key => $value) {
        $stmt .= $key . '='. $value . 'and';
      }
      $stmt = rtrim($stmt, 'and');
    } else {
      // @Todo and and or grouping
    }

    try {
      $query = $this->db_connect->query($stmt);

      if (!$first) {
      $result = $query->fetchAll();
      } else {
        $result = $query->fetch();
      }


    }
    catch(PDOException $e) {
    echo  "<br>" . $e->getMessage();
    }
    return $result;
  }


}
