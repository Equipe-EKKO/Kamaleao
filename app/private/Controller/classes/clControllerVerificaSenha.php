<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); # essa constante serve pra pegar qual é a raiz do documento e evitar erros independente do local de acesso
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-ProcessosLogin.php');
use Respect\Validation\Validator as v;

class ControllerVerificaSenha{
  private $senha;
  private function validaSenha():bool{
    if ($this->senha == null) {
      /*$_SESSION["error"] = 'Verifique se todos os campos estão inseridos corretamente!';
      header("Location: /Github/Kamaleao/app/public/view/pós_login/config_perfil/config_perfil.php");*/
      ob_end_clean();
      echo "Verifique se todos os campos estão inseridos corretamente!";
      echo false;
      return false;
    }else if (v::stringType()->length(7, null)->validate($this->senha) == false ){
      /*$_SESSION["error"] = 'Sua senha deve conter pelo menos 7 caracteres!';
      header("Location: /Github/Kamaleao/app/public/view/pós_login/config_perfil/config_perfil.php");*/
      ob_end_clean();
      echo "Sua senha deve conter pelo menos 7 caracteres!";
      return false;
    }else { 
      return true;
    }
  }
  public function __construct(string $senha) {
    $this->senha = $senha;
    $this->validaSenha();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaSenha()) {
      if(confirmaSenha($this->senha)):
        ob_end_clean();
        echo true;
      else:
        ob_end_clean();
        echo "A senha inserida é diferente da que foi registrada!";
      endif;
    }
  }
}