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
    public function searchServEsp(string $username, string $titulo){
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT s.cd_serviço as 'cdServ', nm_serviço as 'titulo', ds_serviço as 'desc', vl_serviço as 'valor', nm_categoria as 'categoria', nm_licença as 'licenca', i.cd_url_serviço as 'urlfoto' FROM tb_serviço AS s JOIN tb_usuario AS u ON u.cd_usuario = s.cd_usuario JOIN tb_login AS l ON l.cd_login = u.cd_login JOIN tb_categoria AS cat ON s.cd_categoria = cat.cd_categoria JOIN tb_tipos_licença AS li ON li.cd_licença = s.cd_licença JOIN tb_imagem AS i ON s.cd_serviço = i.cd_serviço  WHERE l.nm_username = :username AND s.nm_serviço = :tituloserv"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':username', $username); 
        $stmt->bindValue(':tituloserv', $titulo);

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $resultados = $stmt->fetch(PDO::FETCH_ASSOC);         
            $resultstr = serialize($resultados); # transforma o array em string
            return $resultstr; # retorna a string
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
    }

    public function searchAllServMinosEsp(string $username, string $titulo){
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT s.cd_serviço as 'codigoserv',s.nm_serviço AS 'titulo', s.vl_serviço AS 'preço', img.cd_url_serviço as 'url_da_imagem',l.nm_username AS 'usernameserv' FROM `tb_serviço` AS s JOIN tb_usuario AS us ON us.cd_usuario = s.cd_usuario JOIN tb_login AS l ON l.cd_login = us.cd_login JOIN tb_imagem AS img ON s.cd_serviço = img.cd_serviço WHERE l.nm_username = :username AND s.nm_serviço != :tituloserv"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':username', $username); 
        $stmt->bindValue(':tituloserv', $titulo);

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $listAlmostAlll = $stmt->fetchALL(PDO::FETCH_ASSOC);         
            $resultstr = serialize($listAlmostAlll); # transforma o array em string
            return $resultstr; # retorna a string
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
    }

    public function listServRecente(){
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT s.cd_serviço as 'codigoserv',s.nm_serviço AS 'titulo', s.vl_serviço AS 'preço', img.cd_url_serviço as 'url_da_imagem',l.nm_username AS 'usernameserv' FROM `tb_serviço` AS s JOIN tb_usuario AS us ON us.cd_usuario = s.cd_usuario JOIN tb_login AS l ON l.cd_login = us.cd_login JOIN tb_imagem AS img ON s.cd_serviço = img.cd_serviço ORDER BY s.dt_criação DESC LIMIT 16"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
    
        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $listAll = $stmt->fetchALL(PDO::FETCH_ASSOC);         
            $resultstr = serialize($listAll); # transforma o array em string
            return $resultstr; # retorna a string
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
    }
    

    #Métodos Especias - Getter e Setters para os atributos e Construct
    public function __construct($nm_table) {
        $this->nomeTabela = $nm_table;
    }
    /* GETTERS */
    public function getNomeTabela() {
        return $this->nomeTabela;
    }
    /* SETTERS */
    public function setNomeTabela($nomeTabela) {
        $this->nomeTabela = $nomeTabela;
    }
}
