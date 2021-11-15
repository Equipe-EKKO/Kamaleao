<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); # essa constante serve pra pegar qual é a raiz do documento e evitar erros independente do local de acesso
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-PesquisaAbertaBanco.php');

ob_end_clean();

if (!empty($_POST)) { #verifica se o formulário está enviando algo ao controller
    $titulo = $_POST['titulo'];
    $username = $_POST['username'];
    if ($titulo != null || $username != null) {
        echo json_encode(pesquisaServInfo($username, $titulo));
    } else {
        echo "Algo de errado não está certo";
    }
    
} else {
    /*$_SESSION["error"] = 'Nada foi enviado';
    header("Location: /Github/Kamaleao/app/public/View/pós_login/config_perfil/config_perfil.php");*/
    echo "Nada foi enviado";
    #Caso contrário ele retorna o erro 
}

?>