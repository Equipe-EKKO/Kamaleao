<?php
require_once 'classes/clParticipante.php';
require_once 'classes/clUsuario.php';
require_once 'classes/clAdministrador.php';
function recebeLogPosts(string $email, string $senha) {
    $usuario = new \Usuario(null, null, null, null);
    $administrador = new \Administrador();
    if ($usuario->logarConta($email, $senha) == false && $administrador->logarConta($email, $senha) == false){
        echo "Usuário não cadastrado. Se cadastre antes de logar ! <hr>";
    } elseif($usuario->logarConta($email, $senha) && $administrador->logarConta($email, $senha) == false) {
        echo "Logou como usuario! Parabéns! <hr>";
    } else {
        echo "Logou como administrador LOL, XD. Parabéns! <hr>";
    }
}
?>