<?php
require_once 'classes/clControllerCadastro.php';

if (!empty($_POST)) {
    $ControllerLogin = new ControllerCadastro($_POST['nome'], $_POST['sobrenome'], $_POST['username'], $_POST['dt_nascimento'], $_POST['cpf'], $_POST['email'], $_POST['senha'], $_POST['confsenha']);
} else {
    echo "Nada foi enviado";
}



?>