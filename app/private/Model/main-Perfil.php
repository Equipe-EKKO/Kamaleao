<?php
require_once "classes/autoloadClass.php";
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (ConexaoBanco -- classe que realiza a conexão com o banco de dados | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #arquivo de configuracao

// Função chamada no view para realizar pesquisa na tabela serviço
function pesquisaServPerf():mixed {
    $usuario = unserialize($_SESSION['usuario']);

    $rsltSelect = $usuario->perfil->listarServiços();

    if ($rsltSelect == false) {
        echo "Houve um problema na conexão. Perdão.";
        return "Houve um problema na conexão. Perdão.";
    } else {
        $servReturn = unserialize($rsltSelect);
        return $servReturn;
    }
}

// Função chamada no view para realizar pesquisa na tabela pedido
function pesquisaComisPerf(string $nmuser):mixed {
    $usuario = unserialize($_SESSION['usuario']);

    $rsltSelect = $usuario->perfil->listarComissoes($nmuser);

    if ($rsltSelect == false) {
        echo "Houve um problema na conexão. Perdão.";
        return "Houve um problema na conexão. Perdão.";
    } else {
        $servReturn = unserialize($rsltSelect);
        return $servReturn;
    }
}

// Função chamada no view para realizar pesquisa na tabela pedido
function pesquisaPedidosPerf(string $nmuser):mixed {
    $usuario = unserialize($_SESSION['usuario']);

    $rsltSelect = $usuario->perfil->listarPedidosFeitos($nmuser);

    if ($rsltSelect == false) {
        echo "Houve um problema na conexão. Perdão.";
        return "Houve um problema na conexão. Perdão.";
    } else {
        $servReturn = unserialize($rsltSelect);
        return $servReturn;
    }
}

function pesquisaPerfInfo(string $username):mixed {
    $perfilalheio = new PerfilAlheio();

    if ($perfilalheio->dadosPerfilAlheio($username)) {
        $rslPerfil = array(
            "username" => $perfilalheio->getUsername(),
            "descricao" => $perfilalheio->getDescricao(),
            "urlfoto" => $perfilalheio->getFotoPerfil()
        );
        return $rslPerfil;
    } else {
        return false;
    }
}

function pesquisaServPerfAlheio():mixed {
    $perfilalheio = new PerfilAlheio();

    $rsltSelect = $perfilalheio->listarServiços();

    if ($rsltSelect == false) {
        echo "Houve um problema na conexão. Perdão.";
        return "Houve um problema na conexão. Perdão.";
    } else {
        $servReturn = unserialize($rsltSelect);
        return $servReturn;
    }
}

// Função chamada no view para realizar pesquisa na tabela pedido
function pesquisaPerfInventario(string $nmuser):mixed {
    $usuario = unserialize($_SESSION['usuario']);

    $rsltSelect = $usuario->perfil->listarInventario($nmuser);

    if ($rsltSelect == false) {
        echo "Houve um problema na conexão. Perdão.";
        return "Houve um problema na conexão. Perdão.";
    } else {
        $servReturn = unserialize($rsltSelect);
        return $servReturn;
    }
}

?>