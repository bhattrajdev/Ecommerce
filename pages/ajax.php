<?php

if (isset($_POST)) {

    if (
        isset($_POST['token']) &&
        isset($_POST['amount']) &&
        isset($_POST['order_id']) &&
        isset($_POST['order_date']) &&
        isset($_POST['is_paid'])
    ) {
        $token = $_POST['token'];
        echo $token;
        $amount = $_POST['amount'];
        echo $amount;

        $order_id = $_POST['order_id'];
        echo $order_id;

        $order_date = $_POST['order_date'];
        echo $order_date;

        $is_paid = $_POST['is_paid'];
        echo $is_paid;


        $data = [
            'token' => $token,
            'amount' => $amount,
        ];


        $url = "https://khalti.com/api/v2/payment/verify/";

        $ch = curl_init($url);


        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Key test_secret_key_112ed1b55aee46498542a2527d686d55',
            'Content-Type: application/json',
        ));

        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);


        $responseData = json_decode($response, true);

        print_r($response);
        if ($responseData === null || json_last_error() !== JSON_ERROR_NONE) {
            error_log("Invalid JSON response: " . $response);
            echo "Invalid JSON response received from the API.";
            exit;
        }
        if ($status_code == 200 && isset($responseData['success']) && $responseData['success'] == true) {
            $_SESSION['is_paid'] = 1;
            $_SESSION['order_date'] = date('Y-m-d');
            exit;
        } else {

            error_log("Payment verification failed: " . print_r($responseData, true));

            $_SESSION['message'] = [
                'title' => 'Failure',
                'message' => 'Payment Failed',
                'type' => 'error'
            ];
            // header('Location: failure.php');
            exit;
        }
    } else {
        echo "Invalid request. Required data missing.";
        $errorMsg = "Payment processing failed. Please try again later.";
        $responseData = [
            'success' => 0,
            'error' => $errorMsg
        ];

        echo json_encode($responseData);
        exit;
    }
} else {
    echo 'Invalid request method.';
    exit;
}
