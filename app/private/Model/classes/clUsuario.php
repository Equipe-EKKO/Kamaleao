<?php
#requere as classes necessárias para o funcionamento (Conexão para fazer o CRUD e Participante para herdar da classe mãe)
require_once 'clParticipante.php';
require_once 'clPerfilProprio.php';
use PHPMailer\PHPMailer\PHPMailer;
use PerfilProprio;
//Subclasse de Participante cuja função é lidar com as funcionalidades CRUD da partição do usuário comum
class Usuario extends Participante {
    #Atributos
    public $nome, $perfil; // nome: string || perfil: classe perfil?
    private $sobrenome, $chavePix, $cdUpdate; // sobrenome: string
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
            header('Location /Github/Kamaleao/app/public/view/cadastro/cadastro.php'); # recarrega a pagina de cadastro, exibindo o erro, caso o resultado de verificaDados seja falso
            return false;
            
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
                $this->setEmail($email);
                $this->setSenha($senha);
                $stmt = $banco->prepare("SELECT l.nm_email, l.nm_username, us.cd_pix, us.im_foto_perfil, us.ds_usuario, us.nm_nome, us.nm_sobrenome, us.cd_cpf, us.dt_nascimento FROM tb_login AS l JOIN tb_usuario as us ON l.cd_login = us.cd_login WHERE l.nm_email = :email");
                /*Substitui os placeholders da query preparada*/
                $stmt->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
                 /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou e então, guardar esses resultados numa session que será usada em perfil/config perfil, além de instanciar uma nova classe para perfilProprio*/
                try {
                    $stmt->execute(); # tenta executar o select preparado
                    $resultados = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->setUsername($resultados['nm_username']);
                    if ($resultados['ds_usuario'] == "" || $resultados['ds_usuario'] == null) {
                        $sobre = "";
                    }else {
                        $sobre = $resultados['ds_usuario'];
                    }
                    $this->setNome($resultados['nm_nome']);
                    $this->setSobrenome($resultados['nm_sobrenome']);
                    $this->setCpf($resultados['cd_cpf']);
                    $this->setData_nascimento($resultados['dt_nascimento']);
                    $this->setChavePix($resultados['cd_pix']);
                    $this->setPerfil(new PerfilProprio($this->getUsername(), $sobre));
                    $_SESSION['userinfo'] = serialize($resultados);
                    /*Nova query de select*/
                    $stmt = $banco->prepare("SELECT l.cd_login FROM tb_login AS l JOIN tb_usuario as us ON l.cd_login = us.cd_login WHERE l.nm_email = :email");
                    /*Substitui os placeholders da query preparada*/
                    $stmt->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
                    /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou e então, guardar esses resultados numa session que será usada em perfil/config perfil, além de instanciar uma nova classe para perfilProprio*/
                    try {
                        $stmt->execute(); # tenta executar o select preparado
                        $this->setCdUpdate($stmt->fetchColumn());
                        return true; # seta o retorno da função como verdadeiro
                    } catch (\PDOException $e) {
                        exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                        return false;
                    }
                } catch (\PDOException $e) {
                    exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                    return false;
                }
                
            } else { #se o valor armazenado for diferente de 1...
                /*Retorna que não há nenhum usuário com essas credenciais cadastrado no sistema*/
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
    function recuperarSenha(string $email, string $novaSenha):bool {
        $banco = ConexaoBanco::abreConexao();
        $espstmt = $banco->prepare("SELECT cd_login FROM tb_login WHERE nm_email = :email AND ic_is_administrador = false"); # prepara um select que irá recuperar o cd_login (chave primária da tabela login), para que possa ser usado como referência no update
        $espstmt->bindValue(':email', $email); #substituiu o placeholder email pelo parametro
        /*Faz um try catch para tentar executar o select ou pegar o erro se der errado*/
        try {
            $espstmt->execute(); # executa o select
            $cd_login = $espstmt->fetchColumn(); # pega o primeiro resultado da primeira linha (o cd_login)
            if (!isset($cd_login) || empty($cd_login) || $cd_login == "" || $cd_login == null) { # condicional que verifica que se o select retornou, se não tiver retornado...
                echo "ERRO! Não há nenhuma conta registrada com o email inserido. <hr>"; #exibe o erro para o usuário
                return false;
            }
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
            return false;
        }
        $sql = "UPDATE tb_login SET nm_senha = :novaSenha WHERE cd_login = :cd_login";
        $stmt = $banco->prepare($sql);
        $stmt->bindValue(':novaSenha', $novaSenha);
        $stmt->bindValue('cd_login', $cd_login);

        try {
            $stmt->execute();
            return true;
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
            return false;
        }
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
            $_SESSION['erroemail'] = "Esse email já foi cadastrado no sistema. Tente outro."; # exibe ao usuário que o email escolhido já foi cadastrado.
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
                $_SESSION['errousername'] = "Esse username está em uso. Tente outro.";  # exibe ao usuário que o username escolhido já foi cadastrado.
                return false; # retorna a saída como falsa
            } else { # caso não...
                return true; # retorna a saída do método como verdadeira para que o processo de inserção prossiga
            }
        }
    }

    public function enviaEmailRecuperacao(string $endemail):bool {
        $this->setEmail($endemail); # seta o atributo email (da classe Usuario) com o valor recebido pelo parametro
        /*select pra ver se o email existe e ta cadastrado*/
        $banco = ConexaoBanco::abreConexao(); # chama a função estática da classe ConexaoBanco para abrir a conexão com o servidor MYSQL 
        $stmt = $banco->prepare("SELECT nm_email, ic_is_administrador FROM tb_login WHERE nm_email = :email AND ic_is_administrador = false"); # prepara para a execução um select que verificará se as informações inseridas correspondem com o que está registrado no database na categoria usuário (ic_is_administrador = falso)
        /*Substitui os placeholders da query preparada*/
        $stmt->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
        /*Try catch que tentará executar o select, registrar quantas linhas ele retornou e então, abrir uma estrutura de decisão para enviar o email ou não*/
        try {
            $stmt->execute(); # tenta executar o select preparado 
            $contaLinha = $stmt->rowCount();  # armazena numa variável o valor de quantas linhas existem no retorno desse select
            if ($contaLinha == 1 ) { # estrutura condicional que verifica se o valor retornado no select corresponde a apenas e somente 1, e se sim...
                /*código para realizar o email*/
                $email = new PHPMailer(); #instancia a Classe PHPMailer da Biblioteca
                /*Configurações para enviar o email corretamente*/
                $email->isSMTP(true); #define que o método vai ser usar um servidor SMTP
                $email->CharSet = 'UTF-8'; #define o charset como utf-8
                $email->setLanguage('pt-br', DIR_ROOT . '/GitHub/Kamaleao/vendor/phpmailer/phpmailer/language/phpmailer.lang-pt_br.php'); #seta a linguagem de erro como português
                $email->SMTPDebug = 2; # define que o debug só vai exibir mensagens
                $email->SMTPSecure = 'tls'; # define que o secure transfer está habilitado, função REQUIRED para SMTP GMail
                $email->SMTPAutoTLS = true; # define o tls como automático, para questões de segurança
                $email->Host = 'smtp.gmail.com'; #servidor host de SMTP que vai ser usado é o do google
                $email->Port = 587; # a porta de comunicação é 587 que precisa de configurações manuais
                $email->SMTPAuth = true; #autenticação de SMTP setada como true
                /*Informações de Login da Kamaleão*/
                $email->Username = 'kamaleaoctt@gmail.com';
                $email->Password = 'GabrielzinhoLindo1012';
                /*Configurações referentes ao envio do Email em si*/
                $email->setFrom($email->Username, 'Equipe Kamaleao'); # define o remetente como a Kamaleão
                $email->addAddress($endemail); #define o destinatário como a pessoa que pediu a redefinição
                $email->addReplyTo('naoresponda@kamaleao.com', 'Informa Kamaleão'); #adiciona um email inexistente chamado 'não responda', para que o destinatário entenda que é um processo automático
                $email->Subject = "Solicitação de Recuperação de Senha"; # define o assunto
                /*Corpo do Email a ser enviado que foi escrito com HTML e CSS*/
                $conteudo = "<div style='font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-align: justify;'>
                <h1>Olá, aqui é a Equipe Kamaleão!</h1>
                <h3>Fomos informados sobre uma solicitação de recuperação de senha.</h3>
            
                <p>Para cadastrar uma nova senha e poder desfrutar dos benefícios da plataforma, por favor, click no link abaixo para que você seja redirecionado.</p>
            
                <p style='padding-left: 25%;'><a href='http://localhost:80/Github/Kamaleao/app/public/View/pré_login/redef_senha/redef_senha.php' style='color:dodgerblue;'>Cadastrar nova senha.</a></p>
            
                <p><span style='color:rgb(241, 72, 53);'>ATENÇÃO: A solicitação possui um prazo de 15 minutos. Caso o tempo seja excedido, é necessário uma nova solicitação na plataforma.</span> <br>
                Caso você não tenha solicitado alteração de senha na Kamaleão recentemente, por favor, ignore este email.</p>
            
                <p style='font-style: italic;'>Atenciosamente, <br>
                    <span style='padding-left: 25px;'>A equipe Kamaleão </span></p>
                </div>";
                /*Fim do Corpo*/
                /*Configutações adicionais*/
                $email->Priority = 1; #prioridade 1 significa que é um email importante, para não cair no spam
                $email->Body = $conteudo; #define o corpo do email como o que foi digitado acima
                $email->isHTML(true); #define que o email terá um corpo escrito em html
                $email->AltBody = $email->html2text($conteudo); #tentativa de transformar o HTML em plain text para servidores de email que não leem HTML

                if (!$email->send()) { # estrutura condicional que verifica se o email foi enviado e se não...
                    $_SESSION["error"] = 'Houve um erro no envio: ' . $email->ErrorInfo; # exibe que houve um erro no envio, e concatena o erro oferecido pelo PHPMailer
                    header("Location: /Github/Kamaleao/app/public/view/pré_login/rec_senha/rec_senha.php"); #redireciona para a mesma página, mas exibindo a mensagem de erro.
                    return false; # seta o retorno da função como falso
                } else { #agora caso tenha sido enviado...
                    /* Espaço para que as váriaveis da sessão sejam armazenados */
                    if (!isset($_SESSION['tempo_sessao']) && !isset($_SESSION['emailinfo'])) {
                        $_SESSION['tempo_sessao'] = time(); # armazena o tempo em segundos desde 1970 até atualmente
                        $_SESSION['emailinfo'] = $endemail; # armazena o email inserido para que seja usado na redefinição
                    }
                    /*Fim sessão*/
                    return true; # retorna resultado positivo
                }
                /*finalização do código de email*/
            } else { #se o valor armazenado for diferente de 1...
                $_SESSION["error"] = 'O email inserido não pertence a nenhuma conta cadastrada no sistema.'; # exibe que o email não existe no banco de dados
                header("Location: /Github/Kamaleao/app/public/view/pré_login/rec_senha/rec_senha.php");
                return false; # seta o retorno da função como falso
            }
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
            return false; # seta o retorno da função como falso
        }
        /*finalização do select que foi iniciado para verificar os dados inseridos*/
    }

    #Métodos Especias - Getter e Setters para os atributos e Construct
    /* Construtor -- A função que é chamada automaticamente ao instanciar */
    public function __construct(string $nome, string $sobrenome, string $cpf, string $data_nascimento) { # declara que os dados a serem inseridos devem ser obrigatoriamente strings
        $this->setNome($nome); 
        $this->setSobrenome($sobrenome);
        $this->setCpf($cpf);
        $this->setData_nascimento($data_nascimento);
    }
    /* Destructor -- A função que é chamada automaticamente ao unset/set null um objeto desta classe */
    public function __destruct() {
        $this->setEmail("");
        $this->setCpf("");
        $this->setData_nascimento("");
        $this->setNome("");
        unset($this->perfil);
        $this->setSenha("");
        $this->setSobrenome("");
        $this->setUsername("");
    }
    /*GETTERS*/
    public function getNome(){
        return $this->nome;
    }
    public function getSobrenome(){
        return $this->sobrenome;
    }
    public function getPerfil() {
        return $this->perfil;
    }
    public function getCpf(){
        return $this->cpf;
    }
    public function getData_nascimento() {
        return $this->data_nascimento;
    }
    public function getChavePix() {
        return $this->chavePix;
    }
    public function getCdUpdate() {
        return $this->cdUpdate;
    }
    /*SETTERS*/
    public function setNome(string $nome) {
        $this->nome = $nome;
    }
    public function setPerfil(Perfil $perfil) {
        $this->perfil = $perfil;
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
    public function setChavePix($chavePix) {
        $this->chavePix = $chavePix;
    }
    public function setCdUpdate($cdupt) {
        $this->cdUpdate = $cdupt
    }
}

?>