<?php
/*
    Criação da classe Usuario com o CRUD
*/
class UsuarioDAO{
    
    public function create(Usuario $usuario) {
        try {
            $sql = "INSERT INTO usuario (                   
                  nome,hamburguer,bebida,complemento)
                  VALUES (
                  :nome,:hamburguer,:bebida,:complemento)";

            $p_sql = Conexao::getConexao()->prepare($sql);
            $p_sql->bindValue(":nome", $usuario->getNome());
            $p_sql->bindValue(":hamburguer", $usuario->getHamburguer());
            $p_sql->bindValue(":bebida", $usuario->getBebida());
            $p_sql->bindValue(":complemento", $usuario->getComplemento());
            
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Erro ao Inserir usuario <br>" . $e . '<br>';
        }
    }

    public function read() {
        try {
            $sql = "SELECT * FROM usuario order by nome asc";
            $result = Conexao::getConexao()->query($sql);
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_lista = array();
            foreach ($lista as $l) {
                $f_lista[] = $this->listaUsuarios($l);
            }
            return $f_lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar Buscar Todos." . $e;
        }
    }
     
    public function update(Usuario $usuario) {
        try {
            $sql = "UPDATE usuario set
                
                  nome=:nome,
                  hamburguer=:hamburguer,
                  bebida=:bebida,
                  complemento=:complemento                  
                                                                       
                  WHERE id = :id";
            $p_sql = Conexao::getConexao()->prepare($sql);
            $p_sql->bindValue(":nome", $usuario->getNome());
            $p_sql->bindValue(":hamburguer", $usuario->getHamburguer());
            $p_sql->bindValue(":bebida", $usuario->getBebida());
            $p_sql->bindValue(":complemento", $usuario->getComplemento());
            $p_sql->bindValue(":id", $usuario->getId());
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar fazer Update<br> $e <br>";
        }
    }

    public function delete(Usuario $usuario) {
        try {
            $sql = "DELETE FROM usuario WHERE id = :id";
            $p_sql = Conexao::getConexao()->prepare($sql);
            $p_sql->bindValue(":id", $usuario->getId());
            return $p_sql->execute();
        } catch (Exception $e) {
            echo "Erro ao Excluir usuario<br> $e <br>";
        }
    }


    

    private function listaUsuarios($row) {
        $usuario = new Usuario();
        $usuario->setId($row['id']);
        $usuario->setNome($row['nome']);
        $usuario->setHamburguer($row['hamburguer']);
        $usuario->setBebida($row['bebida']);
        $usuario->setComplemento($row['complemento']);

        return $usuario;
    }
 }

 ?>
