<!DOCTYPE html>
<html>
<head>
    <title>Kamaleao - Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/LogoKamaleao1.png" />
    <meta charset="utf-8" />
</head>

<body>
    <div class="form_login">
        <img src="../assets/img/LogoKamaleao1.png" class="logo" />
        <form>
            <fieldset>
                <h1>Login</h1>
                <p>E-mail</p>
                <input type="text" id="email" name="email" />

                <p>Senha</p>
                <input type="password" id="senha" name="password" /><br />
                <input type="checkbox" id="checkbox" name="manter_conectado" value="" /><span>Manter conectado</span>
                <br />
                <input type="submit" class="botao" name="acao" value="Login" /><br />
                <a href="#" class="esqueci">Esqueci minha senha</a>

            </fieldset>
        </form>
    </div>
</body>

</html>