<?php
#requere as classes necessárias para o funcionamento (Conexão para fazer o CRUD e Participante para herdar da classe mãe)
require_once 'clConexaoBanco.php';
require_once 'clParticipante.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
//Subclasse de Participante cuja função é lidar com as funcionalidades CRUD da partição do Administrador do sistema
class Administrador extends Participante {
    //Classe não tera atributos próprios

    //Métodos da classe abstrata sendo implementados
    /*Função para impedir que outro administrador seja cadastrado*/
    function cadastrarConta(string $email, string $username, string $senha) {
        $retorno = "Erro!. Não deve-se cadastrar contas como Administrador"; # registra um erro, caso a função seja chamada, dentro de uma variável
        echo $retorno; # exibe o erro
        return $retorno; # retorna a mensagem como saída da função
    }
    function logarConta(string $email, string $senha):bool { #define que a saída (retorno) terá um tipo booleano
        $banco = ConexaoBanco::abreConexao(); # chama a função estática da classe ConexaoBanco para abrir a conexão com o servidor MYSQL 
        $stmt = $banco->prepare("SELECT nm_email, nm_senha, ic_is_administrador FROM tb_login WHERE nm_email = :email AND nm_senha = :senha AND ic_is_administrador = true"); # prepara para a execução um select que verificará se as informações inseridas correspondem com o que está registrado no database na categoria administrador (ic_is_administrador = verdadeiro)
        /*Substitui os placeholders da query preparada*/
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':senha', $senha, PDO::PARAM_STR);
        /*Try catch que tentará executar o select, registrar quantas linhas ele retornou e então, abrir uma estrutura de decisão para logar ou não*/
        try {
            $stmt->execute(); # tenta executar o select preparado 
            $contaLinha = $stmt->rowCount(); # armazena numa variável o valor de quantas linhas existem no retorno desse select
            if ($contaLinha == 1 ) { # estrutura condicional que verifica se o valor retornado no select corresponde a apenas e somente 1, e se sim...
                #echo "Login realizado. 'Ai nesse ponto teria q redirecionar pra home né' <hr>";
                return true; # seta o retorno da função como verdadeiro
            } else { #se o valor armazenado for diferente de 1...
                /*echo "Este usuário não está cadastrado no sistema. <hr>";*/
                return false; # seta o retorno da função como falso
            }
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
            return false;
        }
    }
    /*Função para impedir que um administrador (que é essencial para o sistema) seja excluído*/
    function excluirConta() {
        $retorno = "Erro!. Não deve-se excluir a conta Administrador"; # registra um erro, caso a função seja chamada, dentro de uma variável
        echo $retorno; # exibe o erro
        return $retorno; # retorna a mensagem como saída da função
    }
    /*Função para impedir que um administrador (que é essencial para o sistema) tenha seu email de login alterado*/
    function atualizarEmail() {
        $retorno = "Erro!. Não deve-se atualizar o email da conta Administrador"; # registra um erro, caso a função seja chamada, dentro de uma variável
        echo $retorno; # exibe o erro
        return $retorno; # retorna a mensagem como saída da função
    }
    /*Função para impedir que um administrador (que é essencial para o sistema) tenha sua senha de login alterada*/
    function atualizarSenha() {
        $retorno = "Erro!. Não deve-se atualizar a senha da conta Administrador"; # registra um erro, caso a função seja chamada, dentro de uma variável
        echo $retorno; # exibe o erro
        return $retorno; # retorna a mensagem como saída da função
    }
    /*Função para impedir que um administrador (que é essencial para o sistema) tenha sua senha de login alterada via email*/
    function recuperarSenha(string $email, string $novaSenha) {
        $retorno = "Erro!. Não deve-se recuperar a senha da conta Administrador"; # registra um erro, caso a função seja chamada, dentro de uma variável
        echo $retorno; # exibe o erro
        return $retorno; # retorna a mensagem como saída da função
    }
}
