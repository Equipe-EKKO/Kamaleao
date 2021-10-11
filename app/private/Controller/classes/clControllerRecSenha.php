<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);  //   E:/xampp/htdocs
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-ProcessosLogin.php');
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Respect\Validation\Validator as v;

class ControllerRecSenha{
  private $email;
  private function validaRecuperacao():bool{
    if ($this->email == null) {
      $_SESSION["error"] = 'Verifique se o campo de email está inserido corretamente!';
      header("Location: /Github/Kamaleao/app/public/View/pré_login/rec_senha/rec_senha.php");
      return false;
    }else if (v::email()->validate($this->email) == false){
      $_SESSION["error"] = 'Digite o email corretamente!';
      header("Location: /Github/Kamaleao/app/public/View/pré_login/rec_senha/rec_senha.php");
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
        $_SESSION['error'] = "Pronto! Foi enviado um email com um link para que você recupere sua senha";
        header( "Location: /Github/Kamaleao/app/public/View/pré_login/rec_senha/rec_senha.php" );
      }
    }
  }
}

?>
