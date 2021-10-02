<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Kamaleao - Recuperação de Senha</title>
    <link rel="stylesheet" href="style/rec_senha.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/LogoKamaleao1.png" />
    <meta http-equiv="content-language" content="pt-br" charset="utf-8" />
    <meta http-equiv="cache-control" content="private"/>
</head>

<body>
    <div class="rec_senha">
        <form method="POST" action="../../../Controller/controllerRecuperaSenha.php">
            <h1>Esqueceu sua senha?</h1>
            <p>Não se preocupe! Enviaremos um e-mail para que você possa redefinir sua senha. Basta escrever o e-mail usado no cadastro logo abaixo:</p>
            <input type="text" id="r_email" name="r_email" /><br />
            <button type="submit" class="botao" name="acao">Enviar e-mail</button>
        </form>
    </div>
</body>

</html>