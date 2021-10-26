<?php
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (ConexaoBanco -- classe que realiza a conexão com o banco de dados | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once 'classes/clConexaoBanco.php';
require_once 'classes/clUsuario.php';
require_once 'classes/clPerfilProprio.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #arquivo de configuracao

// Função chamada no controller para realizar o envio do email para redefinir senha
function recebeUpdPerfilPost(string $email):bool { # define que o parametro a ser passado deve ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Não é possível redefinir a senha do email usado para logar o Adm, então caso alguém tente, um erro é exibido.
        => Só é necessário instanciar a classe Usuário pelo mesmo motivo. Caso o email tenha sido enviado, a função retorna true para exibir mensagem de sucesso, e caso não tenha sido, retorna false para a exibição de um erro ao usuário */
    if ($email === "kamaleaoctt@gmail.com") { # estrutura condicional que verificará se o email inserido pertence ao que é usado pelo administrador, e se for...
        $_SESSION['error'] = "Este email é protegido e não pode ter sua senha redefinida"; # registra a ação como erro, e exibe ao usuário
        header("Location: /Github/Kamaleao/app/public/view/pré_login/rec_senha/rec_senha.php"); # o redirecionando para a mesma página ao enviar outra header com http
        return false;
    }
    $usuario = new \Usuario("", "", "", "");#instancia a classe Usuario, setando os valores requisitados pelo construtor como vazios, já que não são necessários
    if ($usuario->enviaEmailRecuperacao($email)): # estrutura condicional que setará os valores restantes inseridos nos parametros, irá verificar se a tentativa de cadastro é verdadeira, e se for...
        # exibe para o cliente que o email de recuperação de senha FOI enviado, retornando a função como true
        return true;
    else: # e se não for...
        # exibe para o cliente que o email de recuperação de senha NÃO foi enviado e que houve um erro, retornando a função como false
        return false;
    endif;
}
