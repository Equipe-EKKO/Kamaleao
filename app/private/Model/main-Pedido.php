<?php
require_once "classes/autoloadClass.php";
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (ConexaoBanco -- classe que realiza a conexão com o banco de dados | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #arquivo de configuracao

// Função chamada no controller para realizar cadastro de serviço
function recebePedidoPost(string $titulo, string $descriçao, string $username, int $cd_serviço):bool {
    $pedido = new \Pedido();
    
    if ($pedido->salvaPedido($cd_serviço, $username, $titulo, $descriçao)) {
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

