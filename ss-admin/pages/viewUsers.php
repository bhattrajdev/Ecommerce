<?php
$data = select('*', 'users');


?>

<div class="d-flex justify-content-between mt-4 mb-1">
    <h3>Users</h3>
</div>

<div class="table-responsive">
    <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">History</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $key => $item) { ?>
                <tr>
                    <td><?= ++$key ?></td>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['email'] ?></td>
                    <td>
                        <a href="userSales.php?user_id=<?= $item['user_id'] ?>"><button class="btn btn-success"><i class="fa-solid fa-eye"></i> Sales</button></a>
                        <a href="userPurchase.php?user_id=<?= $item['user_id'] ?>"><button class="btn btn-primary"><i class="fa-solid fa-eye"></i> Purchase</button></a>
                    </td>
                    <td>
                        <a href="deleteUsers.php?user_id=<?= $item['user_id'] ?>"><button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete ?')"> <i class=" fa-solid fa-trash"></i> Delete</button></a>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</div>