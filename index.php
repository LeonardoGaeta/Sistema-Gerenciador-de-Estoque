<?php
require_once './lib/config.php';

if (isset($_GET["error"])) {
    $error = (string) $_GET["error"];
}


$sqlEst = "SELECT * FROM `produtos`";
$stmt = $conn->query($sqlEst);

$produtos = $stmt->fetchAll(PDO::FETCH_OBJ);

$sqlLog = "SELECT * FROM `log`";
$stmt = $conn->query($sqlLog);

$logs = $stmt->fetchAll(PDO::FETCH_OBJ);

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
            <span>Error: <?=$error?></span>
            <button id="closeAlert" class="font-bold ml-6 btn btn-error" onclick="body.removeChild(this.parentNode)">
                <i class="fas fa-close"></i>
            </button>
        </div>
    <?php } ?>

    <div class="navbar bg-base-100">
        <div class="navbar-start">
            <a href="index.php" class="btn btn-ghost text-xl">Estoque</a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1"> <!-- Open the modal using ID.showModal() method -->
                <button class="btn btn-outline text-xl" onclick="my_modal_5.showModal()">Cadastrar</button>
                <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
                    <div class="modal-box">
                        <h3 class="text-lg font-bold">Cadastrar!</h3>
                        <form action="./cadastro.php" method="POST" class="flex flex-col gap-14">
                            <div>
                                <label for="produto" class="form-control">
                                    <div class="label">
                                        <span class="label-text">Produto</span>
                                    </div>
                                    <input name="produto" id="produto" type="text" placeholder="Type here"
                                        class="input input-bordered" required />
                                </label>

                                <label for="categoria" class="form-control">
                                    <div class="label">
                                        <span class="label-text">Categoria</span>
                                    </div>
                                    <input name="categoria" id="categoria" type="text" placeholder="Type here"
                                        class="input input-bordered" required />
                                </label>

                                <label for="estoque" class="form-control">
                                    <div class="label">
                                        <span class="label-text">Estoque</span>
                                    </div>
                                    <input name="estoque" id="estoque" type="text" placeholder="Type here"
                                        class="input input-bordered" required />
                                </label>

                                <label for="estoqueMin" class="form-control">
                                    <div class="label">
                                        <span class="label-text">Estoque Minimo</span>
                                    </div>
                                    <input name="estoqueMin" id="estoqueMin" type="text" placeholder="Type here"
                                        class="input input-bordered" required />
                                </label>
                            </div>
                            <button type="submit" class=" btn btn-outline btn-success">Cadastrar</button>
                        </form>
                        <div class="modal-action">
                            <form method="dialog">
                                <button class="btn">Close</button>
                            </form>
                        </div>
                    </div>
                </dialog>
            </ul>
        </div>
    </div>

    <div class="space-y-40">
        <div class="container mx-auto">
            <div class="overflow-x-auto">
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Estoque</th>
                            <th>Estoque Minimo</th>
                            <th>Situação</th>
                        </tr>
                    </thead>
                    <!-- body -->
                    <tbody>
                        <?php
                        foreach ($produtos as $produto) {
                            ?>
                            <tr class="hover">
                                <td><?= $produto->id ?></td>
                                <td><?= $produto->produto ?></td>
                                <td><?= $produto->categoria ?></td>
                                <td><?= $produto->estoque ?></td>
                                <td><?= $produto->estoqueMin ?></td>
                                <td><?= $produto->situacao ?></td>
                                <td>
                                    <a href="./formEditar.php?id=<?=$produto->id?>" class="btn btn-outline btn-accent">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="./excluirConfirm.php?id=<?=$produto->id?>" class="btn btn-outline btn-secondary">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="container mx-auto">
            <div class="overflow-x-auto">
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Log</th>
                            <th>Situação</th>
                            <th>Data log</th>
                        </tr>
                    </thead>
                    <!-- body -->
                    <tbody>
                        <?php
                        foreach ($logs as $log) {
                            ?>
                            <tr class="hover">
                                <td><?= $log->id ?></td>
                                <td><?= $log->desc ?></td>
                                <td><?= $log->situacao ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($log->dataLog)) ?></td>
                                <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="./limparLog.php" class="btn btn-outline btn-error">Limpar Log</a>
            </div>
        </div>
    </div>
</body>

</html>