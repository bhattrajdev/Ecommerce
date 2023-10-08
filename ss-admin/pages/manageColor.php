<?php
// selecting color 
$color = select('*', 'color', 'ORDER BY color_id DESC');

// for delete
if (isset($_GET['id']) && $_GET['type'] === 'delete') {
    $id = $_GET['id'];
    $dbcon->exec("SET FOREIGN_KEY_CHECKS = 0");
    delete('color', 'color_id', $id);
    $_SESSION['message'] = [
        'title' => 'Success',
        'message' => 'Color deleted succesfully',
        'type' => 'success'
    ];
    $dbcon->exec("SET FOREIGN_KEY_CHECKS = 1");
    header('Location: manageColor.php');
} else {
    if (isset($_POST['color'])) {
        if (empty($_POST['color'])) {
            $_SESSION['message'] = [
                'title' => 'Error',
                'message' => 'The field cannot be empty',
                'type' => 'error'
            ];
        } else {
            // for update
            if (isset($_GET['name']) && isset($_GET['id']) && $_GET['type'] === 'update') {
                $id = $_GET['id'];
                $data = ucfirst($_POST['color']);
                $found = false;
                foreach ($color as $b) {
                    if ($b['name'] == $data) {
                        $found = true;

                        $_SESSION['message'] = [
                            'title' => 'Error',
                            'message' => 'Color Already exists',
                            'type' => 'error'
                        ];
                        break;
                    }
                }

                // updating into database
                if (!$found) {
                    update('color', ['name' => $data], "color_id = $id");
                    $_SESSION['message'] = [
                        'title' => 'Success',
                        'message' => 'Color Updated Successfully',
                        'type' => 'success'
                    ];
                    header('Location: manageColor.php');
                }
            } else {
                $data = ucfirst($_POST['color']);
                $found = false;
                foreach ($color as $b) {
                    if ($b['name'] == $data) {
                        $found = true;
                        $_SESSION['message'] = [
                            'title' => 'Error',
                            'message' => 'Color Already exists',
                            'type' => 'error'
                        ];
                        break;
                    }
                }

                // inserting into database
                if (!$found) {
                    insert('color', ['name' => $data]);

                    $_SESSION['message'] = [
                        'title' => 'Success',
                        'message' => 'Color Added Successfully',
                        'type' => 'success'
                    ];
                    header('Location: manageColor.php');
                }
            }
        }
    }
}
?>

<div class="d-flex justify-content-between">
    <h3>Manage Color</h3>
    <div class="row">
        <div class="col-md-12">
            <form action="" method="post" class="row g-2">
                <div class="col">
                    <input type="text" name="color" class="form-control" id="color" value="<?= isset($_GET['name']) ? $_GET['name'] : '' ?>">
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
                <?php foreach ($color as $key => $b) { ?>
                    <tr>
                        <td><?= ++$key ?></td>
                        <td><?= $b['name'] ?></td>
                        <td>
                            <a class="btn btn-primary" href="manageColor.php?id=<?= $b['color_id'] ?>&name=<?= $b['name'] ?>&type=update" onclick="return confirm('Are you sure you want to edit this Color?')"><i class="fa-solid fa-edit" style="color: #fff;"></i></a>
                            <a class="btn btn-danger" href="manageColor.php?id=<?= $b['color_id'] ?>&type=delete" onclick="return confirm('Are you sure you want to delete this Color?')"><i class="fa-solid fa-trash" style="color: #fff;"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>