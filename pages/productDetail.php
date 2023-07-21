<?php
$product_id = $_GET['id'];

// Add to cart and buy now
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['name']) || !isset($_SESSION['email']) || !isset($_SESSION['users_id'])) {
        header('Location: login.php');
        exit();
    }

    $user_id = $_SESSION['users_id'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $productname = $_POST['productname'];
    $productprice = $_POST['productprice'];
    $productimage = $_POST['singleimage'];

    if (!empty($size) && !empty($color)) {
        if (isset($_POST['add_to_cart'])) {
            $data = select('*', 'productvariation', "WHERE product_id = $product_id AND color_id = $color AND size_id = $size");

            if (!empty($data)) {
                $productvariation_id = $data[0]['productvariation_id'];

                // Check if the item already exists in the cart
                $itemExists = false;
                $cartItems = $_SESSION['cartdata'];

                foreach ($cartItems as $cart) {
                    if ($cart['user_id'] == $user_id && $cart['product_id'] == $product_id && $cart['productvariation_id'] == $productvariation_id) {
                        $itemExists = true;
                        break;
                    }
                }

                if ($itemExists) {
                    // Give an error message if the product already exists in the cart
                    $_SESSION['message'] = [
                        'title' => 'Error',
                        'message' => 'The product already exists in the cart with the same size and color.',
                        'type' => 'error'
                    ];
                } else {
                    $cartData = [
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'productvariation_id' => $productvariation_id,
                        'quantity' => $quantity,
                        'product_image' => $productimage,
                        'product_name' => $productname,
                        'product_price' => $productprice,
                    ];

                    // store the data in session
                    $_SESSION['cartdata'][] = $cartData;
                    $_SESSION['message'] = [
                        'title' => 'Success',
                        'message' => 'Product successfully added to the cart.',
                        'type' => 'success'
                    ];
                }
            } else {
                $_SESSION['message'] = [
                    'title' => 'Error',
                    'message' => 'No matching product variation found.',
                    'type' => 'error'
                ];
            }
        } elseif (isset($_POST['buy_now'])) {
            // Handle buy now functionality
            echo "Hello world, this is buy now.";
        }
    } else {
        $_SESSION['message'] = [
            'title' => 'Error',
            'message' => 'Please select the desired size and color.',
            'type' => 'error'
        ];
    }

    header("Refresh:0");
}



// query to fetch data from tables
$element = select(
    "product.discount AS product_discount,
    product.description AS product_description, 
    product.product_id AS product_id, 
    product.name AS product_name, 
    product.price AS product_price,
    brand.name AS brand_name, 
    category.name AS category_name, 
    GROUP_CONCAT(DISTINCT productgallery.name) AS images,
    (
        SELECT GROUP_CONCAT(DISTINCT color.color_id, ':', color.name)
        FROM productvariation
        JOIN color ON productvariation.color_id = color.color_id
        WHERE productvariation.product_id = product.product_id
    ) AS colors,
    (
        SELECT GROUP_CONCAT(DISTINCT size.size_id, ':', size.name)
        FROM productvariation
        JOIN size ON productvariation.size_id = size.size_id
        WHERE productvariation.product_id = product.product_id
    ) AS sizes",
    "product
    JOIN brand ON product.brand_id = brand.brand_id
    JOIN category ON product.category_id = category.category_id
    JOIN productgallery ON product.product_id = productgallery.product_id
    WHERE product.product_id = $product_id
    GROUP BY product.product_id"
);

// accessing the 0th element of the array
$data = $element[0];



// separating images
$image = $data['images'];
$images = explode(',', $image);


// separating colors
$color = $data['colors'];
$colorArray = explode(',', $color);

$colorsData = [];
foreach ($colorArray as $colorItem) {
    $colorValues = explode(':', $colorItem);
    $colorId = $colorValues[0];
    $colorName = $colorValues[1];

    $colorsData[] = [
        'color_id' => $colorId,
        'color_name' => $colorName,
    ];
}


// separating sizes
$size = $data['sizes'];
$sizeArray = explode(',', $size);

$sizesData = [];
foreach ($sizeArray as $sizeItem) {
    $sizeValues = explode(':', $sizeItem);
    $sizeId = $sizeValues[0];
    $sizeName = $sizeValues[1];

    $sizesData[] = [
        'size_id' => $sizeId,
        'size_name' => $sizeName,
    ];
}






?>






<section id="product-detail">
    <div class="main-wrapper">
        <div class="container demo">
            <div class="product-div">
                <div class="product-div-left">
                    <div class="img-container">
                        <img src="<?= url('public/' . $images[0]) ?>" alt="image not found">
                    </div>
                    <div class="hover-container">
                        <?php foreach ($images as $image) { ?>
                            <div>
                                <img src="<?= url('public/' . $image) ?>" class="img-fluid" alt="Image not found">
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="product-div-right">
                    <span class="product-name"><?= $data['product_name'] ?></span>
                    <span>
                        <span class="product-price"><?= $data['product_price'] ?></span>
                        <p class="product-description"><?= $data['product_description'] ?></p>
                        <form method="POST" action="">
                            <input type="hidden" name="singleimage" value="<?= $images[0] ?>">
                            <input type="hidden" name="productname" value="<?= $data['product_name'] ?>">
                            <input type="hidden" name="productprice" value="<?= $data['product_price'] ?>">
                            <div class="options">
                                <div>
                                    <span>Quantity:</span>
                                    <input type="number" class="quantity" name="quantity" value="1">
                                </div>
                                <div class="size">
                                    <span>Size:</span>
                                    <select name="size">
                                        <option value="" selected>Choose</option>
                                        <?php foreach ($sizesData as $sd) { ?>
                                            <option value="<?= $sd['size_id'] ?>"><?= $sd['size_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="color">
                                    <span>Color:</span>
                                    <select id="colorSelect" name="color">
                                        <option value="" selected>Choose</option>
                                        <?php foreach ($colorsData as $cd) { ?>
                                            <option value="<?= $cd['color_id'] ?>"><?= $cd['color_name'] ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="btn-groups">
                                <button type="submit" name="add_to_cart" class="add-cart-btn">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                                <button type="submit" name="buy_now" class="buy-now-btn">
                                    <i class="fa-solid fa-credit-card"></i> Buy Now
                                </button>
                            </div>
                </div>
                </form>
                </span>
            </div>

        </div>
    </div>
    </div>

</section>