<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);  //   E:/xampp/htdocs
require_once (DIR_ROOT . '/GitHub/Kamaleao/app/Model/main-RecuperaSenha.php');
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Respect\Validation\Validator as v;

class ControllerRecSenha{
  private $email;
  private function validaRecuperacao():bool{
    if ($this->email == null) {
      echo "<span> Verifique se o campo de email está inserido corretamente!</span>";
      return false;
    }else if (v::email()->validate($this->email) == false){
      echo "<span> Digite o email corretamente!</span>";
      return false;
    } else {
        return true;
    }
  }
  public function __construct(string $email) {
    $this->email = $email;
    $this->validaRecuperacao();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaRecuperacao()) {
      if (recebeEmailRecPost($this->email)) {
        while (ob_get_status()) {
          ob_end_clean();
        }
        sleep(1);
        header( "Location: http://localhost:8080/Github/Kamaleao/app/public/View/aviso_email/aviso_email.html" );
      }
    }
  }
}

?>
