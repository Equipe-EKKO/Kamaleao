<?php
ob_start();
/* escrita por: Carolina Sena, no dia 21.11.2021*/
require_once 'clConexaoBanco.php'; # requere a classe ConexaoBanco usada nos filhos
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); # requere a Config usada nos filhos

//Classe cuja função é representar um ou mais objetos de Serviço
class Pedido {
    #Atributos
    public $nmPedido, $dsPedido, $icCancelado, $vlPedido, $dsResposta; # nmServiço: string || dsServiço: string || imtmpServiço: string com url de imagem || tipoLicença: inteiro || vlServiço: float
    private $cdUsuario, $cdServiço; // cdDono e cdUsuario: inteiro

    public function salvaPedido(int $cd_serviço, string $username, string $titulo, string $desc):bool {
        /*seta os valores dos parametros*/
        $this->setNmPedido($titulo);
        $this->setDsPedido($desc);
        if ($this->verificaDados($cd_serviço, $username)) {
            /*Conexão com o Banco*/
            $banco = ConexaoBanco::abreConexao(); # chama a função estática da classe ConexaoBanco para abrir a conexão com o servidor MYSQL
            $sql = "INSERT INTO `tb_pedido` (`nm_pedido`, `ds_pedido`, `cd_serviço`, cd_usuario) VALUES (:titulo, :descricao, :cdservico, :cdusuario)"; # declara a query do insert na tabela serviço do banco de dados 
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/
            $stmt->bindValue(':titulo', $titulo); 
            $stmt->bindValue(':descricao', $desc);
            $stmt->bindValue(':cdservico', $cd_serviço);
            $stmt->bindValue(':cdusuario', $this->getCdUsuario());

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt->execute(); # executa a query preparada anteriormente
                return true; # retorna true se o processo dos dois inserts forem verdadeiros
            } catch (\PDOException $e) {
                exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }  
        } else {
            return false;
        }
        
    }

    private function verificaDados(int $cdserv, string $username):bool {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático
        
        $sql = "SELECT `cd_serviço` FROM `tb_serviço` WHERE `cd_serviço` = :cdserv"; # declara query do select que irá verificar se o serviço existe
        $stmt = $banco->prepare($sql); # prepara o select para execuçãp
        $stmt->bindValue(':cdserv', $cdserv); #substitui o placeholder da query preparada
        
        /*Try catch que tentará executar o select e contar quantas linhas foram retornadas*/
        try {
            $stmt->execute(); # executa a query preparada 
            $contaLinha = $stmt->rowCount(); # armazena numa variável o valor de quantas linhas existem no retorno desse select
        } catch (\PDOException $e) {
            exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        
        if ($contaLinha === 1) { # estrutura condicional que irá verificar se o valor de linhas do select anterior é igual a um, ou seja, se o select retorna que o serviço existe, e caso tenha retornado...
            $this->setCdServiço($cdserv);
            $sql2 = "SELECT cd_usuario FROM tb_usuario JOIN tb_login ON tb_login.cd_login = tb_usuario.cd_login WHERE nm_username = :nmuser"; # declara query do select que irá verificar se o username solicitante existe
            $stmt2 = $banco->prepare($sql2); # prepara o select para execuçãp
            $stmt2->bindValue(':nmuser', $username); #substitui o placeholder da query preparada

            /*Try catch que tentará executar o select e contar quantas linhas foram retornadas*/
            try {
                $stmt2->execute(); # executa a query preparada 
                $contaLinha2 = $stmt2->rowCount(); # armazena numa variável o valor de quantas linhas existem no retorno desse select
                $cduser = $stmt->fetchColumn();
            } catch (\PDOException $e) {
                exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage());  # retorna erro, caso houver, e sai do script
                return false;
            }

            if ($contaLinha2 === 1) { # estrutura condicional que irá verificar se o valor de linhas do select anterior é igual a 1, ou seja, se o select retornou algo, e caso tenha retornado...
                $this->setCdUsuario($cdserv);
                return true;
            } else {
                ob_end_clean();
                echo "Houve um erro na seleção do usuário solicitante. Tente novamente.";  # exibe ao usuário que o username escolhido já foi cadastrado.
                return false; # retorna a saída como falsa
            }
        } else { # caso não, retorna erro
            ob_end_clean();
            echo "Houve um erro na seleção do serviço relacionado ao pedido solicitado. Tente novamente.";  # exibe ao usuário que o username escolhido já foi cadastrado.
            return false; # retorna a saída como falsa
        }
    }

    #Métodos Especias - Getter e Setters para os atributos
    /*GETTERS*/
    public function getNmPedido() {
        return $this->nmPedido;
    }
    public function getDsPedido() {
        return $this->dsPedido;
    }
    public function getIcCancelado() {
        return $this->icCancelado;
    }
    public function getVlPedido() {
        return $this->vlPedido;
    }
    public function getDsResposta() {
        return $this->dsResposta;
    }
    public function getCdUsuario() {
        return $this->cdUsuario;
    }
    public function getCdServiço() {
        return $this->cdServiço;
    }
    //*SETTERS*/
    public function setNmPedido(string $nmPedido) {
        $this->nmPedido = $nmPedido;
    }
    public function setDsPedido(string $dsPedido) {
        $this->dsPedido = $dsPedido;
    }
    
    private function setCdServiço($cdServiço) {
        $this->cdServiço = $cdServiço;
    } 
    public function setIcCancelado($icCancelado) {
        $this->icCancelado = $icCancelado;
    } 
    public function setVlPedido($vlPedido) {
        $this->vlPedido = $vlPedido;
    }
    public function setDsResposta($dsResposta) {
        $this->dsResposta = $dsResposta;
    } 
    public function setCdUsuario($cdUsuario) {
        $this->cdUsuario = $cdUsuario;
    }
}

?>