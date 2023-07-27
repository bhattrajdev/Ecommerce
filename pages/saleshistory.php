<?php
$user_id = $_SESSION['users_id'];
// $data = select(
//     "product.product_id AS product_id,product.name AS product_name,
//  product.price AS product_price, brand.name AS brand_name, category.name AS category_name",
//     "product LEFT JOIN brand ON product.brand_id = brand.brand_id LEFT JOIN category ON 
//   product.category_id = category.category_id
//    WHERE product.seller_id = $user_id ORDER BY product.product_id DESC"
// );

$data = select('*','product', "JOIN orderproducts ON product.product_id = orderproducts.product_id
 JOIN orders ON orderproducts.order_id = orders.order_id WHERE product.seller_id = $user_id");
echo "<pre>";
print_r($data);

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
    <h2 class="no_data_found container mt-4" style="min-height:80vh;">No Data Found</h2>
<?php } else { ?>
    <div class="container order" style="margin-top: 20px;">
        <h2>SALES HISTORY</h2>
        <a href="<?= url('history') ?>" class="sold_btn">ORDER HISTORY</a>
    </div>
    <div class="container" style="min-height:80vh;">
        <table>
            <thead>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $key => $item) { ?>
                            <tr>
                                <td><?= ++$key ?></td>
                                <td><?= $item['product_name'] ?></td>
                                <td>RS <?= $item['product_price'] ?></td>
                                <td>Unsold</td>
                                <td><a href="sellerproductdetail.php?id=<?= $item['product_id'] ?>" class="btn btn-success"><i class="fa-solid fa-eye"></i> </a>
                                    <a href="editsellerproduct.php?id=<?= $item['product_id'] ?>" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i> </a>
                                    <a href="deletesellerproduct.php?id=<?= $item['product_id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i> </a>
                                </td>
                                <td>
                                    <button class="btn btn-secondary">Change status</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
    </div>
<?php } ?>