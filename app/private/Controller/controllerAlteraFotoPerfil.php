<?php
ob_start();
require_once 'classes/clControllerAlteraInformacoes.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

ob_end_clean();

if ((!empty($_FILES[
    
    
    
    
    ) && ($_FILES['servfile']['size']> 0) && ($_FILES["servfile"]["error"] == 0))) { #verifica se o formulário está enviando algo ao controller
    switch($_FILES["servfile"]["error"]) {
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
            $ControllerCriaServiço = new ControllerAlteraFotoPerfil($_FILES['servfile']['name'], $_FILES['servfile']['size'], $_FILES['servfile']['type'], $_FILES['servfile']['tmp_name']);
            break;
    }
} else {
    /*$_SESSION["error"] = 'Nada foi enviado';
    header("Location: /Github/Kamaleao/app/public/View/pós_login/config_perfil/config_perfil.php");*/
    echo "Nada foi enviado";
    #Caso contrário ele retorna o erro 
}
?>