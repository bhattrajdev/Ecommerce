<?php
$user_id = $_GET['user_id'];
$dbcon->exec("SET FOREIGN_KEY_CHECKS = 0");
$product = select('*','product',"WHERE seller_id = $user_id");
if(!empty($product)){
    foreach($product as $data){
        $id= $data['product_id'];
        $images = select('name', 'productgallery', 'WHERE product_id =' . $id);
        foreach ($images as $image) {
            if (file_exists(public_path($image['name']))) {
                unlink(public_path($image['name']));
            }
        }
        // delete product images
        delete('productgallery', 'product_id', $id);

        // delete product variation
        delete('productvariation', 'product_id', $id);
        }
    }


      $data =   select('order_id','orderproducts',"WHERE product_id = $id");
      if(!empty ($data)){
        foreach($data as $d ){
                $order_id = $d['order_id'];
                delete('orderproducts','order_id',"$order_id");
        }
        delete('order','user_id',"$id");
        delete('address','user_id',"$id");
    }

delete('users','user_id',"$user_id");

$dbcon->exec("SET FOREIGN_KEY_CHECKS = 1");
$_SESSION['message'] = [
    'title' => 'Success',
    'message' => 'Product deleted successfully',
    'type' => 'success'
];
header('Location:viewUsers.php');



