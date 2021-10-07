<?php
require_once 'classes/clControllerLogin.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

if (!empty($_POST)) {  #verifica se o formulário está enviando algo ao controller
    $ControllerLogin = new ControllerLogin($_POST['email'], $_POST['senha']);#Se estiver ele aciona a função
} else {
    $_SESSION["error"] = 'Nada foi enviado';
      header("Location: /Github/Kamaleao/app/public/view/login/login.php");#Caso contrário ele retorna o erro 
}



?>