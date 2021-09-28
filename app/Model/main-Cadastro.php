<?php
require_once 'classes/clConexaoBanco.php';
require_once 'classes/clParticipante.php';
require_once 'classes/clUsuario.php';
require_once '../Controller/ControllerCadastro.php';
//Atual arquivo para testes
$usuario = new Usuario($ControllerCadastro->nome, $ControllerCadastro->sobrenome, $ControllerCadastro->cpf, $ControllerCadastro->dt_nascimento);

if ($usuario->cadastrarConta($ControllerCadastro->email, $ControllerCadastro->senha)): 
    echo "Usuário cadastrado! <hr>";
else:
    echo "Usuário não cadastrado. ERRO! <hr>";
endif;

?>