<?php
include 'config/config.php';
$bdd = $bdd= new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
?>
<!--Mis a disposition de connection a la bdd avec les identifiant de config.php-->