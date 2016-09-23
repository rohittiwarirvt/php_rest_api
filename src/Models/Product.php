<?php

namespace Webonise\Models;

use Webonise\Models\Interfaces\CrudAbstract;


class Product extends CrudAbstract
{

  protected $fillable = array('name', 'description', 'price', 'discount','category_id');

  public $table_name ="Products";

  public $category;

  public function __construct() {
    parent::__construct();
    $this->category = new Category();
  }
  public function getCategory($prod_id) {
     //@Todo integration of matches
    $stmt = "select * from {$this->table_name} as prod left join {$this->category->table_name} as cat on prod.id=cat.id where prod.id = {$prod_id}";
    try {
      $query = $this->db_connect->query($stmt);

      $result = $query->fetchAll();

    }
    catch(PDOException $e) {
    echo  "<br>" . $e->getMessage();
    }
    return $result;
  }
}
