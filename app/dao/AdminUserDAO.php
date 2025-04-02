<?php

class AdminUserDAO {
    
    public function create(AdminUser $user) {
        try {
            $sql = "INSERT INTO admin_users (username, password, nome, email)
                  VALUES (:username, :password, :nome, :email)";

            $p_sql = Conexao::getConexao()->prepare($sql);
            $p_sql->bindValue(":username", $user->getUsername());
            $p_sql->bindValue(":password", $user->getPassword());
            $p_sql->bindValue(":nome", $user->getNome());
            $p_sql->bindValue(":email", $user->getEmail());
            
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao Inserir usuário <br>" . $e . '<br>';
            return false;
        }
    }

    public function read() {
        try {
            $sql = "SELECT * FROM admin_users ORDER BY username ASC";
            $result = Conexao::getConexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_lista = array();
            foreach ($lista as $l) {
                $f_lista[] = $this->listaAdminUsers($l);
            }
            return $f_lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar Buscar Todos." . $e;
            return array();
        }
    }
     
    public function update(AdminUser $user) {
        try {
            $sql = "UPDATE admin_users SET
                  username = :username,
                  nome = :nome,
                  email = :email
                  WHERE id = :id";
            $p_sql = Conexao::getConexao()->prepare($sql);
            $p_sql->bindValue(":username", $user->getUsername());
            $p_sql->bindValue(":nome", $user->getNome());
            $p_sql->bindValue(":email", $user->getEmail());
            $p_sql->bindValue(":id", $user->getId());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar fazer Update<br> $e <br>";
            return false;
        }
    }

    public function updatePassword(AdminUser $user) {
        try {
            $sql = "UPDATE admin_users SET
                  password = :password
                  WHERE id = :id";
            $p_sql = Conexao::getConexao()->prepare($sql);
            $p_sql->bindValue(":password", $user->getPassword());
            $p_sql->bindValue(":id", $user->getId());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar atualizar a senha<br> $e <br>";
            return false;
        }
    }

    public function delete(AdminUser $user) {
        try {
            $sql = "DELETE FROM admin_users WHERE id = :id";
            $p_sql = Conexao::getConexao()->prepare($sql);
            $p_sql->bindValue(":id", $user->getId());
            return $p_sql->execute();
        } catch (Exception $e) {
            echo "Erro ao Excluir usuário<br> $e <br>";
            return false;
        }
    }

    public function findByUsername($username) {
        try {
            $sql = "SELECT * FROM admin_users WHERE username = :username LIMIT 1";
            $p_sql = Conexao::getConexao()->prepare($sql);
            $p_sql->bindValue(":username", $username);
            $p_sql->execute();
            $row = $p_sql->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                return $this->listaAdminUsers($row);
            }
            return null;
        } catch (Exception $e) {
            echo "Erro ao buscar usuário<br> $e <br>";
            return null;
        }
    }

    private function listaAdminUsers($row) {
        $user = new AdminUser();
        $user->setId($row['id']);
        $user->setUsername($row['username']);
        $user->setPassword($row['password']);
        $user->setNome($row['nome']);
        $user->setEmail($row['email']);
        $user->setCreatedAt($row['created_at']);

        return $user;
    }
}