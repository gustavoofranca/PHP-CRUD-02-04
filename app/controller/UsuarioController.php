<?php
include_once "../conexao/Conexao.php";
include_once "../model/Usuario.php";
include_once "../dao/UsuarioDAO.php";

//instancia as classes
$usuario = new Usuario();
$usuariodao = new UsuarioDAO();

//pega todos os dados passado por POST

$d = filter_input_array(INPUT_POST);

//se a operação for gravar entra nessa condição
if(isset($_POST['cadastrar'])){
    $errors = [];
    
    if (empty($d['nome'])) {
        $errors[] = "O campo nome é obrigatório";
    }
    
    if (empty($d['hamburguer'])) {
        $errors[] = "O campo hamburguer é obrigatório";
    }
    
    if (empty($d['bebida'])) {
        $errors[] = "O campo bebida é obrigatório";
    }
    
    if (empty($d['complemento'])) {
        $errors[] = "O campo complemento é obrigatório";
    }
    
    if (empty($d['telefone'])) {
        $errors[] = "O campo telefone é obrigatório";
    } else {
        // Remove caracteres não numéricos
        $telefone = preg_replace('/[^0-9]/', '', $d['telefone']);
        // Verifica se o telefone tem entre 10 e 11 dígitos (com DDD)
        if (strlen($telefone) < 10 || strlen($telefone) > 11) {
            $errors[] = "O telefone informado é inválido";
        }
    }
    
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../../");
        exit;
    }

    $usuario->setNome($d['nome']);
    $usuario->setHamburguer($d['hamburguer']);
    $usuario->setBebida($d['bebida']);
    $usuario->setComplemento($d['complemento']);
    $usuario->setTelefone($d['telefone']);

    if($usuariodao->create($usuario)) {
        $_SESSION['success'] = "Pedido cadastrado com sucesso!";
    } else {
        $_SESSION['errors'] = ["Erro ao cadastrar pedido"];
    }

    header("Location: ../../");
} 
// se a requisição for editar
else if(isset($_POST['editar'])){
    $errors = [];
    
    if (empty($d['nome'])) {
        $errors[] = "O campo nome é obrigatório";
    }
    
    if (empty($d['hamburguer'])) {
        $errors[] = "O campo hamburguer é obrigatório";
    }
    
    if (empty($d['bebida'])) {
        $errors[] = "O campo bebida é obrigatório";
    }
    
    if (empty($d['complemento'])) {
        $errors[] = "O campo complemento é obrigatório";
    }
    
    if (empty($d['telefone'])) {
        $errors[] = "O campo telefone é obrigatório";
    } else {
        // Remove caracteres não numéricos
        $telefone = preg_replace('/[^0-9]/', '', $d['telefone']);
        // Verifica se o telefone tem entre 10 e 11 dígitos (com DDD)
        if (strlen($telefone) < 10 || strlen($telefone) > 11) {
            $errors[] = "O telefone informado é inválido";
        }
    }
    
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../../");
        exit;
    }

    $usuario->setNome($d['nome']);
    $usuario->setHamburguer($d['hamburguer']);
    $usuario->setBebida($d['bebida']);
    $usuario->setComplemento($d['complemento']);
    $usuario->setTelefone($d['telefone']);
    $usuario->setId($d['id']);

    if($usuariodao->update($usuario)) {
        $_SESSION['success'] = "Pedido atualizado com sucesso!";
    } else {
        $_SESSION['errors'] = ["Erro ao atualizar pedido"];
    }

    header("Location: ../../");
}
// se a requisição for deletar
else if(isset($_GET['del'])){

    $usuario->setId($_GET['del']);

    $usuariodao->delete($usuario);

    header("Location: ../../");
}else{
    header("Location: ../../");
}