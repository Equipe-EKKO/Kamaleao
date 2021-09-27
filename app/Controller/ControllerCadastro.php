<?php
require_once("../model/cdlUsuario.php");
require('vendor/autoload.php');
use Respect\Validation\Validator as v;

  class ControllerCadastro{
    private function validaCadastro(){
      $nome = $_POST['nome'];
      $sobrenome = $_POST['sobrenome'];
      $cpf = $_POST['cpf'];
      $email = $_POST['email'];
      $senha = $_POST['senha'];
      $confsenha = $_POST['confsenha'];

      if ($nome == null || $sobrenome == null || $cpf == null || $email == null || $senha == null || $confsenha == null){
        echo "<span> Verifique se todos os campos estão inseridos corretamente!</span>";
      }else if (v::email()->validate($email) == false){
        echo "<span> Digite o email corretamente!</span>";
      }else if (v::cpf()->validate($cpf) == false){
        echo "<span> Digite o cpf corretamente!</span>";
      }else if (v::stringType()->length(7, null)->validate($senha) == false ){
        echo "<span> Sua senha deve conter pelo menos 7 caracteres!</span>";
      }else if ($senha != $confsenha){
        echo "<span> Sua senhas devem coincidir!</span>";
      }else{
        echo "<span> Ta certo fio! </span>";
      }
    }
  }
?>