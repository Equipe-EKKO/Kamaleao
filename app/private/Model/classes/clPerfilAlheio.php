<?php
#requere as classes necessárias para o funcionamento (Conexão para fazer o CRUD e Perfil para herdar da classe mãe)
require_once 'clPerfil.php';
//Subclasse de Perfil cuja função é lidar com as funcionalidades CRUD da partição do Perfil Alheio do sistema
class PerfilAlheio extends Perfil {
    #Atributos
    public $avaliacao; # avaliação: instancia de classe 

    #Métodos da classe abstrata sendo implementados
    function listarServiços() {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT s.nm_serviço AS 'titulo', s.vl_serviço AS 'preço', img.cd_url_serviço as 'url_da_imagem',l.nm_username AS 'username' FROM `tb_serviço` AS s JOIN tb_usuario AS us ON us.cd_usuario = s.cd_usuario JOIN tb_login AS l ON l.cd_login = us.cd_login JOIN tb_imagem AS img ON s.cd_serviço = img.cd_serviço WHERE l.nm_username = :username"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara o select para execução
        $stmt->bindValue(':username', $_SESSION['gambiarrauser']);

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $rsltService = $stmt->fetchAll(PDO::FETCH_ASSOC);           
            $rsltStrService = serialize($rsltService); # transforma o array em string
            return $rsltStrService; # retorna a string
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
    }

    #Métodos da Classe PerfilPróprio em Si
    public function dadosPerfilAlheio(string $username) {
        if ($this->verificaPerfilExiste($username)) {
            $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

            $sql = "SELECT l.nm_username as 'username', us.ds_usuario as 'descricao', ft.cd_url_perfil as 'urlfoto' FROM tb_usuario AS us JOIN tb_login AS l ON l.cd_login = us.cd_login JOIN tb_foto_perfil as ft ON us.cd_usuario = ft.cd_usuario  WHERE l.nm_username = :username"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
            $stmt = $banco->prepare($sql); # prepara o select para execução
            $stmt->bindValue(':username', $username);

            /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
            try {
                $stmt->execute(); # executa a query preparada           
                $rsltPerf = $stmt->fetch(PDO::FETCH_ASSOC);           
                $this->setUsername($rsltPerf['username']);
                if ($rsltPerf['descricao'] != null) {
                    $this->setDescricao($rsltPerf['descricao']);
                }
                if ($rsltPerf['urlfoto'] != null) {
                    $this->setFotoPerfil($rsltPerf['urlfoto']);
                }
                $_SESSION['gambiarrauser'] = $rsltPerf['username'];
                return true; # retorna a string
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
                return false;
        }
        } else {
            return false;
        }
    }
    private function verificaPerfilExiste(string $username):bool {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT l.nm_username as 'username', us.nm_nome as 'nome' FROM tb_usuario AS us JOIN tb_login AS l ON l.cd_login = us.cd_login WHERE l.nm_username = :username"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara o select para execução
        $stmt->bindValue(':username', $username);

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada           
            $contaLinha = $stmt->rowCount();
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }

        if ($contaLinha == 1) {
            return true;
        } else {
            return false;
        }
    }    
}
