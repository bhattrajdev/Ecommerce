<?php
if (!isset($_SESSION['name']) && !isset($_SESSION['email']) && !isset($_SESSION['users_id'])) {
    header('location: login.php');
    exit();
} else {
    $user_id = $_SESSION['users_id'];

    // Getting previous addresses
    $addressdata = select('*', 'address', "WHERE user_id = $user_id ORDER BY address_id DESC");

    $errors = [
        'address' => '',
        'phone' => '',
        'email' => '',
    ];
    $oldvalues = [
        'address' => '',
        'phone' => '',
        'email' => '',
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Adding new address
        if (isset($_POST['add_address'])) {
            foreach ($_POST as $key => $value) {
                if (empty($_POST[$key])) {
                    $errors[$key]  = ucfirst($key) . " field is required";
                } else {
                    $oldvalues[$key] = $value;
                }
            }
            $errors['add_address'] = '';

            // Inserting data if no errors found
            if (!array_filter($errors)) {
                $address = $_POST['address'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $user_id = $_SESSION['users_id'];
                $data = [
                    'user_id' => $user_id,
                    'address' => $address,
                    'phone' => $phone,
                    'email' => $email
                ];
                insert('address', $data);
                $_SESSION['message'] = [
                    'title' => 'Success',
                    'message' => 'New Address Inserted Successfully',
                    'type' => 'success'
                ];
                header('refresh:0');
            }
        }

        // Editing the previous address
        if (isset($_POST['edit'])) {
            $id = $_POST['edit'];
            $data = select('*', 'address', "WHERE address_id = $id");
            if (!empty($data)) {
                $update_address = $data[0];
            }
        }

        // Updating the data
        if (isset($_POST['update_address'])) {
            foreach ($_POST as $key => $value) {
                if (empty($_POST[$key])) {
                    $errors[$key]  = ucfirst($key) . " field is required";
                } else {
                    $oldvalues[$key] = $value;
                }
            }
            $errors['update_address'] = '';

            // Inserting data if no errors found
            if (!array_filter($errors)) {
                $address = $_POST['address'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $user_id = $_SESSION['users_id'];
                $address_id = $_POST['address_id'];
                $data = [
                    'user_id' => $user_id,
                    'address' => $address,
                    'phone' => $phone,
                    'email' => $email
                ];
                update('address', $data, "address_id = $address_id");
                $_SESSION['message'] = [
                    'title' => 'Success',
                    'message' => 'Address Updated Successfully',
                    'type' => 'success'
                ];
                header('Location:checkout.php');
            }
        }

        // Deleting the previous address
        if (isset($_POST['delete'])) {
            $id = $_POST['delete'];
            delete('address', 'address_id', $id);
            $_SESSION['message'] = [
                'title' => 'Success',
                'message' => 'Address Deleted Successfully',
                'type' => 'success'
            ];
            header('Location: checkout.php');
            exit();
        }
        // taking the address from the form 
        if (isset($_POST['form-submit'])) {
            if (!empty($_POST['selected_address_id'])) {
                $_SESSION['selected_address_id'] = $_POST['selected_address_id']; 
                $address = $_SESSION['selected_address_id'];
                $total = $_SESSION['total'];
                $data=[
                    'user_id' => $user_id,
                    'address_id' => $address,
                    'total' =>$total
                ];
                $last_inserted_id = insert('orders',$data);
                // getting cart data and inserting it into product order 
                $cartdata = $_SESSION['cartdata'];
                foreach ($cartdata as $product) {
                    $product_id = $product['product_id'];
                    $productvariation_id = $product['productvariation_id'];
                    $quantity = $product['quantity'];
                    $order_product_data = array(
                        'order_id' => $last_inserted_id,
                        'product_id' => $product_id,
                        'productvariation_id' => $productvariation_id,
                        'quantity'=>$quantity,
                    );
                    insert('orderproducts', $order_product_data);
                }
                $_SESSION['order_id'] = $last_inserted_id;
               header('Location:paymentoption.php');
            } else {
                $_SESSION['message'] = [
                    'title' => 'Error',
                    'message' => 'Please choose an address',
                    'type' => 'error'
                ];
                header('Location: checkout.php');
                exit();
            }
        }

    }
}
?>



<!-- custom inline css -->
<style>
    .data {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .data input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 75px;
        width: 5px;

    }

    .data input:checked~.checkmark {
        background-color: red;
        height: 60px;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .data input:checked~.checkmark:after {
        display: block;
    }

    .data .checkmark:after {
        background: white;
        color: red;
    }

    .checkout-box {
        max-height: 326px;
        overflow-y: scroll;
    }


    .row {
        display: flex;
        flex-wrap: wrap;
        margin-top: 1.5rem;
    }

    .container {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }

    .col-md-8 {
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        margin-bottom: 1.5rem;
        border-radius: 0.25rem;
        border: 1px solid rgba(0, 0, 0, 0.125);
        background-color: #fff;
    }

    .card-header {
        padding: 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        background-color: #f8f9fa;
    }

    .py-3 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .card-body {
        flex: 1 1 auto;
        padding: 1.25rem;
    }

    .form-outline {
        margin-bottom: 1.5rem;
    }

    .form-label {
        margin-bottom: 0;
        display: inline-block;
    }

    .form-control {
        display: block;
        width: 100%;
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .col-md-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }



    .card-header h5 {
        margin-bottom: 0;
    }

    .card-body form {
        margin-bottom: 0;
    }

    hr {
        margin-top: 1rem;
        margin-bottom: 1rem;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .horizonatal_row {
        border-bottom: 1px solid black;
    }

    .data h6 {
        margin-bottom: 0;
    }

    .checkout-box form {
        margin-bottom: 0;
    }

    .buttons {
        border: none;
        background: none;

    }

    @media (max-width: 600px) {

        .col-md-8,
        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>



<div class="row container mt-4">
    <div class="col-md-8 mb-4">
        <div class="card mb-4">
            <div class="card-header py-3">
                <h4 class="mb-0">
                    <?= isset($_POST['edit']) ? "Update Address" : "Add New Address" ?>

                </h4>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <!-- Text input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="address">Address: <span style="color:red"><?= $errors['address'] ?? '' ?></span></label>
                        <input type="text" id="address" name="address" value="<?= isset($_POST['edit']) ? $update_address['address'] : $oldvalues['address'] ?>" class="form-control" />
                    </div>
                    <?php if (isset($_POST['edit'])) { ?>
                        <input type="hidden" name="address_id" value="<?= $update_address['address_id'] ?>">
                    <?php } ?>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email: <span style="color:red"><?= $errors['email'] ?? '' ?></span></label>
                        <input type="email" id="email" name="email" value="<?= isset($_POST['edit']) ? $update_address['email'] : $oldvalues['email'] ?>" class="form-control" />
                    </div>

                    <!-- Number input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="phone">Phone: <span style="color:red"><?= $errors['phone'] ?? '' ?></span></label>
                        <input type="text" id="phone" name="phone" value="<?= isset($_POST['edit']) ? $update_address['phone'] : $oldvalues['phone'] ?>" class="form-control" />
                    </div>
                    <div class="col-md-4"><button class="button" name="<?= isset($_POST['edit']) ? 'update_address' : 'add_address' ?>"><?= isset($_POST['edit']) ? "Update" : "Add" ?></button></div>

                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card mb-4">
            <div class="card-header py-3">
                <h4>Previous Addresses</h4>
            </div>
            <form action="" method="POST">
                <div class="card-body checkout-box">
                    <?php foreach ($addressdata as $item) { ?>
                        <label class="data">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6><?= $item['address'] ?></h6>
                                    <h6><?= $item['email'] ?></h6>
                                    <h6><?= $item['phone'] ?></h6>
                                    <input type="radio" name="selected_address_id" value="<?= $item['address_id'] ?>">
                                    <span class="checkmark"></span>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" name="edit" value="<?= $item['address_id'] ?>" class="buttons" onclick="return confirm('Are you sure you want to edit this address?')">
                                        <i class="fa-solid fa-pen-to-square" style="color: #00ff4c;"></i>
                                    </button>
                                    <button type="submit" name="delete" value="<?= $item['address_id'] ?>" class="buttons" onclick="return confirm('Are you sure you want to delete this address?')">
                                        <i class="fa-sharp fa-solid fa-trash" style="color: #ff0000;"></i>
                                    </button>
                                </div>
                            </div>
                        </label>
                        <hr class="horizonatal_row">
                    <?php } ?>
                </div>
                <input type="submit" name="form-submit" style="margin-top: 20px;" class="button" value="Next">
            </form>


        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.custom-radio input').change(function() {
            $('.custom-radio').removeClass('selected');
            $(this).closest('.custom-radio').addClass('selected');
        });
    });

    function setSelectedAddressId(addressId) {
        document.querySelector('input[name="selected_address_id"]').value = addressId;
    }
</script>