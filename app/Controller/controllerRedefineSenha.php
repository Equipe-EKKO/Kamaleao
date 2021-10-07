<?php
require_once 'classes/clControllerRedSenha.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

if (!empty($_POST) && isset($_POST)) { #verifica se o formulário está enviando algo ao controller
    $ControllerLogin = new ControllerRedSenha($_SESSION['emailinfo'], $_POST['r_senha'], $_POST['r_confsenha']); #Se estiver ele aciona a função
} else {
    $_SESSION["error"] = 'Nada foi enviado';
    header("Location: /Github/Kamaleao/app/public/view/red_senha/red_senha.php"); #Caso contrário ele retorna o erro 
}



?>