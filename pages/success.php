<?php
$order_id = $_SESSION['order_id'];
echo $order_id;
print_r($order_id);

$query = select('*', 'orders', "WHERE order_id = $order_id");
$data = $query[0];
echo "<pre>";
print_r($query);


$response = $_GET['q'];

if ($response == 'su') {

    $url = "https://uat.esewa.com.np/epay/transrec";
    $data = [
        'amt' => $data['total'],
        // 'rid'=> $data['refId'],
        // 'pid'=> $data['oid'],
        'scd' => 'EPAYTEST'
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    // dd($total_amount);
    // strrpos()

    // if (strpos($response, "su")) {
        echo "Success";
        $_SESSION['message'] = [
            'title' => 'Success',
            'message' => 'Payment successfull',
            'type' => 'success'
        ];

        header('Location:index.php');
//     } else {
//     }
}
