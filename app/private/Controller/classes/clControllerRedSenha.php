<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);  //   E:/xampp/htdocs
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-ProcessosLogin.php');
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Respect\Validation\Validator as v;

class ControllerRedSenha{
  private $email, $senha, $confsenha;
  private function validaRedefinicao():bool{
    if ($this->email == null || $this->senha == null || $this->confsenha == null) {
      $_SESSION['error'] = "Verifique se os campos de senha estão inseridos corretamente!";
      header( "Location: /Github/Kamaleao/app/public/View/redef_senha/redef_senha.php" );
      return false;
    }else if (v::stringType()->length(7, null)->validate($this->senha) == false ){
      $_SESSION['error'] = "Sua senha deve conter pelo menos 7 caracteres!";
      header( "Location: /Github/Kamaleao/app/public/View/redef_senha/redef_senha.php" );
      return false;
    }else if ($this->senha != $this->confsenha){
      $_SESSION['error'] = "Sua senhas devem coincidir!";
      header( "Location: /Github/Kamaleao/app/public/View/redef_senha/redef_senha.php" );
      return false;
    }else if (v::email()->validate($this->email) == false){
      $_SESSION['error'] = "Erro na inserção do email! (não é um erro do usuário btw)";
      header( "Location: /Github/Kamaleao/app/public/View/redef_senha/redef_senha.php" );
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
