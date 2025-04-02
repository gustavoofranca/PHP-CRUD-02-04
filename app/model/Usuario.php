<?php

class Usuario{
    
    private $id;
    private $nome;
    private $hamburguer;
    private $bebida;
    private $complemento;
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getHamburguer() {
        return $this->hamburguer;
    }

    function getBebida() {
        return $this->bebida;
    }

    function getComplemento() {
        return $this->complemento;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setHamburguer($hamburguer) {
        $this->hamburguer = $hamburguer;
    }

    function setBebida($bebida) {
        $this->bebida = $bebida;
    }

    function setComplemento($complemento) {
        $this->complemento = $complemento;
    }


    
}

