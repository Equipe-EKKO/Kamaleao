<?php
ob_start();
require_once 'classes/clControllerGerenciaServiço.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

ob_end_clean();

if (!empty($_POST)) { #verifica se o formulário está enviando algo ao controller
    $ControllerTitulo = new ControllerAlteraPreço($_POST['preco'], $_POST['cd_serviço']);
} else {
    echo "Nada foi enviado"; #Caso contrário ele retorna o erro 
}
?>