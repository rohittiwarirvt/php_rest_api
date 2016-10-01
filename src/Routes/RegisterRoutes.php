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
      $cart  = new Cart();
      return $this->response->responseOK($cart->createCart($product_id,$args));

    });

    $this->route->addRoute('GET', '/carts/:id', function($id){
      $cart  = new Cart();
      return $this->response->responseOK($cart->retrieve($id));

    });

    // e.g. http://dev.weboniseapis.local/carts/5?product_ids=[{"id":1},{"id":2}]
    $this->route->addRoute('PUT', '/carts/:id', function($id, $args){
      $cart  = new Cart();

     return $this->response->responseOK($cart->addProductsCart($id, $args));

    });

    // e.g. http://dev.weboniseapis.local/carts/5?product_ids=[{"id":1},{"id":2}]
    $this->route->addRoute('DELETE', '/removeproductsfromcart/:id', function($id, $args){
      $cart  = new Cart();
     // print_r("dd");
     return $this->response->responseOK($cart->removeProductsCart($id, $args));

    });

    $this->route->addRoute('DELETE', '/carts/:id', function($id){
      $cart  = new Cart();
      return $this->response->responseOK($cart->delete($id));

    });

    $this->route->addRoute('GET', '/calculatecarttotal/:id', function($id){
      $cart  = new Cart();
      return $this->response->responseOK($cart->calculateCartTotal($id));

    });

    $this->route->addRoute('GET', '/calculatecarttotaldiscount/:id', function($id){
      $cart  = new Cart();
      return $this->response->responseOK($cart->calculateCartTotalDiscount($id));

    });

    $this->route->addRoute('GET', '/calculatecarttotalwithdiscount/:id', function($id){
      $cart  = new Cart();
      return $this->response->responseOK($cart->calculateCartTotalWithDiscount($id));

    });

    $this->route->addRoute('GET', '/calculatecarttotaltax/:id', function($id){
      $cart  = new Cart();
      return $this->response->responseOK($cart->calculateCartTotalTax($id));

    });

    $this->route->addRoute('GET', '/calculatecarttotalwithtax/:id', function($id){
      $cart  = new Cart();
      return $this->response->responseOK($cart->calculateCartTotalWithTax($id));

    });

    $this->route->addRoute('GET', '/calculatecartgrandtotal/:id', function($id){
      $cart  = new Cart();
      return $this->response->responseOK($cart->calculateCartGrandTotal($id));

    });

    return $this->route->startRouting();
  }



}



