<?php
require('../../vendor/autoload.php');
use Respect\Validation\Validator as v;

class ControllerLogin{
  private $email, $senha;
  private function validaLogin():bool{
    $erro = false;
    if ($this->email == null || $this->senha == null) {
      echo "Verifique se todos os campos estão inseridos corretamente!";
      return false;
    }else if (v::email()->validate($this->email) == false){
      echo "Digite o email corretamente!";
      return false;
    }else if (v::stringType()->length(7, null)->validate($this->senha) == false ){
      echo "Sua senha deve conter pelo menos 7 caracteres!";
      return false;
    }else {
      return true;
    }
  }
  public function __construct(string $email, string $senha) {
    $this->email = $email;
    $this->senha = $senha;
    $this->validaLogin();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaLogin()) {
      require_once '../Model/main-Login.php';
      recebeLogPosts($this->email, $this->senha);
      /* kamaleaoctt@gmail.com   GabrielzinhoLindo1012  */
    }
  }
}