<?php
// selecting size 
$size = select('*', 'size', 'ORDER BY size_id DESC');

// for delete
if (isset($_GET['id']) && $_GET['type'] === 'delete') {
    $id = $_GET['id'];
    if(delete('size', 'size_id', $id)){
        $_SESSION['message'] = [
            'title' => 'Success',
            'message' => 'Size Deleted Successfully',
            'type' => 'success'
        ];
    header('Location: manageSize.php');
    }else{
        $_SESSION['message'] = [
            'title' => 'Error',
            'message' => 'Cannot delete  a parent row: a foreign key constraint fails',
            'type' => 'error'
        ];
    }
} else {
    if (isset($_POST['size'])) {
        if (empty($_POST['size'])) {
            $_SESSION['message'] = [
                'title' => 'Error',
                'message' => 'The field cannot be empty',
                'type' => 'error'
            ];
        } else {
            // for update
            if (isset($_GET['name']) && isset($_GET['id']) && $_GET['type'] === 'update') {
                $id = $_GET['id'];
                $data = ucfirst($_POST['size']);
                $found = false;
                foreach ($size as $b) {
                    if ($b['name'] == $data) {
                        $found = true;
                        $_SESSION['message'] = [
                            'title' => 'Error',
                            'message' => 'Size Already exists',
                            'type' => 'error'
                        ];
                        break;
                    }
                }

                // updating into database
                if (!$found) {
                    update('size', ['name' => $data], "size_id = $id");
                    $_SESSION['message'] = [
                        'title' => 'Success',
                        'message' => 'Size Updated Successfully',
                        'type' => 'success'
                    ];
                    header('Location: manageSize.php');
                }
            } else {
                $data = ucfirst($_POST['size']);
                $found = false;
                foreach ($size as $b) {
                    if ($b['name'] == $data) {
                        $found = true;
                        $_SESSION['message'] = [
                            'title' => 'Error',
                            'message' => 'Size Already Exists',
                            'type' => 'error'
                        ];
                        break;
                    }
                }

                // inserting into database
                if (!$found) {
                    insert('size', ['name' => $data]);
                    $_SESSION['message'] = [
                        'title' => 'Success',
                        'message' => 'Size Added Successfully',
                        'type' => 'success'
                    ];
                    header('Location: manageSize.php');
                }
            }
        }
    }
}
?>

<div class="d-flex justify-content-between">
    <h3>Manage size</h3>
    <div class="row">
        <div class="col-md-12">
            <form action="" method="post" class="row g-2">
                <div class="col">
                    <input type="text" name="size" class="form-control" id="size" value="<?= isset($_GET['name']) ? $_GET['name'] : '' ?>">
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
                <?php foreach ($size as $key => $b) { ?>
                    <tr>
                        <td><?= ++$key ?></td>
                        <td><?= $b['name'] ?></td>
                        <td>
                            <a class="btn btn-primary" href="manageSize.php?id=<?= $b['size_id'] ?>&name=<?= $b['name'] ?>&type=update" onclick="return confirm('Are you sure you want to edit this size?')"><i class="fa-solid fa-edit" style="color: #fff;"></i></a>
                            <a class="btn btn-danger" href="manageSize.php?id=<?= $b['size_id'] ?>&type=delete" onclick="return confirm('Are you sure you want to delete this size?')"><i class="fa-solid fa-trash" style="color: #fff;"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>