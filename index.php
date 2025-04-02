<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include_once "./app/conexao/Conexao.php";
include_once "./app/dao/UsuarioDAO.php";
include_once "./app/model/Usuario.php";

//instancia as classes
$usuario = new Usuario();
$usuariodao = new UsuarioDAO();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Gusta's Hamburgueria</title>
    <style>
        body {
            background-color: #222;
            color: #f8f9fa;
        }
        .menu,
        thead {
            background-color: #333 !important;
            color: #f8f9fa !important;
        }
        .navbar {
            background-color: #222 !important;
            border-bottom: 2px solid #ff5722;
        }
        .navbar-brand {
            color: #ff5722 !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .row {
            padding: 10px;
        }
        .btn-primary {
            background-color: #ff5722 !important;
            border-color: #ff5722 !important;
        }
        .btn-warning {
            background-color: #ff9800 !important;
            border-color: #ff9800 !important;
            color: white !important;
        }
        .table {
            color: #f8f9fa !important;
        }
        .table-hover tbody tr:hover {
            background-color: #444 !important;
        }
        .modal-content {
            background-color: #333;
            color: #f8f9fa;
        }
        .form-control {
            background-color: #444;
            color: #f8f9fa;
            border: 1px solid #555;
        }
        .form-control:focus {
            background-color: #555;
            color: #f8f9fa;
        }
        .close {
            color: #f8f9fa;
        }
        .close:hover {
            color: #ff5722;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark menu">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="./assets/Logo.png" width="40" height="40" class="d-inline-block align-top mr-2" alt="">
                Gusta's Hamburgueria
            </a>
            <div class="d-flex align-items-center">
                <span class="text-light mr-3">Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?></span>
                <a href="app/controller/AuthController.php?logout=true" class="btn btn-outline-light btn-sm">Sair</a>
            </div>
        </div>
    </nav>
    
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="container mt-3">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="container mt-3">
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['success']; ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <div class="container">
        <form action="app/controller/UsuarioController.php" method="POST">
            <div class="row">
                <div class="col-md-3">
                    <label>Nome do Cliente</label>
                    <input type="text" name="nome" value="" autofocus class="form-control" required />
                </div>
                <div class="col-md-3">
                    <label>Hambúrguer</label>
                    <select name="hamburguer" class="form-control">
                        <option value="X-Burguer">X-Burguer</option>
                        <option value="X-Salada">X-Salada</option>
                        <option value="X-Bacon">X-Bacon</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Bebida</label>
                    <select name="bebida" class="form-control">
                        <option value="Coca-Cola">Coca-Cola</option>
                        <option value="Coca-Cola Zero">Coca-Cola Zero</option>
                        <option value="Kuat">Kuat</option>
                        <option value="Sprite">Sprite</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Complemento</label>
                    <select name="complemento" class="form-control">
                        <option value="Batata Frita">Batata Frita</option>
                        <option value="Sem Complemento">Sem Complemento</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Telefone</label>
                    <input type="tel" name="telefone" class="form-control" required placeholder="(99) 99999-9999" />
                </div>
                <div class="col-md-2">
                    <br>
                    <button class="btn btn-primary" type="submit" name="cadastrar">Registrar Pedido</button>
                </div>
            </div>
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Cliente</th>
                        <th>Hambúrguer</th>
                        <th>Bebida</th>
                        <th>Complemento</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuariodao->read() as $usuario) : ?>
                        <tr>
                            <td><?= $usuario->getId() ?></td>
                            <td><?= $usuario->getNome() ?></td>
                            <td><?= $usuario->getHamburguer() ?></td>
                            <td><?= $usuario->getBebida() ?></td>
                            <td><?= $usuario->getComplemento() ?></td>
                            <td><?= $usuario->getTelefone() ?></td>
                            <td class="text-center">
                                <button class="btn  btn-warning btn-sm" data-toggle="modal" data-target="#editar><?= $usuario->getId() ?>">
                                    Modificar
                                </button>
                                <a href="app/controller/UsuarioController.php?del=<?= $usuario->getId() ?>">
                                <button class="btn  btn-danger btn-sm" type="button">Excluir</button>
                                </a>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="editar><?= $usuario->getId() ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modificar Pedido</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="app/controller/UsuarioController.php" method="POST">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Nome do Cliente</label>
                                                    <input type="text" name="nome" value="<?= $usuario->getNome() ?>" class="form-control" require />
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Hambúrguer</label>
                                                    <select name="hamburguer" class="form-control">
                                                        <option value="Classic" <?= $usuario->getHamburguer() == 'Classic' ? 'selected' : '' ?>>Classic</option>
                                                        <option value="Cheese" <?= $usuario->getHamburguer() == 'Cheese' ? 'selected' : '' ?>>Cheese</option>
                                                        <option value="Bacon" <?= $usuario->getHamburguer() == 'Bacon' ? 'selected' : '' ?>>Bacon</option>
                                                        <option value="Vegano" <?= $usuario->getHamburguer() == 'Vegano' ? 'selected' : '' ?>>Vegano</option>
                                                        <option value="Duplo" <?= $usuario->getHamburguer() == 'Duplo' ? 'selected' : '' ?>>Duplo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Bebida</label>
                                                    <select name="bebida" class="form-control">
                                                        <option value="Coca-Cola" <?= $usuario->getBebida() == 'Coca-Cola' ? 'selected' : '' ?>>Coca-Cola</option>
                                                        <option value="Coca-Cola Zero" <?= $usuario->getBebida() == 'Coca-Cola Zero' ? 'selected' : '' ?>>Coca-Cola Zero</option>
                                                        <option value="Kuat" <?= $usuario->getBebida() == 'Kuat' ? 'selected' : '' ?>>Kuat</option>
                                                        <option value="Sprite" <?= $usuario->getBebida() == 'Sprite' ? 'selected' : '' ?>>Sprite</option>
                                                        <option value="Milk-Shake" <?= $usuario->getBebida() == 'Milk-Shake' ? 'selected' : '' ?>>Milk-Shake</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Complemento</label>
                                                    <select name="complemento" class="form-control" required>
                                                        <option value="Batata Frita" <?= $usuario->getComplemento() == 'Batata Frita' ? 'selected' : '' ?>>Batata Frita</option>
                                                        <option value="Onion Rings" <?= $usuario->getComplemento() == 'Onion Rings' ? 'selected' : '' ?>>Onion Rings</option>
                                                        <option value="Nuggets" <?= $usuario->getComplemento() == 'Nuggets' ? 'selected' : '' ?>>Nuggets</option>
                                                        <option value="Sem Complemento" <?= $usuario->getComplemento() == 'Sem Complemento' ? 'selected' : '' ?>>Sem Complemento</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Telefone</label>
                                                    <input type="tel" name="telefone" value="<?= $usuario->getTelefone() ?>" class="form-control" required placeholder="(99) 99999-9999" />
                                                </div>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <br>
                                                    <input type="hidden" name="id" value="<?= $usuario->getId() ?>" />
                                                    <button class="btn btn-primary" type="submit" name="editar">Atualizar Pedido</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>