<?php
require_once "classes/autoloadClass.php";
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (ConexaoBanco -- classe que realiza a conexão com o banco de dados | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #arquivo de configuracao

// Função chamada no controller para realizar cadastro de serviço
function recebePedidoPost(string $titulo, string $descriçao, string $username, int $cd_serviço, $dt_entrega):bool {
    $pedido = new \Pedido();
    
    if ($pedido->salvaPedido($cd_serviço, $username, $titulo, $descriçao, $dt_entrega)) {
        return true;
    } else {
        return false;
    }
}
// Função chamada no controller para negar o pedido
function recebePedidoNegaPost(int $cd_pedido):bool {
    $pedido = new \Pedido();
    
    if ($pedido->negaPedido($cd_pedido)) {
        return true;
    } else {
        return false;
    }
}
// Função chamada no controller para aceitar o pedido
function recebePedidoAceitaPost(int $cd_pedido, float $vl_pedido):bool {
    $pedido = new \Pedido();
    
    if ($pedido->aceitaPedido($cd_pedido, $vl_pedido)) {
        return true;
    } else {
        return false;
    }
}

// Função chamada no controller para ver as informações do pedido feito
function pesquisaPedidoInfo(int $cdpedidoid):mixed {
    $pedido = new \Pedido();

    $rsltSelect =  $pedido->searchPedidoEsp($cdpedidoid);

    if ($rsltSelect == false) {
        echo "Houve um problema na conexão. Perdão.";
        return "Houve um problema na conexão. Perdão.";
    } else {
        $servReturn = unserialize($rsltSelect);
        return $servReturn;
    }
}

function recebePedidoValAceitaPost(int $cd_pedido):bool {
    $pedido = new \Pedido();
    
    if ($pedido->aceitaValPedido($cd_pedido)) {
        return true;
    } else {
        return false;
    }
}

function recebePedidoValNegaPost(int $cd_pedido):bool {
    $pedido = new \Pedido();
    
    if ($pedido->negaValPedido($cd_pedido)) {
        return true;
    } else {
        return false;
    }
}