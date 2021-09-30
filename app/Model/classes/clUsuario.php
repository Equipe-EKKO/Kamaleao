<?php
#requere as classes necessárias para o funcionamento (Conexão para fazer o CRUD e Participante para herdar da classe mãe)
require_once 'clConexaoBanco.php';
require_once 'clParticipante.php';
//Subclasse de Participante cuja função é lidar com as funcionalidades CRUD da partição do usuário comum
class Usuario extends Participante {
    #Atributos
    public $nome, $foto_perfil; // nome: string || foto_perfil: blob
    private $sobrenome; // sobrenome: string
    protected $cpf, $data_nascimento; //ambos tipo string

    #Métodos da classe abstrata sendo implementados
    //Método que irá realizar o cadastro do Usuário
    function cadastrarConta(string $email, string $username, string $senha):bool { #define que a saída (retorno) terá um tipo booleano
        /*Agrupamento dos valores a serem inseridos*/
        $nome = $this->getNome(); # pega o valor de nome setado no construct e insere ele numa variável
        $sobrenome = $this->getSobrenome(); # pega o valor de sobrenome setado no construct e insere ele numa variável
        $cpf = $this->getCpf(); # pega o valor de cpf setado no construct e insere ele numa variável
        $dataNasc = $this->getData_nascimento(); # pega o valor de data de nascimento setado no construct e insere ele numa variável
        $this->setEmail($email); # seta que o atributo email herdado da hiperclasse Participante recebe o mesmo valor do parametro passado quando a função for chamda
        $this->setUsername($username); # seta que o atributo username herdado da hiperclasse Participante recebe o mesmo valor do parametro passado quando a função for chamda
        $this->setSenha($senha); # seta que o atributo senha herdado da hiperclasse Participante recebe o mesmo valor do parametro passado quando a função for chamda

        $banco = ConexaoBanco::abreConexao(); # chama a função estática da classe ConexaoBanco para abrir a conexão com o servidor MYSQL 

        if ($this->verificaDados()) { #estrutura condicional que irá verificar se o retorno da função verificaDados é positiva, e se for...
            $sql = "INSERT INTO tb_login (nm_email, nm_username, nm_senha, ic_is_administrador) VALUES (:email, :username, :senha, false)"; # declara a query do insert na tabela login do banco de dados 
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/
            $stmt->bindValue(':email', $email); 
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':senha', $senha);

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt->execute(); # executa a query preparada anteriormente
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }

            $espstmt = $banco->prepare("SELECT cd_login FROM tb_login WHERE nm_email = :email"); # prepara um select que irá recuperar o cd_login (chave primária da tabela login) inserido anteriormente, para que possa ser usado no próximo insert (como chave estrangeira)
            $espstmt->bindValue(':email', $email); #substituiu o placeholder email pelo parametro
            /*Faz um try catch para tentar executar o select ou pegar o erro se der errado*/
            try {
                $espstmt->execute(); # executa o select
                $cd_login = $espstmt->fetchColumn(); # pega o primeiro resultado da primeira linha (o cd_login )
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }

            $sql2 = "INSERT INTO tb_usuario (nm_nome, nm_sobrenome, cd_cpf, dt_nascimento, cd_login) VALUES (:nome, :sobrenome, :cpf, :dtNasc, :cd_login)";  # declara a query do insert na tabela usuario do banco de dados, que só é feito após o insert na tabela login
            $stmt2 = $banco->prepare($sql2); # prepara a query com o insert para a execução
            /*Substitui os placeholders da query preparada*/
            $stmt2->bindValue(':nome', $nome);
            $stmt2->bindValue(':sobrenome', $sobrenome);
            $stmt2->bindValue(':cpf', $cpf);
            $stmt2->bindValue(':dtNasc', $dataNasc);
            $stmt2->bindValue(':cd_login', $cd_login);

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt2->execute(); # executa a query preparada anteriormente
                return true; # retorna true se o processo dos dois inserts forem verdadeiros
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
        } else {
            return false; #retorna falso caso o resultado de verificaDados seja false
            /*OBS::::: toda vez que há um erro, o retorno é falso*/
        }    
    }
    //Método que irá realizar o login do Usuário
    function logarConta(string $email, string $senha):bool { #define que a saída (retorno) terá um tipo booleano
        $banco = ConexaoBanco::abreConexao(); # chama a função estática da classe ConexaoBanco para abrir a conexão com o servidor MYSQL 
        $stmt = $banco->prepare("SELECT nm_email, nm_senha, ic_is_administrador FROM tb_login WHERE nm_email = :email AND nm_senha = :senha AND ic_is_administrador = false"); # prepara para a execução um select que verificará se as informações inseridas correspondem com o que está registrado no database na categoria usuário (ic_is_administrador = falso)
        /*Substitui os placeholders da query preparada*/
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':senha', $senha, PDO::PARAM_STR);
        /*Try catch que tentará executar o select, registrar quantas linhas ele retornou e então, abrir uma estrutura de decisão para logar ou não*/
        try {
            $stmt->execute(); # tenta executar o select preparado 
            $contaLinha = $stmt->rowCount();  # armazena numa variável o valor de quantas linhas existem no retorno desse select
            if ($contaLinha == 1 ) { # estrutura condicional que verifica se o valor retornado no select corresponde a apenas e somente 1, e se sim...
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
    function recuperarSenha(string $email, string $novaSenha) {

    }

    #Métodos da classe Usuario em si
    //Método cuja função é verificar os dados antes que sejam inseridos
    private function verificaDados():bool {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT nm_email, ic_is_administrador FROM tb_login WHERE nm_email = :email "; # declara query do select que irá verificar se o email escolhido já foi cadastrado anteriormente numa conta (tanto como usuário ou como administrador)
        $stmt = $banco->prepare($sql); # prepara o select para execuçãp
        $stmt->bindValue(':email', $this->getEmail()); #substitui o placeholder da query preparada

        /*Try catch que tentará executar o select e contar quantas linhas foram retornadas*/
        try {
            $stmt->execute(); # executa a query preparada 
            $contaLinha = $stmt->rowCount(); # armazena numa variável o valor de quantas linhas existem no retorno desse select
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }

        if ($contaLinha > 0) { # estrutura condicional que irá verificar se o valor de linhas do select anterior é maior que zero, ou seja, se o select retornou algo, e caso tenha retornado...
            echo "Esse email já foi cadastrado no sistema. Tente outro."; # exibe ao usuário que o email escolhido já foi cadastrado.
            return false; 
        } else { # caso não, prepara outro select para mais uma verificação
            $sql = "SELECT nm_username, ic_is_administrador FROM tb_login WHERE nm_username = :username "; # declara query do select que irá verificar se o username escolhido já foi cadastrado anteriormente numa conta (tanto como usuário ou como administrador)
            $stmt = $banco->prepare($sql); # prepara o select para execuçãp
            $stmt->bindValue(':username', $this->getUsername()); #substitui o placeholder da query preparada

            /*Try catch que tentará executar o select e contar quantas linhas foram retornadas*/
            try {
                $stmt->execute(); # executa a query preparada 
                $contaLinha = $stmt->rowCount(); # armazena numa variável o valor de quantas linhas existem no retorno desse select
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage());  # retorna erro, caso houver, e sai do script
                return false;
            }

            if ($contaLinha > 0) { # estrutura condicional que irá verificar se o valor de linhas do select anterior é maior que zero, ou seja, se o select retornou algo, e caso tenha retornado...
                echo "Esse username está em uso. Tente outro.";  # exibe ao usuário que o username escolhido já foi cadastrado.
                return false; # retorna a saída como falsa
            } else { # caso não...
                return true; # retorna a saída do método como verdadeira para que o processo de inserção prossiga
            }
        }
    }

    private function enviaConfirmacao()/*:bool*/ {

    }

    #Métodos Especias - Getter e Setters para os atributos e Construct
    /*Construtor*/
    public function __construct(string $nome, string $sobrenome, string $cpf, string $data_nascimento) {
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
    public function setNome(string $nome) {
        $this->nome = $nome;
    }
    public function setFoto_perfil($foto_perfil) {
        $this->foto_perfil = $foto_perfil;
    }
    public function setSobrenome(string $sobrenome) {
        $this->sobrenome = $sobrenome;
    }
    public function setCpf(string $cpf) {
        $this->cpf = $cpf;
    } 
    public function setData_nascimento(string $data_nascimento) {
        $this->data_nascimento = $data_nascimento;
    }
}

?>