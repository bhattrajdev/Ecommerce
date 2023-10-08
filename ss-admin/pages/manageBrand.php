<?php
// selecting brand 
$brand = select('*', 'brand', 'ORDER BY brand_id DESC');

// for delete
if (isset($_GET['id']) && isset($_GET['name']) && $_GET['type'] === 'delete') {
    $id = $_GET['id'];
    $data = $_GET['name'];
    // deleting a folder
    // $directoryPath = public_path('images') . '/' . $data;
    // if (is_dir($directoryPath)) {
    //     rmdir($directoryPath);
    // }
    $dbcon->exec("SET FOREIGN_KEY_CHECKS = 0");
    delete('brand', 'brand_id', $id);
    $dbcon->exec("SET FOREIGN_KEY_CHECKS = 1");

    $_SESSION['message'] = [
        'title' => 'Success',
        'message' => 'Brand deleted successfully',
        'type' => 'success'
    ];


    header('Location: manageBrand.php');
} else {
    if (isset($_POST['brand'])) {
        if (empty($_POST['brand'])) {
            $_SESSION['message'] = [
                'title' => 'Error',
                'message' => 'The field cannot be empty',
                'type' => 'error'
            ];
        } else {
            // for update
            if (isset($_GET['name']) && isset($_GET['id']) && $_GET['type'] === 'update') {
                $id = $_GET['id'];
                $data = ucfirst($_POST['brand']);
                $found = false;
                foreach ($brand as $b) {
                    if ($b['name'] == $data) {
                        $found = true;
                        $_SESSION['message'] = [
                            'title' => 'Error',
                            'message' => 'Brand already exists',
                            'type' => 'error'
                        ];

                        break;
                    }
                }

                // updating into database
                if (!$found) {
                    update('brand', ['name' => $data], "brand_id = $id");
                    $_SESSION['message'] = [
                        'title' => 'Success',
                        'message' => 'Brand updated successfully',
                        'type' => 'success'
                    ];
                    header('Location: manageBrand.php');
                }
            } else {
                $data = ucfirst($_POST['brand']);
                $found = false;
                foreach ($brand as $b) {
                    if ($b['name'] == $data) {
                        $found = true;
                        $_SESSION['message'] = [
                            'title' => 'Error',
                            'message' => 'Brand already exists',
                            'type' => 'error'
                        ];

                        break;
                    }
                }

                // inserting into database
                if (!$found) {
                    insert('brand', ['name' => $data]);

                    $_SESSION['message'] = [
                        'title' => 'Success',
                        'message' => 'Brand Added successfully',
                        'type' => 'success'
                    ];

                    header('Location: manageBrand.php');
                }
            }
        }
    }
}
?>

<div class="d-flex justify-content-between">
    <h3>Manage Brand</h3>
    <div class="row">
        <div class="col-md-12">
            <form action="" method="post" class="row g-2">
                <div class="col">
                    <input type="text" name="brand" class="form-control" id="brand" value="<?= isset($_GET['name']) ? $_GET['name'] : '' ?>">
                </div>
                <div class="col-auto">
                    <button class="btn btn-success" type="submit"><?= isset($_GET['name']) ? 'Update' : 'Add' ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-dark text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($brand as $key => $b) { ?>
                    <tr>
                        <td><?= ++$key ?></td>
                        <td><?= $b['name'] ?></td>
                        <td>
                            <a class="btn btn-primary" href="manageBrand.php?id=<?= $b['brand_id'] ?>&name=<?= $b['name'] ?>&type=update" onclick="return confirm('Are you sure you want to edit this brand?')"><i class="fa-solid fa-edit" style="color: #fff;"></i></a>
                            <a class="btn btn-danger" href="manageBrand.php?id=<?= $b['brand_id'] ?>&name=<?= $b['name'] ?>&type=delete" onclick="return confirm('Are you sure you want to delete this brand?')"><i class="fa-solid fa-trash" style="color: #fff;"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>