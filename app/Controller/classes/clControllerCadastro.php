<?php
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); 
require_once (DIR_ROOT . '/Github/Kamaleao/app/Model/main-Cadastro.php');
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Respect\Validation\Validator as v;

class ControllerCadastro{
  private $nome, $sobrenome, $username, $dt_nascimento, $cpf, $email, $senha, $confsenha;
  private function validaCadastro():bool{
    if ($this->nome == null || $this->sobrenome == null || $this->dt_nascimento == null ||$this->cpf == null || $this->email == null || $this->username == null ||$this->senha == null || $this->confsenha == null) {
      $_SESSION["error"] = 'Verifique se todos os campos estão inseridos corretamente!';
      header("location: ../public/View/cadastro/cadastro.php");
      return false;
    }else if (v::email()->validate($this->email) == false){
      $_SESSION["error"] = 'Digite o email corretamente!';
      header("location: ../public/View/cadastro/cadastro.php");
      return false;
    }else if (v::maxAge(15, 'Y-m-d')->validate($this->dt_nascimento)){
      $_SESSION["error"] = 'Você precisa ser maior de 15 anos!';
      header("location: ../public/View/cadastro/cadastro.php");
      return false;
    }
    else if (v::cpf()->validate($this->cpf) == false){
      $_SESSION["error"] = 'Digite o cpf corretamente!';
      header("location: ../public/View/cadastro/cadastro.php");
      return false;
    }else if (v::stringType()->length(7, null)->validate($this->senha) == false ){
      $_SESSION["error"] = 'Sua senha deve conter pelo menos 7 caracteres!';
      header("location: ../public/View/cadastro/cadastro.php");
      return false;
    }else if ($this->senha != $this->confsenha){
      $_SESSION["error"] = 'As senhas devem coincidir!';
      header("location: ../public/View/cadastro/cadastro.php");
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
