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

// Função chamada no controller para ver as informações do pedido feito
function pesquisaPedidoInfoStatus(int $cdpedidoid, string $username):mixed {
    $pedido = new \Pedido();

    $rsltSelect =  $pedido->searchPedidoStatus($cdpedidoid, $username);

    if ($rsltSelect == false) {
        echo "Houve um problema na conexão. Perdão.";
        return "Houve um problema na conexão. Perdão.";
    } else {
        $servReturn = unserialize($rsltSelect);
        return $servReturn;
    }
}

// Função chamada no controller para cancelar pedidos feitos sem resposta a mais de 5 dias
function cancelaPedidoFeito():bool {
    $pedido = new \Pedido();

    $usuario = unserialize($_SESSION['usuario']);
    $cdcancel = $usuario->getCdUpdate() - 1;
    
    if ($pedido->cancelaPedidoAutomatic($cdcancel)) {
        return true;
    } else {
        return false;
    }
}

// Função chamada no controller para cancelar comisoes pedidas sem resposta a mais de 5 dias
function cancelaComissaoPedida():bool {
    $pedido = new \Pedido();

    $usuario = unserialize($_SESSION['usuario']);
    $cdcancel = $usuario->getCdUpdate() - 1;
    
    if ($pedido->cancelaComissaoAutomatic($cdcancel)) {
        return true;
    } else {
        return false;
    }
}

function recebePedidoValAceitaPost(int $cd_pedido):bool {
    $pedido = new \Pedido();
    $usuario = unserialize($_SESSION['usuario']);
    $cdins = $usuario->getCdUpdate() - 1;
    if ($pedido->aceitaValPedido($cd_pedido, $cdins)) {
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

// Função chamada no controller para entregar o produto
function recebeProdutoPost(int $cdpedido, string $imgType, $imgtmpName):bool {
    $temp = explode("/", $imgType);
    $extension = end($temp);
    $serviço = new \Pedido($titulo, $descriçao, $preçoMedio, $licença, $optionCategoria);
    $usuario = unserialize($_SESSION['usuario']);
    $resulUser = unserialize($_SESSION['userinfo']);
    $usuario->perfil->setServiço($serviço);
    if ($usuario->perfil->criarServiço($titulo, $resulUser['cd_usuario'], $extension, $imgtmpName)) {
        return true;
    } else {
        return false;
    }
}