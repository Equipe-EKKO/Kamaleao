<?php
ob_start();
require_once 'classes/clControllerGerenciaProduto.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

if (!empty($_GET)) {
    $ControllerFazPagamento = new ControllerFazPagamento($_GET['pedidopag']);
} else {
    ob_end_clean();
    echo "Alguma informação essencial não foi enviada.";
    #Caso contrário ele retorna o erro
}
?>
