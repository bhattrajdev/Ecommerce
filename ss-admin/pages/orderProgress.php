<?php
$data = select('*', 'orders', "JOIN users ON orders.user_id = users.users_id JOIN address ON orders.address_id = address.address_id WHERE orders.is_accepted = '1' AND orders.is_delivered ='0'  ORDER BY order_id DESC");

$email = $_SESSION['email'];
// handling marked as delivered button
if (isset($_POST)) {
    if (isset($_POST['markasdelivered'])) {
        $orderid = $_POST['order_id'];
        $query = select('order_id,order_date,address,total','orders', "JOIN address ON orders.address_id = address.address_id WHERE orders.order_id = $orderid ");
        $order_id = $query[0]['order_id'];
        $order_date = $query[0]['order_date'];
        $delivery_address = $query[0]['address'];
        $total = $query[0]['total'];
        $data = [
            'is_paid' => 1,
            'is_delivered' => 1,
            'delivery_date' => date("Y-m-d"),
        ];
        update('orders', $data, "order_id = $orderid");
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

<div class="d-flex justify-content-between mt-4 mb-1">
    <h3>Order Progress</h3>
</div>

<div class="table-responsive">
    <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">User</th>
                <th scope="col">Price</th>
                <th scope="col">Order Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $key => $item) { ?>
                <tr>
                    <td><?= ++$key ?></td>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['total'] ?></td>
                    <td><?= $item['order_date'] ?></td>
                    <td class="d-flex"> <a href="vieworderProgress.php?id=<?= $item['order_id'] ?>"><button class="btn btn-primary"><i class="fa-solid fa-eye" style="color: #fff;"></i> View</button></a>
                        <form action="" method="post">
                            <input type="hidden" name="order_id" value="<?= $item['order_id'] ?>">

                            <?php if ($item['is_shipped'] == 0) { ?>
                                <button class="btn btn-success mx-4" name="markasshipped"><i class="fa-solid fa-check" style="color: #fff;"></i> Mark As Shipped</button>
                            <?php } else { ?>
                                <button class="btn btn-success mx-4" name="markasdelivered"><i class="fa-solid fa-check" style="color: #fff;"></i> Mark As Delivered</button>
                            <?php } ?>
                        </form>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
                            </div>