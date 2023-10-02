<?php
// getting data

$color = select('*', 'color');
$size = select('*', 'size');
$category = select('*', 'category');
$brand = select('*', 'brand');

// for product validation

$oldvalues = [
    'name' => '',
    'brand' => '',
    'category' => '',
    'slug' => '',
    'price' => '',
    'description' => '',
    'discount' => '',
    'color' => [],
    'size' => [],
];

$errors = [
    'name' => '',
    'brand' => '',
    'category' => '',
    'slug' => '',
    'price' => '',
    'description' => '',
    'images' => '',
    'color' => '',
    'size' => '',
];

if (!empty($_POST)) {


    foreach ($_POST as $key => $value) {
        if (empty($_POST[$key])) {
            $errors[$key] = ucfirst($key) . " field is required";
        } else {
            $oldvalues[$key] = $value;
        }
    }
    if (empty($_FILES['images']['name'][0])) {
        $errors['images'] = "Image field is required";
    }
    if (empty($_POST['color'])) {
        $errors['color'] = "Color field is required";
    }
    if (empty($_POST['size'])) {
        $errors['size'] = "Size field is required";
    }
    if (empty($_POST['brand'])) {
        $errors['brand'] = "Brand field is required";
    }
    if (empty($_POST['category'])) {
        $errors['category'] = "Category field is required";
    }


    $errors['discount'] = '';


    if (!array_filter($errors)) {
        // getting values
        $name = $_POST['name'];
        $brand = $_POST['brand'];
        $category = $_POST['category'];
        $slug = $_POST['slug'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $discount = $_POST['discount'];
        $color = $_POST['color'];
        $size = $_POST['size'];
        $images = '';

        if ($discount > 0) {
            $price = $price - ($price * $discount) / 100;
        }

        // inserting into products table
        $productdata = [
            'name' => $name,
            'brand_id' => $brand,
            'category_id' => $category,
            'slug' => $slug,
            'price' => $price,
            'description' => $description,
            'discount' => $discount,
        ];
        $lastinsertedid = insert('product', $productdata);


        foreach ($color as $clr) {
            foreach ($size as $s) {
                $productvariation = [
                    'product_id' => $lastinsertedid,
                    'color_id' => $clr,
                    'size_id' => $s,
                ];
                insert('productvariation', $productvariation);
            }
        }


        // uploading multiple images in the database
        if (!empty($_FILES['images']['name'])) {
            $uploadedImages = [];
            foreach ($_FILES['images']['name'] as $index => $imageName) {
                $ext = pathinfo($imageName, PATHINFO_EXTENSION);
                $imageName = md5(microtime()) . '_' . $index . '.' . $ext;

                $tmpName = $_FILES['images']['tmp_name'][$index];
                $destinationPath = public_path('products/images/') . $imageName;
                $imagepath = 'products/images/' . $imageName;

                move_uploaded_file($tmpName, $destinationPath);
                $uploadedImages[] = $imagepath;
            }

            $productgallery = [
                'product_id' => $lastinsertedid,
                'name' => $uploadedImages,
            ];


            insertImages('productgallery', $productgallery);

            // Set success message
            $_SESSION['message'] = [
                'title' => 'Success',
                'message' => 'Product Added Successfully',
                'type' => 'success'
            ];
            header('Location: addProduct.php');
        }
    } else {
        echo "failed";
    }
}

?>

<div class="d-flex justify-content-between mt-4 mb-1">
    <h3>Add Product</h3>
    <a href="<?= url('ss-admin/viewProduct.php') ?>" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i> View Products</a>
</div>

<form action="" method="post" enctype="multipart/form-data">
    <div class="card">
        <div class="row m-4">
            <div class="col-md-8">
                <!-- for name -->
                <div class="form-group">
                    <label for="name" class="form-label">Name: <span style="color:red"><?= $errors['name'] ?? '' ?></span></label>
                    <input type="text" name="name" id="name" value="<?= $oldvalues['name'] ?>" class="form-control">
                </div>
                <!-- for brand -->
                <div class="form-group mt-4">
                    <label for="brand" class="form-label">Brand: <span style="color:red"><?= $errors['brand'] ?? '' ?></span></label>
                    <select class="form-control" id="brand" name="brand">
                        <option selected value="" disabled>---------------- Choose Brand -----------------</option>
                        <?php foreach ($brand as $b) { ?>
                            <option value="<?= $b['brand_id'] ?>" <?= $oldvalues['brand'] == $b['brand_id'] ? 'selected' : '' ?>><?= $b['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- for category -->
                <div class="form-group mt-4">
                    <label for="category" class="form-label">Category: <span style="color:red"><?= $errors['category'] ?? '' ?></span></label>
                    <select class="form-control" id="category" name="category">
                        <option selected disabled>---------------- Choose Category -----------------</option>
                        <?php foreach ($category as $c) {
                            if ($c['name'] == 'used') {
                            } else { ?>
                                <option value="<?= $c['category_id'] ?>" <?= $oldvalues['category'] == $c['category_id'] ? 'selected' : '' ?>><?= $c['name'] ?></option>

                            <?php } ?>


                        <?php } ?>
                    </select>
                </div>
                <!-- for slug -->
                <div class="form-group mt-4">
                    <label for="slug" class="form-label">Slug: <span style="color:red"><?= $errors['slug'] ?? '' ?></span></label>
                    <input type="text" name="slug" id="slug" value="<?= $oldvalues['slug'] ?>" class="form-control">
                </div>
                <!-- for price -->
                <div class="form-group mt-4">
                    <label for="price" class="form-label">Price: <span style="color:red"><?= $errors['price'] ?? '' ?></span></label>
                    <input type="number" name="price" id="price" value="<?= $oldvalues['price'] ?>" class="form-control">
                </div>
                <!-- for images -->
                <div class="form-group mt-4">
                    <label for="images" class="form-label">Images: <span style="color:red"><?= $errors['images'] ?? '' ?></span></label>
                    <input type="file" name="images[]" id="images" multiple class="form-control">
                </div>

            </div>

            <div class="col-md-4">

                <!-- for discount -->
                <div class="form-group ">
                    <label for="discount" class="form-label">Discount: </label>
                    <input type="number" name="discount" id="discount" value="<?= $oldvalues['discount'] ?>" class="form-control">

                </div>
                <!-- for color -->
                <div class="form-group mt-4">
                    <label for="color" class="form-label">Color: <span style="color:red"><?= $errors['color'] ?? '' ?></span></label>
                    <select class="selectpicker form-control" name="color[]" id="color" multiple data-live-search="true">
                        <?php foreach ($color as $c) { ?>
                            <option value="<?= $c['color_id'] ?>" <?= in_array($c['color_id'], $oldvalues['color']) ? 'selected' : '' ?>><?= $c['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <!-- for size -->
                <div class="form-group mt-4">
                    <label for="size" class="form-label">Size: <span style="color:red"><?= $errors['size'] ?? '' ?></span></label>
                    <select class="selectpicker form-control" name="size[]" id="size" multiple data-live-search="true">
                        <?php foreach ($size as $s) { ?>
                            <option value="<?= $s['size_id'] ?>" <?= in_array($s['size_id'], $oldvalues['size']) ? 'selected' : '' ?>><?= $s['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- for description -->
        <div class="container">
            <div class="form-group  mt-4">
                <label for="description" class="form-label">Description: <span style="color:red"><?= $errors['description'] ?? '' ?></span></label>
                <textarea name="description" id="editor" rows="30"><?= $oldvalues['description'] ?></textarea>
            </div>
            <!-- for buttons -->
            <div class="form-group mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-success" style="margin-right: 10px;">Save</button>
                <button type="clear" class="btn btn-danger">Cancel</button>
            </div>
        </div>
    </div>
</form>
<script>
    CKEDITOR.replace('editor');

    // for slug
    let name = document.querySelector('#name');
    let slug = document.querySelector('#slug');
    name.addEventListener('input', function(e) {
        let originalString = e.target.value;
        let newString = originalString.replace(/ /g, "-");
        slug.value = newString;
    });
</script>