<?php
require_once 'classes/clConexaoBanco.php';
require_once 'classes/clParticipante.php';
require_once 'classes/clUsuario.php';
require_once '../Controller/ControllerLogin.php';
//Atual arquivo para testes
$usuario = new Usuario(null, null, null, null);

if ($usuario->logarConta($ControllerLogin->email, $ControllerLogin->senha) == false) {
    $administrador = new Administrador();
    if ($administrador->logarConta($ControllerLogin->email, $ControllerLogin->senha) == false) {
        echo "Usuário não cadastrad o. Se cadastre antes de logar ! <hr>";
    } else {
        echo "Logou como administrador LOL, XD. Parabéns! <hr>";
    }
} else {
    echo "Logou! Parabéns! <hr>";
}

?>