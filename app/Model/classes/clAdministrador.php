<?php
require_once 'clConexaoBanco.php';
require_once 'clParticipante.php';
class Administrador extends Participante {
    #Classe não tera atributos próprios

    #Métodos da classe abstrata sendo implementados
    function cadastrarConta(string $email, string $username, string $senha) {
        $retorno = "Erro!. Não deve-se cadastrar contas como Administrador";
        echo $retorno;
        return $retorno;
    }
    function logarConta(string $email, string $senha):bool {
        $banco = ConexaoBanco::abreConexao();
        $stmt = $banco->prepare("SELECT nm_email, nm_senha, ic_is_administrador FROM tb_login WHERE nm_email = :email AND nm_senha = :senha AND ic_is_administrador = true");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':senha', $senha, PDO::PARAM_STR);
        try {
            $stmt->execute();
            $contaLinha = $stmt->rowCount();
            if ($contaLinha > 0 ) {
                echo "Login realizado. 'Ai nesse ponto teria q redirecionar pra home né'";
            } else {
                echo "Este usuário não está cadastrado no sistema. <hr>";
                return false;
            }
            return true;
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage());
            return false;
        }
    }
    function excluirConta() {
        $retorno = "Erro!. Não deve-se excluir a conta Administrador";
        echo $retorno;
        return $retorno;
    }
    function atualizarEmail() {
        $retorno = "Erro!. Não deve-se atualizar o email da conta Administrador";
        echo $retorno;
        return $retorno;
    }
    function atualizarSenha() {
        $retorno = "Erro!. Não deve-se atualizar a senha da conta Administrador";
        echo $retorno;
        return $retorno;
    }
}
