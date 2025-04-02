-- Adicionando campo de telefone na tabela usuario
ALTER TABLE usuario
ADD COLUMN telefone VARCHAR(20) NOT NULL DEFAULT '';

-- Atualizando registros existentes para ter um valor padrão
UPDATE usuario SET telefone = 'Não informado' WHERE telefone = '';