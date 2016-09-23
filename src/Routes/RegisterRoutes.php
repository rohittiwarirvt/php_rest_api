<?php
namespace Webonise\Routes;

use Webonise\Routes\Http\Routes;
use Webonise\Models\Product;
use Webonise\Models\Category;
use Webonise\Models\Cart;
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

    $this->route->addRoute('DELETE', '/products/:id', function($id){
      $product  = new Product();
      return $this->response->responseOK($product->delete($id));

    });

    // Categories api
    $this->route->addRoute('POST', '/category', function($args){
      $category  = new Category();
      return $this->response->responseOK($category->create($args));

    });

    $this->route->addRoute('GET', '/category', function($args){
      $category  = new Category();
      return $this->response->responseOK($category->retrieve($args));

    });

    $this->route->addRoute('PUT', '/category/:id', function($id, $args){
      $category  = new Category();

     return $this->response->responseOK($category->update($id, $args));

    });

    $this->route->addRoute('DELETE', '/category/:id', function($id){
      $category  = new Category();
      return $this->response->responseOK($category->delete($id));

    });

      // Cart apis
    $this->route->addRoute('POST', '/carts/:productid', function($product_id,$args){
      $cart  = new Product();
      return $this->response->responseOK($cart->create($product_id,$args));

    });

    $this->route->addRoute('GET', '/carts/:id', function($id){
      $cart  = new Product();
      return $this->response->responseOK($cart->retrieve(['id' => $id]));

    });

    $this->route->addRoute('PUT', '/carts/:id/:productid', function($id, $product_id, $args){
      $cart  = new Product();

     return $this->response->responseOK($cart->update($id, $product_id, $args));

    });

    $this->route->addRoute('DELETE', '/carts/:id', function($id){
      $cart  = new Product();
      return $this->response->responseOK($cart->delete($id));

    });
    return $this->route->startRouting();
  }



}



