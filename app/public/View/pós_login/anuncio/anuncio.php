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
    ob_end_clean();
    $_SESSION["error"] = 'Você precisa estar logado para acessar esta página!';
    header("Location: /Github/Kamaleao/app/public/view/pré_login/login/login.php");
else:
    ob_end_clean();
    if (!empty($_GET)) { #verifica se o formulário está enviando algo ao controller
        $titulo = $_GET['titulo'];
        $usernameserv = $_GET['username'];
        if ($titulo != null || $usernameserv != null) {
            $resposta = pesquisaServInfo($usernameserv, $titulo);
            $resposta2 = pesquisaQuaseServInfo($usernameserv, $titulo);
            echo $twig->render('anuncio.html.twig', ['titulo' => $resposta['titulo'], 'preço' => $resposta['valor'], 'licença' => $resposta['licenca'], 'url_da_imagem' => $resposta['urlfoto'], 'desc' => $resposta['desc'], 'categoria' => $resposta['categoria'],'username' => $username, 'usernameserv' => $usernameserv, 'outrosservicos' => $resposta2]);
        } else {
            echo "Algo de errado não está certo";
        }
            
        } else {
            echo "Nada foi enviado";
            #Caso contrário ele retorna o erro 
        }        
    
endif;
