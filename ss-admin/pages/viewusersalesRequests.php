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
    orders.order_id',
    'orders',
    "JOIN users ON orders.user_id = users.user_id
    JOIN address ON orders.address_id = address.address_id 
    JOIN orderproducts ON orders.order_id = orderproducts.order_id
    JOIN productvariation ON orderproducts.productvariation_id = productvariation.productvariation_id
    JOIN product ON productvariation.product_id = product.product_id
    JOIN color ON productvariation.color_id = color.color_id
    JOIN size ON productvariation.size_id = size.size_id
    WHERE orders.order_id = $order_id"
);
$data = $output[0];

?>
<div class="container mt-4 pt-4 ">
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
                    <h4>Delivery Details</h4>
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


    </div>
</div>