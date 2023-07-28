<?php
// Getting data
$colorA = select('*', 'color');
$sizeA = select('*', 'size');
$category = select('*', 'category');
$brand = select('*', 'brand');

$product_id = $_GET['id'];
$element = select(
    "product.discount AS product_discount,
    product.description AS product_description, 
    product.product_id AS product_id, 
    product.name AS product_name, 
    product.price AS product_price,
    product.slug AS product_slug,
    product.quantity AS product_quantity,
    brand.name AS brand_name, 
    category.name AS category_name, 
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
    WHERE product.product_id = $product_id
    GROUP BY product.product_id"
);

// Accessing the 0 element of the array
$data = $element[0];

// Separating colors
$color = $data['color'];
$colors = explode(',', $color);

// Separating sizes
$size = $data['size'];
$sizes = explode(',', $size);

// Initialize errors array

$errors = [
    'name' => '',
    'brand' => '',
    'category' => '',
    'slug' => '',
    'price' => '',
    'description' => '',
    'quantity' => '',
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

    if (!array_filter($errors)) {
    // Updating product table

    $name = $_POST['name'];
    $brand_id = $_POST['brand'];
    $category_id = $_POST['category'];
    $slug = $_POST['slug'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $discount = $_POST['discount'];
    $updateColor = $_POST['color'];
    $UpdateSize = $_POST['size'];



    $productdata = [
        'name' => $name,
        'brand_id' => $brand_id,
        'category_id' => $category_id,
        'slug' => $slug,
        'price' => $price,
        'description' => $description,
        'discount' => $discount,
    ];
    update('product', $productdata, "product_id=$product_id");

        // Updating color and size in product variation
        $colors = $_POST['color'];
        $sizes = $_POST['size'];

        $productvariationData = select('*',
            'productvariation',
            "WHERE product_id = $product_id"
        );
        if (!empty($productvariationData[0])) {
            // Delete existing product variations
            delete('productvariation', 'product_id', $product_id);
        }

        foreach ($color as $clr) {
            foreach ($size as $s) {
                $productvariation = [
                    'product_id' => $lastinsertedid,
                    'color_id' => $clr,
                    'size_id' => $s,
                ];
                insert('productvariation',
                    $productvariation
                );
            }
        }


        


    // updating images
    if (!empty($_FILES['images']['name'][0])) {
        // Removing old images
        $images = select('name', 'productgallery', 'WHERE product_id =' . $product_id);
        foreach ($images as $image) {
            $imagePath = public_path('') . $image['name'];
         
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        // delete old product images
        delete('productgallery', 'product_id', $product_id);

        // Adding new images
        $uploadedImages = [];
        foreach ($_FILES['images']['name'] as $index => $imageName) {
            $ext = pathinfo($imageName, PATHINFO_EXTENSION);
            $imageName = md5(microtime()) . '_' . $index . '.' . $ext;

                $tmpName = $_FILES['images']['tmp_name'][$index];
                $destinationPath = public_path('products/images/') . $imageName;
                $imagepath = 'products/images/' . $imageName;


            if (!move_uploaded_file($tmpName, $destinationPath)) {
                die('File upload failed');
            } else {
                $uploadedImages[] = $imagepath;
            }
        }

        $productgallery = [
            'product_id' => $product_id,
            'name' => $uploadedImages,
        ];
        // inserting images
        insertImages('productgallery',$productgallery);
    }
    // Set success message
    $_SESSION['message'] = [
        'title' => 'Success',
        'message' => 'Product Updated Successfully',
        'type' => 'success'
    ];
    header('Location:viewProduct.php');

    }
}

?>

<div class="d-flex justify-content-between mt-4 mb-1">
    <h3>Update Product</h3>
</div>

<form action="" method="post" enctype="multipart/form-data">
    <div class="card">
        <div class="row m-4">
            <div class="col-md-8">
                <!-- for name -->
                <div class="form-group">
                    <label for="name" class="form-label">Name: <span style="color:red"><?= $errors['name'] ?? '' ?></span></label>
                    <input type="text" name="name" id="name" value="<?= $data['product_name'] ?>" class="form-control">
                </div>
                <!-- for brand -->
                <div class="form-group mt-4">
                    <label for="brand" class="form-label">Brand: <span style="color:red"><?= $errors['brand'] ?? '' ?></span></label>
                    <select class="form-control" id="brand" name="brand">
                        <?php foreach ($brand as $b) { ?>
                            <option value="<?= $b['brand_id'] ?>" <?= $data['brand_name'] == $b['name'] ? 'selected' : '' ?>><?= $b['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- for category -->
                <div class="form-group mt-4">
                    <label for="category" class="form-label">Category: <span style="color:red"><?= $errors['category'] ?? '' ?></span></label>
                    <select class="form-control" id="category" name="category">
                        <?php foreach ($category as $c) { ?>
                            <option value="<?= $c['category_id'] ?>" <?= $data['category_name'] == $c['name'] ? 'selected' : '' ?>><?= $c['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <!-- for slug -->
                <div class="form-group mt-4">
                    <label for="slug" class="form-label">Slug: <span style="color:red"><?= $errors['slug'] ?? '' ?></span></label>
                    <input type="text" name="slug" id="slug" value="<?= $data['product_slug'] ?>" class="form-control">
                </div>
                <!-- for price -->
                <div class="form-group mt-4">
                    <label for="price" class="form-label">Price: <span style="color:red"><?= $errors['price'] ?? '' ?></span></label>
                    <input type="number" name="price" id="price" value="<?= $data['product_price'] ?>" class="form-control">
                </div>
                <!-- for images -->
                <div class="form-group mt-4">
                    <label for="images" class="form-label">Images:</span></label>
                    <input type="file" name="images[]" id="images" multiple class="form-control">
                </div>

            </div>

            <div class="col-md-4">
                <!-- for discount -->
                <div class="form-group ">
                    <label for="discount" class="form-label">Discount: </label>
                    <input type="number" name="discount" id="discount" value="<?= $data['product_discount'] ?>" class="form-control">
                </div>
                <!-- for color -->
                <div class="form-group mt-4">
                    <label for="color" class="form-label">Color: <span style="color:red"><?= $errors['color'] ?? '' ?></span></label>
                    <select class="selectpicker form-control" name="color[]" id="color" multiple data-live-search="true">
                        <?php foreach ($colorA as $c) {
                            $selected = '';
                            foreach ($colors as $clr) {
                                if ($c['name'] == $clr) {
                                    $selected = 'selected';
                                    break;
                                }
                            }
                        ?>
                            <option value="<?= $c['color_id'] ?>" <?= $selected ?>>
                                <?= $c['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <!-- for size -->
                <div class="form-group mt-4">
                    <label for="size" class="form-label">Size: <span style="color:red"><?= $errors['size'] ?? '' ?></span></label>
                    <select class="selectpicker form-control" name="size[]" id="size" multiple data-live-search="true">
                        <?php foreach ($sizeA as $c) {
                            $selected = '';
                            foreach ($sizes as $clr) {
                                if ($c['name'] == $clr) {
                                    $selected = 'selected';
                                    break;
                                }
                            }
                        ?>
                            <option value="<?= $c['size_id'] ?>" <?= $selected ?>>
                                <?= $c['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- for description -->
        <div class="container">
            <div class="form-group  mt-4">
                <label for="description" class="form-label">Description: <span style="color:red"><?= $errors['description'] ?? '' ?></span></label>
                <textarea name="description" id="editor" rows="30"><?= $data['product_description'] ?></textarea>
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

