<?php
// getting data
if (!isset($_SESSION['name']) && !isset($_SESSION['email']) && !isset($_SESSION['users_id'])) {
    header('location: login.php');
    exit();
} else {
$color = select('*', 'color');
$size = select('*', 'size');
$category = select('*', 'category', 'WHERE name = "used"');
$brand = select('*', 'brand');

$admin = select('*','admin');
$adminmail = $admin[0]['email'];
// for product validation

$oldvalues = [
    'name' => '',
    'brand' => '',
    'slug' => '',
    'price' => '',
    'description' => '',
    'quantity' => '',
    'discount' => '',
    'color' =>'' ,
    'size' => '',
];

$errors = [
    'name' => '',
    'brand' => '',
    'slug' => '',
    'price' => '',
    'description' => '',
    'quantity' => '',
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
    $errors['category'] = '';


    if (!array_filter($errors)) {
        // getting values
        $name = $_POST['name'];
        $brand = $_POST['brand'];
        $category = $_POST['category'];
        $slug = $_POST['slug'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $discount = $_POST['discount'];
        $color = $_POST['color'];
        $size = $_POST['size'];
        $images = '';

        if ($discount > 0) {
            $price = $price - ($price * $discount) / 100;
        }


        $user_id = $_SESSION['users_id'];
       
        // inserting into products table
        $productdata = [
            'name' => $name,
            'brand_id' => $brand,
            'category_id' => $category,
            'slug' => $slug,
            'price' => $price,
            'description' => $description,
            'quantity' => $quantity,
            'discount' => $discount,
            'seller_id' => $user_id
        ];
        $lastinsertedid = insert('product', $productdata);

        
                $productvariation = [
                    'product_id' => $lastinsertedid,
                    'color_id' => $color,
                    'size_id' => $size,
                ];
                insert('productvariation', $productvariation);
        


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
            
            $categoryname = select('name','category',"WHERE category_id =$category ");
        
            $productLink = url("productDetail.php?slug=$slug&category=$category&id=$lastinsertedid");
    
            // sending mail to admin for new uploaded product
            $message = "Hello Admin,<br>
            A new product has been uploaded by a seller.<br>

            To visit the product <br>
                $productLink
            ";
                phpmailer($adminmail, $message, "New product uploaded");

            // Set success message
            $_SESSION['message'] = [
                'title' => 'Success',
                'message' => 'Product Added Successfully',
                'type' => 'success'
            ];
            header('Location: index.php');
        }
    }
}
}
?>
<style>
    .custom-button-container {
        display: flex;
        justify-content: flex-end;
    }

    .custom-button {
        width: 120px;
        /* Set the desired width here */
    }
</style>


<form action="" method="post" enctype="multipart/form-data">
    <div class="container">
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

                <input type="hidden" value="<?= $category[0]['category_id'] ?>" id="category" name="category">
                <!-- <div class="form-group mt-4">
                    <label for="category" class="form-label">Category: <span style="color:red"><?= $errors['category'] ?? '' ?></span></label>
                    <select class="form-control" id="category" name="category">
                        <option selected disabled>---------------- Choose Category -----------------</option>
                        <?php foreach ($category as $c) { ?>
                            <option value="<?= $c['category_id'] ?>" <?= $oldvalues['category'] == $c['category_id'] ? 'selected' : '' ?>><?= $c['name'] ?></option>
                        <?php } ?>
                    </select>
                </div> -->
                <!-- for slug -->
                <div class="form-group mt-4">
                    <input type="hidden" name="slug" id="slug" value="<?= $oldvalues['slug'] ?>" class="form-control">
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
                <!-- for quantity -->
                <div class="form-group">
                    <label for="quantity" class="form-label">Quantity: <span style="color:red"><?= $errors['quantity'] ?? '' ?></span></label>
                    <input type="text" name="quantity" id="quantity" value="<?= $oldvalues['quantity'] ?>" class="form-control">
                </div>
                <!-- for discount -->
                <div class="form-group mt-4">
                    <label for="discount" class="form-label">Discount: </label>
                    <input type="number" name="discount" id="discount" value="<?= $oldvalues['discount'] ?>" class="form-control">

                </div>
                <!-- for color -->
                <div class="form-group mt-4">
                    <label for="color" class="form-label">Color: <span style="color:red"><?= $errors['color'] ?? '' ?></span></label>
                    <select class="form-control" name="color" id="color" >
                        <?php foreach ($color as $c) { ?>
                            <option value="<?= $c['color_id'] ?>"><?= $c['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <!-- for size -->
                <div class="form-group mt-4">
                    <label for="size" class="form-label">Size: <span style="color:red"><?= $errors['size'] ?? '' ?></span></label>
                    <select class="form-control" name="size" id="size" >
                        <?php foreach ($size as $s) { ?>
                            <option value="<?= $s['size_id'] ?>"><?= $s['name'] ?></option>
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
            <div class="form-group mt-4 mb-4 d-flex justify-content-end custom-button-container">
                <button type="clear" class="btn btn-danger custom-button" style="margin-right: 10px;">Cancel</button>
                <button type="submit" class="btn btn-primary custom-button" style="background: green;">Save</button>
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