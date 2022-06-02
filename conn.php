<?php
$host = "127.0.0.1";
$user = "root";
$password = "";

$db_name = "pdo";

$con = new PDO("mysql:host=$host; dbname=$db_name", $user, $password);