<?php

namespace Webonise\Models;

use Webonise\Models\Interfaces\CrudAbstract;

class Category extends CrudAbstract
{
  protected $fillable = array('name', 'description', 'tax');

  public $table_name ="Categories";
}
