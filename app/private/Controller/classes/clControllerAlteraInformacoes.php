<?php
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); # essa constante serve pra pegar qual é a raiz do documento e evitar erros independente do local de acesso
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
// require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-ProcessosLogin.php');
use Respect\Validation\Validator as v;


class ControllerAlteraInformacoes{
  private $username, $descricao, $email, $chavepix, $senha, $confsenha;
  private function validaLogin():bool{
    if ($this->email == null || $this->username == null) {
      $_SESSION["error"] = "os campos 'nome de usuário' e 'email' não podem estar em branco!";
      header("Location: /Github/Kamaleao/app/public/view/pré_login/login/login.php");
      return false;
    }else if (v::stringType()->length(1, null)->validate($this->senha) == true && v::stringType()->length(7, null)->validate($this->senha) == false){
      $_SESSION["error"] = 'Sua senha deve conter pelo menos 7 caracteres!';
      header("Location: /Github/Kamaleao/app/public/view/pré_login/login/login.php");
      return false;
    }else if ($this->senha != $this->confsenha){
      $_SESSION["error"] = "Os campos 'senha' e 'confirmar senha' devem coincidir!";
      header("Location: /Github/Kamaleao/app/public/view/pré_login/login/login.php");
      return false;
    }else { 
      return true;
    }
  }
  public function __construct(string $username, string $descricao, string $email, string $chavepix, string $senha, string $confsenha) {
    $this->username = $username;
    $this->descricao = $descricao;
    $this->email = $email;
    $this->chavepix = $chavepix;
    $this->senha = $senha;
    $this->confsenha = $confsenha;
    $this->validaLogin();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaLogin()) {
      recebeLogPosts($this->email, $this->senha);
    }
  }
}