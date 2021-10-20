<?php
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); # essa constante serve pra pegar qual é a raiz do documento e evitar erros independente do local de acesso
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-ProcessosLogin.php');

$usuario = unserialize($_SESSION['usuario']);
if (isset($usuario) || is_object($usuario)) {
    fazLogOff($usuario);
} else {
    echo "Houve um erro ao chamar este comando. Passar bem.";
}

?>