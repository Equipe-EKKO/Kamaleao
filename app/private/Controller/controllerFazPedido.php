<?php
ob_start();
require_once 'classes/clControllerGerenciaPedido.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

ob_end_clean();

if (!empty($_POST)) { #verifica se o formulário está enviando algo ao controller
    $ControllerTitulo = new ControllerFazPedido($_POST['titulo'], $_POST['desc'], $_POST['nmuser'], $_POST['cd_serviço'], $_POST['dt_entrega']);
} else {
    echo "Nada foi enviado"; #Caso contrário ele retorna o erro 
}
?>