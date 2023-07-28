<?php
$user_id = $_SESSION['users_id'];
$product_id = $_GET['id'];
$detalis = select('*', 'product', "WHERE product_id = $product_id");

$element = select(
    ' users.name AS user_name,
    product.name AS product_name,
    users.email AS user_email,
    product.quantity AS product_quantity,
    product.quantity AS total_quantity,
    address.address AS delivery_address,
    address.email AS delivery_email,
    address.phone AS delivery_phone,
    orders.is_accepted,
    orders.is_shipped,
    orders.order_date,
    orders.is_paid,
    orders.order_id,
    orders.is_delivered,
    orders.delivery_date,
    orders.total,
    orderproducts.quantity AS ordered_quantity',
    'orders',
    "JOIN orderproducts ON orderproducts.order_id = orders.order_id 
JOIN product ON product.product_id = orderproducts.product_id 
JOIN users ON users.user_id = orders.user_id 
JOIN address ON address.address_id = orders.address_id
WHERE orderproducts.product_id = $product_id ORDER BY order_id DESC"
);
if (!empty($element)) {
    $data = $element[0];
}



if (!empty($_POST)) {
    $email = $data['user_email'];
    $order_date = $data['order_date'];
    $delivery_address = $data['delivery_address'];
    $total = $data['total'];
    $order_id = $_POST['order_id'];
    if (isset($_POST['accept'])) {
        $orderData = select('*', 'orders', "WHERE order_id = $order_id");
        if (!empty($orderData)) {
            $orderedProductData = select('*', 'orderproducts', "WHERE order_id = $order_id");
            if (!empty($orderedProductData)) {
                foreach ($orderedProductData as $item) {
                    $product_id = $item['product_id'];
                    $ordered_quantity = $item['quantity'];
                    $productData = select('*', 'product', "WHERE product_id = $product_id");
                    if (!empty($productData)) {
                        $current_quantity = $productData[0]['quantity'];
                        if ($current_quantity == 0) {
                            $_SESSION['message'] = [
                                'title' => 'Error',
                                'message' => 'The quantity is 0 so no orders can be taken',
                                'type' => 'error'
                            ];
                            header("Location:");
                        } else {
                            $new_quantity = $current_quantity - $ordered_quantity;

                            $productUpdateData = [
                                'quantity' => $new_quantity,
                            ];
                            update('product', $productUpdateData, "product_id = $product_id");
                        }
                    }
                }
                $orderUpdateData = [
                    'is_accepted' => 1,
                ];
                update('orders', $orderUpdateData, "order_id = $order_id");
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
                header("Refresh:0");
            }
        }
    }

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
        header("Refresh:0");
    }
    if (isset($_POST['markedasshipped'])) {
        $data = [
            'is_shipped' => 1
        ];
        update('orders', $data, "order_id = $order_id");
        header("Refresh:0");
    }
    if (isset($_POST['markedasdelivered'])) {
        $data = [
            'is_paid' => 1,
            'is_delivered' => 1,
            'delivery_date' => date("Y-m-d"),
        ];
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
        update('orders', $data, "order_id = $order_id");
        // header("Refresh:0");
    }
}
?>
<style>
    .order {
        display: flex;
        justify-content: space-between;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
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

    .order-status {
        font-weight: bold;
        text-transform: uppercase;
    }

    .order-status.shipped {
        color: #ffcc00;
        /* color: yellow; */
    }

    .order-status.accepted {
        color: #3366ff;
    }

    .order-status.delivered {
        color: #00cc66;
    }

    .order-status.rejected {
        color: #FF0000;
    }

    .order-status .pending {
        color: #993333;
    }

    a {
        text-decoration: none;
        color: blue;
    }
</style>


<?php if (empty($element)) { ?>
    <h4 class="no_data_found container mt-4" style="min-height:80vh;">No Data Found</h4>
<?php } else { ?>
    <div class="container order mb-4" style="margin-top: 20px;">
        <?php foreach ($detalis as $item) { ?>
            <h3><?= $item['name'] ?></h3>
            <h4>Quantity Available: <?= $item['quantity'] ?></h4>
        <?php } ?>
    </div>
    <div class="container" style="min-height:80vh;">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Ordered Quantity</th>
                    <th>User Email</th>
                    <th>Order Date</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>View</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($element as $key => $item) { ?>

                    <tr>
                        <td><?= ++$key ?></td>
                        <td><?= $item['user_name'] ?></td>
                        <td><?= $item['ordered_quantity'] ?></td>
                        <td><?= $item['user_email'] ?></td>
                        <td><?= $item['order_date'] ?></td>
                        <td><?= $item['is_paid'] == 0 ? 'Pending' : 'Done' ?></td>
                        <td>
                            <?php
                            if ($item['is_accepted'] == '') {
                                echo "<span class='order-status shipped'>pending</span>";
                            } elseif ($item['is_accepted'] === 0) {
                                echo "<span class='order-status shipped'>rejected</span>";
                            } elseif ($item['is_accepted'] == 1 && $item['is_shipped'] == 0) {
                                echo "<span class='order-status shipped'>accepted</span>";
                            } elseif ($item['is_shipped'] == 1 && $item['is_delivered'] == 0) {
                                echo "<span class='order-status shipped'>shipped</span>";
                            } elseif ($item['is_delivered'] == 1 && $item['delivery_date'] != null) {
                                echo "<span class='order-status shipped'>delivered</span>";
                            }
                            ?>
                        </td>
                        <td> <a href="viewRequests.php?id=<?= $item['order_id'] ?>"><Button class="btn btn-success"><i class="fa-solid fa-eye"></i> View</Button></a></td>
                        <td>
                            <form method="post" action="#">
                                <input type="hidden" value="<?= $item['order_id'] ?>" name="order_id">
                                <?php if ($item['order_id'] !== null && $item['is_accepted'] == '') { ?>
                                    <button class="btn btn-success" name="accept">Accept</button>
                                    <button class="btn btn-danger" name="reject">Reject</button>
                                <?php } elseif ($item['is_accepted'] == 1 && $item['is_shipped'] == 0) { ?>
                                    <button class="btn btn-success" name="markedasshipped">Mark as shipped</button>
                                <?php } elseif ($item['is_shipped'] == 1 && $item['is_delivered'] == 0) { ?>
                                    <button class="btn btn-success" name="markedasdelivered">Mark as delivered</button>
                                <?php } ?>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>