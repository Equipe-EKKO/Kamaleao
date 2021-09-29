<?php
require_once 'classes/clConexaoBanco.php';
require_once 'classes/clParticipante.php';
require_once 'classes/clUsuario.php';

//Atual arquivo para testes
function recebeCadPosts(string $nome, string $sobrenome, string $dtNascimento, string $cpf, string $email, string $username, string $senha) {
    $usuario = new \Usuario($nome, $sobrenome, $cpf, $dtNascimento);
    if ($usuario->cadastrarConta($email, $username, $senha)): 
        echo "Usuário cadastrado! <hr>";
    else:
        echo "Usuário não cadastrado. ERRO! <hr>";
    endif;
}


?>