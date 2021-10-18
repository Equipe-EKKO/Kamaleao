<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(DIR_ROOT . '/GitHub/Kamaleao/app/public/View/assets/templates/', '/templates');
$twig = new Environment($loader);

if (isset($_SESSION['usernameProprio'])) {
    $username = $_SESSION['usernameProprio'];
    if (!isset($_SESSION['descProprio']) || empty($_SESSION['descProprio']) || $_SESSION['descProprio'] == "" || $_SESSION['descProprio'] == null) {
        $sobre = "O usuário ainda não adicionou uma descrição ao perfil.";
    }
    else {
        $sobre = $_SESSION['descProprio'];
    }
} else {
    $username = "userIndefinido";
}

if ($username === "userIndefinido"):
    ob_end_clean();
    $_SESSION["error"] = 'Você precisa estar logado para acessar esta página!';
    header("Location: /Github/Kamaleao/app/public/view/pré_login/login/login.php");
else:
    echo $twig->render('perfil.html.twig', ['Usuario' => $username, 'Descricao' => $sobre]);
    ob_end_flush();
endif;