<?php
ob_start();
require_once 'classes/clControllerGerenciaPedido.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

if (!empty($_GET)) {
    $ControllerNegaPedido = new ControllerNegaPedido($_GET['pedido']);
} else {
    /*$_SESSION["error"] = 'Nada foi enviado';
    header("Location: /Github/Kamaleao/app/public/View/pós_login/perfil/perfil.php");*/
    ob_end_clean();
    echo "Alguma informação essencial não foi enviada.";
    #Caso contrário ele retorna o erro
}
?>
