<?php
namespace Webonise\Routes;

use Webonise\Routes\Http\Routes;
use Webonise\Models\Product;
use Webonise\Routes\Http\Response;

class RegisterRoutes {

  protected  $route;

  protected $response;

  public function __construct(Routes $route) {
    $this->route =$route;
    $this->response = new Response();
  }

  public function initRoute() {



    // Products api
    $this->route->addRoute('POST', '/products', function($args){
      $product  = new Product();
      return $this->response->responseOK($product->create($args));

    });

    $this->route->addRoute('GET', '/products', function($args){
      $product  = new Product();
      return $this->response->responseOK($product->retrieve($args));

    });

    $this->route->addRoute('PUT', '/products/:id', function($id, $args){
      $product  = new Product();

     return $this->response->responseOK($product->update($id, $args));

    });

    $this->route->addRoute('DELETE', '/products/:id', function($args){
      $product  = new Product();
      return $this->response->responseOK($product->create($args));

    });

    return $this->route->startRouting();
  }



}



