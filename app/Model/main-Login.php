<?php
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (Participante -- hiperclasse abstrata | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once 'classes/clParticipante.php';
require_once 'classes/clUsuario.php';
require_once 'classes/clAdministrador.php';
// O programa principal está inserido dentro de uma função para que possa ser chamado no Controller
function recebeLogPosts(string $email, string $senha) { # define que os parametros a serem passados devem ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Instanciar as duas classes possíveis que fazem login
        => Estrutura condicional onde a primeira situação possível é tentar chamar o método que realiza o login, nos dois objetos instanciados, e verificar se ambos os resultados serão falsos
        => A segunda situação é que o resultado da chamada do método de login no objeto de Usuário retorna um valor verdadeiro, enquanto no objeto Administrador é falso, significando que os parâmetros passados são referentes a um usuário
        => A ultima situação é que o resultado de Usuário é falso e o resultado de Administrador é verdadeiro, significando que os parâmetros passados são referentes a um administrador */
    $usuario = new \Usuario("", "", "", ""); # aqui o construtor de Usuário recebe strings vazias pois os atributos da classe Usuário não são necessários para realizar o login
    $administrador = new \Administrador(); # instancia a classe administrador, normalmente
    if ($usuario->logarConta($email, $senha) == false && $administrador->logarConta($email, $senha) == false){
        $_SESSION["error"] = 'Não encontramos nenhum usuário com estas credenciais, tente novamente!';# o resultado caso as duas tentativas de login sejam falsas é que os dados que o cliente inseriu não estão registrados no banco de dados
        header("location: ../public/view/login/login.php");
    } elseif($usuario->logarConta($email, $senha) && $administrador->logarConta($email, $senha) == false) {
        echo "Logou como usuario! Parabéns! <hr>"; # o resultado caso o Usuário seja positivo e o Administrador falso, é que os dados que o cliente inseriu são referentes ao Usuário
    } else {
        echo "Logou como administrador LOL, XD. Parabéns! <hr>"; # o resultado caso o Usuário seja falso e o Administrador verdadeiro, é que os dados que o cliente inseriu são referentes ao Adm
    }
}
?>