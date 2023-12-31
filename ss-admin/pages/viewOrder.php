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
    orders.order_id,
    orders.is_paid,
    orders.payment_method
    ',
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

// echo "<pre>";
// print_r($data);
// die();


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
- Order id: {$order_id}<br>
- Order Date: {$order_date}<br>
- Delivery Address: {$delivery_address}<br>
- Total Amount: {$total}<br><br>

Thank you for shopping with us. We look forward to serving you again in the future.<br><br>

Best regards,<br>
The SneakerStation Team";


        phpmailer($email, $message, "Order Placed Successfully");
        $_SESSION['message'] = [
            'title' => 'Success',
            'message' => 'Order marked as accepted successfully',
            'type' => 'success'
        ];
        header('Location:newOrders.php');
    }
    // handle reject 
    if (isset($_POST['reject'])) {
        $data = [
            'is_accepted' => 0,
        ];
        update('orders', $data, "order_id = $order_id");
        $message = "  Dear Customer,
We hope this email finds you well. We regret to inform you that your recent order with SneakerStation has been canceled. We apologize for any inconvenience this may have caused.<br>
Your satisfaction is our top priority, and we understand the importance of a seamless shopping experience.<br><br>
The following are the details of the canceled order:<br><br>
Order ID: {$order_id}<br>
Order Date: {$order_date}<br>
Delivery Address: {$delivery_address}<br>
Total Amount: {$total}<br>
If you have already made a payment for the order, rest assured that the amount will be refunded to your original payment method within the next 3 to 5 working days.<br>
We understand that order cancellations can be frustrating, and we would like to extend our assistance in case you have any concerns or questions regarding the cancellation. <br>
Please don't hesitate to reach out to our customer support team, and we'll be more than happy to assist you.<br><br>
Once again, we apologize for any disappointment caused by this cancellation. We value your patronage and sincerely hope that this experience won't deter you from considering SneakerStation for future purchases.
<br><br>
Thank you for your understanding.
<br><br>
Best regards,
<br><br>
The SneakerStation Team";

        phpmailer($email, $message, "Order Cancellation Notification");
        $_SESSION['message'] = [
            'title' => 'Success',
            'message' => 'Order marked as rejected successfully',
            'type' => 'success'
        ];
        header('Location:newOrders.php');
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

        <?php if ($data['payment_method'] != null) { ?>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 font-weight-bold">Payment Type:</div>
                            <div class="col-md-8"><?= $data['payment_method'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 font-weight-bold">Paid:</div>
                            <div class="col-md-8"><?= $data['is_paid'] == 0 ? 'Pending' : 'Done' ?></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
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
        <div class="d-flex justify-content-end my-4 ">
            <button class="btn btn-danger mx-2" name="reject">Reject</button>
            <button class="btn btn-success" name="accept">Accept</button>
        </div>
    </form>
</div>