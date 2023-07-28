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
                        <td> <a href="viewusersalesRequests.php?id=<?= $item['order_id'] ?>"><Button class="btn btn-success"><i class="fa-solid fa-eye"></i> View</Button></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>