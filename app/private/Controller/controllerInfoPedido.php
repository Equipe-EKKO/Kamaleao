<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); # essa constante serve pra pegar qual é a raiz do documento e evitar erros independente do local de acesso
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-Pedido.php');

ob_end_clean();

if (!empty($_POST)) { #verifica se o formulário está enviando algo ao controller
    $cdpedido = $_POST['idpedido'];
    if ($cdpedido != null) {
        echo json_encode(pesquisaPedidoInfo($cdpedido));
    } else {
        echo "Algo de errado não está certo";
    }
} else {
    echo "Nada foi enviado";
    #Caso contrário ele retorna o erro 
}

?>