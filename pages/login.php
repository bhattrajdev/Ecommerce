<?php
$errors = [
    'email' => '',
    'password' => '',
];
$oldvalue = [
    'email' => '',
];

$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if (empty($_POST[$key])) {
            $errors[$key]  = ucfirst($key) . " field is required";
        } else {
            $oldvalue[$key] = $value;
        }
    }

    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please Enter a valid email";
    }
    if (!array_filter($errors)) {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $query = select('*', 'Users', "WHERE email='{$email}' AND password='{$password}'");
        if ($query != null) {
            foreach ($query as $data) {
                $is_verified = $data['is_verified'];

                if ($is_verified == 1) {
                    $name = $data['name'];
                    $email = $data['email'];
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['users_id'] = $data['users_id'];
                    header('Location:index.php');
                } else {
                    $msg = "Please! Validate yourself";
                }
            }
        } else {
            $msg = "Invalid Credentials";
        }
    }
}





?>

<section id="sign-up" style="height: 80vh;">
    <div class="form-box-signup">
        <?php if ($msg != null) { ?>
            <h4 class="alert alert-danger" style="width: 100%; text-align:center; background-color:red; color:white;"><?= $msg ?></h4>
        <?php } ?>
        <h3>Sign up</h3>
        <form action="#" class="form" method="post">
            <div class="form-grp">
                <label for="email" class="form-label">Email:<span style="color:red"><?= $errors['email'] ?></span></label><br>
                <input type="text" name="email" class="form-input" id="email" value="<?= $oldvalue['email'] ?>">
            </div>
            <div class="form-grp">
                <label for="password" class="form-label">Password:<span style="color:red"><?= $errors['password'] ?></span></label><br>
                <input type="password" name="password" class="form-input" id="password">
            </div>
            <button class="btn">Sign Up</button>
        </form>
        <div class="already-text">Or Continue With</div>
        <div class="continue-width">

            <a href="#" class="facebook"><img src="<?= url("/public/images/facebook.png"); ?>"></a>
            <a href="#" class="google"><img src="<?= url("/public/images/google.png"); ?>"></a>
        </div>
        <div class="already-text">New Here?<a href="register.php"> &nbsp;Register</a></div>
    </div>
</section>
<!---------------------------------Login Code---------------------------->