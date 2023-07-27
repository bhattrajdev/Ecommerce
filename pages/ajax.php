<?php
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $args = http_build_query(array(
//         'token' => $_POST['token'],
//         'amount' => $_POST['amount'],

//     ));
//     $url = "https://khalti.com/api/v2/payment/verify/";
//     // $url = "https://a.khalti.com/api/v2/epayment/initiate/";
//     // $url = "https://khalti.com/api/v2/payment/verify/";

//     // Make the call using API.
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_POST, 1);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//     $headers = ['Authorization: Key test_secret_key_112ed1b55aee46498542a2527d686d55'];
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//     // Response
//     $response = curl_exec($ch);
//     $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     curl_close($ch);

//     // Process the response
//     $responseData = json_decode($response, true);
//     if ($responseData['success']) {
//         $_SESSION['is_paid'] = 1;
//         $_SESSION['order_date'] = date('Y-m-d');

//         // Insert the payment details into the database
//         $payment_method = "khalti";
//         $order_id = $_POST['order_id'];
//         $isPaid = 1;
//         $orderDate = date('Y-m-d');

//         $data = [
//             'payment_method' => $payment_method,
//             'is_paid' => '1',
//             'order_date' => $orderDate
//         ];
//         update('orders', $data, "order_id = $order_id");

//         // update('orders',)
//         $_SESSION['message'] = [
//             'title' => 'Success',
//             'message' => 'New Order Placed Succesfully',
//             'type' => 'success'
//         ];
//         unset($_SESSION['cartdata']);
//         header('Content-Type: application/json');
//         $_SESSION['message'] = [
//             'title' => 'Success',
//             'message' => 'payment Successfull',
//             'type' => 'success'
//         ];

//         echo json_encode(array('success' => true, 'message' => 'Payment successful'));
//         exit;
//     } else {
//         header('Content-Type: application/json');
//         $_SESSION['message'] = [
//             'title' => 'Success',
//             'message' => 'payment Failed',
//             'type' => 'success'
//         ];

//         echo json_encode(array('success' => false, 'message' => 'Payment verification failed'));
//         exit;
//     }
// }
?>
