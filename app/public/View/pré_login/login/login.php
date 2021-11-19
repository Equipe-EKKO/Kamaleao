<?php
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(DIR_ROOT . '/GitHub/Kamaleao/app/public/View/assets/templates/', '/templates');
$twig = new Environment($loader);

error_reporting(E_ALL & ~E_WARNING);

if (!isset($_SESSION['error'])){
    $_SESSION['error'] = " ";
    $error = $_SESSION['error'];
    echo $twig->render('login.html.twig', ['erro' => $error]);
}else {
    $error = $_SESSION['error'];
    echo $twig->render('login.html.twig', ['erro' => $error]);
    session_unset();
    $_SESSION['error'] = " ";
}
?>