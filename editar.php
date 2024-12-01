<?php
    require_once './lib/config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST)) {
        try {
            foreach ($_POST as $chave => $valor) {
                $valor = trim(strip_tags($valor));
                $$chave = $valor;
            }
    
            $sqlEdit = "  UPDATE `produtos`
                            SET produto = :produto, categoria = :categoria, estoque = :estoque, estoqueMin = :estoqueMin
                            WHERE id = :id";
            $stmt = $conn -> prepare($sqlEdit);
            $stmt -> bindValue(":produto", $produto);
            $stmt -> bindValue(":categoria", $categoria);
            $stmt -> bindValue(":estoque", $estoque);
            $stmt -> bindValue(":estoqueMin", $estoqueMin);
            $stmt -> bindValue(":id", $id);
    
            $stmt -> execute();
        } catch (Exception $e) {
            $error = $e ->getMessage();
            
        }

        $conn = null;
    }

    if (isset($error)) {
        header("Refresh:0; url='formEditar.php?error=$error&id=$id'");
    } else {
        header("Refresh:0; url='index.php'");
    }