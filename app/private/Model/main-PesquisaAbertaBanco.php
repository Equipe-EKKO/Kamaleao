<?php
require_once "classes/autoloadClass.php";
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (ConexaoBanco -- classe que realiza a conexão com o banco de dados | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #arquivo de configuracao


// Função chamada no view para realizar pesquisa na tabela cadastro no banco
function pesquisaCategoria():mixed {
    $categoria = new \PesquisaAberta("tb_categoria");

    $rsltSelect =  $categoria->searchCategoria();

    if ($rsltSelect == false) {
        echo "Houve um problema na conexão. Perdão.";
        return "Houve um problema na conexão. Perdão.";
    } else {
        $catReturn = unserialize($rsltSelect);
        return $catReturn;
    }
}

function pesquisaServInfo(string $username, string $titulo):mixed {
    $serviço= new \PesquisaAberta("tb_serviço");

    $rsltSelect =  $serviço->searchServEsp($username, $titulo);

    if ($rsltSelect == false) {
        echo "Houve um problema na conexão. Perdão.";
        return "Houve um problema na conexão. Perdão.";
    } else {
        $servReturn = unserialize($rsltSelect);
        return $servReturn;
    }
}

function pesquisaComissaoInfo(int $cdpedidoid):mixed {
    $serviço= new \PesquisaAberta("tb_pedido");

    $rsltSelect =  $serviço->searchComissaoEsp($cdpedidoid);

    if ($rsltSelect == false) {
        echo "Houve um problema na conexão. Perdão.";
        return "Houve um problema na conexão. Perdão.";
    } else {
        $servReturn = unserialize($rsltSelect);
        return $servReturn;
    }
}

function pesquisaQuaseServInfo(string $categoria, string $titulo):mixed {
    $serviço= new \PesquisaAberta("tb_serviço");

    $rsltSelect =  $serviço->searchAllServMinosEsp($categoria, $titulo);

    if ($rsltSelect == false) {
        echo "Houve um problema na conexão. Perdão.";
        return "Houve um problema na conexão. Perdão.";
    } else {
        $servReturn = unserialize($rsltSelect);
        return $servReturn;
    }
}

function pesquisaAllServRec():mixed {
    $serviço= new \PesquisaAberta("tb_serviço");

    $rsltSelect =  $serviço->listServRecente();

    if ($rsltSelect == false) {
        echo "Houve um problema na conexão. Perdão.";
        return "Houve um problema na conexão. Perdão.";
    } else {
        $servAllReturn = unserialize($rsltSelect);
        return $servAllReturn;
    }
}

?>