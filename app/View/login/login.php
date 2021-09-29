<!DOCTYPE html>
<html>
<head>
    <title>Kamaleao - Login</title>
    <link rel="stylesheet" href="style/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/LogoKamaleao1.png" />
    <meta charset="utf-8" />
</head>

<body>
    <div class="form_login">
        <form method="POST" action="../../controller/controllerLogin.php">
            <fieldset>
                <h1>Login</h1>
                <p>E-mail</p>
                <input type="text" id="email" name="email" />
                <p>Senha</p>
                <input type="password" id="senha" name="senha" /><br />
                <button type="submit" class="botao" name="acao">Login</button>
                <br />
                <a href="#" class="esqueci">Esqueci minha senha</a>
                <?

                ?>
            </fieldset>
        </form>
    </div>
</body>

</html>