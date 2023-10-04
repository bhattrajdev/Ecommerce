<?php
echo $_POST;
die();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['token']) &&
        isset($_POST['amount']) &&
        isset($_POST['order_id']) &&
        isset($_POST['order_date']) &&
        isset($_POST['is_paid'])
    ) {
        $token = $_POST['token'];
        $amount = $_POST['amount'];
        $order_id = $_POST['order_id'];
        $order_date = $_POST['order_date'];
        $is_paid = $_POST['is_paid'];

        $args = http_build_query(array(
            'token' => $token,
            'amount' => $amount
        ));

        $url = "https://a.khalti.com/api/v2/epayment/initiate/";

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
        $responseData = json_decode($response, true);

        // Check if the response is valid JSON
        if ($responseData === null || json_last_error() !== JSON_ERROR_NONE) {
            // Invalid JSON received
            error_log("Invalid JSON response: " . $response);
            echo "Invalid JSON response received from the API.";
            exit;
        }

        if ($status_code == 200 && $responseData['success']) {
            // Payment was successful
            $_SESSION['is_paid'] = 1;
            $_SESSION['order_date'] = date('Y-m-d');
            $payment_method = "khalti";
            $order_id = $_POST['order_id'];
            $isPaid = 1;
            $orderDate = date('Y-m-d');

            $data = [
                'payment_method' => $payment_method,
                'is_paid' => $isPaid,
                'order_date' => $orderDate
            ];
            // Assuming `update` is your custom function to update the order status
            update('orders', $data, "order_id = $order_id");

            // Display success message and redirect to index.php
            $_SESSION['message'] = [
                'title' => 'Success',
                'message' => 'New Order Placed Successfully',
                'type' => 'success'
            ];
            unset($_SESSION['cartdata']);
            header('Location: index.php');
            exit;
        } else {
            // Payment failed or API returned an error
            error_log("Payment verification failed: " . print_r($responseData, true));

            // Display failure message and stay on the same page
            $_SESSION['message'] = [
                'title' => 'Failure',
                'message' => 'Payment Failed',
                'type' => 'error'
            ];
            header('Location: index.php'); // Redirect to the appropriate page
            exit;
        }
    } else {
        // Required POST data missing
        echo "Invalid request. Required data missing.";
        exit;
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
    exit;
}
