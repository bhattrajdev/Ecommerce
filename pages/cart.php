   <?php
 if (!isset($_SESSION['name']) && !isset($_SESSION['email'])) {
        header('location:login.php');
} 





?>
   
   
   <section id="cart">
        <div class="container">
            <!-- <h1>Shopping Cart</h1> -->

            <div class="shopping-cart">

                <div class="column-labels">
                    <label class="product-image cart-label">Image</label>
                    <label class="product-details cart-label">Product</label>
                    <label class="product-price cart-label">Price</label>
                    <label class="product-quantity cart-label">Quantity</label>
                    <label class="product-line-price cart-label">Total</label>
                </div>

                <div class="product">
                    <div class="product-removal">
                        <button class="remove-product">
                            <i class="fa-sharp fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="product-image">
                        <img src="https://th.bing.com/th/id/OIP.RAk0wTpA1sO5rqsVXz1MZQHaE8?pid=ImgDet&rs=1" width="100">
                    </div>
                    <div class="product-details">
                        <div class="product-title">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi, reiciendis? </div>
                    </div>
                    <div class="product-price">12.99</div>
                    <div class="product-quantity">
                        <button class="quantity-btn decrease">-</button>
                        <span class="quantity-value">2</span>
                        <button class="quantity-btn increase">+</button>
                    </div>

                    <div class="product-line-price">25.98</div>
                </div>

                <hr class="separator">

                <div class="product">
                    <div class="product-removal">
                        <button class="remove-product">
                            <i class="fa-sharp fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="product-image">
                        <img src="https://th.bing.com/th/id/OIP.RAk0wTpA1sO5rqsVXz1MZQHaE8?pid=ImgDet&rs=1" width="100">
                    </div>
                    <div class="product-details">
                        <div class="product-title">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Delectus, voluptatum?
                        </div>

                    </div>
                    <div class="product-price">45.99</div>
                    <div class="product-quantity">
                        <button class="quantity-btn decrease">-</button>
                        <span class="quantity-value">2</span>
                        <button class="quantity-btn increase">+</button>
                    </div>

                    <div class="product-line-price">45.99</div>
                </div>
                <hr class="separator">
                <!-- for items total -->
                <div class="totals">
                    <div class="totals-item">
                        <label>Subtotal</label>
                        <div class="totals-value" id="cart-subtotal">71.97</div>
                    </div>
                    <div class="totals-item">
                        <label>Tax (5%)</label>
                        <div class="totals-value" id="cart-tax">3.60</div>
                    </div>
                    <div class="totals-item">
                        <label>Shipping</label>
                        <div class="totals-value" id="cart-shipping">15.00</div>
                    </div>
                    <div class="totals-item totals-item-total">
                        <label>Grand Total</label>
                        <div class="totals-value" id="cart-total">90.57</div>
                    </div>
                    <button class="checkout">Checkout</button>
                </div>
            </div>
        </div>


    </section>