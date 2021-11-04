<?php
/* escrita por: Carolina Sena, no dia 03.11.2021*/
require_once 'clConexaoBanco.php'; # requere a classe ConexaoBanco usada nos filhos
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); # requere a Config usada nos filhos
require_once "autoloadClass.php";

//Classe cuja função é servir de agrupamento para a realização de consultas livres.
class PesquisaAberta {
    #Atributos
    public $nomeTabela; // tabela a ser pesquisada. nomeTabela: string.
    #Métodos da classe abstrata sendo implementados
    //Método que fará o select para pegar todas as categorias
    public function searchCategoria():mixed {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT cd_categoria, nm_categoria FROM tb_categoria"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara o select para execução

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);           
            $resultstr = serialize($resultados); # transforma o array em string
            return $resultstr; # retorna a string
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
    }
    #Métodos Especias - Getter e Setters para os atributos e Construct

    /* GETTERS */
    public function getNomeTabela() {
        return $this->nomeTabela;
    }
    /* SETTERS */
    public function setNomeTabela($nomeTabela) {
        $this->nomeTabela = $nomeTabela;
    }
}
