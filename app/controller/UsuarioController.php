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

    $usuario->setNome($d['nome']);
    $usuario->setHamburguer($d['hamburguer']);
    $usuario->setBebida($d['bebida']);
    $usuario->setComplemento($d['complemento']);

    $usuariodao->create($usuario);

    header("Location: ../../");
} 
// se a requisição for editar
else if(isset($_POST['editar'])){

    $usuario->setNome($d['nome']);
    $usuario->setHamburguer($d['hamburguer']);
    $usuario->setBebida($d['bebida']);
    $usuario->setComplemento($d['complemento']);
    $usuario->setId($d['id']);

    $usuariodao->update($usuario);

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