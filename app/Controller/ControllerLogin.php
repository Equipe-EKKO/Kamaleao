<?php
require_once 'classes/clControllerLogin.php';

if (!empty($_POST)) {
    $ControllerLogin = new ControllerLogin($_POST['email'], $_POST['senha']);
} else {
    echo "Nada foi enviado";
}



?>