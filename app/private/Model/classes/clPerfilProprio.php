<?php
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
    function addDescricao() {

    }
    function updateDescricao() {

    }
    function criarAnuncio() {

    }
    function excluirAnuncio() {

    }
    function avaliarComissao() {

    }

    #Métodos Especias - Getter e Setters para os atributos
    /* Construtor */
    public function __construct(string $user) {
        $this->setUsername($user);
        $this->setFotoPerfil(null);
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
