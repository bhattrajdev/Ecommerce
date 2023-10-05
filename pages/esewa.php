<?php
$url = "https://uat.esewa.com.np/epay/main";
$data = [
    'amt' => 100,
    'pdc' => 0,
    'psc' => 0,
    'txAmt' => 0,
    'tAmt' => 100,
    'pid' => 'ee2c3ca1-696b-4cc5-a6be-2c40d929d453',
    'scd' => 'EPAYTEST',
    'su' => 'http://merchant.com.np/page/esewa_payment_success?q=su',
    'fu' => 'http://merchant.com.np/page/esewa_payment_failed?q=fu'
];

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);
?>


<body>
    <form action="https://uat.esewa.com.np/epay/main" method="POST">
        <input value="100" name="tAmt" type="hidden">
        <input value="90" name="amt" type="hidden">
        <input value="5" name="txAmt" type="hidden">
        <input value="2" name="psc" type="hidden">
        <input value="3" name="pdc" type="hidden">
        <input value="EPAYTEST" name="scd" type="hidden">
        <input value="ee2c3ca1-696b-4cc5-a6be-2c40d929d453" name="pid" type="hidden">
        <input value="http://merchant.com.np/page/esewa_payment_success?q=su" type="hidden" name="su">
        <input value="http://merchant.com.np/page/esewa_payment_failed?q=fu" type="hidden" name="fu">
        <input value="Submit" type="submit">
    </form>
</body>