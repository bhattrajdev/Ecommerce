<?php

$order_id = $_GET['id'];
$output = select(
    'users.name AS user_name, 
    users.email AS user_email,
    address.address AS delivery_address, 
    address.email AS address_email, 
    address.phone AS address_phone,
    product.name AS product_name,
    color.name AS product_color,
    size.name AS product_size,
    orderproducts.quantity AS product_quantity,
    orders.total,
    orders.order_date,
    orders.payment_method,
    orders.delivery_date,
    orders.order_id',
    'orders',
    "JOIN users ON orders.user_id = users.user_id
    JOIN address ON orders.address_id = address.address_id 
    JOIN orderproducts ON orders.order_id = orderproducts.order_id
    JOIN productvariation ON orderproducts.productvariation_id = productvariation.productvariation_id
    JOIN product ON productvariation.product_id = product.product_id
    JOIN color ON productvariation.color_id = color.color_id
    JOIN size ON productvariation.size_id = size.size_id
    WHERE orders.order_id = $order_id
    ORDER BY orders.order_id DESC
    "
);
$data = $output[0];

// Separating product name
$product_name = explode(',', $data['product_name']);

// Separating product color
$product_color = explode(',', $data['product_color']);

// Separating product size
$product_size = explode(',', $data['product_size']);

// Separating product qunatity
$product_quantity = explode(',', $data['product_quantity']);


// handling accept and reject
if (isset($_POST)) {
    $email = $data['user_email'];
    $order_date = $data['order_date'];
    $delivery_address = $data['delivery_address'];
    $total = $data['total'];
    // handle accept 
    if (isset($_POST['accept'])) {
        $data = [
            'is_accepted' => 1,
        ];
        update('orders', $data, "order_id = $order_id");
        $message = "Dear Customer,<br><br>

Thank you for choosing SneakerStation. We are delighted to inform you that your order has been successfully placed and is currently being processed. <br>
Your order will be delivered to the provided delivery address within 3 to 5 working days.<br><br>

If you have any questions or need any assistance, please don't hesitate to reach out to our customer support team.<br><br>

Here are the details of your order:<br>
- Order Number: {$order_id}<br>
- Order Date: {$order_date}<br>
- Delivery Address: {$delivery_address}<br>
- Total Amount: {$total}<br><br>

Thank you for shopping with us. We look forward to serving you again in the future.<br><br>

Best regards,<br>
The SneakerStation Team";


        phpmailer($email, $message, "Order Placed Successfully");
        header('Location:newOrders.php');
    }
    // handle reject 
    if (isset($_POST['reject'])) {
    }
}

?>
<div class="container mt-4 pt-4 card">
    <!-- User Details Card -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>User Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Name:</div>
                        <div class="col-md-8"><?= $data['user_name'] ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Email:</div>
                        <div class="col-md-8"><?= $data['user_email'] ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Details Card -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Delivery Address</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Address:</div>
                        <div class="col-md-8"><?= $data['delivery_address'] ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Email:</div>
                        <div class="col-md-8"><?= $data['address_email'] ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Contact:</div>
                        <div class="col-md-8"><?= $data['address_phone'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- order Details Card -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Order Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Total Price:</div>
                        <div class="col-md-8"><?= $data['total'] ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Placed On:</div>
                        <div class="col-md-8"><?= $data['order_date'] ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Delivery Detail</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Payment Type:</div>
                        <div class="col-md-8"><?= $data['payment_method'] ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Delivery Date</div>
                        <div class="col-md-8"><?= $data['delivery_date'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Details Table -->
    <div class="card">
        <div class="card-header">
            <h4>Orders</h4>
        </div>
        <div class="card-body">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Size</th>
                        <th>Color</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <?php for ($i = 0; $i < count($product_name); $i++) { ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $product_name[$i] ?></td>
                            <td><?= $product_quantity[$i] ?></td>
                            <td><?= $product_size[$i] ?></td>
                            <td><?= $product_color[$i] ?></td>
                        </tr>
                    <?php } ?> -->
                    <?php foreach ($output as $key => $data) { ?>
                        <tr>
                            <td><?= ++$key ?></td>
                            <td><?= $data['product_name'] ?></td>
                            <td><?= $data['product_quantity'] ?></td>
                            <td><?= $data['product_size'] ?></td>
                            <td><?= $data['product_color'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- for accept and reject buttons  -->

</div>