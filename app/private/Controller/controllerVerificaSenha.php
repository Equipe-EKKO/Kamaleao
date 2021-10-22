<?php
require_once 'classes/clControllerVerificaSenha.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

if (!empty($_POST)) {  #verifica se o formulário está enviando algo ao controller
    $ControllerLogin = new ControllerLogin($_POST['senha']);#Se estiver ele aciona a função
} else {
    $_SESSION["error"] = 'Nada foi enviado';
    header("Location: /Github/Kamaleao/app/public/view/pós_login/config_perfil/config_perfil.php");#Caso contrário ele retorna o erro 
}



?>