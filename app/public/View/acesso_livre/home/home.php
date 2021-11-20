<?php
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-PesquisaAbertaBanco.php');
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-Perfil.php');

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(DIR_ROOT . '/GitHub/Kamaleao/app/public/View/assets/templates/', '/templates');
$twig = new Environment($loader);

if (isset($_SESSION['userinfo'])) {
    $perfilInfo = unserialize($_SESSION['userinfo']);
}
if (isset($_SESSION['userinfoToPerfil'])) {
    $userinfoToPerfil = unserialize($_SESSION['userinfoToPerfil']);
    if (isset($userinfoToPerfil['nm_username']) && isset($userinfoToPerfil['nm_email']) && isset($userinfoToPerfil['nm_senha'])) {
        $username = $userinfoToPerfil['nm_username'];
        $email = $userinfoToPerfil['nm_email'];
        $senha = $userinfoToPerfil['nm_senha'];
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
    } else {
        $username = "userIndefinido";
        $email = "emailIndefinido";
        $senha = "senhaIndefinida";
    }
}

if ($username === "userIndefinido"):
    $slc_servicosAll = pesquisaAllServRec();
    echo $twig->render('home.html.twig', ['servicos' => $slc_servicosAll]);
else:
    $slc_servicosAll = pesquisaAllServRec();
    echo $twig->render('home.html.twig', ['username' => $username, 'servicos' => $slc_servicosAll]);
    
endif;
