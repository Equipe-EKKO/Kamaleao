<?php
ob_start();
require_once 'classes/clControllerAlteraInformacoes.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

ob_end_clean();

/*, $_POST['descricao'], $_POST['email'], $_POST['chavepix'], $_POST['senha'], $_POST['confsenha']*/

if (!empty($_POST)) { #verifica se o formulário está enviando algo ao controller
    $ControllerLogin = new ControllerAlteraDescricao($_POST['descricao']);
} else {
    /*$_SESSION["error"] = 'Nada foi enviado';
    header("Location: /Github/Kamaleao/app/public/View/pós_login/config_perfil/config_perfil.php");*/
    echo "Nada foi enviado";
    #Caso contrário ele retorna o erro 
}


?>