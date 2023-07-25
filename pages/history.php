<?php
$user_id = $_SESSION['users_id'];
$data = select('*', 'orders', "WHERE user_id = $user_id ORDER BY order_id DESC");
?>

<style>
    .order{
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

<?php if (empty($data)) { ?>
    <h2 class="no_data_found container mt-4" style="min-height:80vh;">No Data Found</h2>
<?php } else { ?>
    <div class="container order" style="margin-top: 20px;">
        <h2>ORDER HISTORY</h2>
       <a href="#" class="sold_btn">SOLD HISTORY</a>
    </div>
    <div class="container" style="min-height:80vh;">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key => $item) { ?>
                    <tr>
                        <td><?= ++$key ?></td>
                        <td><?= $item['order_id'] ?></td>
                        <td><?= $item['order_date'] ?></td>
                        <td>RS <?= $item['total'] ?></td>
                        <?php
                        if ($item['is_accepted'] == null) { ?>
                            <td class="order-status pending">Pending</td>
                            <?php } else {
                            if ($item['is_accepted'] == 0) { ?>
                                <td class="order-status rejected">Rejected</td>
                                <?php } else {
                                if ($item['is_accepted'] == 1 && $item['is_shipped'] == 0) { ?>
                                    <td class="order-status accepted">Accepted</td>
                                <?php } elseif ($item['is_accepted'] == 1 && $item['is_shipped'] == 1 && $item['delivery_date'] == null) { ?>
                                    <td class="order-status shipped">Shipped</td>
                                <?php } else { ?>
                                    <td class="order-status delivered">Delivered</td>
                            <?php }
                            } ?>



                        <?php } ?>



                        <td><a href="vieworderHistory.php?id=<?= $item['order_id'] ?>"><i class="fa-solid fa-eye"></i> View</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>