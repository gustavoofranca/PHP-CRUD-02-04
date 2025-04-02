<?php
session_start();

// Se já estiver logado, redireciona para a página principal
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Login - Gusta's Hamburgueria</title>
    <style>
        body {
            background-color: #222;
            color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background-color: #333;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 400px;
        }
        .btn-primary {
            background-color: #ff5722 !important;
            border-color: #ff5722 !important;
        }
        .form-control {
            background-color: #444;
            color: #f8f9fa;
            border: 1px solid #555;
        }
        .form-control:focus {
            background-color: #555;
            color: #f8f9fa;
            border-color: #ff5722;
            box-shadow: 0 0 0 0.2rem rgba(255,87,34,0.25);
        }
        .alert {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-container">
                    <div class="text-center mb-4">
                        <img src="./assets/Logo.png" width="80" height="80" alt="Logo">
                        <h2 class="mt-3">Gusta's Hamburgueria</h2>
                    </div>

                    <?php if (isset($_SESSION['login_errors'])): ?>
                        <?php foreach ($_SESSION['login_errors'] as $error): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['login_errors']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['register_success'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION['register_success']; ?>
                        </div>
                        <?php unset($_SESSION['register_success']); ?>
                    <?php endif; ?>

                    <form action="app/controller/AuthController.php" method="POST">
                        <div class="form-group">
                            <label for="username">Usuário</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary btn-block">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>