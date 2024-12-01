<?php
$driverName =   "mysql";
$serverName =   "localhost";
$dbName =       "mercado";
$user =         "root";
$password =     "";

try {
    $conn = new PDO("$driverName:host=$serverName;dbname=$dbName", $user, $password);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die ("Erro na conexão: ". $e -> getMessage());
}