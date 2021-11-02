<?php
require_once 'classes/clControllerCriaServiço.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

if ((!empty($_POST)) && ($_FILES['servfile']['size']> 0) && ($_FILES["servfile"]["error"] == 0) && (!empty($_POST['select_cat']))) {
    switch($_FILES["servfile"]["error"]) {
        case 1:
            echo "Arquivo muito grande para ser salvo.";
            break;
        case 2:
            echo "Erro impossível.";
            break;
        case 3:
            echo "O upload do arquivo foi feito de forma parcial.";
            break;    
        case 4:
            echo "Você não inseriu uma imagem, por favor reveja o formulário.";
            break;
        case 6:
            echo "Erro na pasta temporária do servidor.";
            break;
        case 7:
            echo "Erro do servidor em escrever o arquivo no HD.";
            break;
        case 8:
            echo "Uma extensão do servidor interrompeu o upload do arquivo.";
            break;
        default:
            $ControllerCriaServiço = new ControllerCriaServiço($_POST["titulo"], $_POST["descricao"], $_POST["precoMedio"], $_POST["licenca"],$_POST["select_cat"], $_FILES['servfile']['name'], $_FILES['servfile']['size'], $_FILES['servfile']['type'], $_FILES['servfile']['tmp_name']);
            break;
    }
} else {
    /*$_SESSION["error"] = 'Nada foi enviado';
    header("Location: /Github/Kamaleao/app/public/View/pós_login/perfil/perfil.php");*/
    echo "Nada foi enviado.";
    #Caso contrário ele retorna o erro
}
?>
