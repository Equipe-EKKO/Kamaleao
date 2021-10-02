<?php
require_once 'classes/clControllerRecSenha.php';

if (!empty($_POST)) {
    $ControllerLogin = new ControllerRecSenha($_POST['r_email']);
} else {
    echo "Nada foi enviado";
}



?>