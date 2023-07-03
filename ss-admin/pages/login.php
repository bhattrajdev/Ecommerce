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
            $errors[$key] = ucfirst($key) . " field is required";
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
        $query = select('*', 'admin', "WHERE email='{$email}' AND password='{$password}'");
        if ($query != null) {
            foreach ($query as $data) {
                $email = $data['email'];
                $_SESSION['email'] = $email;
                $_SESSION['is_admin'] = true;
                header("Location:" . url('ss-admin'));
            }
        } else {
            $msg = "Username or Password is invalid";
        }
    }
}



?>

<style>
    #sign-up {
        background-color: #F0F4F8;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;

    }

    #sign-up .form-box-signup {
        margin-top: 30px;
        background-color: #ffffff;
        width: 90%;
        max-width: 400px;
        border-top: 5px solid #ff0000;
        border-radius: 10px;
        padding: 20px;
        /* box-shadow: 2px 2px 5px #BBA5A0; */
        box-shadow: 0 20px 40px -14px rgba(0, 0, 0, 0.25);
        margin: 10px;
    }

    #sign-up h3 {
        font-weight: 600;
        margin: 20px 0;
        font-size: 25px;
        text-align: center;
    }

    #sign-up input {
        border-radius: 5px;
        font-size: 15px;
        width: 100%;
        padding: 0.5rem 0.95rem;
        border: 1px solid #bcccdc;
        margin-bottom: 10px;
    }

    .form-grp {
        padding-bottom: 15px;
    }

    .btn {
        width: 100%;
        height: 30px;
        font-size: 15px;
        border: none;
        font-weight: 600;
        background-color: #ff0000;
        cursor: pointer;
        color: #ffffff;
        border-radius: 3px;
        margin-top: 10px;
    }

    .btn:hover {
        box-shadow: 2px 2px 5px #BBA5A0;
    }

    .already-text {
        text-align: center;
        margin-top: 10px;
    }

    .already-text a {
        color: #ff0000;
        text-transform: uppercase;
    }

    .continue-width {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 10px;
    }

    img {
        width: 30px;
        margin-left: 15px;
    }

    @media (max-width: 600px) {
        #sign-up .form-box-signup {
            width: 90%;
            max-width: 90%;
        }
    }

    @media (max-width: 768px) {
        #sign-up .form-box-signup {
            width: 80%;
            max-width: 80%;
        }
    }
</style>


<section id="sign-up">
    <div class="form-box-signup">
        
        <?= $msg !=''?'<div class="msg alert alert-danger">'. $msg.'</div>':''?>
        <h3>Admin Login</h3>
        <form action="#" class="form" method="post">
            <div class="form-grp">
                <label for="email" class="form-label">Email: <a style="color:red;"><?= $errors['email']; ?></a></label><br>
                <input type="text" name="email" class="form-input" id="email" value="<?= $oldvalue['email']; ?>">
            </div>

            <div class="form-grp">
                <label for="password" class="form-label">Password: <a style="color:red;"><?= $errors['password']; ?></a></label><br>
                <input type="password" name="password" class="form-input" id="password">
            </div>
            <button class="btn">Login</button>
        </form>
    </div>
</section>