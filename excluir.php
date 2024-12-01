<?php
require_once './lib/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
    try {
        $id = (int)$_GET["id"];

        $sqlDel = "  DELETE FROM`produtos` WHERE id = :id" ;
        $stmt = $conn -> prepare($sqlDel);
        $stmt -> bindValue(":id", $id);
        $stmt -> execute();

    } catch (Exception $e) {
        $error = $e ->getMessage();
        
    }

    $conn = null;
}

header("Refresh:0; url='index.php'");