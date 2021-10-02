<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);  //   E:/xampp/htdocs
require_once (DIR_ROOT . '/GitHub/Kamaleao/app/Model/main-RecuperaSenha.php');
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Respect\Validation\Validator as v;

class ControllerRedSenha{
  private $senha, $confsenha;
  private function validaRedefinicao()/*:bool*/{
    /*if ($this->senha == null) {
      echo "<span> Verifique se o campo de senha está inserido corretamente!</span>";
      return false;
    }else if (v::senha()->validate($this->senha) == false){
      echo "<span> Digite o senha corretamente!</span>";
      return false;
    } else {
        return true;
    }*/
  }
  public function __construct(string $senha, string $confsenha) {
    $this->senha = $senha;
    $this->confsenha = $confsenha;
    $this->validaRedefinicao();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaRedefinicao()) {
      //if (recebeSenhaRedPost($this->senha)) {
        while (ob_get_status()) {
          ob_end_clean();# RELAXA EH UM TESTE!!!
          #to relaxado!
          # DEU CERTO NUNCA FUI TRISTE
        }
        sleep(1);
        //header( "Location: http://localhost:8080/Github/Kamaleao/app/public/View/aviso_senha/aviso_senha.html" );
      }
    }
  }
//}

?>
