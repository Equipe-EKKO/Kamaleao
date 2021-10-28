  <?php
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); # essa constante serve pra pegar qual é a raiz do documento e evitar erros independente do local de acesso
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-ProcessosLogin.php');
use Respect\Validation\Validator as v;

class ControllerLogin{
  private $email, $senha;
  private function validaLogin():bool{
    if ($this->email == null || $this->senha == null) {
      $_SESSION["error"] = 'Verifique se todos os campos estão inseridos corretamente!';
      header("Location: /Github/Kamaleao/app/public/view/pré_login/login/login.php");
      return false;
    }else if (v::email()->validate($this->email) == false){
      $_SESSION["error"] = 'Digite o email corretamente!';
      header("Location: /Github/Kamaleao/app/public/view/pré_login/login/login.php");
      return false;
    }else if (v::stringType()->length(7, null)->validate($this->senha) == false ){
      $_SESSION["error"] = 'Sua senha deve conter pelo menos 7 caracteres!';
      header("Location: /Github/Kamaleao/app/public/view/pré_login/login/login.php");
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
      recebeLogPosts($this->email, $this->senha);
    }
  }
}