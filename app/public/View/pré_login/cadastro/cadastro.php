<?php
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(DIR_ROOT . '/GitHub/Kamaleao/app/public/View/pré_login/templates/', '/templates');
$twig = new Environment($loader);

if ($_SESSION['error'] == null || !isset($_SESSION['error'])){
    $_SESSION['error'] = "";
    $error = $_SESSION['error'];
    echo $twig->render('cadastro.html.twig', ['erro' => $error]);
}else {
    $error = $_SESSION['error'];
    echo $twig->render('cadastro.html.twig', ['erro' => $error]);
    session_unset();
    $_SESSION['error'] = "";
}
?>