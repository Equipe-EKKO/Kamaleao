<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Kamaleao - Refinição de Senha</title>
    <link rel="stylesheet" href="style/redef_senha.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="/GitHub/Kamaleao/app/public/View/assets/img/LogoKamaleao1.png" />
    <script type="text/javascript" src="js/script.js"></script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <script src="https://kit.fontawesome.com/684a277949.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c5e517703f.js" crossorigin="anonymous"></script>
</head>
<?php session_start(); ob_start(); ?>
<body>
    <div class="form_refinicao">
        <form method="POST" action="/GitHub/Kamaleao/app/private/Controller/controllerRedefineSenha.php">
            <fieldset>
                <h1>Redefinição de Senha</h1>
                <div class ="redefinicao">

                    <div class="grid">
                        <p>Insira uma nova senha</p>
                        <!--senha-->
                        <input type="password" id="r_senha" name="r_senha" /><br />

                        <p>Confirme sua nova senha</p>
                        <input type="password" id="r_confsenha" name="r_confsenha" />
                         <!--conf senha-->
                    </div> <!--grid-->
                </div> <!--redefinicao-->
                <input type="submit" class="botao" value="Redefinir" />
            </fieldset>
        </form>
    </div>
</body>
<?php 
if (isset($_SESSION['tempo_sessao']) && isset($_SESSION['emailinfo'])) {
    if (time() - $_SESSION['tempo_sessao'] <= 900) {
        ob_end_flush();
    } else {
        session_unset();
        session_destroy();
        ob_end_clean();
        echo "
        <body>
            <div class='form_refinicao'>
                <fieldset>
                <h1>Erro na Redefinição de Senha</h1>
                <div class ='redefinicao'>
                    <div class='grid'>
                    <p>O tempo para redefinição foi excedido. Tente novamente, pedindo uma nova solicitação de redefinição.</p>
                    </div> <!--grid-->
                </div> <!--redefinicao-->  
                </fieldset>       
            </div>
        </body>
        </html>";
    }
} else {
    session_unset();
    session_destroy();
    ob_end_clean();
    echo "
        <body>
            <div class='form_refinicao'>
            <fieldset>
                <h1>Erro na Redefinição de Senha</h1>
                <div class ='redefinicao'>
                    <div class='grid'>
                    <p>Houve um erro no processo. Realize todo o processo de redefinição no mesmo aparelho e mesmo navegador, por favor.</p>
                    
                    </div> <!--grid-->
                </div> <!--redefinicao-->         
            </div>
            </fieldset>
        </body>
        </html>";
}
?>
</html>
    