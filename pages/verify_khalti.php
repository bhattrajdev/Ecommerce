<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Access the payload data
    if (isset($_POST) && !empty($_POST)) {
$payload = $_POST;

// Access specific data from the payload
$idx = $_POST['token'];

$args = http_build_query(array(
    'token' => $idx,
    'amount'  => 1000
));

$url = "https://khalti.com/api/v2/payment/verify/";

# Make the call using API.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$headers = ['Authorization: Key test_secret_key_112ed1b55aee46498542a2527d686d55'];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Response
$response = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if($status_code == 200){
            $_SESSION['message'] = [
                'title' => 'Success',
                'message' => 'transaction success',
                'type' => 'success'
            ];
}else{
            $_SESSION['message'] = [
                'title' => 'error',
                'message' => $status_code,
                'type' => 'error'
            ];
}

    }
}
