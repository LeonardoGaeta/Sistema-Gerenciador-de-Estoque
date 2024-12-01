<?php
require_once './lib/config.php';
$sqlDel = "  DELETE FROM `log`";
$stmt = $conn->query($sqlDel);

header("Refresh:0; url='index.php'");