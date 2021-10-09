<?php
require_once 'classes/clControllerCadastro.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

if (!empty($_POST)) { #verifica se o formulário está enviando algo ao controller
    $ControllerLogin = new ControllerCadastro($_POST['nome'], $_POST['sobrenome'], $_POST['username'], $_POST['dt_nascimento'], $_POST['cpf'], $_POST['email'], $_POST['senha'], $_POST['confsenha']); #Se estiver ele aciona a função
} else {
    $_SESSION["error"] = 'Nada foi enviado';
    header("Location: /Github/Kamaleao/app/public/view/cadastro/cadastro.php");#Caso contrário ele retorna o erro 
}


?>