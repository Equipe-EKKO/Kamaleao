<?php
require_once 'classes/clControllerRedSenha.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');

if (!empty($_POST)) {
    if (isset($_SESSION['tempo_sessao']) && isset($_SESSION['emailinfo'])) {
        if (time() - $_SESSION['tempo_sessao'] <= 900) {
            $ControllerLogin = new ControllerRedSenha($_SESSION['emailinfo'], $_POST['r_senha'], $_POST['r_confsenha']);
        } else {
            echo "O tempo para redefinição foi excedido. Tente novamente, pedindo uma nova solicitação de redefinição";
            session_unset();
            session_destroy();
        }
    } else {
        echo "Houve um erro no processo. Realize todo o processo de redefinição no mesmo aparelho e mesmo navegador, por favor.";
    }
} else {
    echo "Nada foi enviado";
}



?>