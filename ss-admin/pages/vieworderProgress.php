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
    orders.is_shipped,
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


// Separating product name
$product_name = explode(',', $data['product_name']);

// Separating product color
$product_color = explode(',', $data['product_color']);

// Separating product size
$product_size = explode(',', $data['product_size']);

// Separating product qunatity
$product_quantity = explode(',', $data['product_quantity']);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $data['user_email'];
    // for mark as delivered
    if (isset($_POST['markasdelivered'])) {
        $order_id = $_POST['order_id'];
        $query = select('order_id,order_date,address,total', 'orders', "JOIN address ON orders.address_id = address.address_id WHERE orders.order_id = $order_id ");
        $order_id = $query[0]['order_id'];
        $order_date = $query[0]['order_date'];
        $delivery_address = $query[0]['address'];
        $total = $query[0]['total'];
        $data = [
            'is_paid' => 1,
            'is_delivered' => 1,
            'delivery_date' => date("Y-m-d"),
        ];
        update('orders', $data, "order_id = $order_id");
        $message = "Dear Customer,<br><br>

Congratulations! Your order from SneakerStation has been successfully delivered to your provided delivery address. We hope you are delighted with your new sneakers!<br><br>

If you have any questions or need any assistance, please don't hesitate to reach out to our customer support team.<br><br>

Here are the details of your order:<br>
- Order Number: {$order_id}<br>
- Order Date: {$order_date}<br>
- Delivery Address: {$delivery_address}<br>
- Total Amount: {$total}<br><br>

Thank you for choosing SneakerStation. We value your business and look forward to serving you again in the future.<br><br>

Best regards,<br>
The SneakerStation Team";
phpmailer($email, $message, "Order Delivered");

        $_SESSION['message'] = [
            'title' => 'Success',
            'message' => 'Order marked as delivered successfully',
            'type' => 'success'
        ];
        header('Location:orderProgress.php');
    }
    // for mark as shipped
    if (isset($_POST['markasshipped'])) {
        $order_id = $_POST['order_id'];
        $query = select('order_id,order_date,address,total', 'orders', "JOIN address ON orders.address_id = address.address_id WHERE orders.order_id = $order_id ");
        $order_id = $query[0]['order_id'];
        $order_date = $query[0]['order_date'];
        $delivery_address = $query[0]['address'];
        $total = $query[0]['total'];
        $data = [
            'is_shipped' => 1
        ];
        update('orders', $data, "order_id = $order_id");
        $message = "Dear Customer,<br><br>

Thank you for choosing SneakerStation. We are pleased to inform you that your order has been shipped and is on its way to your provided delivery address. <br>
Your order is expected to be delivered within the next 3 to 5 working days.<br><br>

If you have any questions or need any assistance, please don't hesitate to reach out to our customer support team.<br><br>

Here are the details of your order:<br>
- Order Number: {$order_id}<br>
- Order Date: {$order_date}<br>
- Delivery Address: {$delivery_address}<br>
- Total Amount: {$total}<br><br>

We hope you enjoy your new sneakers! Thank you for shopping with us. Should you need anything else, feel free to contact us.<br><br>

Best regards,<br>
The SneakerStation Team";
phpmailer($email, $message, "Order Shipped");
        $_SESSION['message'] = [
            'title' => 'Success',
            'message' => 'Order marked as shipped successfully',
            'type' => 'success'
        ];
        header('Location:orderProgress.php');
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
        <form action="" method="post">
            <input type="hidden" name="order_id" value=<?=$data['order_id']?>>
            <div class="d-flex justify-content-end my-4 ">

                <?php if ($data['is_shipped'] == 0) { ?>
                    <button class="btn btn-success mx-4" name="markasshipped"><i class="fa-solid fa-check" style="color: #fff;"></i> Mark As Shipped</button>
                <?php } else { ?>
                    <button class="btn btn-success mx-4" name="markasdelivered"><i class="fa-solid fa-check" style="color: #fff;"></i> Mark As Delivered</button>
                <?php } ?>
            </div>
        </form>
    </div>