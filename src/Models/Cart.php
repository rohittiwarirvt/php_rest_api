<?php

namespace Webonise\Models;

use Webonise\Models\Interfaces\CrudAbstract;

use Webonise\Models\Product;

use Webonise\Models\Line_item;

class  Cart extends CrudAbstract

{

  protected $fillable = array('name', 'description', 'total', 'total_discount','total_with_discount',
                              'total_tax', 'total_with_tax', 'grand_total' );

  protected $table_name ="Carts";

  protected $product;

  protected $line_item;

  public __construct() {
    $this->product = new Product();

    $this->line_item = new Line_item();
  }


  public function create($product_id, array $data) {

    $product = $this->product->findBy(['id' => $product_id]);

    $category = $this->product->getCategory($product_id);

    return $product;
    if (!empty($product)){
      $cart_data = array_merge($data, [
        'total' => $product['price'],
        'total_dicount' => $product['discount'],
        'total_with_discount' => $product['price'] - $product['discount'],
        ]);
        if($category) {
         $cart_data = array_merge($cart_data,
           'total_tax' => $category['tax'],
           'total_with_tax' => $cart_data['total_with_discount'] + $category['tax'],
          );
        }
        $cart['grand_total'] = $cart_data['total_with_tax'];
      $cart = parent::create($cart_data);
     // $this->line_item->create(['cart_id' = cart['id']])
    } else {
      return "product not exists";
    }
  }

  public function calculateCartTotal() {

  }

  public function calculateCartTotalDiscount() {

  }

  public function calculateCartTotalWithDiscount() {

  }

  public function calculateCartTotalTax() {

  }

    public function calculateCartTotalWithTax() {

  }

    public function calculateCartGrandTotal() {

  }

  public function getLineItems($cart_id){
     //@Todo integration of matches
    $stmt = "select * from {$this->table_name} as cart left join {$this->line_item->table_name} as li on cart.id=li.cart_id where cart.id = {$cart_id}Cart.php";
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
