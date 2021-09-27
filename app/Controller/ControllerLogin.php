<?php
require_once("../model/cdlUsuario.php");
require('vendor/autoload.php');
use Respect\Validation\Validator as v;

  class ControllerCadastro{
    private function validaLogin(){
      $email = $_POST['nome'];
      $senha = $_POST['senha'];

      if ($email == null || $senha == null){
        echo "<span> Verifique se todos os campos estão inseridos corretamente!</span>";
      }else if (v::email()->validate($email) == false){
        echo "<span> Digite o email corretamente!</span>";
      }else if (v::stringType()->length(7, null)->validate($senha) == false ){
        echo "<span> Sua senha deve conter pelo menos 7 caracteres!</span>";
      }else{
        echo "<span> Ta certo fio! </span>";
      }
    }
  }
?>