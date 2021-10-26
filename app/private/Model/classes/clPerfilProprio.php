<?php
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
#requere as classes necessárias para o funcionamento (Conexão para fazer o CRUD e Perfil para herdar da classe mãe)
require_once 'clPerfil.php';
use Anuncio;

//Subclasse de Perfil cuja função é lidar com as funcionalidades CRUD da partição do Perfil no sistema
class PerfilProprio extends Perfil {
    #Atributos
    /*public $listAnuncio;*/
    private $inventario, $comissao; # inventario: instancia de classe || comissao: instancia de classe
    //Métodos da classe abstrata sendo implementados
    function listarAnuncio() {
        
    }

    #Métodos da Classe PerfilPróprio em Si
    function baixarInventario() {

    }
    function updateDescricao(string $desc, int $cdUpdate) {
        /*Agrupamento dos valores a serem inseridos*/
        $this->setDescricao($desc);
        /*Conexão com o Banco*/
        $banco = ConexaoBanco::abreConexao(); # chama a função estática da classe ConexaoBanco para abrir a conexão com o servidor MYSQL

        $sql = "UPDATE tb_usuario SET ds_usuario = :descricao WHERE cd_login = :cdUpdate"; # declara a query do insert na tabela login do banco de dados 
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':descricao', $desc); 
        $stmt->bindValue(':cdUpdate', $cdUpdate);

        /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
        try {
            $stmt->execute(); # executa a query preparada anteriormente
            return true;
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
            return false;
        }
    }
    function criarAnuncio() {

    }
    function excluirAnuncio() {

    }
    function avaliarComissao() {

    }

    #Métodos Especias - Getter e Setters para os atributos
    /* Construtor */
    public function __construct(string $user, string $desc) {
        $this->setUsername($user);
        $this->setFotoPerfil(null);
        $this->setDescricao($desc);
    }
    /*GETTERS*/
    public function getAnuncio() {
        /*foreach ($this->anuncio as $key => $anuncio) {
            return $anuncio[$key];
        }*/
        
    }
    public function getInventario() {
        return $this->inventario;
    }
    public function getComissao() {
        return $this->comissao;
    }
    /*SETTERS*/
    public function setAnuncio(Anuncio $anuncio) {
        $this->anuncio = $anuncio;
    }

    public function setInventario(/*Inventario*/ $inventario) {
        $this->inventario = $inventario;
    }

    public function setComissao(/*Comissao*/ $comissao) {
        $this->comissao = $comissao;
    }
}
