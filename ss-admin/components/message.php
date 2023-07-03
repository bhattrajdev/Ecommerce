<?php
/* 
=======================Sweet alert 2 function==============
*/
if (isset($_SESSION['message'])) {
    $title = $_SESSION['message']['title'];
    $message = $_SESSION['message']['message'];
    $type = $_SESSION['message']['type'];

    // Display the message
    echo "<script type='text/javascript'>";
    echo "Swal.fire({
        title: '$title',
        text: '$message',
        icon: '$type'
    });";
    echo "</script>";

    // Clear the message from the session
    unset($_SESSION['message']);
}


