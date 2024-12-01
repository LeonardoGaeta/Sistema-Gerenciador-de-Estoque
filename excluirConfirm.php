<?php
require_once './lib/config.php';

if (isset($_GET["error"])) {
    $error = (string) $_GET["error"];
}

$id = (int) $_GET["id"];


$sqlEst = "SELECT * FROM `produtos` WHERE id = :id";
$stmt = $conn->prepare($sqlEst);
$stmt->bindValue(":id", $id);
$stmt->execute();

$produto = $stmt->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Estoque</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/9dabb0ed4f.js"></script>
</head>

<body>
    <?php if (isset($error)) { ?>
        <div role="alert" class="alert alert-error" id="alert">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Error: <?= $error ?></span>
            <button id="closeAlert" class="font-bold ml-6 btn btn-error" onclick="body.removeChild(this.parentNode)">
                <i class="fas fa-close"></i>
            </button>
        </div>
    <?php } ?>
    <div class="navbar bg-base-100">
        <div class="navbar-start">
            <a href="index.php" class="btn btn-ghost text-xl">Estoque</a>
        </div>
    </div>

    <div class="space-y-60">
        <div class="container mx-auto">
            <div class="overflow-x-auto">
                <form action="./excluir.php?id=<?=$produto->id?>" method="POST" class="my-14">
                    <table class="table">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th></th>
                                <th>Produto</th>
                                <th>Categoria</th>
                                <th>Estoque</th>
                                <th>Estoque Minimo</th>
                            </tr>
                        </thead>
                        <!-- body -->
                        <tbody>
                            <tr class="hover">
                                <td><?= $produto->id ?></td>
                                <td><?= $produto->produto ?></td>
                                <td><?= $produto->categoria ?></td>
                                <td><?= $produto->estoque ?></td>
                                <td><?= $produto->estoqueMin ?></td>
                                <td><?= $produto->situacao ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div role="alert" class="alert alert-warning mt-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Warning: Você está presetes a apagar este registro. Tem certeza?</span>
                        <div>
                            <button class="btn btn-lg btn btn-active text-yellow-500"><a href="./index.php">Deny</a></button>
                            <button class="btn btn-lg btn btn-active text-yellow-500" type="submit">Accept</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</body>

</html>