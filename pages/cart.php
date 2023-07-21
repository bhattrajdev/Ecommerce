<?php
if (!isset($_SESSION['name']) && !isset($_SESSION['email']) && !isset($_SESSION['users_id'])) {
    header('location:login.php');
    exit();
} else {
    if (isset($_POST['remove'])) {
        $id = $_POST['remove'];
        foreach ($_SESSION['cartdata'] as $index => $cartItem) {
            if ($cartItem['product_id'] == $id) {
                unset($_SESSION['cartdata'][$index]);
                break;
            }
        }
        header('Location:cart.php');
        $_SESSION['message'] = [
            'title' => 'Success',
            'message' => 'Product Successfully Removed From Cart',
            'type' => 'success'
        ];
    }
    if(isset($_POST['checkout'])){
        $_SESSION['total']=$_POST['total'];
        header('Location:checkout.php');
    }
}

// getting user id
$user_id = $_SESSION['users_id'];




// Displaying cart items
$subTotal = 0;
?>

<section id="cart">
    <?php if (!empty($_SESSION['cartdata']) && $_SESSION['users_id'] == $user_id) { ?>
        <div class="container">
            <div class="shopping-cart">
                <div class="column-labels">
                    <label class="product-image cart-label">Image</label>
                    <label class="product-details cart-label">Product</label>
                    <label class="product-price cart-label">Price</label>
                    <label class="product-quantity cart-label">Quantity</label>
                    <label class="product-line-price cart-label">Total</label>
                </div>

                <?php foreach ($_SESSION['cartdata'] as $cartItem) { ?>
                    <div class="product">
                        <div class="product-removal">
                            <form method="post" action="">
                                <button type="submit" class="remove-product" name="remove" value="<?= $cartItem['product_id']; ?>" onclick="return confirm('Are you sure you want to remove this product from the cart?')">
                                    <i class="fa-sharp fa-solid fa-xmark"></i>
                                </button>
                            </form>
                        </div>
                        <div class="product-image">
                            <img src="<?= url('public/' . $cartItem['product_image']) ?>" width="100">
                        </div>
                        <div class="product-details">
                            <div class="product-title"><?= $cartItem['product_name'] ?> </div>
                        </div>
                        <div class="product-price"><?= $cartItem['product_price'] ?></div>
                        <div class="product-quantity">
                            <button class="quantity-btn decrease">-</button>
                            <span class="quantity-value"><?= $cartItem['quantity'] ?></span>
                            <button class="quantity-btn increase">+</button>
                        </div>
                        <div class="product-line-price"><?= $cartItem['product_price'] * $cartItem['quantity'] ?></div>
                    </div>

                    <hr class="separator">
                    <?php $subTotal += $cartItem['product_price'] * $cartItem['quantity']; ?>
                <?php } ?>

                <!-- Totals section -->
                <div class="totals">
                    <form action="" method="post">
                        <div class="totals-item">
                            <label>Subtotal</label>
                            <div class="totals-value" id="cart-subtotal"><?= $subTotal ?></div>
                        </div>
                        <div class="totals-item">
                            <label>VAT (13%)</label>
                            <div class="totals-value" id="cart-tax"><?= ($subTotal * 12) / 100 ?></div>
                        </div>
                        <div class="totals-item">
                            <label>Shipping</label>
                            <div class="totals-value" id="cart-shipping">200</div>
                        </div>
                        <div class="totals-item totals-item-total">
                            <label>Grand Total</label>
                            <div class="totals-value" id="cart-total"><?= $subTotal + ($subTotal * 12) / 100 + 200 ?></div>
                            <input type="hidden" name="total" value="<?= $subTotal + ($subTotal * 12) / 100 + 200 ?>">
                        </div>
                        <button class="checkout" name="checkout" style="text-align: center;"> Checkout</a>
                </div>
                </form>
            </div>
        </div>
    <?php } else { ?>
        <h1 class="container">No Data Found</h1>
    <?php } ?>
</section>