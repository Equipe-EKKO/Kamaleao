<?php
/* escrita por: Carolina Sena, no dia 24.09.2021*/
require_once 'clConexaoBanco.php'; # requere a classe ConexaoBanco usada nos filhos
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); # requere a Config usada nos filhos
require_once 'clAnuncio.php';
//Classe abstrata cuja função é servir de modelo para suas subclasses, combinando os métodos que elas têm em comum
abstract class Perfil {
    //Atributos da classe
    public $username, $descricao, $anuncio; # tipo: string. anuncio: classe anuncio

    //Metódos abstratos que serão declarados nas subclasses
    abstract function listarAnuncio(); 

    //Métodos Especias - Getter e Setters para os atributos
    /*Getters*/
    public function getUsername() {
        return $this->username; #retorna o valor do username
    }
    public function getDescricao() {
        return $this->descricao;
    }
    public function getAnuncio() {
        return $this->anuncio;
    }
    /*Setters*/
    public function setUsername(string $username) { //seta que o tipo de dado a ser passado como parametro deve ser string
        $this->username = $username; #seta o valor do username
    }
    public function setDescricao(string $descricao) {
        $this->descricao = $descricao;
    }
    public function setAnuncio(Anuncio $anuncio) {
        $this->anuncio = $anuncio;
    }
    // eu percebi que anuncio tbm é uma classe
    //minha nossa senhora
}
?>