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
    <div class="form_cadastro">
        <form method="POST" action="../../Controller/controllerCadastro.php">
            <fieldset>
                <h1>Cadastro</h1>
                <div class ="grid_cadastro">
                    <div>
                        <p>Nome</p>
                        <input type="text" id="nome" name="nome" />
                    </div>

                    <div>
                        <p>Sobrenome</p>
                        <input type="text" id="sobrenome" name="sobrenome" />
                    </div>

                    <div>
                        <p>Nome de usuário</p>
                        <input type="text" id="username" name="username" />
                    </div>

                    <div>
                        <p>Data de nascimento</p>
                    <input type="date" id="dt_nascimento" name="dt_nascimento" /></div>

                    <div>
                        <p>CPF</p>
                        <input type="text" id="cpf" name="cpf" maxlength="14" onkeyup="mascara_cpf()" />
                    </div>

                    <div>
                        <p>E-mail</p>
                        <input type="text" id="email" name="email" />
                    </div>
                    
                    <!--email-->

                    <div class="grid">
                        <p>Insira uma senha</p>
                        <!--senha-->
                        <input type="password" id="senha" name="senha" /><br />
                    </div>
                    <!--senha-->

                    <div>
                        <p>Confirme sua senha</p>
                        <input type="password" id="confsenha" name="confsenha" />
                    </div>
                <!--conf senha-->
                </div>
                <input type="submit" class="botao" name="acao" value="Cadastrar" />
            </fieldset>
        </form>
    </div>
</body>


</html>