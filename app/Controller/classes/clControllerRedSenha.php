<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);  //   E:/xampp/htdocs
require_once (DIR_ROOT . '/GitHub/Kamaleao/app/Model/\main-RedefineSenha.php');
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Respect\Validation\Validator as v;

class ControllerRedSenha{
  private $email, $senha, $confsenha;
  private function validaRedefinicao():bool{
    if ($this->email == null || $this->senha == null || $this->confsenha == null) {
      echo "<span> Verifique se os campos de senha estão inseridos corretamente!</span>";
      return false;
    }else if (v::stringType()->length(7, null)->validate($this->senha) == false ){
      echo "<span> Sua senha deve conter pelo menos 7 caracteres!</span>";
      return false;
    }else if ($this->senha != $this->confsenha){
      echo "<span> Sua senhas devem coincidir!</span>";
      return false;
    }else if (v::email()->validate($this->email) == false){
      echo "<span> Erro na inserção do email! (não é um erro do usuário btw)</span>";
      return false;
    }
    return true;
  }
  public function __construct(string $email, string $senha, string $confsenha) {
    $this->email = $email;
    $this->senha = $senha;
    $this->confsenha = $confsenha;
    $this->validaRedefinicao();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaRedefinicao()) {
      if (recebeSenhaRedPost($this->email, $this->senha)) {
        echo 'Senha redefinida com sucesso! <hr>';
      }
    }
  }
}

?>
