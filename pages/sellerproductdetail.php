<?php
$product_id  = $_GET['id'];

// query to fetch data from tables
$element = select(
    "product.discount AS product_discount,
                product.description AS product_description, 
                product.product_id AS product_id, 
                product.name AS product_name, 
                product.price AS product_price,
                brand.name AS brand_name, 
                category.name AS category_name, 
                GROUP_CONCAT(DISTINCT productgallery.name) AS images,
                (
                    SELECT GROUP_CONCAT(DISTINCT color.name)
                    FROM productvariation
                    JOIN color ON productvariation.color_id = color.color_id
                    WHERE productvariation.product_id = product.product_id
                ) AS color,
                (
                    SELECT GROUP_CONCAT(DISTINCT size.name)
                    FROM productvariation
                    JOIN size ON productvariation.size_id = size.size_id
                    WHERE productvariation.product_id = product.product_id
                ) AS size",
    "product
                JOIN brand ON product.brand_id = brand.brand_id
                JOIN category ON product.category_id = category.category_id
                JOIN productgallery ON product.product_id = productgallery.product_id
                WHERE product.product_id = $product_id
                GROUP BY product.product_id"
);

// accessing the 0 elment of the array
$data = $element[0];

// separating images
$image = $data['images'];
$images = explode(',', $image);



?>


    <!-- for description -->
    <div class="container my-4">
        <h4>Product Description</h4>
    </div>
    <div class="table-responsive">
        <table class="table ">
            <tbody>
                <tr class="text-center">
                    <th>Name</th>
                    <td><?= $data['product_name'] ?></td>
                </tr>
                <tr class="text-center">
                    <th>Brand</th>
                    <td><?= $data['brand_name'] ?></td>
                </tr>
                <tr class="text-center">
                    <th>Price</th>
                    <td><?= $data['product_price'] ?></td>
                </tr>
                <tr class="text-center">
                    <th>Category</th>
                    <td><?= $data['category_name'] ?></td>
                </tr>
                <tr class="text-center">
                    <th>Description</th>
                    <td><?= $data['product_description'] ?></td>
                </tr>
                <tr class="text-center">
                    <th>Discount</th>
                    <td><?= $data['product_discount'] ?>%</td>
                </tr>
                <tr class="text-center">
                    <th>Colors</th>
                    <td><?= $data['color'] ?></td>
                </tr>
                <tr class="text-center">
                    <th>Sizes</th>
                    <td><?= $data['size'] ?></td>
                </tr>
            </tbody>
        </table>

        <!-- for images -->
        <div class="container mt-4 ">
            <h4>Images</h4>
        </div>
        <div class="container">
            <div class="row ">
                <?php foreach ($images as $image) { ?>
                    <div class="col-md-4">
                        <img src="<?= url('public/' . $image) ?>" class="img-fluid mb-4" alt="Image not found">
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>