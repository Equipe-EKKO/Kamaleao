<?php
require_once "classes/autoloadClass.php";
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (ConexaoBanco -- classe que realiza a conexão com o banco de dados | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #arquivo de configuracao

// Função chamada no controller para realizar cadastro de serviço
function recebeServPost(string $titulo, string $descriçao, $preçoMedio, $licença, $optionCategoria, string $imgType, $imgtmpName):bool {
    $temp = explode("/", $imgType);
    $extension = end($temp);
    $serviço = new \Serviço($titulo, $descriçao, $preçoMedio, $licença, $optionCategoria);
    $usuario = unserialize($_SESSION['usuario']);
    $resulUser = unserialize($_SESSION['userinfo']);
    $usuario->perfil->setServiço($serviço);
    if ($usuario->perfil->criarServiço($titulo, $resulUser['cd_usuario'], $extension, $imgtmpName)) {
        return true;
    } else {
        return false;
    }
}

// Função chamada no controller para realizar exclusão de serviço
function recebeServExcludePost(int $cdServ):bool {
    $serviço = new \Serviço("", "", 0, 0, 0);
    $usuario = unserialize($_SESSION['usuario']);
    $usuario->perfil->setServiço($serviço);
    if ($usuario->perfil->serviço->excluiServiço($cdServ)) {
        echo true;
        return true;
    } else {
        return false;
    }
}
// Função chamada no controller para mudar o título do serviço
function atualizaTitulo(string $titulo,int $cdServ) {
    $serviço = new \Serviço($titulo , "", 0, 0, 0);
    $usuario = unserialize($_SESSION['usuario']);
    $usuario->perfil->setServiço($serviço);
    if ($respo = $usuario->perfil->serviço->editaServiçoTitulo($titulo, $cdServ)) {
        echo true;
        return true;
    } else {
        echo $respo;
        return $respo;
    }
}
// Função chamada no controller para mudar o preço do serviço
function atualizaPreço(float $preço, int $cdServ) {
    $serviço = new \Serviço("", "", $preço, 0, 0);
    $usuario = unserialize($_SESSION['usuario']);
    $usuario->perfil->setServiço($serviço);
    if ($respo = $usuario->perfil->serviço->editaServiçoPreço($preço, $cdServ)) {
        echo true;
        return true;
    } else {
        echo $respo;
        return $respo;
    }
}
// Função chamada no controller para mudar a descrição do serviço
function atualizaDescricaoAnuncio(string $desc, int $cdServ) {
    $serviço = new \Serviço("", $desc, 0, 0, 0);
    $usuario = unserialize($_SESSION['usuario']);
    $usuario->perfil->setServiço($serviço);
    if ($respo = $usuario->perfil->serviço->editaServiçoDesc($desc, $cdServ)) {
        echo true;
        return true;
    } else {
        echo $respo;
        return $respo;
    }
}
// Função chamada no controller para mudar a licença do serviço
function atualizaLicença(int $licenca, int $cdServ) {
    $serviço = new \Serviço("", "", 0, $licenca, 0);
    $usuario = unserialize($_SESSION['usuario']);
    $usuario->perfil->setServiço($serviço);
    if ($respo = $usuario->perfil->serviço->editaServiçoLic($licenca, $cdServ)) {
        echo true;
        return true;
    } else {
        echo $respo;
        return $respo;
    }
}
// Função chamada no controller para mudar a categoria do serviço
function atualizaCategoria(int $categoria, int $cdServ) {
    $serviço = new \Serviço("", "", 0, 0, $categoria);
    $usuario = unserialize($_SESSION['usuario']);
    $usuario->perfil->setServiço($serviço);
    if ($respo = $usuario->perfil->serviço->editaServiçoCategoria($categoria, $cdServ)) {
        echo true;
        return true;
    } else {
        echo $respo;
        return $respo;
    }
}
