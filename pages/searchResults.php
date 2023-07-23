<?php
if (!empty($_GET['search'])) {
    // $search= $_GET['search'];
    $search = $_GET['search'];
    $element = select(
        "product.discount AS product_discount,
    product.product_id AS product_id,
    product.name AS product_name,
    product.price AS product_price,
    product.slug AS product_slug,
    brand.name AS brand_name,
    category.name AS category_name,
    GROUP_CONCAT(DISTINCT productgallery.name) AS images,
    col.name AS color_name,
    s.name AS size_name",
        "product
    JOIN brand ON product.brand_id = brand.brand_id
    JOIN category ON product.category_id = category.category_id
    JOIN productvariation AS pv ON product.product_id = pv.product_id
    JOIN productgallery ON product.product_id = productgallery.product_id
    JOIN color AS col ON pv.color_id = col.color_id
    JOIN size AS s ON pv.size_id = s.size_id",
        "WHERE 
    (product.name LIKE '$search'
    OR brand.name LIKE '$search'
    OR category.name LIKE '$search'
    OR col.name LIKE '$search'
    OR s.name LIKE '$search')
    GROUP BY product.product_id
    ORDER BY product.product_id DESC"
    );
}

?>

<?php if (empty($element)) { ?>
    <h2 class="no_data_found container">No Data Found</h2>
<?php } else { ?>

    <section id="pages">
        <div class="container">
            <div class="products container">
                <?php
                if (count($element) > 0) {
                    foreach ($element as $key => $data) {
                        $images = explode(',', $data['images']);
                        $firstImage = $images[0]; ?>
                        <div class="item">
                            <a href="./productDetail.php?slug=<?= $data['product_slug'] ?>&category=<?= $data['category_name'] ?>&id=<?= $data['product_id'] ?>">
                                <img src="<?= url('public/' . $firstImage) ?>" alt="Image not found">
                                <p class="brand"><?= $data['brand_name']; ?></p>
                                <p class="desc"><?= $data['product_name']; ?></p>
                                <div class="price_discount">
                                    <div class="price">RS <?= $data['product_price']; ?></div>
                                    <div class="discount">
                                        <?php if ($data['product_discount'] > 0) { ?>
                                            <?= $data['product_discount']; ?>% off
                                        <?php } ?>
                                    </div>
                                </div>

                            </a>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
    </section>
    <?php } ?>