<?php
/* escrita por: Carolina Sena, no dia 12.10.2021 */
require_once 'clConexaoBanco.php'; # requere a classe ConexaoBanco usada nos filhos
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); # requere a Config usada nos filhos

//Classe abstrata cuja função é servir de modelo para suas subclasses, combinando os métodos e atributos que elas têm em comum
abstract class Perfil {
    #Atributos da classe
    public $username, $urlfotoPerfil, $descricao, $serviço; // username: string || foto_perfil: blob || descrição: string || Serviço: instancia de clServiço

    #Metódos abstratos que serão declarados nas subclasses
    abstract function listarServiço(); 

    #Métodos Especias - Getter e Setters para os atributos
    /*GETTERS*/
    public function getUsername() {
        return $this->username; #retorna o valor do username
    }
    public function getDescricao() {
        return $this->descricao;
    }
    public function getFotoPerfil() {
        return $this->fotoPerfil;
    }
    # Sem GET para Serviço pois é um atributo que depende de cada filho
    /*SETTERS*/
    public function setUsername(string $username) { //seta que o tipo de dado a ser passado como parametro deve ser string
        $this->username = $username; #seta o valor do username (que vai vir do cadastro)
    }
    public function setDescricao(string $descricao) { //seta que o tipo de dado a ser passado como parametro deve ser string
        $this->descricao = $descricao; #seta o valor de descricao
    }
    public function setFotoPerfil($fotoPerfil) { 
        $this->fotoPerfil = $fotoPerfil;
    }
    # Sem SET para Serviço pois é um atributo que depende de cada filho
}
?>