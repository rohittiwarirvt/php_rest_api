<?php

namespace Webonise\Models;

use Webonise\Models\Interfaces\CrudAbstract;


class Product extends CrudAbstract
{

  protected $fillable = array('name', 'description', 'price', 'discount','category_id');

  protected $table_name ="Products";
}
