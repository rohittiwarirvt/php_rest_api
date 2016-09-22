<?php

namespace Webonise\Routes\Http;




class Request {


  public $method;

  public $url;

  public $args;


  public function __construct() {
    $this->url = $_SERVER['REQUEST_URI'];
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->args = $_REQUEST;
  }


  public function request() {

  }


}
