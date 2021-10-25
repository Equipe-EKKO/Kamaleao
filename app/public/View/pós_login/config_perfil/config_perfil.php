<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(DIR_ROOT . '/GitHub/Kamaleao/app/public/View/assets/templates/', '/templates');
$twig = new Environment($loader);

$perfilInfo = unserialize($_SESSION['userinfo']);

/*      TEM Q PUXAR:
    - username - ja foi
    - email - ja foi
    - descricao - ja foi
    - chave pix
*/


if (isset($perfilInfo['nm_username']) && isset($perfilInfo['nm_email'])) {
    $username = $perfilInfo['nm_username'];
    $email = $perfilInfo['nm_email'];
    if (!isset($perfilInfo['ds_usuario']) || empty($perfilInfo['ds_usuario']) || $perfilInfo['ds_usuario'] == "" || $perfilInfo['ds_usuario'] == null) {
        $sobre = "";
    }
    else {
        $sobre = $perfilInfo['ds_usuario'];
    }
    if (!isset($perfilInfo['cd_pix']) || empty($perfilInfo['cd_pix']) || $perfilInfo['cd_pix'] == "" || $perfilInfo['cd_pix'] == null) {
        $chavePix = "";
    }
    else {
        $sobre = $perfilInfo['ds_usuario'];
    }
} else {
    $username = "userIndefinido";
    $email = "emailIndefinido";
}

if ($username === "userIndefinido"):
    ob_end_clean();
    $_SESSION["error"] = 'Você precisa estar logado para acessar esta página!';
    header("Location: /Github/Kamaleao/app/public/view/pré_login/login/login.php");
else:
    echo $twig->render('config_perfil.html.twig', ['Usuario' => $username, 'Descricao' => $sobre, 'Email' => $email, 'ChavePix' => $chavePix]);
    ob_end_flush();
endif;
