<?php
ob_start();
/* escrita por: Carolina Sena, no dia 13.10.2021*/
require_once 'clConexaoBanco.php'; # requere a classe ConexaoBanco usada nos filhos
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); # requere a Config usada nos filhos
use Cloudinary\Api\Upload\UploadApi;

//Classe cuja função é representar um ou mais objetos de Serviço
class Serviço {
    #Atributos
    public $nmServiço, $dsServiço, $URLServiço, $vlServiço, $tipoLicença, $cdCategoria; # nmServiço: string || dsServiço: string || imtmpServiço: string com url de imagem || tipoLicença: inteiro || vlServiço: float
    private $cdDono, $cdServiço; // cdDono: inteiro

    function salvaServiço(string $cd_usuario, string $URLSerImg, string $publicid):bool {
        /*seta os valores dos parametros*/
        $this->setURLServiço($URLSerImg);
        $this->setCdDono($cd_usuario);
        /* recupera os outros possíveis valores */
        $titulo = $this->getNmServiço();
        $desc = $this->getDsServiço();
        $urlimg = $this->getURLServiço();
        $valor = $this->getVlServiço();
        $tipo = $this->getTipoLicença();
        $cat = $this->getCdCategoria();
        $cdus = $this->getCdDono();
        if ($this->verificaDados()) {
            /*Conexão com o Banco*/
            $banco = ConexaoBanco::abreConexao(); # chama a função estática da classe ConexaoBanco para abrir a conexão com o servidor MYSQL
            $sql = "INSERT INTO `tb_serviço` (`nm_serviço`, `ds_serviço`, `vl_serviço`, cd_usuario, cd_categoria, `cd_licença`) VALUES (:titulo, :descricao, :valor, :cdusuario, :cdcategoria, :cdlicenca)"; # declara a query do insert na tabela serviço do banco de dados 
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/
            $stmt->bindValue(':titulo', $titulo); 
            $stmt->bindValue(':descricao', $desc);
            $stmt->bindValue(':valor', $valor);
            $stmt->bindValue(':cdusuario', $cdus);
            $stmt->bindValue(':cdcategoria', $cat);
            $stmt->bindValue(':cdlicenca', $tipo);

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt->execute(); # executa a query preparada anteriormente
                goto segA;
            } catch (\PDOException $e) {
                exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
            segA:
            $espstmt = $banco->prepare("SELECT `cd_serviço` FROM `tb_serviço` WHERE `nm_serviço` = :titulo AND cd_usuario = :cdusuario"); # prepara um select que irá recuperar o cd_serviço (chave primária da tabela serviço) inserido anteriormente, para que possa ser usado no próximo insert (como chave estrangeira)
            $espstmt->bindValue(':titulo', $titulo); #substituiu o placeholder titulo pelo parametro
            $espstmt->bindValue(':cdusuario', $cdus); #substituiu o placeholder cdusuario pelo parametro
            /*Faz um try catch para tentar executar o select ou pegar o erro se der errado*/
            try {
                $espstmt->execute(); # executa o select
                $this->setCdServiço($espstmt->fetchColumn()); # pega o primeiro resultado da primeira linha (o cd_serviço )
                goto segB;
            } catch (\PDOException $e) {
                exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
            segB:
            $sql2 = "INSERT INTO tb_imagem (`cd_url_serviço`, cd_public_id,`cd_serviço`) VALUES (:cdurlimg,  :publicid, :cdserv)";  # declara a query do insert na tabela imagem do banco de dados, que só é feito após o insert na tabela serviço
            $stmt2 = $banco->prepare($sql2); # prepara a query com o insert para a execução
            /*Substitui os placeholders da query preparada*/
            $stmt2->bindValue(':cdurlimg', $urlimg);
            $stmt2->bindValue(':publicid', $publicid);
            $stmt2->bindValue(':cdserv', $this->getCdServiço());

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt2->execute(); # executa a query preparada anteriormente
                return true; # retorna true se o processo dos dois inserts forem verdadeiros
            } catch (\PDOException $e) {
                exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
            
        } else {
            return false;
        }
        
    }
    function excluiServiço(int $cdServiço) {
        $this->setNmServiço("");
        $this->setDsServiço("");
        $this->setVlServiço(0);
        $this->setTipoLicença(0);
        $this->setCdCategoria(0);
        $this->setCdServiço($cdServiço);

        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT cd_public_id FROM tb_imagem WHERE cd_serviço = :cd_serv"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':cd_serv', $cdServiço); 

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $publicid = $stmt->fetchColumn();
            if((new UploadApi())->destroy($publicid)):
                $result1 = true;
            else:
                $result1 = false;
            endif;
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        if ($result1) {
            $sql = "DELETE FROM tb_imagem WHERE cd_serviço = :cd_serv"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/
            $stmt->bindValue(':cd_serv', $cdServiço); 

            /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
            try { 
                if($stmt->execute()): # executa a query (delete tabela de imagem) preparada e ve o resultado
                    $result2 = true;
                else:
                    $result2 = false;
                endif;
            } catch (\PDOException $e) {
                $result2 = false;
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
                return false;
            }
            if ($result2 == true) {
                $sql = "DELETE FROM tb_serviço WHERE cd_serviço = :cd_serv"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
                $stmt = $banco->prepare($sql); # prepara a query para execução
                /*Substitui os valores de cada placeholder na query preparada*/
                $stmt->bindValue(':cd_serv', $cdServiço); 
    
                /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
                try { 
                    if($stmt->execute()): # executa a query (delete tabela de imagem) preparada e ve o resultado
                        $result3 = true;
                    else:
                        $result3 = false;
                    endif;
                } catch (\PDOException $e) {
                    $result3 = false;
                    exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
                    return false;
                }
                if ($result3) {
                    //echo true;
                    return true;
                }else {
                    //echo false;
                    return false;
                }
            } else {
                //echo false;
                return false;
            }
        } else {
            //echo false;
            return false;
        }
    }
    public function editaServiçoTitulo(string $newtitulo, int $cdServiço):mixed {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT * FROM tb_serviço WHERE cd_serviço = :cd_serv"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':cd_serv', $cdServiço); 

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $contaserv = $stmt->rowCount();
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        if ($contaserv == 1) {
            $sql = "UPDATE tb_serviço SET nm_serviço = :titulo WHERE cd_serviço = :cdServ"; # declara a query do insert na tabela login do banco de dados 
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/
            $stmt->bindValue(':titulo', $newtitulo); 
            $stmt->bindValue(':cdServ', $cdServiço);

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt->execute(); # executa a query preparada anteriormente
                return true;
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
        } else {
            return "Esse serviço não existe";
        }
        
    }

    public function editaServiçoPreço(float $newpreço, int $cdServiço):mixed {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT * FROM tb_serviço WHERE cd_serviço = :cd_serv"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':cd_serv', $cdServiço); 

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $contaserv = $stmt->rowCount();
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        if ($contaserv == 1) {
            $sql = "UPDATE tb_serviço SET vl_serviço = :valor WHERE cd_serviço = :cdServ"; # declara a query do insert na tabela login do banco de dados 
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/
            $stmt->bindValue(':valor', $newpreço); 
            $stmt->bindValue(':cdServ', $cdServiço);

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt->execute(); # executa a query preparada anteriormente
                return true;
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
        } else {
            return "Esse serviço não existe";
        }
        
    }

    public function editaServiçoDesc(string $newdesc, int $cdServiço):mixed {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT * FROM tb_serviço WHERE cd_serviço = :cd_serv"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':cd_serv', $cdServiço); 

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $contaserv = $stmt->rowCount();
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        if ($contaserv == 1) {
            $sql = "UPDATE tb_serviço SET ds_serviço = :descri WHERE cd_serviço = :cdServ"; # declara a query do insert na tabela login do banco de dados 
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/
            $stmt->bindValue(':descri', $newdesc); 
            $stmt->bindValue(':cdServ', $cdServiço);

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt->execute(); # executa a query preparada anteriormente
                return true;
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
        } else {
            return "Esse serviço não existe";
        }
        
    }

    public function editaServiçoLic(string $newlic, int $cdServiço):mixed {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT * FROM tb_serviço WHERE cd_serviço = :cd_serv"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':cd_serv', $cdServiço); 

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $contaserv = $stmt->rowCount();
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        if ($contaserv == 1) {
            $sql = "UPDATE tb_serviço SET cd_licença = :lic WHERE cd_serviço = :cdServ"; # declara a query do insert na tabela login do banco de dados 
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/
            $stmt->bindValue(':lic', $newlic); 
            $stmt->bindValue(':cdServ', $cdServiço);

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt->execute(); # executa a query preparada anteriormente
                return true;
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
        } else {
            return "Esse serviço não existe";
        }
        
    }
    
    public function editaServiçoCategoria(string $newcat, int $cdServiço):mixed {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT * FROM tb_serviço WHERE cd_serviço = :cd_serv"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':cd_serv', $cdServiço); 

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $contaserv = $stmt->rowCount();
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        if ($contaserv == 1) {
            $sql = "UPDATE tb_serviço SET cd_categoria = :cate WHERE cd_serviço = :cdServ"; # declara a query do insert na tabela login do banco de dados 
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/
            $stmt->bindValue(':cate', $newcat); 
            $stmt->bindValue(':cdServ', $cdServiço);

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt->execute(); # executa a query preparada anteriormente
                return true;
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
        } else {
            return "Esse serviço não existe";
        }
        
    }

    private function verificaDados():bool {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático
        
        $sql = "SELECT `nm_serviço` FROM `tb_serviço` WHERE `nm_serviço` = :nmtitulo AND cd_usuario = :cdus"; # declara query do select que irá verificar se o titulo escolhido já foi cadastrado anteriormente pelo usuário da conta
        $stmt = $banco->prepare($sql); # prepara o select para execuçãp
        $stmt->bindValue(':nmtitulo', $this->getNmServiço()); #substitui o placeholder da query preparada
        $stmt->bindValue(':cdus', $this->getCdDono()); #substitui o placeholder da query preparada
        
        /*Try catch que tentará executar o select e contar quantas linhas foram retornadas*/
        try {
            $stmt->execute(); # executa a query preparada 
            $contaLinha = $stmt->rowCount(); # armazena numa variável o valor de quantas linhas existem no retorno desse select
        } catch (\PDOException $e) {
            exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        
        if ($contaLinha > 0) { # estrutura condicional que irá verificar se o valor de linhas do select anterior é maior que zero, ou seja, se o select retornou algo, e caso tenha retornado...
            ob_end_clean();
            echo "Esse título já foi cadastrado por você previamente. Tente outro."; # exibe ao usuário que o email escolhido já foi cadastrado.
            return false; 
        } else { # caso não, prepara outro select para mais uma verificação
            $sql = "SELECT cd_categoria FROM tb_categoria WHERE cd_categoria = :cdcat "; # declara query do select que irá verificar se o username escolhido já foi cadastrado anteriormente numa conta (tanto como usuário ou como administrador)
            $stmt = $banco->prepare($sql); # prepara o select para execuçãp
            $stmt->bindValue(':cdcat', $this->getCdCategoria()); #substitui o placeholder da query preparada

            /*Try catch que tentará executar o select e contar quantas linhas foram retornadas*/
            try {
                $stmt->execute(); # executa a query preparada 
                $contaLinha = $stmt->rowCount(); # armazena numa variável o valor de quantas linhas existem no retorno desse select
            } catch (\PDOException $e) {
                exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage());  # retorna erro, caso houver, e sai do script
                return false;
            }

            if ($contaLinha != 1) { # estrutura condicional que irá verificar se o valor de linhas do select anterior é maior que zero, ou seja, se o select retornou algo, e caso tenha retornado...
                ob_end_clean();
                echo "Houve um erro na seleção da categoria. Tente novamente.";  # exibe ao usuário que o username escolhido já foi cadastrado.
                return false; # retorna a saída como falsa
            } else { # caso não...
                $sql = "SELECT `cd_licença` FROM `tb_tipos_licença` WHERE `cd_licença` = :cdlic "; # declara query do select que irá verificar se o username escolhido já foi cadastrado anteriormente numa conta (tanto como usuário ou como administrador)
                $stmt = $banco->prepare($sql); # prepara o select para execuçãp
                $stmt->bindValue(':cdlic', $this->getTipoLicença()); #substitui o placeholder da query preparada

                /*Try catch que tentará executar o select e contar quantas linhas foram retornadas*/
                try {
                    $stmt->execute(); # executa a query preparada 
                    $contaLinha = $stmt->rowCount(); # armazena numa variável o valor de quantas linhas existem no retorno desse select
                } catch (\PDOException $e) {
                    exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage());  # retorna erro, caso houver, e sai do script
                    return false;
                }

                if ($contaLinha != 1) { # estrutura condicional que irá verificar se o valor de linhas do select anterior é maior que zero, ou seja, se o select retornou algo, e caso tenha retornado...
                    ob_end_clean();
                    echo "Houve um erro na seleção da licença. Tente novamente.";  # exibe ao usuário que o username escolhido já foi cadastrado.
                    return false; # retorna a saída como falsa
                } else {
                    return true; # retorna a saída do método como verdadeira para que o processo de inserção prossiga
                }
            }
        }
    }

    #Métodos Especias - Getter e Setters para os atributos
    /* Construtor */
    public function __construct(string $nmServiço, string $dsServiço, float $vlServiço, int $tipoLicença, int $cdCategoria) {
        $this->setNmServiço($nmServiço);
        $this->setDsServiço($dsServiço);
        $this->setVlServiço($vlServiço);
        $this->setTipoLicença($tipoLicença);
        $this->setCdCategoria($cdCategoria);
    }
    /*GETTERS*/
    public function getNmServiço() {
        return $this->nmServiço;
    }
    public function getDsServiço() {
        return $this->dsServiço;
    }
    public function getURLServiço() {
        return $this->URLServiço;
    }
    public function getTipoLicença() {
        return $this->tipoLicença;
    }
    public function getVlServiço() {
        return $this->vlServiço;
    }
    public function getCdCategoria() {
        return $this->cdCategoria;
    }
    public function getCdDono() {
        return $this->cdDono;
    }
    public function getCdServiço() {
        return $this->cdServiço;
    }
    //*SETTERS*/
    public function setNmServiço(string $nmServiço) {
        $this->nmServiço = $nmServiço;
    }
    public function setDsServiço(string $dsServiço) {
        $this->dsServiço = $dsServiço;
    }
    public function setURLServiço($URLServiço) /*tipo: caminho do file*/ {
        $this->URLServiço = $URLServiço;
    }
    public function setTipoLicença(int $tipoLicença) {
        $this->tipoLicença = $tipoLicença;
    }
    public function setVlServiço(float $vlServiço) {
        $this->vlServiço = $vlServiço;
    }
    public function setCdCategoria(int $CdCategoria) {
        $this->cdCategoria = $CdCategoria;
    }
    private function setCdDono($cdDono){
        $this->cdDono = $cdDono;
    }
    private function setCdServiço($cdServiço){
        $this->cdServiço = $cdServiço;
    } 
    
}

?>