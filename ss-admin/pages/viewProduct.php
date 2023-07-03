<?php
// $data = select('*','product','LEFT JOIN brand ON product.brand_id = brand.brand_id LEFT JOIN category ON product.category_id=category.category_id');


// $data = select('product.name AS product_name', 'brand.name AS brand_name', 'category.name AS category_name', 'product', 'LEFT JOIN brand ON product.brand_id = brand.brand_id', 'LEFT JOIN category ON product.category_id = category.category_id');
$data = select("product.product_id AS product_id,product.name AS product_name, product.price AS product_price, brand.name AS brand_name, category.name AS category_name", "product LEFT JOIN brand ON product.brand_id = brand.brand_id LEFT JOIN category ON product.category_id = category.category_id ORDER BY product.product_id DESC");

?>
<div class="d-flex justify-content-between mt-4 mb-1">
    <h3>View Product</h3>
    <a href="<?= url('ss-admin/addProduct.php') ?>" class="btn btn-success"> <i class="fa fa-plus" aria-hidden="true"></i> Add Product</a>
</div>

<div class="table-responsive">
    <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Brand</th>
                <th scope="col">Category</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $key => $info) { ?>
                <tr>
                    <td><?= ++$key ?></td>
                    <td><?= $info['product_name'] ?></td>
                    <td><?= $info['brand_name'] ?></td>
                    <td><?= $info['category_name'] ?></td>
                    <td><?= $info['product_price'] ?></td>
                    <td>
                        <a href="productDetail.php?id=<?= $info['product_id'] ?>" ><button class="btn btn-primary"><i class="fa-solid fa-eye" style="color: #fff;"></i></button></a>
                        <a href="editProduct.php?id=<?= $info['product_id']?>"><button class="btn btn-success" onclick="return confirm('Are you sure want to edit this product?')";><i class="fa-solid fa-pen-to-square" style="color: #fff;"></i></button></a>
                        <a href="deleteproduct.php?id=<?= $info['product_id'] ?>" onclick="return confirm('Are you sure want to delete this product')"><button class="btn btn-danger"><i class="fa-solid fa-trash" style="color: #fff;"></i></button></a>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</div>