<?php
$data = select(
    '*',
    'orders',
    "JOIN users ON orders.user_id = users.user_id 
    WHERE 
        (orders.is_accepted = '0') 
        OR 
        (orders.is_accepted = '1' AND delivery_date IS NOT NULL)
    ORDER BY order_id DESC"
);

?>

<div class="d-flex justify-content-between mt-4 mb-1">
    <h3>Old Orders</h3>
</div>

<div class="table-responsive">
    <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">User</th>
                <th scope="col">Order Id</th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th scope="col">Order Date</th>
                <th scope="col">Delivery Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $key => $item) { ?>
                <tr>
                    <td><?= ++$key ?></td>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['order_id'] ?></td>
                    <td><?= $item['total'] ?></td>
                    <td><?= $item['is_accepted']==1?'Accepted':'Rejected' ?></td>
                    <td><?= $item['order_date'] ?></td>
                    <td><?= $item['delivery_date'] ?></td>
                    <td class="d-flex"> <a href="viewoldOrder.php?id=<?= $item['order_id'] ?>"><button class="btn btn-primary"><i class="fa-solid fa-eye" style="color: #fff;"></i> View</button></a>
                        <form action="" method="post">
                            <input type="hidden" name="order_id" value="<?= $item['order_id'] ?>">

                        </form>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</div>