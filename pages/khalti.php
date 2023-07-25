<button id="payment-button">Pay with Khalti</button>
<!-- Place this where you need the payment button -->

<!-- Paste this code anywhere in your body tag -->
<script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
<script>
    function verify_payment(token, amount) {
        var secretKey = "test_secret_key_112ed1b55aee46498542a2527d686d55"; // Replace this with your actual secret key

        $.ajax({
            url: "https://khalti.com/api/v2/payment/verify", // Replace this with the server-side PHP file URL that handles the verification
            type: "POST",
            headers: secretKey, // Send the entire payload directly to the server-side for verification
            dataType: token,
            amount,
            success: function(response) {
                // Handle the success response from the server-side verification
                console.log(response);
            },
            error: function(error) {
                // Handle the error response from the server-side verification
                console.error(error);
            }
        });
    }

    var config = {
        // replace the publicKey with yours
        "publicKey": "test_public_key_2de166fa2c874f3faa716209e31f3882", // Replace this with your actual public key
        "productIdentity": "1234565126527890",
        "productName": "new balance 1",
        "productUrl": "http://localhost/SneakersStation/productDetail.php",
        "paymentPreference": [
            "KHALTI",
            "EBANKING",
            "MOBILE_BANKING",
            "CONNECT_IPS",
            "SCT",
        ],
        "eventHandler": {
            onSuccess(payload) {
                console.log(payload);
                if (payload.idx) {
                    $.ajax({
                        method: 'POST',
                        url: "verify_khalti.php",
                        data: payload,
                        success: function(response) {
                            if (response.success == 1) {
                                window.location = response.redirecto;

                            } else {
                                checkout.hide();
                            }
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                }
                 },
            onError(error) {
                console.log("failure");
                console.log(error);
            },
            onClose() {
                console.log('widget is closing');
            }
        }
    };

    var checkout = new KhaltiCheckout(config);
    var btn = document.getElementById("payment-button");
    btn.onclick = function() {
        // minimum transaction amount must be 10, i.e 1000 in paisa.
        checkout.show({
            amount: 1000
        });
    };
</script>
<!-- Paste this code anywhere in your body tag -->