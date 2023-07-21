<?php
if (!isset($_SESSION['name']) && !isset($_SESSION['email']) && !isset($_SESSION['users_id'])) {
    header('location: login.php');
}
$address = $_SESSION['selected_address_id'];
$data = select('*', 'address', "WHERE address_id =" . $_SESSION['selected_address_id']);
$address = $data[0];
// echo "<pre>";
// print_r($_SESSION);
?>

<!-- custom inline css -->
<style>
    .data {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .data input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 75px;
        width: 5px;

    }

    .data input:checked~.checkmark {
        background-color: red;
        height: 60px;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .data input:checked~.checkmark:after {
        display: block;
    }

    .data .checkmark:after {
        background: white;
        color: red;
    }

    .checkout-box {
        max-height: 326px;
        overflow-y: scroll;
    }


    .row {
        display: flex;
        flex-wrap: wrap;
        margin-top: 1.5rem;
    }

    .container {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }

    .col-md-8 {
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        margin-bottom: 1.5rem;
        border-radius: 0.25rem;
        border: 1px solid rgba(0, 0, 0, 0.125);
        background-color: #fff;
    }

    .card-header {
        padding: 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        background-color: #f8f9fa;
    }

    .py-3 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .card-body {
        flex: 1 1 auto;
        padding: 1.25rem;
    }

    .form-outline {
        margin-bottom: 1.5rem;
    }

    .form-label {
        margin-bottom: 0;
        display: inline-block;
    }

    .form-control {
        display: block;
        width: 100%;
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .col-md-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }



    .card-header h5 {
        margin-bottom: 0;
    }

    .card-body form {
        margin-bottom: 0;
    }

    hr {
        margin-top: 1rem;
        margin-bottom: 1rem;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .horizonatal_row {
        border-bottom: 1px solid black;
    }

    .data h6 {
        margin-bottom: 0;
    }

    .checkout-box form {
        margin-bottom: 0;
    }

    .buttons {
        border: none;
        background: black;
        color: white;
        margin-top: 10px;
        margin-bottom: 10px;
        width: 100%;
        padding: 10px;
        cursor: pointer;
        font-size: 17px;
        font-weight: 600;
    }

    .line {
        border-bottom: 1px solid black;
    }

    @media (max-width: 600px) {

        .col-md-8,
        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        padding: 8px;

    }

    /* Additional styles */

    /* Responsive styles */
    @media screen and (max-width: 600px) {
        table {
            font-size: 12px;
        }

        th {
            padding: 5px;
        }
    }

    th {
        display: flex;
        justify-content: space-between;
    }

    .button_grp {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .esewa {
        background-color: #5DB544;
    }
</style>



<div class="row container mt-4">
    <div class="col-md-8 mb-4">
        <div class="card mb-4">
            <div class="card-header py-3">
                <h4 class="mb-0">
                    Overview
                </h4>
            </div>
            <div class="card-body">
                <table>
                    <tbody>
                        <tr>
                            <th>Address: <div><?= $address['address'] ?></div>
                            </th>
                        </tr>
                        <tr>
                            <th>Phone: <div><?= $address['phone'] ?><div>
                            </th>
                        </tr>
                        <tr>
                            <th>Email: <div><?= $address['email'] ?></div>
                            </th>
                        </tr>
                        <tr>
                            <th class="line"></th>
                        </tr>
                        <tr>
                            <th>Total: <div><?= $_SESSION['total'] - 200 - (($_SESSION['total'] - 200) * 13 / 100) ?></div>
                            </th>
                        </tr>
                        <tr>
                            <th>VAT(13%): <div><?= ($_SESSION['total'] - 200) * 13 / 100 ?></div>
                            </th>
                        </tr>
                        <tr>
                            <th>Delivery Charge <div> 200.00</div>
                            </th>
                        </tr>
                        <tr>
                            <th class="line"></th>
                        </tr>
                        <tr>
                            <th>Grand Total <div><?= $_SESSION['total'] ?></div>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card mb-4">
            <div class="card-header py-3">
                <h4>Payment Option</h4>
            </div>

            <div class="button_grp">
                <form action="#" method="post">
                    <button class="buttons cod" type="submit">Cash On Delivery</button>
                    <button class="buttons esewa" type="submit">E-sewa</button>
                </form>
            </div>

        </div>
    </div>
</div