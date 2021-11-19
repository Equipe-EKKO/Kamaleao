<?php
ob_start();
require_once 'classes/clControllerAlteraInformacoes.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

ob_end_clean();

if (!empty($_POST)) { #verifica se o formulário está enviando algo ao controller
    $ControllerLogin = new ControllerAlteraSenha($_POST['senha'], $_POST['confsenha']);
} else {   
    echo "Nada foi enviado";
    #Caso contrário ele retorna o erro 
}


?>