<?php
require_once("../model/classes/clUsuario.php");
require_once("../model/classes/clAdministrador.php");
require('../../vendor/autoload.php');
use Respect\Validation\Validator as v;

class ControllerLogin{
  public $email, $senha;  
  private function validaLogin():bool{
    $this->email = $_POST['nome'];
    $this->senha = $_POST['senha'];

    if ($this->email == null || $this->senha == null){
      $erro = "Verifique se todos os campos estão inseridos corretamente!";
    }else if (v::email()->validate($this->email) == false){
      $erro = "Digite o email corretamente!";
    }else if (v::stringType()->length(7, null)->validate($this->senha) == false ){
      $erro = "Sua senha deve conter pelo menos 7 caracteres!";
    }else {
      return true;
    }
  }
  public function __construct() {
    $this->chamaModel();
  }
  private function chamaModel() {
    if ($this->validaLogin()) {
      echo "<script> window.location.assign('../Model/main-Login.php') </script>";
    }
  }
}
$ControllerLogin = new ControllerLogin();