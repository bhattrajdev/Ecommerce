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
    orders.delivery_date,
    orders.payment_method,
    orders.order_id',
    'orders',
    "JOIN users ON orders.user_id = users.users_id
    JOIN address ON orders.address_id = address.address_id 
    JOIN orderproducts ON orders.order_id = orderproducts.order_id
    JOIN productvariation ON orderproducts.productvariation_id = productvariation.productvariation_id
    JOIN product ON productvariation.product_id = product.product_id
    JOIN color ON productvariation.color_id = color.color_id
    JOIN size ON productvariation.size_id = size.size_id
    WHERE orders.order_id = $order_id"
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

?>

<!-- custom inline css -->
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        height: 100%;
    }

    table th,
    table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ccc;
    }

    table th {
        background-color: #f2f2f2;
    }

    .data {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .data input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 75px;
        width: 5px;

    }

    .data input:checked~.checkmark {
        background-color: red;
        height: 60px;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .data input:checked~.checkmark:after {
        display: block;
    }

    .data .checkmark:after {
        background: white;
        color: red;
    }

    .checkout-box {
        max-height: 326px;
        overflow-y: scroll;
    }


    .row {
        display: flex;
        flex-wrap: wrap;
        margin-top: 1.5rem;
    }

    .container {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }

    .col-md-8 {
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        margin-bottom: 1.5rem;
        border-radius: 0.25rem;
        border: 1px solid rgba(0, 0, 0, 0.125);
        background-color: #fff;
    }

    .card-header {
        padding: 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        background-color: #f8f9fa;
    }

    .py-3 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .card-body {
        flex: 1 1 auto;
        padding: 1.25rem;
    }

    .form-outline {
        margin-bottom: 1.5rem;
    }

    .form-label {
        margin-bottom: 0;
        display: inline-block;
    }

    .form-control {
        display: block;
        width: 100%;
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .col-md-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;

    }


    .card-header h5 {
        margin-bottom: 0;
    }

    .card-body form {
        margin-bottom: 0;
    }

    hr {
        margin-top: 1rem;
        margin-bottom: 1rem;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .horizonatal_row {
        border-bottom: 1px solid black;
    }

    .data h6 {
        margin-bottom: 0;
    }

    .checkout-box form {
        margin-bottom: 0;
    }

    .buttons {
        border: none;
        background: none;
    }


    @media (max-width: 600px) {

        .col-md-8,
        .col-md-4,
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
<div class="container mt-4 pt-4 ">
    <!-- User Details Card -->
    <div class="row">
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


        <!-- order Details Card -->

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


    <?php if ($data['delivery_date'] != null) { ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Delivery Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 font-weight-bold">Delivered On:</div>
                            <div class="col-md-8"><?= $data['delivery_date'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 font-weight-bold">Payment Type:</div>
                            <div class="col-md-8"><?= $data['payment_method'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Orders Details Table -->
    <div class="card">
        <div class="card-header">
            <h4>Orders</h4>
        </div>
        <div class="card-body">
            <table width="100%">
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
</div>