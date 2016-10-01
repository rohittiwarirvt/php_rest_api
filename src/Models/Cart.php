<?php

namespace Webonise\Models;

use Webonise\Models\Interfaces\CrudAbstract;

// use Webonise\Models\Product;

// use Webonise\Models\Line_item;

class  Cart extends CrudAbstract

{

  protected $fillable = array('name', 'description', 'total', 'total_discount','total_with_discount',
                              'total_tax', 'total_with_tax', 'grand_total' );

  public $table_name ="Carts";

  protected $product;

  protected $line_item;

  public function __construct() {
    parent::__construct();
    $this->product = new Product();

    $this->line_item = new Line_Item();

    $this->category = new Category();
  }


  public function createCart($product_id, array $data) {

    $product = $this->product->findBy(['id' => $product_id, 'first' => true]);

    $category = $this->product->getCategory($product_id)[0];

   // return $product['id'];
    if (!empty($product)){
      $cart_data = array_merge($data, [
        'total' => $product['price'],
        'total_dicount' => $product['discount'],
        'total_with_discount' => $product['price'] - $product['discount'],
        ]);
        if($category) {
         $cart_data = array_merge($cart_data, array(
           'total_tax' => $category['tax'],
           'total_with_tax' => $cart_data['total_with_discount'] + $category['tax'],
           )
          );
        }
        $cart_data['grand_total'] = $cart_data['total_with_tax'];
        array_walk_recursive($cart_data,  function(&$item, $key) {
            $item = is_null($item)? 0 : $item;
        });

      $cart = parent::create($cart_data);

      $this->line_item->create(['cart_id' => $cart[0]['id'],'product_id' => $product_id]);
      return $cart;
    } else {
      return "product not exists";
    }
  }


  public function addProductsCart($cart_id, $args) {
    $cart_exists = $this->findBy(['id' => $cart_id, 'first' => true]);
    if($cart_exists && isset($args['product_ids'])) {
      $product_ids = json_decode($args['product_ids']);
      foreach ($product_ids as $key => $product_id) {
      //  print_r($product_id);
        $product_id = (array)$product_id;
        $this->addProductToCart($cart_id, $product_id['id']);
      }
    }
  }

  public function addProductToCart($cart_id, $product_id) {
  //  print_r($product_id);
    $cart = $this->findBy(['id' => $cart_id, 'first' => true]);
    $product = $this->product->findBy(['id' => $product_id, 'first' => true]);
    // print_r($product);
    // return $product;
    $category = $this->product->getCategory($product_id)[0];
    if (!empty($product)){
      $cart['total'] += $product['price'];
      $cart['total_discount'] += $product['discount'];
      $cart['total_with_discount'] += $product['price'] -  $product['discount'];
      if($category) {
        $cart['total_tax'] += $category['tax'];
        $cart['total_with_tax'] +=  $cart['total_with_discount'] + $category['tax'];
        }
        $cart['grand_total'] = $cart['total_with_tax'];
        array_walk_recursive($cart,  function(&$item, $key) {
            $item = is_null($item)? 0 : $item;
        });
      }
      //print_r($cart);
      $this->update($cart_id,$cart);
    return $this->line_item->create(['cart_id' => $cart_id,'product_id' => $product_id]);
  }


  public function removeProductsCart($cart_id, $args) {
    $cart_exists = $this->findBy(['id' => $cart_id, 'first' => true]);
    if($cart_exists && isset($args['product_ids'])) {
      $product_ids = json_decode($args['product_ids']);
      foreach ($product_ids as $key => $product_id) {
      //  print_r($product_id);
        $product_id = (array)$product_id;
        $this->removeProductToCart($cart_id, $product_id['id']);
      }
    }
  }

  public function removeProductToCart($cart_id, $product_id) {
    $line_item = $this->line_item->findBy(['cart_id' => $cart_id,'product_id' => $product_id, 'first' => true]);
    if (!empty($line_item)) {
        $cart = $this->findBy(['id' => $cart_id, 'first' => true]);

        $product = $this->product->findBy(['id' => $product_id, 'first' => true]);

        $category = $this->product->getCategory($product_id)[0];
        if (!empty($product)){
          $cart['total'] -= $product['price'];
          $cart['total_discount'] -= $product['discount'];
          $cart['total_with_discount'] -= $product['price'] -  $product['discount'];
          if($category) {
            $cart['total_tax'] -= $category['tax'];
            $cart['total_with_tax'] -=  $cart['total_with_discount'] + $category['tax'];
            }
            $cart['grand_total'] = $cart['total_with_tax'];
            array_walk_recursive($cart,  function(&$item, $key) {
                $item = is_null($item)? 0 : $item;
            });
          }
         // print_r($line_item);
         $this->update($cart_id,$cart);
      //  $cart = $this->findBy(['id' => $cart_id, 'first' => true]);
       return $this->line_item->delete($line_item['id']);
    }

  }


  public function retrieve($cart_id) {
    $result = [];
    $cart = $this->findBy(['id' => $cart_id]);
    if (!empty($cart)) {
        $line_items = $this->getLineItems($cart_id);
       $result[] = ['cart' => $cart];
       $result[] = ['line_items' =>$line_items];
    }

    return $result;
  }

  //ToDo
  public function calculateCartTotal($cart_id) {

    $cart = $this->findBy(['id' => $cart_id,'first' => true]);
    return  $cart['total'];

  }

  public function calculateCartTotalDiscount($cart_id) {
    $cart = $this->findBy(['id' => $cart_id,'first' => true]);
    return  $cart['total_discount'];
  }

  public function calculateCartTotalWithDiscount($cart_id) {
    $cart = $this->findBy(['id' => $cart_id,'first' => true]);
    return  $cart['total_with_discount'];
  }

  public function calculateCartTotalTax($cart_id) {
    $cart = $this->findBy(['id' => $cart_id,'first' => true]);
    return  $cart['total_tax'];
  }

    public function calculateCartTotalWithTax($cart_id) {
    $cart = $this->findBy(['id' => $cart_id,'first' => true]);
    return  $cart['total_with_tax'];
  }

    public function calculateCartGrandTotal($cart_id) {
    $cart = $this->findBy(['id' => $cart_id,'first' => true]);
    return  $cart['grand_total'];
  }

  public function getLineItems($cart_id){
     //@Todo integration of matches
    $stmt = "select
                  prod.name  prod_name, prod.description prod_desc,
                  prod.price as prod_price, prod.discount as prod_discount,
                  cat.name as cat_name, cat.description cat_desc, cat.tax as category_tax
             from
                 {$this->table_name} as cart left join {$this->line_item->table_name} as li on cart.id=li.cart_id
              left join
                 {$this->product->table_name} as prod on prod.id = li.product_id
              left join
                {$this->category->table_name} as cat on cat.id = prod.category_id
                  where cart.id = {$cart_id}";
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
