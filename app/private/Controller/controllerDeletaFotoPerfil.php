<?php
ob_start();
require_once 'classes/clControllerAlteraInformacoes.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

ob_end_clean();

if (!empty($_GET)) {
    $ControllerDelServiço = new ControllerDeletaFotoPerfil($_GET['nmuser']);
} else {
    ob_end_clean();
    echo "Alguma informação essencial não foi enviada.";
}
?>
