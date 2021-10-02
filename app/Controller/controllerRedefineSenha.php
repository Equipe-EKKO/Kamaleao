<?php
require_once 'classes/clControllerRedSenha.php';

if (!empty($_POST)) {
    $ControllerLogin = new ControllerRedSenha($_POST['r_senha'], $_POST['r_confsenha']);
} else {
    echo "Nada foi enviado";
}



?>