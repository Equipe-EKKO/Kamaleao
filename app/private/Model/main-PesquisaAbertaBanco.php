<?php
require_once "classes/autoloadClass.php";
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (ConexaoBanco -- classe que realiza a conexão com o banco de dados | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #arquivo de configuracao


// Função chamada no controller para realizar pesquisa na tabela cadastro no banco
function pesquisaCategoria():mixed {
    $categoria = new \PesquisaAberta();

    $gabriel =  $categoria->searchCategoria();

    if ($gabriel == false) {
        echo "AAAAAAAAA carlaho";
        return "AAAAAAAAA carlaho";
    } else {
        $gabrielmuniz = unserialize($gabriel);
        return $gabrielmuniz;
    }
}

?>