<?php

namespace Webonise\Models;

use Webonise\Models\Interfaces\CrudAbstract;

class Line_Item extends CrudAbstract

{
  protected $fillable = array('name', 'description', 'price', 'discount','category_id');

  protected $table_name ="Line_Items";
}
