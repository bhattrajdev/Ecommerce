<?php
ob_start();

require '../helpers/config.php';
require '../helpers/insert.php';
require '../helpers/select.php';
require '../helpers/update.php';
require '../helpers/delete.php';
require './helpers/insertImages.php';
require "./layout/header.php";
require './components/message.php';




if (isset($_SESSION['email']) && isset($_SESSION['is_admin'])) {

    $requesturi = isset($_GET['uri']) ? $_GET['uri'] : 'index';
    $requesturi = str_replace('.php', '', $requesturi);
    $title = $requesturi;
    $requesturi = $requesturi . '.php';

    $pagepath = __DIR__ . '/pages/' . $requesturi;
    require "./layout/aside.php";

    if (file_exists($pagepath) && is_file($pagepath)) {
        require $pagepath;
    } else {
        require 'pages/errors/404.php';
    }
    require "./layout/footer.php";
} else {
    $pagepath = __DIR__ . '/pages/' . 'login.php';
    require $pagepath;
}
