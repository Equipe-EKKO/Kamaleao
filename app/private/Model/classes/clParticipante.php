<?php
/* escrita por: Carolina Sena, no dia 24.09.2021*/
require_once 'clConexaoBanco.php'; # requere a classe ConexaoBanco usada nos filhos
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); # requere a Config usada nos filhos
require_once "autoloadClass.php";

//Classe abstrata cuja função é servir de modelo para suas subclasses, combinando os métodos e atributos que elas têm em comum
abstract class Participante {
    //Atributos da classe
    private $senha; # tipo: string. 
    protected $email; # tipo: string. 
    public $username; # tipo: string. 

    //Metódos abstratos que serão declarados nas subclasses
    abstract function cadastrarConta(string $email, string $username, string $senha); # método para cadastrar conta (disponível apenas para usuário)
    abstract function logarConta(string $email, string $senha); # método para cadastrar conta (disponível para todos)
    abstract function atualizarEmail(string $email, int $cdUpdate); # método para atualizar email da conta (disponível apenas para usuário)
    abstract function atualizarSenha(string $senha, int $cdUpdate); # método para atualizar senha da conta (disponível apenas para usuário)
    abstract function atualizarUsername(string $username, int $cdUpdate); # método para atualizar username da conta (disponível apenas para usuário)
    abstract function recuperarSenha(string $email, string $novaSenha);  # método para recuperação de senha quando o usuário não tiver como inserir a anterior (disponível apenas para usuários)

    //Métodos Especias - Getter e Setters para os atributos
    /*Getters*/
    public function getSenha() {
        return $this->senha; #retorna o valor da senha
    }
    public function getEmail() {
        return $this->email; #retorna o valor do email
    }
    public function getUsername() {
        return $this->username; #retorna o valor do username
    }
    /*Setters*/
    public function setSenha(string $senha) { //seta que o tipo de dado a ser passado como parametro deve ser string
        $this->senha = $senha; #seta o valor da senha
    }
    public function setEmail(string $email) { //seta que o tipo de dado a ser passado como parametro deve ser string
        $this->email = $email; #seta o valor do email
    }
    public function setUsername(string $username) { //seta que o tipo de dado a ser passado como parametro deve ser string
        $this->username = $username; #seta o valor do username
    }
}
?>