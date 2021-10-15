<?php
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(DIR_ROOT . '/GitHub/Kamaleao/app/public/View/assets/templates/', '/templates');
$twig = new Environment($loader);

if (isset($_SESSION['usernameProprio'])) {
    $username = $_SESSION['usernameProprio'];
} else {
    $username = "userIndefinido";
}

echo $twig->render('perfil.html.twig', ['Usuario' => $username]);