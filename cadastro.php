<?php
    require_once './lib/config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
        try {
            foreach ($_POST as $chave => $valor) {
                $valor = trim(strip_tags($valor));
                $$chave = $valor;
            }
    
            $sqlInsert = "  INSERT INTO `produtos` (`produto`, `categoria`, `estoque`, `estoqueMin`)
                            VALUES (:produto, :categoria, :estoque, :estoqueMin)";
            $stmt = $conn -> prepare($sqlInsert);
            $stmt -> bindValue(":produto", $produto);
            $stmt -> bindValue(":categoria", $categoria);
            $stmt -> bindValue(":estoque", $estoque);
            $stmt -> bindValue(":estoqueMin", $estoqueMin);
    
            $stmt -> execute();
        } catch (Exception $e) {
            $error = $e ->getMessage();
            
        }

        $conn = null;
    }

    if (isset($error)) {
        header("Refresh:0; url='index.php?error=$error'");
    } else {
        header("Refresh:0; url='index.php'");
    }