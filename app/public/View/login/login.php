<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kamaleao - Login</title>
    <link rel="stylesheet" href="style/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/LogoKamaleao1.png" />
    <script src="https://kit.fontawesome.com/684a277949.js" crossorigin="anonymous"></script>
    <meta charset="utf-8" />
</head>

<body>
    <div class="form_login">
        <form method="POST" action="../../../Controller/controllerLogin.php">
            <fieldset>
                <h1>Login</h1>
                <p>E-mail</p>
                <input type="text" id="email" name="email" />
                <p>Senha</p>
                <input type="password" id="senha" name="senha" /><br />
                <button type="submit" class="botao" name="submit" id="mail-submit">Login</button>
                <br />
                <a href="../rec_senha/rec_senha.php" class="esqueci">Esqueci minha senha</a>    
                <p class="form-message">
                    <?php
                        if(isset($_SESSION["error"])){
                            $error = $_SESSION["error"];
                            echo $error;
                        }
                    ?>  
                </p>
            </fieldset>
        </form>
    </div>
</body>
</html>

<?php
    unset($_SESSION["error"]);
?>
