<?php 
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); # essa constante serve pra pegar qual é a raiz do documento e evitar erros independente do local de acesso
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #chama o arquivo que faz todas as configurações do
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Kamaleao - Recuperação de Senha</title>
    <link rel="stylesheet" href="style/rec_senha.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="/GitHub/Kamaleao/app/public/View/assets/img/LogoKamaleao1.png" />
    <script src="https://kit.fontawesome.com/684a277949.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c5e517703f.js" crossorigin="anonymous"></script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="cache-control" content="private"/>
</head>

<body>
    <div class="rec_senha">
        <form method="POST" action="/GitHub/Kamaleao/app/private/Controller/controllerRecuperaSenha.php">
            <h1>Esqueceu sua senha?</h1>
            <p>Não se preocupe! Enviaremos um e-mail para que você possa redefinir sua senha. Basta escrever o e-mail usado no cadastro logo abaixo:</p>
            <input type="text" id="r_email" name="r_email" /><br />
            <button type="submit" class="botao" name="acao">Enviar e-mail</button>
            <p class="form-message">
                <?php
                    if(isset($_SESSION["error"])){
                        $error = $_SESSION["error"];
                        echo "<div style='color: #f44336;'><i class='fas fa-exclamation-triangle'></i> &nbsp; $error </div>";
                    }else if(isset($_SESSION["sucess"])){
                        $sucess = $_SESSION["sucess"];
                        echo "<div style='color: #04AA6D;'><i class='fas fa-exclamation-triangle'></i>&nbsp; $sucess</div>";
                    }
                ?>  
            </p>
        </form>
    </div>
</body>
</html>

<?php
    unset($_SESSION["error"]);
    unset($_SESSION["sucess"]);
?>
