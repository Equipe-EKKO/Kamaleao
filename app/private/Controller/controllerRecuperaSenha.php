<?php
require_once 'classes/clControllerRecSenha.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

if (!empty($_POST)) {#verifica se o formulário está enviando algo ao controller
    $ControllerLogin = new ControllerRecSenha($_POST['r_email']);#Se estiver ele aciona a função
} else {
    $_SESSION["error"] = 'Nada foi enviado';
    header("Location: /Github/Kamaleao/app/public/View/pré_login/rec_senha/rec_senha.php");#Caso contrário ele retorna o erro 
}



?>