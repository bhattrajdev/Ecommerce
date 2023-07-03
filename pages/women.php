<?php
$brand = select('*', 'brand');
$size = select('*', 'size');

$oldvalue = [
    'brand' => '',
    'size' => '',
    'price' => '',
];
$whereClause = "category.name = 'Women'"; // Default WHERE clause

if (!empty($_POST['brand'])) {
    $brandId = $_POST['brand'];
    $oldvalue['brand'] = $brandId;
    $whereClause .= " AND product.brand_id = $brandId";
}

if (!empty($_POST['Size'])) {
    $sizeId = $_POST['Size'];
    $oldvalue['size'] = $sizeId;

    $whereClause .= " AND productvariation.size_id = $sizeId";
}

$orderClause = "";
if (!empty($_POST['price'])) {
    $priceOrder = $_POST['price'];
    $oldvalue['price'] = $priceOrder;
    if ($priceOrder === "lowtohigh") {
        $orderClause = "ORDER BY product.price ASC";
    } elseif ($priceOrder === "hightolow") {
        $orderClause = "ORDER BY product.price DESC";
    }
}

$element = select(
    "product.discount AS product_discount,
product.product_id AS product_id,
product.name AS product_name,
product.price AS product_price,
product.slug AS product_slug,
brand.name AS brand_name,
category.name AS category_name,
GROUP_CONCAT(DISTINCT productgallery.name) AS images",
    "product
JOIN brand ON product.brand_id = brand.brand_id
JOIN category ON product.category_id = category.category_id
JOIN productvariation ON product.product_id = productvariation.product_id
JOIN productgallery ON product.product_id = productgallery.product_id
WHERE $whereClause
GROUP BY product.product_id
$orderClause"
);


?>
<section id="pages">
    <div class="container">
        <form action="" method="post">
            <div class="filter">
                <div class="filter_options">
                    <span>Brand:</span>
                    <select name="brand">
                        <option value="" selected>Choose</option>
                        <?php foreach ($brand as $b) { ?>
                            <option value="<?= $b['brand_id'] ?>" <?= ($oldvalue['brand'] == $b['brand_id'] ? 'selected' : '') ?>>
                                <?= $b['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="filter_options">
                    <span>Size:</span>
                    <select name="Size">
                        <option value="" selected>Choose</option>
                        <?php foreach ($size as $b) { ?>
                            <option value="<?= $b['size_id'] ?>" <?= ($oldvalue['size'] == $b['size_id'] ? 'selected' : '') ?>>
                                <?= $b['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="filter_options">
                    <span>Price:</span>
                    <select name="price">
                        <option value="" selected>Choose</option>
                        <option value="lowtohigh" <?= ($oldvalue['price'] == "lowtohigh" ? 'selected' : '') ?>>low to high</option>
                        <option value="hightolow" <?= ($oldvalue['price'] == "hightolow" ? 'selected' : '') ?>>high to low</option>
                    </select>
                </div>
                <div class="filter_options">
                    <button class="filterbtn" type="submit">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <div class="products container">
        <?php
        if (count($element) > 0) {
            foreach ($element as $key => $data) {
                $images = explode(',', $data['images']);
                $firstImage = $images[0]; ?>
                <div class="item">
                    <a href="./productDetail.php?slug=<?= $data['product_slug'] ?>?category=<?= $data['category_name'] ?>?id=<?= $data['product_id'] ?>">
                        <img src="<?= url('public/' . $firstImage) ?>" alt="Image not found">
                        <p class="brand"><?= $data['brand_name']; ?></p>
                        <p class="desc"><?= $data['product_name']; ?></p>
                        <div class="price_discount">
                            <div class="price">RS <?= $data['product_price']; ?></div>
                            <div class="discount"><?= $data['product_discount']; ?>% off</div>
                        </div>
                    </a>
                </div>
            <?php }
        } else { ?>

            <h2 class="no_data_found">No Data Found</h2>
        <?php } ?>
    </div>
    </div>
</section>