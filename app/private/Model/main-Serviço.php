<?php
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (ConexaoBanco -- classe que realiza a conexão com o banco de dados | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once 'classes/clConexaoBanco.php';
require_once 'classes/clServiço.php';
require_once 'classes/clPerfilProprio.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #arquivo de configuracao
use Serviço;

// Função chamada no controller para realizar cadastro de serviço
function recebeServPost(string $titulo, string $descriçao, $preçoMedio, $licença, $optionCategoria, string $imgType, $imgtmpName):bool {
    $temp = explode("/", $imgType);
    $extension = end($temp);
    $serviço = new Serviço($titulo, $descriçao, $preçoMedio, $licença, $optionCategoria);
    $usuario = unserialize($_SESSION['usuario']);
    $resulUser = unserialize($_SESSION['userinfo']);
    $usuario->perfil->setServiço($serviço);
    if ($usuario->perfil->criarServiço($titulo, $resulUser['cd_usuario'], $extension, $imgtmpName)) {
        return true;
    }
    return false;
}