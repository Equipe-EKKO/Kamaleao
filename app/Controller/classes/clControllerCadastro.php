<?php
require_once '../Model/main-Cadastro.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Respect\Validation\Validator as v;

class ControllerCadastro{
  private $nome, $sobrenome, $username, $dt_nascimento, $cpf, $email, $senha, $confsenha;
  private function validaCadastro():bool{
    if ($this->nome == null || $this->sobrenome == null || $this->dt_nascimento == null ||$this->cpf == null || $this->email == null || $this->username == null ||$this->senha == null || $this->confsenha == null) {
      echo "<span> Verifique se todos os campos estão inseridos corretamente!</span>";
      return false;
    }else if (v::email()->validate($this->email) == false){
      echo "<span> Digite o email corretamente!</span>";
      return false;
    }else if (v::maxAge(15, 'Y-m-d')->validate($this->dt_nascimento)){
      echo "<span> Você precisa ser maior de 15 anos!</span>";
      return false;
    }
    else if (v::cpf()->validate($this->cpf) == false){
      echo "<span> Digite o cpf corretamente!</span>";
      return false;
    }else if (v::stringType()->length(7, null)->validate($this->senha) == false ){
      echo "<span> Sua senha deve conter pelo menos 7 caracteres!</span>";
      return false;
    }else if ($this->senha != $this->confsenha){
      echo "<span> Sua senhas devem coincidir!</span>";
      return false;
    }
    return true;
  }
  public function __construct(string $nome, string $sobrenome, string $username, string $dt_nascimento, string $cpf, string $email, string $senha, string $confsenha) {
    $this->nome = $nome;
    $this->sobrenome = $sobrenome;
    $this->username = $username;
    $this->dt_nascimento = $dt_nascimento;
    $this->cpf = $cpf;
    $this->email = $email;
    $this->senha = $senha;
    $this->confsenha = $confsenha;
    $this->validaCadastro();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaCadastro()) {
      recebeCadPosts($this->nome, $this->sobrenome, $this->dt_nascimento, $this->cpf, $this->email, $this->username, $this->senha);
    }
  }
}

?>
