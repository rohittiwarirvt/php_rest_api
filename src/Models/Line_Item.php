<?php

namespace Webonise\Models;

use Webonise\Models\Interfaces\CrudAbstract;

class Line_Item extends CrudAbstract

{
  protected $fillable = array('cart_id', 'product_id');

  public $table_name ="Line_Items";
}
