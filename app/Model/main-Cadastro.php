<?php
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (Participante -- hiperclasse abstrata | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once 'classes/clConexaoBanco.php';
require_once 'classes/clUsuario.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #arquivo de configuracao
// O programa principal está inserido dentro de uma função para que possa ser chamado no Controller
function recebeCadPosts(string $nome, string $sobrenome, string $dtNascimento, string $cpf, string $email, string $username, string $senha) { # define que os parametros a serem passados devem ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Não é possível que um adminsitrador seja cadastrado pelas vias comuns de cadastro, já que isso é um risco a segurança do sistema todo
        => Portanto, o cadastro só pode ser feito pelo objeto de Usuário */
    $usuario = new \Usuario($nome, $sobrenome, $cpf, $dtNascimento); #instancia a classe Usuario, setando os valores requisitados pelo construtor como alguns dos parametros inseridos na função
    if ($usuario->cadastrarConta($email, $username, $senha)): # estrutura condicional que setará os valores restantes inseridos nos parametros, irá verificar se a tentativa de cadastro é verdadeira, e se for...
        echo "Usuário cadastrado! <hr>"; # exibe para o cliente que um novo usuário FOI cadastrado
    else: # e se não for...
        echo "<hr>Usuário não cadastrado. ERRO! <hr>";  # exibe para o cliente que um novo usuário NÃO foi cadastrado e que houve um erro
    endif;
}
?>