<?php

$errors = [
    'name' => '',
    'email' => '',
    'confirmpassword' => '',
    'password' => '',
];
$oldvalues = [
    'name' => '',
    'email' => '',
];
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
    if ($_POST['password'] != $_POST['confirmpassword']) {
        $errors['confirmpassword'] = "Password doesn't match";
    }
    if (!array_filter($errors)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $confirm_passowrd = md5($_POST['confirmpassword']);
        $_SESSION['email'] = $email;
        $min = 100000;
        $max = 999999;
        $randomNumber = rand($min, $max);


        if ($password === $confirm_passowrd) {
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'verification_code' => $randomNumber,
            ];
            insert('Users', $data);
            $_SESSION['registered'] = true;
            $body =
                'Dear Customer,
                Thank you for choosing SneakerStation. To ensure the security of your account, we require you to verify your email address.
                Please use the following verification code to complete the verification process:
                <br><br>
                <b>Verification Code: ' . $randomNumber . '</b>
                <br><br>
            Thank you for your cooperation.
            <br><br>
            Best regards,
            <br><br>
            The SneakerStation Team';



            phpmailer($email, $body,"Verification Code");
            header('Location:register_validation.php');
        }
    }
}

?>

<section id="sign-up">
    <div class="form-box-signup">
        <div class="msg"></div>
        <h3>Register</h3>
        <form action="#" class="form" method="post">
            <div class="form-grp">
                <label for="name" class="form-label">Full Name: <a style="color:red;"><?= $errors['name']; ?></a></label><br>
                <input type="text" name="name" class="form-input" id="name" value="<?= $oldvalues['name']; ?>">
            </div>
            <div class="form-grp">
                <label for="email" class="form-label">Email: <a style="color:red;"><?= $errors['email']; ?></a></label><br>
                <input type="text" name="email" class="form-input" id="email" value="<?= $oldvalues['email']; ?>">
            </div>

            <div class="form-grp">
                <label for="password" class="form-label">Password: <a style="color:red;"><?= $errors['password']; ?></a></label><br>
                <input type="password" name="password" class="form-input" id="password">
            </div>
            <div class="form-grp">
                <label for="confirmpassword" class="form-label">Confirm Password: <a style="color:red;"><?= $errors['confirmpassword']; ?></a></label><br>
                <input type="password" name="confirmpassword" class="form-input" id="confirmpassword">
            </div>
            <button class="btn">Register</button>
        </form>

        <div class="already-text">Already a member?<a href="login.php"> &nbsp;Login</a></div>
    </div>
</section>