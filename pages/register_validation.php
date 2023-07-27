<?php
if ($_SESSION['registered'] != 'true') {
    header('Location:index.php');
}

$email = $_SESSION['email'];
$query = select('verification_code', 'Users', "WHERE email = '{$email}'");
if ($query !== null) {
    foreach ($query as $data) {
        $verification_code = $data['verification_code'];
    }
}

$errors = [
    'vcode' => '', 
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!preg_match("/^\d{6}$/", $_POST['vcode'])) {
        $errors['vcode'] = "Verification code should be a 6-digit number";
    } else {
        $vcode = $_POST['vcode'];

        if ($vcode == $verification_code) {
            $data = [
                'is_verified' => 1,
            ];
            $condition = "email = '{$email}'";
            update('users', $data, $condition);
            header('Location:login.php');
            unset($_SESSION['registered']);
            unset($_SESSION['email']);
        } else {
            $errors['vcode'] = "Verification code does not match";
        }
    }
}
?>

<section id="sign-up" style="height: 60vh;">
    <div class="form-box-signup">

        <h3>Check your mail, then enter the verification code.</h3>
        <form action="#" class="form" method="post">
            <div class="form-grp">
                <a style="color: red;"><?= $errors['vcode'] ?></a>
                <input type="text" name="vcode" class="form-input" id="vcode">
            </div>
            <button class="button">Submit</button>
        </form>
    </div>
</section>