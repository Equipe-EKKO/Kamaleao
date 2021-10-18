<?php
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(DIR_ROOT . '/GitHub/Kamaleao/app/public/View/assets/templates/', '/templates');
$twig = new Environment($loader);

if ($_SESSION['error'] == null || !isset($_SESSION['error'])){
    $_SESSION['error'] = " ";
    $error = $_SESSION['error'];
    echo $twig->render('rec_senha.html.twig', ['erro' => $error]);
}elseif ($_SESSION['error'] == "Verifique se o campo de email está inserido corretamente!" || $_SESSION['error'] == 'Digite o email corretamente!' || $_SESSION['error'] == "Este email é protegido e não pode ter sua senha redefinida" ||  $_SESSION['error'] == "O email inserido não pertence a nenhuma conta cadastrada no sistema") {
    $error = $_SESSION['error'];
    echo $twig->render('rec_senha.html.twig', ['erro' => $error]);
    session_unset();
    $_SESSION['error'] = " ";
} else {
    $sucesso = $_SESSION['error'];
    echo $twig->render('rec_senha.html.twig', ['erro' => $sucesso]);
    session_unset();
    $_SESSION['error'] = " ";
}
?>