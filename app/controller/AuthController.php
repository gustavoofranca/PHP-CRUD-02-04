<?php
session_start();
include_once "../conexao/Conexao.php";
include_once "../model/AdminUser.php";
include_once "../dao/AdminUserDAO.php";

// Instancia as classes
$adminUser = new AdminUser();
$adminUserDAO = new AdminUserDAO();

// Pega todos os dados passados por POST
$d = filter_input_array(INPUT_POST);

// Verifica a operação solicitada
if (isset($_POST['login'])) {
    // Validação dos campos
    $errors = [];
    
    if (empty($d['username'])) {
        $errors[] = "O campo usuário é obrigatório";
    }
    
    if (empty($d['password'])) {
        $errors[] = "O campo senha é obrigatório";
    }
    
    // Se houver erros, redireciona de volta com as mensagens
    if (!empty($errors)) {
        $_SESSION['login_errors'] = $errors;
        header("Location: ../../login.php");
        exit;
    }
    
    // Busca o usuário pelo nome de usuário
    $user = $adminUserDAO->findByUsername($d['username']);
    
    // Verifica se o usuário existe e se a senha está correta
    if ($user && password_verify($d['password'], $user->getPassword())) {
        // Login bem-sucedido, cria a sessão
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['nome'] = $user->getNome();
        $_SESSION['is_logged_in'] = true;
        
        // Redireciona para a página principal
        header("Location: ../../index.php");
        exit;
    } else {
        // Login falhou
        $_SESSION['login_errors'] = ["Dados inválidos"];
        header("Location: ../../login.php");
        exit;
    }
} 
// Operação de logout
else if (isset($_GET['logout'])) {
    // Destrói a sessão
    session_unset();
    session_destroy();
    
    // Redireciona para a página de login
    header("Location: ../../login.php");
    exit;
}
// Operação de registro (opcional, para adicionar novos administradores)
else if (isset($_POST['register'])) {
    // Validação dos campos
    $errors = [];
    
    if (empty($d['username'])) {
        $errors[] = "O campo usuário é obrigatório";
    }
    
    if (empty($d['password'])) {
        $errors[] = "O campo senha é obrigatório";
    }
    
    if (empty($d['nome'])) {
        $errors[] = "O campo nome é obrigatório";
    }
    
    if (empty($d['email'])) {
        $errors[] = "O campo email é obrigatório";
    } else if (!filter_var($d['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "O email informado é inválido";
    }
    
    // Verifica se o usuário já existe
    $existingUser = $adminUserDAO->findByUsername($d['username']);
    if ($existingUser) {
        $errors[] = "Este nome de usuário já está em uso";
    }
    
    // Se houver erros, redireciona de volta com as mensagens
    if (!empty($errors)) {
        $_SESSION['register_errors'] = $errors;
        header("Location: ../../register.php");
        exit;
    }
    
    // Cria o novo usuário
    $adminUser->setUsername($d['username']);
    $adminUser->setPassword(password_hash($d['password'], PASSWORD_DEFAULT));
    $adminUser->setNome($d['nome']);
    $adminUser->setEmail($d['email']);
    
    if ($adminUserDAO->create($adminUser)) {
        $_SESSION['register_success'] = "Usuário cadastrado com sucesso!";
        header("Location: ../../login.php");
        exit;
    } else {
        $_SESSION['register_errors'] = ["Erro ao cadastrar usuário"];
        header("Location: ../../register.php");
        exit;
    }
} 
// Redireciona para a página principal se nenhuma operação for especificada
else {
    header("Location: ../../index.php");
    exit;
}