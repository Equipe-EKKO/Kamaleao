<?php
/* escrita por: Carolina Sena, no dia 03.11.2021*/
require_once 'clConexaoBanco.php'; # requere a classe ConexaoBanco usada nos filhos
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); # requere a Config usada nos filhos
require_once "autoloadClass.php";

//Classe abstrata cuja função é servir de modelo para suas subclasses, combinando os métodos e atributos que elas têm em comum
class PesquisaAberta {
    #Atributos
    public $nomeTabela; // tabela a ser pesquisada. nomeTabela: string.
    #Métodos da classe abstrata sendo implementados
    public function searchCategoria():string /*:bool*/ {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT cd_categoria, nm_categoria FROM tb_categoria"; # declara query do select que irá verificar se o email escolhido já foi cadastrado anteriormente numa conta (tanto como usuário ou como administrador)
        $stmt = $banco->prepare($sql); # prepara o select para execução

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $resultados = $stmt->fetchAll(PDO::ATTR_DEFAULT_FETCH_MODE);
            
            $resultstr = serialize($resultados);
            
            return $resultstr;
            //return true;
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
    }
    #Métodos Especias - Getter e Setters para os atributos e Construct
    /* Construtor */
    /*public function __construct(string $nomeTabela) {
        $this->setNomeTabela($nomeTabela);
        /*
        if ($this->getNomeTabela == "tb_categoria") {
            $pesqCat = (array) $this->searchCategoria();
            return $pesqCat;
            /*if ($this->searchCategoria() ):
                return true;
            else:
                return false;
            endif;*/
        //}
    //}

    /* GETTERS */
    public function getNomeTabela() {
        return $this->nomeTabela;
    }
    /* SETTERS */
    public function setNomeTabela($nomeTabela) {
        $this->nomeTabela = $nomeTabela;
    }
}
