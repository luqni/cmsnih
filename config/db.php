<?php

defined('BASEPATH') OR exit('No direct script access allowed'); //prevent direct script access
$host = 'localhost';
$user = 'root'; //replace with your database username
$password = 'P@ssw0rd'; //replace with your database password
$dbname = 'wa_api'; //replace with your database name
$dsn = '';

try{
    $dsn = 'mysql:host='.$host. ';dbname='.$dbname;

    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo 'connection failed: '.$e->getMessage();
}
?>