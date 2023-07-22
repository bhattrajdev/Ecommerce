<?php
$male = select(
    'product.product_id AS product_id,
    brand.name AS brand_name, 
    product.name AS product_name,
    product.price AS product_price,
    product.slug AS product_slug,
    product.discount AS product_discount,
    category.name AS category_name,
    GROUP_CONCAT(productgallery.name) AS image_urls',
    'product',
    "JOIN brand ON product.brand_id = brand.brand_id 
     JOIN productgallery ON product.product_id = productgallery.product_id 
     JOIN category ON product.category_id = category.category_id
     WHERE category.name = 'Male'
     GROUP BY product.product_id
     ORDER BY product.product_id DESC"
);
$women = select(
    'product.product_id AS product_id,
    brand.name AS brand_name, 
    product.name AS product_name,
    product.price AS product_price,
    product.slug AS product_slug,
    product.discount AS product_discount,
    category.name AS category_name,
    GROUP_CONCAT(productgallery.name) AS image_urls',
    'product',
    "JOIN brand ON product.brand_id = brand.brand_id 
     JOIN productgallery ON product.product_id = productgallery.product_id 
     JOIN category ON product.category_id = category.category_id
     WHERE category.name = 'Women'
     GROUP BY product.product_id
     ORDER BY product.product_id DESC"
);
$kids = select(
    'product.product_id AS product_id,
    brand.name AS brand_name, 
    product.name AS product_name,
    product.price AS product_price,
    product.slug AS product_slug,
    product.discount AS product_discount,
    category.name AS category_name,
    GROUP_CONCAT(productgallery.name) AS image_urls',
    'product',
    "JOIN brand ON product.brand_id = brand.brand_id 
     JOIN productgallery ON product.product_id = productgallery.product_id 
     JOIN category ON product.category_id = category.category_id
     WHERE category.name = 'Kids'
     GROUP BY product.product_id
     ORDER BY product.product_id DESC"
);
$used = select(
    'product.product_id AS product_id,
    brand.name AS brand_name, 
    product.name AS product_name,
    product.price AS product_price,
    product.slug AS product_slug,
    product.discount AS product_discount,
    category.name AS category_name,
    GROUP_CONCAT(productgallery.name) AS image_urls',
    'product',
    "JOIN brand ON product.brand_id = brand.brand_id 
     JOIN productgallery ON product.product_id = productgallery.product_id 
     JOIN category ON product.category_id = category.category_id
     WHERE category.name = 'Used'
     GROUP BY product.product_id
     ORDER BY product.product_id DESC"
);

?>


<section id="homepage">
    <!---------------------------------Carousel Start---------------------------->
    <section id="carousel">
        <div class="carousel">
            <div class="imageBox">
                <img src="./public/images/5970772.jpg" alt="Image not found" />
            </div>
            <div class="imageBox">
                <img src="./public/images/5972157.jpg" alt="Image not found" />
            </div>
        </div>
    </section>
    <!---------------------------------Carousel End---------------------------->

    <!-------------------------------------- Card Slider Male Start-------------------------------------->
    <?php if (!empty($male)) { ?>
        <div class="carousel-wrap container">
            <div class="headings">
                <h3>Male</h3>
                <a href="<?= url('male.php') ?>">View All</a>
            </div>
            <div class="owl-carousel">
                <?php foreach ($male as $key => $data) { ?>
                    <div class="item">
                        <a href="./productDetail.php?slug=<?= $data['product_slug'] ?>&category=<?= $data['category_name'] ?>&id=<?= $data['product_id'] ?>">
                            <?php $images = explode(',', $male[$key]['image_urls']);
                            $img = $images[0] ?>
                            <img src="<?= url('public/' . $img); ?>">
                            <p class="brand"><?= $data['brand_name'] ?></p>
                            <p class="desc"><?= $data['product_name'] ?></p>
                            <div class="price_discount">
                                <div class="price">RS <?= $data['product_price'] ?></div>
                                <?php if ($data['product_discount'] > 0) { ?>

                                    <div class="discount"><?= $data['product_discount'] ?>%off</div>
                                <?php  } ?>
                            </div>
                        </a>
                    </div>
                <?php } ?>

            </div>
        </div>
    <?php } ?>
    <!-------------------------------------- Card Slider male end -------------------------------------->


    <!-------------------------------------- Card Slider Women start -------------------------------------->
    <?php if (!empty($women)) { ?>
        <div class="carousel-wrap container">
            <div class="headings">
                <h3>Women</h3>
                <a href="<?= url('women.php') ?>">View All</a>
            </div>
            <div class="owl-carousel">
                <?php foreach ($women as $key => $data) { ?>
                    <div class="item">
                        <a href="./productDetail.php?slug=<?= $data['product_slug'] ?>&category=<?= $data['category_name'] ?>&id=<?= $data['product_id'] ?>">
                            <?php $images = explode(',', $women[$key]['image_urls']);
                            $img = $images[0] ?>
                            <img src="<?= url('public/' . $img); ?>">
                            <p class="brand"><?= $data['brand_name'] ?></p>
                            <p class="desc"><?= $data['product_name'] ?></p>
                            <div class="price_discount">
                                <div class="price">RS <?= $data['product_price'] ?></div>
                                <?php if ($data['product_discount'] > 0) { ?>

                                    <div class="discount"><?= $data['product_discount'] ?>%off</div>
                                <?php  } ?>
                            </div>
                        </a>
                    </div>
                <?php } ?>

            </div>
        </div>
    <?php } ?>
    <!-------------------------------------- Card Slider Women end -------------------------------------->

    <!-------------------------------------- Card Slider kids start -------------------------------------->
    <?php if (!empty($kids)) { ?>
        <div class="carousel-wrap container">
            <div class="headings">
                <h3>Kids</h3>
                <a href="<?= url('kids.php') ?>">View All</a>
            </div>
            <div class="owl-carousel">
                <?php foreach ($kids as $key => $data) { ?>
                    <div class="item">
                        <a href="./productDetail.php?slug=<?= $data['product_slug'] ?>&category=<?= $data['category_name'] ?>&id=<?= $data['product_id'] ?>">
                            <?php $images = explode(',', $kids[$key]['image_urls']);
                            $img = $images[0] ?>
                            <img src="<?= url('public/' . $img); ?>">
                            <p class="brand"><?= $data['brand_name'] ?></p>
                            <p class="desc"><?= $data['product_name'] ?></p>
                            <div class="price_discount">
                                <div class="price">RS <?= $data['product_price'] ?></div>
                                <?php if ($data['product_discount'] > 0) { ?>

                                    <div class="discount"><?= $data['product_discount'] ?>%off</div>
                                <?php  } ?>
                            </div>
                        </a>
                    </div>
                <?php } ?>

            </div>
        </div>
    <?php } ?>

    <!-------------------------------------- Card Slider kids end -------------------------------------->
    <!-------------------------------------- Card Slider used start -------------------------------------->
    <?php if (!empty($used)) { ?>
        <div class="carousel-wrap container">
            <div class="headings">
                <h3>Used</h3>
                <a href="<?= url('used.php') ?>">View All</a>
            </div>
            <div class="owl-carousel">
                <?php foreach ($used as $key => $data) { ?>
                    <div class="item">
                        <a href="./productDetail.php?slug=<?= $data['product_slug'] ?>&category=<?= $data['category_name'] ?>&id=<?= $data['product_id'] ?>">
                            <?php $images = explode(',', $used[$key]['image_urls']);
                            $img = $images[0] ?>
                            <img src="<?= url('public/' . $img); ?>">
                            <p class="brand"><?= $data['brand_name'] ?></p>
                            <p class="desc"><?= $data['product_name'] ?></p>
                            <div class="price_discount">
                                <div class="price">RS <?= $data['product_price'] ?></div>
                                <?php if ($data['product_discount'] > 0) { ?>

                                    <div class="discount"><?= $data['product_discount'] ?>%off</div>
                                <?php  } ?>
                            </div>
                        </a>
                    </div>
                <?php } ?>

            </div>
        </div>
    <?php } ?>

    <!-------------------------------------- Card Slider used end -------------------------------------->
</section>