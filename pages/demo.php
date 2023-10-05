<?php
header('Content-Type: application/json');

if (isset($_POST['token'])) {
    // Your processing logic here...

    $responseData = array(
        'token' => 'hhTS2q53dVVAmCGpWqvKDS',
        'amount' => 333.28,
        'order_id' => 3,
        'order_date' => '23-10-05',
        'is_paid' => 1
    );

    
    echo json_encode($responseData);
    exit;
} else {
    $responseData = array(
        'error' => 'Data not found'
    );

    echo json_encode($responseData);
    exit;
}
