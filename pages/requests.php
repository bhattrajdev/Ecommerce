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
    orders.is_accepted,
    orders.is_shipped,
    orders.order_date,
    orders.is_paid,
    orders.is_delivered,
    orders.delivery_date,
    orders.order_id,
    orderproducts.quantity AS ordered_quantity',
    'orders',
    "JOIN orderproducts ON orderproducts.order_id = orders.order_id 
JOIN product ON product.product_id = orderproducts.product_id 
JOIN users ON users.user_id = orders.user_id 
JOIN address ON address.address_id = orders.address_id
WHERE orderproducts.product_id = $product_id ORDER BY order_id DESC"
);




if (!empty($_POST)) {
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
                            // header("Refresh:0");
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
                // header("Refresh:0");

            }
        }
    }

    if (isset($_POST['reject'])) {
        $data = [
            'is_accepted' => 0,
        ];
        update('orders', $data, "order_id = $order_id");
        // header("Refresh:0");
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
                        <td>
                            <a href="viewRequests.php?id=<?=$item['order_id']?>"><Button class="btn btn-success"><i class="fa-solid fa-eye"></i> View</Button></a>
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