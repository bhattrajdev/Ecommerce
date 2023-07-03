<?php
session_start();
if(!function_exists('url')){
    function url($path  = ""){
        $path = trim($path,'/');
        $http = $_SERVER['REQUEST_SCHEME'];
        $servername = $_SERVER['SERVER_NAME'];
        return $http = $http.'://'.$servername.'/SneakersStation/'.$path;
    
    }
}

if (!function_exists('public_path')) {
    function public_path($path = "")
    {
        return dirname(__DIR__) . '/public/' . $path;
    }
}


$dbcon = new PDO("mysql:host=localhost;dbname=SneakerStation", 'root', '');





?>