# Gusta's Hamburgueria - Sistema de Pedidos

Um sistema simples de gerenciamento de pedidos para a Gusta's Hamburgueria, desenvolvido em PHP com MySQL.

## Características

- Interface com tema escuro e laranja
- Cadastro de pedidos de clientes
- Visualização de todos os pedidos em uma tabela
- Edição e exclusão de pedidos
- Sistema CRUD completo

## Requisitos

- PHP 7.0 ou superior
- MySQL/MariaDB
- Servidor web (Apache, Nginx, etc.)
- XAMPP (recomendado para ambiente de desenvolvimento)

## Instalação

1. Clone ou baixe este repositório para a pasta htdocs do seu servidor XAMPP
2. Importe o banco de dados executando o script SQL fornecido
3. Acesse o sistema através do navegador: http://localhost/PHP-CRUD-02-04/

## Estrutura do Banco de Dados

A tabela `usuario` contém os seguintes campos:

- `id` - Identificador único do pedido
- `nome` - Nome do cliente
- `hamburguer` - Tipo de hambúrguer escolhido
- `bebida` - Bebida escolhida
- `complemento` - Complemento escolhido

## Tecnologias Utilizadas

- PHP (Orientado a Objetos)
- MySQL
- Bootstrap 4
- HTML/CSS
- JavaScript