<?php
// getting id from the url
$id = $_GET['id'];


delete('productvariation','product_id',$id);
delete('orderproducts','product_id',$id);

// removing image from the storage
$images = select('name','productgallery','WHERE product_id ='. $id);
foreach ($images as $image) {
    if (file_exists(public_path($image['name']))) {
        unlink(public_path($image['name']));
    }
}

// delete product images
delete('productgallery','product_id',$id);

// delete product
delete('product','product_id',$id);

// message
$_SESSION['message'] = [
    'title' => 'Success',
    'message' => 'Product Deleted Successfully',
    'type' => 'success'
];
// redirecting to the view product page
header('Location:viewProduct.php');