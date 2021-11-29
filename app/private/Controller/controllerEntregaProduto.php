<?php
ob_start();
require_once 'classes/clControllerGerenciaProduto.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

if ((!empty($_POST)) && ($_FILES['prodfile']['size']> 0) && ($_FILES["prodfile"]["error"] == 0) && (!empty($_POST['idpedido']))) {
    switch($_FILES["prodfile"]["error"]) {
        case 1:
            ob_end_clean();
            echo "Arquivo muito grande para ser salvo.";
            break;
        case 2:
            ob_end_clean();
            echo "Erro impossível.";
            break;
        case 3:
            ob_end_clean();
            echo "O upload do arquivo foi feito de forma parcial.";
            break;    
        case 4:
            ob_end_clean();
            echo "Você não inseriu uma imagem, por favor reveja o formulário.";
            break;
        case 6:
            ob_end_clean();
            echo "Erro na pasta temporária do servidor.";
            break;
        case 7:
            ob_end_clean();
            echo "Erro do servidor em escrever o arquivo no HD.";
            break;
        case 8:
            ob_end_clean();
            echo "Uma extensão do servidor interrompeu o upload do arquivo.";
            break;
        default:
            ob_end_clean();
            $ControllerEntregaProduto = new ControllerEntregaProduto($_POST["idpedido"], $_FILES['prodfile']['name'], $_FILES['prodfile']['size'], $_FILES['prodfile']['type'], $_FILES['prodfile']['tmp_name']);
            break;
    }
} else {
    /*$_SESSION["error"] = 'Nada foi enviado';
    header("Location: /Github/Kamaleao/app/public/View/pós_login/perfil/perfil.php");*/
    ob_end_clean();
    echo "Alguma informação essencial não foi enviada.";
    #Caso contrário ele retorna o erro
}
?>
