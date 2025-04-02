-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS github;
USE github;

-- Criação da tabela usuario
CREATE TABLE IF NOT EXISTS usuario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  hamburguer VARCHAR(50) NOT NULL,
  bebida VARCHAR(50) NOT NULL,
  complemento VARCHAR(50) NOT NULL
);

-- Inserção de alguns dados de exemplo
INSERT INTO usuario (nome, hamburguer, bebida, complemento) VALUES
('João Silva', 'X-Bacon', 'Coca-Cola', 'Batata Frita'),
('Maria Oliveira', 'X-Salada', 'Sprite', 'Sem Complemento'),
('Pedro Santos', 'X-Burguer', 'Coca-Cola Zero', 'Batata Frita');