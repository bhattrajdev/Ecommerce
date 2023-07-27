<?php
            // $data = select('*', 'orders', "JOIN users ON orders.user_id = users.user_id WHERE orders.is_accepted IS NULL  ORDER BY order_id DESC");
            $data = select(
                '*',
                'orders',
                "JOIN users ON orders.user_id = users.user_id
    JOIN orderproducts ON orders.order_id = orderproducts.order_id
    JOIN product ON orderproducts.product_id = product.product_id 
    WHERE orders.is_accepted IS NULL AND product.seller_id IS NULL 
    ORDER BY orders.order_id DESC"
            );


?>

<div class="d-flex justify-content-between mt-4 mb-1">
    <h3>New Orders</h3>
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
                    <td> <a href="viewOrder.php?id=<?= $item['order_id'] ?>"><button class="btn btn-primary"><i class="fa-solid fa-eye" style="color: #fff;"></i> View</button></a></td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</div>