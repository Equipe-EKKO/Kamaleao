<?php
// require_once("../model/classes/clUsuario.php");
// require('../../vendor/autoload.php');
use Respect\Validation\Validator as v;

class ControllerCadastro{
  public $nome, $sobrenome, $dt_nascimento, $cpf, $email, $senha;
  private function validaCadastro():bool{
    $this->nome = $_POST['nome'];
    $this->sobrenome = $_POST['sobrenome'];
    $this->dt_nascimento = $_POST['dt_nascimento'];
    $this->cpf = $_POST['cpf'];
    $this->email = $_POST['email'];
    $this->senha = $_POST['senha'];
    $confsenha = $_POST['confsenha'];

    if ($this->nome == null || $this->sobrenome == null || $this->cpf == null || $this->email == null || $this->senha == null || $confsenha == null) {
      echo "<span> Verifique se todos os campos estão inseridos corretamente!</span>";
      return false;
    }else if (v::email()->validate($this->email) == false){
      echo "<span> Digite o email corretamente!</span>";
      return false;
    }else if (v::cpf()->validate($this->cpf) == false){
      echo "<span> Digite o cpf corretamente!</span>";
      return false;
    }else if (v::stringType()->length(7, null)->validate($this->senha) == false ){
      echo "<span> Sua senha deve conter pelo menos 7 caracteres!</span>";
      return false;
    }else if ($this->senha != $confsenha){
      echo "<span> Sua senhas devem coincidir!</span>";
      return false;
    }
    return true;
  }
  public function __construct() {
    $this->chamaModel();
  }
  private function chamaModel() {
    if ($this->validaCadastro()) {
      echo "<script> window.location.assign('../Model/main-Cadastro.php') </script>";
    }
  }
}
$ControllerCadastro = new ControllerCadastro();
?>
