<?php
ob_start();
require_once 'classes/clControllerAlteraInformacoes.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

ob_end_clean();

if ((!empty($_FILES['fotoperfil']) && ($_FILES['fotoperfil']['size']> 0) && ($_FILES['fotoperfil']["error"] == 0))) { #verifica se o formulário está enviando algo ao controller
    switch($_FILES['fotoperfil']["error"]) {
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
            //ob_end_clean();
            $ControllerCriaServiço = new ControllerAlteraFotoPerfil($_FILES['fotoperfil']['name'], $_FILES['fotoperfil']['size'], $_FILES['fotoperfil']['type'], $_FILES['fotoperfil']['tmp_name']);
            break;
    }
} else {
    /*$_SESSION["error"] = 'Nada foi enviado';
    header("Location: /Github/Kamaleao/app/public/View/pós_login/config_perfil/config_perfil.php");*/
    echo "Nada foi enviado";
    #Caso contrário ele retorna o erro 
}
?>