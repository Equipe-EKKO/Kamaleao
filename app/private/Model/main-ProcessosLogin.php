<?php
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (ConexaoBanco -- classe que realiza a conexão com o banco de dados | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once "classes/autoloadClass.php";
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #arquivo de configuracao

// Função chamada no controller para realizar cadastro de usuários
function recebeCadPosts(string $nome, string $sobrenome, string $dtNascimento, string $cpf, string $email, string $username, string $senha) { # define que os parametros a serem passados devem ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Não é possível que um adminsitrador seja cadastrado pelas vias comuns de cadastro, já que isso é um risco a segurança do sistema todo
        => Portanto, o cadastro só pode ser feito pelo objeto de Usuário */
    $usuario = new \Usuario($nome, $sobrenome, $cpf, $dtNascimento); #instancia a classe Usuario, setando os valores requisitados pelo construtor como alguns dos parametros inseridos na função
    if ($usuario->cadastrarConta($email, $username, $senha)): # estrutura condicional que setará os valores restantes inseridos nos parametros, irá verificar se a tentativa de cadastro é verdadeira, e se for...
        recebeLogPosts($email, $senha); #chama a função que realiza o login e foi declarada abaixo nesse mesmo documento.
    else:
        $_SESSION["error"] = 'Erro ao cadastrar usuário!';  # exibe para o cliente que um novo usuário NÃO foi cadastrado e que houve um erro, o redirecionando para a mesma página ao enviar outra header com http
        header("Location: /Github/Kamaleao/app/public/View/pré_login/cadastro/cadastro.php"); 
    endif;
}

// Função chamada no controller para realizar o login de usuário/administrador
function recebeLogPosts(string $email, string $senha):void { # define que os parametros a serem passados devem ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Instanciar as duas classes possíveis que fazem login
        => Estrutura condicional onde a primeira situação possível é tentar chamar o método que realiza o login, nos dois objetos instanciados, e verificar se ambos os resultados serão falsos
        => A segunda situação é que o resultado da chamada do método de login no objeto de Usuário retorna um valor verdadeiro, enquanto no objeto Administrador é falso, significando que os parâmetros passados são referentes a um usuário
        => A ultima situação é que o resultado de Usuário é falso e o resultado de Administrador é verdadeiro, significando que os parâmetros passados são referentes a um administrador */
    $usuario = new \Usuario("", "", "", ""); # aqui o construtor de Usuário recebe strings vazias pois os atributos da classe Usuário não são necessários para realizar o login
    $administrador = new \Administrador(); # instancia a classe administrador, normalmente
    if ($usuario->logarConta($email, $senha) == false && $administrador->logarConta($email, $senha) == false){ # estrutura condicional que setará os valores inseridos nos parametros como os valores que vão ser chamados junto com a função, irá verificar se a tentativa de login é falsa nos dois objetos, e se for...
        $_SESSION["error"] = 'Não encontramos nenhum usuário com estas credenciais, tente novamente!';# exibe que o resultado caso as duas tentativas de login sejam falsas é que os dados que o cliente inseriu não estão registrados no banco de dados
        header("Location: /Github/Kamaleao/app/public/view/pré_login/login/login.php"); # o redireciona para a mesma página ao enviar outra header com http
    } elseif($usuario->logarConta($email, $senha) && $administrador->logarConta($email, $senha) == false) { # se apenas a tentativa no objeto Administrador for falsa...
        $_SESSION['usuario'] = serialize($usuario);
        header("Location: /Github/Kamaleao/app/public/view/acesso_livre/home/home.php"); # o resultado caso o Usuário seja positivo e o Administrador falso, é que os dados que o cliente inseriu são referentes ao Usuário, portanto, ele carrega a página home do usuário
    } else { # se a tentativa for falsa no objeto Usuário, mas verdadeira em Administrador...
        echo "Logou como administrador LOL, XD. Parabéns! <hr>"; # o resultado caso o Usuário seja falso e o Administrador verdadeiro, é que os dados que o cliente inseriu são referentes ao Adm, portanto, ele carrega a página home do adm
    }
}

// Função chamada no controller para realizar o envio do email para redefinir senha
function recebeEmailRecPost(string $email):bool { # define que o parametro a ser passado deve ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
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

// Função chamada no controller para realizar a redefinição da senha
function recebeSenhaRedPost(string $endemail, string $newSenha):bool {
    # define que os parametros a serem passados devem ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Só é possível redefinir a senha de um usuário, então apenas essa classe é instanciada.
        => Se a redefinição teve sucesso, retorna true. Se não tiver, false */
    $usuario = new \Usuario("", "", "", ""); #instancia a classe Usuario, setando os valores requisitados pelo construtor como vazios, já que não são necessários
    if ($usuario->recuperarSenha($endemail, $newSenha)): # estrutura condicional que setará os valores inseridos nos parametros e irá verificar se a tentativa de redefinição é verdadeira, e se for...
        # exibe para o cliente que o email de recuperação de senha FOI enviado, retornando a função como true
        return true;
    else: # e se não for...
        # exibe para o cliente que o email de recuperação de senha NÃO foi enviado e que houve um erro, retornando a função como false
        return false;
    endif;
}
// Função chamada no controller para realizar o LogOff
function fazLogOff(object $objUsuario):void {
    unset($objUsuario);
    unset($usuario);
    session_destroy();
    header("Location: /Github/Kamaleao/app/public/view/pré_login/login/login" ); # envia header que redireciona a pessoa para a header
}
// Função chamada no controller para validar a senha, que posteriormente permitirá edição de dados
function confirmaSenha(string $senha):bool {
    $usuario = unserialize($_SESSION['usuario']);
    $senhaReal = $usuario->getSenha();
    if ($senha === $senhaReal) {
        return true;
    } else {
        return false;
    }
}
?>