<?php

$client = new Google_Client();

$client_id
= '144129831602-hmb3t40lng5ptrd1oj903cdnaf5a2uo0.apps.googleusercontent.com';
$client_secret =
'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';

$client = new Google\Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);

# redirection location is the path to login.php
$redirect_uri =
'http://localhost/SneakersStation/login';
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");