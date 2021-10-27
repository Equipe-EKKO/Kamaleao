<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); # essa constante serve pra pegar qual é a raiz do documento e evitar erros independente do local de acesso
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-ConfiguraPerfil.php');
use Respect\Validation\Validator as v;

class ControllerAlteraUsername {
  private $username;
  private function validaUsername():bool{
    if ($this->username == null) {
      /*$_SESSION["error"] = 'Verifique se todos os campos estão inseridos corretamente!';
      header("Location: /Github/Kamaleao/app/public/view/pós_login/config_perfil/config_perfil.php");*/
      ob_end_clean();
      echo "Verifique se todos os campos estão inseridos corretamente!";
      return false;
    }elseif (v::noWhitespace()->validate($this->username) == false){
      /*$_SESSION["error"] = 'Sua senha deve conter pelo menos 7 caracteres!';
      header("Location: /Github/Kamaleao/app/public/view/pós_login/config_perfil/config_perfil.php");*/
      ob_end_clean();
      echo "Seu username novo não pode conter espaços!";
      return false;
    }else { 
      return true;
    }
  }
  public function __construct(string $username) {
    $this->username = $username;
    $this->validaUsername();
    $this->chamaModel();
  }
  private function chamaModel() {
    if ($this->validaUsername()) {
      if(atualizaUsuario($this->username)):
        ob_end_clean();
        echo true;
      else:
        ob_end_clean();
        echo "Este username não está disponível. Tente novamente!";
      endif;
    }
  }
}

class ControllerAlteraEmail {
  private $email;
  private function validaEmail():bool{
    if ($this->email == null) {
      /*$_SESSION["error"] = 'Verifique se todos os campos estão inseridos corretamente!';
      header("Location: /Github/Kamaleao/app/public/view/pós_login/config_perfil/config_perfil.php");*/
      ob_end_clean();
      echo "Verifique se todos os campos estão inseridos corretamente!";
      return false;
    } elseif (v::email()->validate($this->email) == false){
      /*$_SESSION["error"] = 'Sua senha deve conter pelo menos 7 caracteres!';
      header("Location: /Github/Kamaleao/app/public/view/pós_login/config_perfil/config_perfil.php");*/
      ob_end_clean();
      echo "Digite o email corretamente!";
      return false;
    }else { 
      return true;
    }
  }
  public function __construct(string $email) {
    $this->email = $email;
    $this->validaEmail();
    $this->chamaModel();
  }
  private function chamaModel() {
    if ($this->validaEmail()) {
      if(atualizaEmail($this->email)):
        ob_end_clean();
        echo true;
      else:
        ob_end_clean();
        echo "Este endereço de email não está disponível. Tente novamente!";
      endif;
    }
  }
}

class ControllerAlteraDescricao {
  private $descricao;
  private function validaDescricao():bool{
    if ($this->descricao == null) {
      /*$_SESSION["error"] = 'Verifique se todos os campos estão inseridos corretamente!';
      header("Location: /Github/Kamaleao/app/public/view/pós_login/config_perfil/config_perfil.php");*/
      ob_end_clean();
      echo "Verifique se todos os campos estão inseridos corretamente!";
      return false;
    } else { 
      return true;
    }
  }
  public function __construct(string $descricao) {
    $this->descricao = $descricao;
    $this->validaDescricao();
    $this->chamaModel();
  }
  private function chamaModel() {
    if ($this->validaDescricao()) {
      if(atualizaDesc($this->descricao)):
        ob_end_clean();
        echo true;
      else:
        ob_end_clean();
        echo "Houve um erro durante a atualização da descrição!";
      endif;
    }
  }
}

class ControllerAlteraChavePix {
  private $chavePix;
  private function validaChavePix():bool{
    if ($this->chavePix == null) {
      /*$_SESSION["error"] = 'Verifique se todos os campos estão inseridos corretamente!';
      header("Location: /Github/Kamaleao/app/public/view/pós_login/config_perfil/config_perfil.php");*/
      ob_end_clean();
      echo "Verifique se todos os campos estão inseridos corretamente!";
      return false;
    } else { 
      return true;
    }
  }
  public function __construct(string $chavePix) {
    $this->chavePix = $chavePix;
    $this->validaChavePix();
    $this->chamaModel();
  }
  private function chamaModel() {
    if ($this->validaChavePix()) {
      if(atualizaChavePix($this->chavePix)):
        ob_end_clean();
        echo true;
      else:
        ob_end_clean();
        echo "Houve um erro durante a atualização da chave Pix!";
      endif;
    }
  }
}

class ControllerAlteraSenha {
  private $senha, $confsenha;
  private function validaSenha():bool{
    if ($this->senha == null) {
      /*$_SESSION["error"] = 'Verifique se todos os campos estão inseridos corretamente!';
      header("Location: /Github/Kamaleao/app/public/view/pós_login/config_perfil/config_perfil.php");*/
      ob_end_clean();
      echo "Verifique se todos os campos estão inseridos corretamente!";
      return false;
    } elseif (v::stringType()->length(7, null)->validate($this->senha) == false) {
      ob_end_clean();
      echo "Sua senha deve conter pelo menos 7 caracteres!";
      return false;
    } elseif ($this->senha != $this->confsenha) {
      ob_end_clean();
      echo "Os campos 'senha' e 'confirmar senha' devem coincidir!";
      return false;
    } else { 
      return true;
    }
  }
  public function __construct(string $senha, string $confsenha) {
    $this->senha = $senha;
    $this->confsenha = $confsenha;
    $this->validaSenha();
    $this->chamaModel();
  }
  private function chamaModel() {
    if ($this->validaSenha()) {
      if(atualizaSenha($this->senha)):
        ob_end_clean();
        echo true;
      else:
        ob_end_clean();
        echo "Houve um erro durante a atualização da chave Pix!";
      endif;
    }
  }
}