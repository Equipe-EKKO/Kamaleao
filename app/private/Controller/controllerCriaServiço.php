<?php
require_once 'classes/clControllerCriaServiço.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
/*
if (!empty($_POST) && $_FILES['servfile']['size'] == 0 && !empty($_POST['select_cat'])) {
    $fileError = $_FILES["servfile"]["error"]; // where FILE_NAME is the name attribute of the file input in your form
    switch($fileError) {
        case UPLOAD_ERR_INI_SIZE:
            echo "Arquivo muito grande para ser salvo.";
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "Você não inseriu uma imagem, por favor reveja o formulário.";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            echo "Erro na pasta temporária do servidor.";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            echo "Erro do servidor em escrever o arquivo no HD.";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            echo "Erro impossível.";
            break;
        case UPLOAD_ERR_PARTIAL:
            echo "O upload do arquivo foi feito de forma parcial.";
            break;    
        case UPLOAD_ERR_EXTENSION:
            echo "Uma extensão do servidor interrompeu o upload do arquivo.";
            break;
        default:
            $ControllerCriaServiço = new ControllerCriaServiço($_POST["titulo"], $_POST["descricao"], $_POST["precoMedio"], $_POST["licenca"],$_POST["select_cat"], $_FILES['servfile']['name'], $_FILES['servfile']['size'], $_FILES['servfile']['type'], $_FILES['servfile']['tmp_name']);
            break;
    }
} else {
    /*$_SESSION["error"] = 'Nada foi enviado';
    header("Location: /Github/Kamaleao/app/public/View/pós_login/perfil/perfil.php");*/
    /*echo "Nada foi enviado.";
    #Caso contrário ele retorna o erro
}*/
$temp = $_FILES["servfile"]["tmp_name"];
$image = basename($_FILES["servfile"]["name"]);
$img = "E:/xampp/htdocs/GitHub/Kamaleao/app/private/Model/image/service/".$image;
move_uploaded_file($temp, $img);
echo "<img src='/GitHub/Kamaleao/app/private/Model/image/service/".$image ."' />";
?>
