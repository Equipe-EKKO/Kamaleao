<?php
/* escrita por: Carolina Sena, no dia 24.09.2021*/
abstract class Participante {
    #Atributos da classe
    private $senha; //tipo: string. 
    protected $email; //tipo: string. 
    public $username; //tipo: string. 

    #Metódos abstratos que serão declarados nas subclasses
    abstract function cadastrarConta(string $email, string $username, string $senha); //método para cadastrar conta (disponível apenas para usuário)
    abstract function logarConta(string $email, string $username, string $senha); //método para cadastrar conta (disponível para todos)
    abstract function excluirConta(); //método para exluir conta (disponível apenas para usuário)
    abstract function atualizarEmail(); //método para atualizar email da conta (disponível apenas para usuário)
    abstract function atualizarSenha(); //método para atualizar senha da conta (disponível apenas para usuário)

    #Métodos Especias - Getter e Setters para os atributos
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