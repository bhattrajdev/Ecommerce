<?php

require 'helpers/phpmailer.php';
require 'helpers/config.php';
require 'helpers/insert.php';
require 'helpers/select.php';
require 'helpers/update.php';
require 'helpers/delete.php';



    // frontend routes
    $requesturi = isset($_GET['uri']) ? $_GET['uri'] : 'index';
    $requesturi = str_replace('.php', '', $requesturi);
    $title = $requesturi;
    $requesturi = $requesturi . '.php';
    $pagepath = __DIR__ . '/pages/' . $requesturi;
    require "components/header.php";
    require 'ss-admin/components/message.php';

    if (file_exists($pagepath) && is_file($pagepath)) {
        require $pagepath;
    } else {
        require 'pages/errors/404.php';
    }
    require "components/footer.php";

