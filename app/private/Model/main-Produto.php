<?php
require_once "classes/autoloadClass.php";
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (ConexaoBanco -- classe que realiza a conexão com o banco de dados | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #arquivo de configuracao

// Função chamada no controller para entregar o produto
function recebeProdutoPost(int $cdpedido,string $imgType, $imgtmpName):bool {
    $temp = explode("/", $imgType);
    $extension = end($temp);
    $produto = new \Produto("", $cdpedido);
    if ($produto->salvaProduto($cdpedido, $extension, $imgtmpName)) {
        return true;
    } else {
        return false;
    }
}