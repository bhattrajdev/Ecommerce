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
    if (isset($_POST['checkout'])) {
        $_SESSION['total'] = $_POST['total'];
        header('Location:checkout.php');
    }

    // Handle quantity update
    if (isset($_POST['action']) && isset($_POST['index'])) {
        $index = $_POST['index'];
        $action = $_POST['action'];

        if ($action === 'increase') {
            if ($_SESSION['cartdata'][$index]['max_quantity'] === null || $_SESSION['cartdata'][$index]['quantity'] < $_SESSION['cartdata'][$index]['max_quantity']) {
                $_SESSION['cartdata'][$index]['quantity']++;
            }
        } elseif ($action === 'decrease' && $_SESSION['cartdata'][$index]['quantity'] > 1) {
            $_SESSION['cartdata'][$index]['quantity']--;
        }
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

                <?php foreach ($_SESSION['cartdata'] as $index => $cartItem) { ?>
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
                            <form method="post" action="">
                                <input type="hidden" name="index" value="<?= $index ?>">
                                <button class="quantity-btn decrease" name="action" value="decrease" <?php if ($cartItem['quantity'] <= 1) echo 'disabled'; ?>>-</button>
                                <span class="quantity-value"><?= $cartItem['quantity'] ?></span>
                                <?php if ($cartItem['max_quantity'] === null || $cartItem['quantity'] < $cartItem['max_quantity']) { ?>
                                    <button class="quantity-btn increase" name="action" value="increase">+</button>
                                <?php } ?>
                            </form>
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
                        <button class="checkout" name="checkout" style="text-align: center;">Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <h1 class="container">No Data Found</h1>
    <?php } ?>
</section>

<script>
    // Function to update totals
    function updateTotals() {
        let subTotal = 0;
        <?php foreach ($_SESSION['cartdata'] as $cartItem) { ?>
            subTotal += <?= $cartItem['product_price'] ?> * <?= $cartItem['quantity'] ?>;
            <?php if ($cartItem['max_quantity'] === null) { ?>
                // If max_quantity is null, allow the user to increase the quantity without restrictions
                const increaseBtn = document.querySelector(`[name="action"][value="increase"][data-index="<?= $index ?>"]`);
                if (increaseBtn) {
                    increaseBtn.disabled = false;
                }
            <?php } ?>
        <?php } ?>
        const vat = (subTotal * 12) / 100;
        const shipping = 200;
        const grandTotal = subTotal + vat + shipping;

        document.getElementById('cart-subtotal').textContent = subTotal.toFixed(2);
        document.getElementById('cart-tax').textContent = vat.toFixed(2);
        document.getElementById('cart-total').textContent = grandTotal.toFixed(2);
    }
</script>