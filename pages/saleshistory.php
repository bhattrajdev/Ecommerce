<?php
$user_id = $_SESSION['users_id'];

$data = select('*', 'product', "WHERE seller_id = $user_id");

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


<?php if (empty($data)) { ?>
    <h4 class="no_data_found container mt-4" style="min-height:80vh;">No Data Found</h4>
<?php } else { ?>
    <div class="container order" style="margin-top: 20px;">
        <h4>SALES HISTORY</h4>
        <a href="<?= url('history') ?>" class="sold_btn">ORDER HISTORY</a>
    </div>
    <div class="container" style="min-height:80vh;">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Action</th>
                    <th>Order Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key => $item) { ?>
                    <?php
                    $data2 = select('*', 'orders', "JOIN orderproducts ON orderproducts.order_id = orders.order_id 
            JOIN product ON product.product_id = orderproducts.product_id 
            WHERE orderproducts.product_id = " . $item['product_id']);
                
                    ?>

                    <tr>
                        <td><?= ++$key ?></td>
                        <td><?= $item['name'] ?></td>
                        <td>RS <?= $item['price'] ?></td>
                        <td>
                            <a href="sellerproductdetail?id=<?= $item['product_id'] ?>"><button class="btn btn-success"> <i class="fa-solid fa-eye"></i> View</button></a>
                            <?php if (empty($data2)) { ?>
                                <a href="editsellerproduct?id=<?= $item['product_id'] ?>"><button class="btn btn-primary"> <i class="fa-solid fa-eye"></i> Edit</button></a>
                                <a href="deletesellerproduct?id=<?= $item['product_id'] ?>"><button class="btn btn-danger"> <i class="fa-solid fa-eye"></i> Delete</button></a>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if (!empty($data2)) { ?>
                                <a href="requests.php?id=<?= $item['product_id'] ?>">
                                    <button class="btn btn-secondary"><i class="fa-solid fa-eye"></i> View Requests</button>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>