<?php 
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); # essa constante serve pra pegar qual é a raiz do documento e evitar erros independente do local de acesso
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #chama o arquivo que faz todas as configurações do php
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Kamaleao - Cadastre-se</title>
    <link rel="stylesheet" href="css/cadastro.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="app/public/View/assets/img/LogoKamaleao1.png"/>
    <script type="text/javascript" src="js/script.js"></script>
    <script src="https://kit.fontawesome.com/c5e517703f.js" crossorigin="anonymous"></script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>
    <div class="form_cadastro">
        <form method="POST" action="/GitHub/Kamaleao/app/private/Controller/controllerCadastro.php">
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
                <input type="submit" class="botao" name="acao" value="Cadastrar" /> <br>
                <p class="form-message">
                    <?php
                        if(isset($_SESSION["error"])){
                            $error = $_SESSION["error"];
                            echo "<i class='fas fa-exclamation-triangle'></i>&nbsp; $error";
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

<!--<i class="fas fa-exclamation-triangle"></i>