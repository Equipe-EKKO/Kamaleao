<?php
require_once 'classes/clControllerAlteraInformacoes.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

if (!empty($_POST)) { #verifica se o formulário está enviando algo ao controller
    $ControllerLogin = new ControllerAlteraInformacoes($_POST['username'], $_POST['descricao'], $_POST['email'], $_POST['chavepix'], $_POST['senha'], $_POST['confsenha']);
} else {
    $_SESSION["error"] = 'Nada foi enviado';
    header("Location: /Github/Kamaleao/app/public/View/pós_login/config_perfil/config_perfil.php");#Caso contrário ele retorna o erro 
}


?>