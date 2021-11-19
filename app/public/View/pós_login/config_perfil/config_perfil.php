<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(DIR_ROOT . '/GitHub/Kamaleao/app/public/View/assets/templates/', '/templates');
$twig = new Environment($loader);

$perfilInfo = unserialize($_SESSION['userinfo']);

if (isset($_SESSION['userinfoToPerfil'])/* || !empty($_SESSION['userinfoToPerfil']) || $_SESSION['userinfoToPerfil'] != null*/) {
    $userinfoToPerfil = unserialize($_SESSION['userinfoToPerfil']);
    if (isset($userinfoToPerfil['nm_username']) && isset($userinfoToPerfil['nm_email']) && isset($userinfoToPerfil['nm_senha'])) {
        $username = $userinfoToPerfil['nm_username'];
        $email = $userinfoToPerfil['nm_email'];
        $senha = $userinfoToPerfil['nm_senha'];
        if (!isset($userinfoToPerfil['ds_usuario']) || empty($userinfoToPerfil['ds_usuario']) || $userinfoToPerfil['ds_usuario'] == "" || $userinfoToPerfil['ds_usuario'] == null) {
            $sobre = "";
        }
        else {
            $sobre = $userinfoToPerfil['ds_usuario'];
        }
    } else {
        $username = "userIndefinido";
        $email = "emailIndefinido";
        $senha = "senhaIndefinida";
    }
} else {
    if (isset($perfilInfo['nm_username']) && isset($perfilInfo['nm_email']) && isset($perfilInfo['nm_senha']) ) {
        $username = $perfilInfo['nm_username'];
        $email = $perfilInfo['nm_email'];
        $senha = $perfilInfo['nm_senha'];
        if (!isset($perfilInfo['ds_usuario']) || empty($perfilInfo['ds_usuario']) || $perfilInfo['ds_usuario'] == "" || $perfilInfo['ds_usuario'] == null) {
            $sobre = "";
        }
        else {
            $sobre = $perfilInfo['ds_usuario'];
        }
    } else {
        $username = "userIndefinido";
        $email = "emailIndefinido";
        $senha = "senhaIndefinida";
    }
}

if ($username === "userIndefinido"):
    ob_end_clean();
    $_SESSION["error"] = 'Você precisa estar logado para acessar esta página!';
    header("Location: /Github/Kamaleao/app/public/view/pré_login/login/login.php");
else:
    if (!isset($_SESSION['fototoPerfil']) || empty($_SESSION['fototoPerfil']) || $_SESSION['fototoPerfil'] == "" || $_SESSION['fototoPerfil'] == null) {
        $urlfotoperf = null;
    }
    else {
        $urlfotoperf = $_SESSION['fototoPerfil'];
    }
    if ($urlfotoperf == null || $urlfotoperf == "" || empty($urlfotoperf)) {
        echo $twig->render('config_perfil.html.twig', ['Usuario' => $username, 'Descricao' => $sobre, 'Email' => $email, 'Senha' => $senha, 'username' => $username]);
        ob_end_flush();
    } else {
        echo $twig->render('config_perfil.html.twig', ['Usuario' => $username, 'Descricao' => $sobre, 'Email' => $email, 'Senha' => $senha, 'username' => $username, 'url_foto_perfil' => $urlfotoperf]);
        ob_end_flush();
    }
endif;
