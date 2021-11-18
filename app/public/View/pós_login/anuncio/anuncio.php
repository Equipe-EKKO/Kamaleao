<?php
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-PesquisaAbertaBanco.php');
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(DIR_ROOT . '/GitHub/Kamaleao/app/public/View/assets/templates/', '/templates');
$twig = new Environment($loader);

ob_end_clean();

if (!empty($_GET)) { #verifica se o formulário está enviando algo ao controller
    $titulo = $_GET['titulo'];
    $username = $_GET['username'];
    if ($titulo != null || $username != null) {
        $resposta = pesquisaServInfo($username, $titulo);
        echo $twig->render('anuncio.html.twig', ['titulo' => $resposta['titulo'], 'preço' => $resposta['valor'], 'licença' => $resposta['licenca'], 'url_da_imagem' => $resposta['urlfoto'], 'desc' => $resposta['desc']]);
    } else {
        echo "Algo de errado não está certo";
    }
    
} else {
    echo "Nada foi enviado";
    #Caso contrário ele retorna o erro 
}

// echo $_GET['itemid'] . " " . $_GET['username'] . " " . $_GET['titulo'];
/* array(7) { ["cdServ"]=> string(1) "7" ["titulo"]=> string(14) "My girl Mitski" ["desc"]=> string(36) "Mitski my girl, my beloved, my queen" ["valor"]=> string(5) "50.00" ["categoria"]=> string(6) "Outros" ["licenca"]=> string(8) "Download" ["urlfoto"]=> string(102) "http://res.cloudinary.com/kamaleaotcc/image/upload/v1637109288/img_service/1_serv_mitski248_wdglht.jpg" } */

