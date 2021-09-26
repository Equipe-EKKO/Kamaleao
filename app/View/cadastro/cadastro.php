<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Kamaleao - Cadastre-se</title>
    <link rel="stylesheet" href="css/cadastro.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/LogoKamaleao1.png" />
    <script type="text/javascript" src="js/script.js"></script>
    <meta charset="utf-8" />
</head>

<body>
    <div class="form_cadastro" action="">
        <form method="POST">
            <fieldset>
                <h1>Cadastro</h1>
                <p>Nome</p>
                <input type="text" id="nome" name="nome" />

                <p>Sobrenome</p>
                <input type="text" id="sobrenome" name="sobrenome" />

                <p>CPF</p>
                <input type="text" id="cpf" name="CPF" maxlength="14" onkeyup="mascara_cpf()" />

                <p>E-mail</p>
                <!--email-->
                <div>
                    <input type="text" id="email" name="email" />
                </div>
                <!--email-->

                <p>Senha</p>
                <div>
                    <!--senha-->
                    <input type="password" id="senha" name="senha" /><br />
                </div>
                <!--senha-->

                <p>Confirme sua senha</p>
                <!--conf senha-->
                <div>
                    <input type="password" id="confsenha" name="confsenha" />
                </div>
                <!--conf senha-->

                <input type="checkbox" id="checkbox" name="manter_conectado" value="" /><span>Eu concordo com os termos
                    de serviço.</span>

                <div>
                    <!--botao-->
                    <input type="submit" class="botao" name="acao" value="Cadastrar" /><br />
                </div>
                <!--botao-->

            </fieldset>
        </form>
    </div>
</body>


</html>