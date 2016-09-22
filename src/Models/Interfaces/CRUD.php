<?php

namespace Webonise\Models\Interfaces;


interface CRUD
{

  public function create(array $data);

  public function update($id, $data);

  public function delete($id);
  public function retrieve($matches);
}
