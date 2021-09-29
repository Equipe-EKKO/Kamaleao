<?php
require_once 'clConexaoBanco.php';
require_once 'clParticipante.php';
class Usuario extends Participante {
    #Atributos
    public $nome, $foto_perfil;
    private $sobrenome;
    protected $cpf, $data_nascimento;

    #Métodos da classe abstrata sendo implementados
    function cadastrarConta(string $email, string $username, string $senha):bool {
        $nome = $this->getNome();
        $sobrenome = $this->getSobrenome();
        $cpf = $this->getCpf();
        $dataNasc = $this->getData_nascimento();
        $this->setEmail($email);
        $this->setUsername($username);
        $this->setSenha($senha);
        $banco = ConexaoBanco::abreConexao();

        if ($this->verificaDados()) {
            $sql = "INSERT INTO tb_login (nm_email, nm_username, nm_senha, ic_is_administrador) VALUES (:email, :username, :senha, false)";
            $stmt = $banco->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':senha', $senha);

            try {
                $stmt->execute();
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage());
                return false;
            }

            $espstmt = $banco->prepare("SELECT cd_login FROM tb_login WHERE nm_email = :email");
            $espstmt->bindValue(':email', $email);
            try {
                $espstmt->execute();
                $cd_login = $espstmt->fetchColumn();
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage());
                return false;
            }

            $sql2 = "INSERT INTO tb_usuario (nm_nome, nm_sobrenome, cd_cpf, dt_nascimento, cd_login) VALUES (:nome, :sobrenome, :cpf, :dtNasc, :cd_login)";
            $stmt2 = $banco->prepare($sql2);
            $stmt2->bindValue(':nome', $nome);
            $stmt2->bindValue(':sobrenome', $sobrenome);
            $stmt2->bindValue(':cpf', $cpf);
            $stmt2->bindValue(':dtNasc', $dataNasc);
            $stmt2->bindValue(':cd_login', $cd_login);

            try {
                $stmt2->execute();
                return true;
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage());
                return false;
            }
        } else {
            return false;
        }    
    }

    function logarConta(string $email, string $senha):bool {
        $banco = ConexaoBanco::abreConexao();
        $stmt = $banco->prepare("SELECT nm_email, nm_senha, ic_is_administrador FROM tb_login WHERE nm_email = :email AND nm_senha = :senha AND ic_is_administrador = false");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':senha', $senha, PDO::PARAM_STR);
        try {
            $stmt->execute();
            $contaLinha = $stmt->rowCount();
            if ($contaLinha == 1 ) {
                return true;
            } else {
                /*echo "Este usuário não está cadastrado no sistema. <hr>";*/
                return false;
            }
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage());
            return false;
        }
    }
    function excluirConta() {
        /*$retorno = "Erro!. Não deve-se excluir a conta Administrador";
        echo $retorno;
        return $retorno;*/
    }
    function atualizarEmail() {
        /*$retorno = "Erro!. Não deve-se atualizar o email da conta Administrador";
        echo $retorno;
        return $retorno;*/
    }
    function atualizarSenha() {
        /*$retorno = "Erro!. Não deve-se atualizar a senha da conta Administrador";
        echo $retorno;
        return $retorno;*/
    }

    #Métodos da classe Usuario em si
    private function verificaDados():bool {
        $banco = ConexaoBanco::abreConexao();

        $sql = "SELECT nm_email, ic_is_administrador FROM tb_login WHERE nm_email = :email AND   ic_is_administrador = false";
        $stmt = $banco->prepare($sql);
        $stmt->bindValue(':email', $this->getEmail());

        try {
            $stmt->execute();
            $contaLinha = $stmt->rowCount();
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage());
            return false;
        }

        if ($contaLinha > 0) {
            echo "Esse email já foi cadastrado no sistema.";
            return false;
        } else {
            $sql = "SELECT nm_username, ic_is_administrador FROM tb_login WHERE nm_username = :username AND   ic_is_administrador = false";
            $stmt = $banco->prepare($sql);
            $stmt->bindValue(':username', $this->getUsername());

            try {
                $stmt->execute();
                $contaLinha = $stmt->rowCount();
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage());
                return false;
            }

            if ($contaLinha > 0) {
                echo "Esse username está em uso. Tente outro.";
                return false;
            } else {
                return true;
            }
        }
    }
    #Métodos Especias - Getter e Setters para os atributos e Construct
    /*Construtor*/
    public function __construct($nome, $sobrenome, $cpf, $data_nascimento) {
        $this->setNome($nome);
        $this->setFoto_perfil(null);
        $this->setSobrenome($sobrenome);
        $this->setCpf($cpf);
        $this->setData_nascimento($data_nascimento);
    }
    /*GETTERS*/
    public function getNome(){
        return $this->nome;
    }
    public function getFoto_perfil(){
        return $this->foto_perfil;
    }
    public function getSobrenome(){
        return $this->sobrenome;
    } 
    public function getCpf(){
        return $this->cpf;
    }
    public function getData_nascimento() {
        return $this->data_nascimento;
    }
    /*SETTERS*/
    public function setNome($nome) {
        $this->nome = $nome;
    }
    public function setFoto_perfil($foto_perfil) {
        $this->foto_perfil = $foto_perfil;
    }
    public function setSobrenome($sobrenome) {
        $this->sobrenome = $sobrenome;
    }
    public function setCpf($cpf) {
        $this->cpf = $cpf;
    } 
    public function setData_nascimento($data_nascimento) {
        $this->data_nascimento = $data_nascimento;
    }
}

?>