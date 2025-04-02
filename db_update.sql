-- Criação da tabela de usuários para o sistema de login
CREATE TABLE IF NOT EXISTS admin_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserção de um usuário administrador padrão (senha: admin123)
INSERT INTO admin_users (username, password, nome, email) VALUES
('admin', '$2y$10$8WxhZ7MUw0G7DNaO5ynCZuQeZ.TpIyFJ3Eq.RuPV2vxGzOYwG.Eni', 'Administrador', 'admin@gusta.com');