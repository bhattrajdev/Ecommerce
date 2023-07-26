<?php
require('googlelogin.php');
$login_url = htmlspecialchars($client->createAuthUrl());

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    
    $token = $client->fetchAccessTokenWithAuthCode($code);
    

    if (isset($token['error'])) {
        // If there's an error in the token response, redirect to the login page
        header('Location: login.php');
        exit;
    }

    // Check if the $token is set and not null before accessing it
    if (is_array($token) && isset($token['access_token'])) {
        // Save the token in the session and redirect to the index page
        $_SESSION['token'] = $token;
        header('Location: index.php');
        exit;
    } else {
        // If $token is not set correctly, redirect to the login page
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Google account</title>
</head>

<body>
    <div class="btn">
        <a href="<?= $login_url ?>" rel="nofollow"><img src="https://tinyurl.com/46bvrw4s" alt="Google Logo"> Login with Google</a>
    </div>
</body>

</html>