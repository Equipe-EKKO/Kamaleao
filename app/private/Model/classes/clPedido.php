<?php
ob_start();
/* escrita por: Carolina Sena, no dia 21.11.2021*/
require_once 'clConexaoBanco.php'; # requere a classe ConexaoBanco usada nos filhos
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); # requere a Config usada nos filhos

//Classe cuja função é representar um ou mais objetos de Serviço
class Pedido {
    #Atributos
    public $nmPedido, $dsPedido, $icCancelado, $vlPedido, $dsResposta; # nmServiço: string || dsServiço: string || imtmpServiço: string com url de imagem || tipoLicença: inteiro || vlServiço: float
    private $cdUsuario, $cdServiço; // cdDono e cdUsuario: inteiro

    public function salvaPedido(int $cd_serviço, string $username, string $titulo, string $desc, string $dtent):bool {
        /*seta os valores dos parametros*/
        $this->setNmPedido($titulo);
        $this->setDsPedido($desc);
        if ($this->verificaDados($cd_serviço, $username)) {
            /*Conexão com o Banco*/
            $banco = ConexaoBanco::abreConexao(); # chama a função estática da classe ConexaoBanco para abrir a conexão com o servidor MYSQL
            $sql = "INSERT INTO `tb_pedido` (`nm_pedido`, `ds_pedido`, `cd_serviço`, cd_usuario, dt_entrega) VALUES (:titulo, :descricao, :cdservico, :cdusuario, :dtent)"; # declara a query do insert na tabela serviço do banco de dados 
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/
            $stmt->bindValue(':titulo', $titulo); 
            $stmt->bindValue(':descricao', $desc);
            $stmt->bindValue(':cdservico', $cd_serviço);
            $stmt->bindValue(':cdusuario', $this->getCdUsuario());
            $stmt->bindValue(':dtent', $dtent);

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt->execute(); # executa a query preparada anteriormente
                return true; # retorna true se o processo dos dois inserts forem verdadeiros
            } catch (\PDOException $e) {
                exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
        } else {
            return false;
        }
        
    }

    public function negaPedido(int $cdpedido):bool {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT * FROM tb_pedido WHERE cd_pedido = :cd_ped"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':cd_ped', $cdpedido); 

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $contaped = $stmt->rowCount();
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        if ($contaped == 1) {
            $sql = "UPDATE tb_pedido SET ic_cancelado = 1 WHERE cd_pedido = :cdPed"; # declara a query do insert na tabela login do banco de dados 
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/ 
            $stmt->bindValue(':cdPed', $cdpedido);

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt->execute(); # executa a query preparada anteriormente
                return true;
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
        } else {
            return false;
        }
    }

    public function aceitaPedido(int $cdpedido, float $vlPedido):bool {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT * FROM tb_pedido WHERE cd_pedido = :cd_ped"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':cd_ped', $cdpedido); 

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $contaped = $stmt->rowCount();
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        if ($contaped == 1) {
            $sql = "UPDATE tb_pedido SET vl_pedido = :vlped WHERE cd_pedido = :cdPed"; # declara a query do insert na tabela login do banco de dados 
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/ 
            $stmt->bindValue(':cdPed', $cdpedido);
            $stmt->bindValue(':vlped', $vlPedido);

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt->execute(); # executa a query preparada anteriormente
                $this->setVlPedido($vlPedido);
                return true;
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
        } else {
            return false;
        }
    }

    public function aceitaValPedido(int $cdpedido, int $cdusuario)/*:bool*/ {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT * FROM tb_pedido WHERE cd_pedido = :cd_ped"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':cd_ped', $cdpedido); 

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada
            $pedinfo = $stmt->fetch(PDO::FETCH_ASSOC);
            $contaped = $stmt->rowCount();
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        if ($contaped == 1) {
            $sql = "UPDATE tb_pedido SET ic_confirmado = 1 WHERE cd_pedido = :cdPed"; # declara a query do insert na tabela login do banco de dados 
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/ 
            $stmt->bindValue(':cdPed', $cdpedido);

            /* SQL - Insert into Produto*/
            $sqlinsert = "INSERT INTO `tb_produto` (`nm_produto`, `cd_pedido`) VALUES (:nmped, :cdped)"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
            $stmtinsert = $banco->prepare($sqlinsert); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/
            $stmtinsert->bindValue(':nmped', $pedinfo['nm_pedido']);
            $stmtinsert->bindValue(':cdped', $pedinfo['cd_pedido']); 
            
            /* SQL - Select from Produto to use in Pagamento*/
            $sqls = "SELECT * FROM `tb_produto` WHERE cd_pedido = :cd_ped"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
            $stmts = $banco->prepare($sqls); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/
            $stmts->bindValue(':cd_ped', $pedinfo['cd_pedido']); 

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt->execute(); # executa a query preparada anteriormente
                $stmtinsert->execute(); # executa a query preparada anteriormente
                $stmts->execute(); # executa a query preparada anteriormente
                $prodinfo = $stmts->fetch(PDO::FETCH_ASSOC);

                /* SQL - Insert into Pagamento*/
                $sqlinsert2 = "INSERT INTO `tb_pagamento` (`cd_status`, `cd_produto`, `cd_usuario`, vl_pagamento) VALUES (1, :cdprod, :cduser, :vlpaga)"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
                $stmtinsert2 = $banco->prepare($sqlinsert2); # prepara a query para execução
                /*Substitui os valores de cada placeholder na query preparada*/
                $stmtinsert2->bindValue(':cdprod', $prodinfo['cd_produto']);
                $stmtinsert2->bindValue(':cduser', $cdusuario);
                $stmtinsert2->bindValue(':vlpaga', $pedinfo['vl_pedido']);
                
                $stmtinsert2->execute(); # executa a query preparada anteriormente
                return true;
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
        } else {
            return false;
        }
    }

    public function negaValPedido(int $cdpedido):bool {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT * FROM tb_pedido WHERE cd_pedido = :cd_ped"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':cd_ped', $cdpedido); 

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $contaped = $stmt->rowCount();
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        if ($contaped == 1) {
            $sql = "UPDATE tb_pedido SET ic_confirmado = 0, ic_cancelado = 1 WHERE cd_pedido = :cdPed"; # declara a query do insert na tabela login do banco de dados 
            $stmt = $banco->prepare($sql); # prepara a query para execução
            /*Substitui os valores de cada placeholder na query preparada*/ 
            $stmt->bindValue(':cdPed', $cdpedido);

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt->execute(); # executa a query preparada anteriormente
                return true;
            } catch (\PDOException $e) {
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
        } else {
            return false;
        }
    }

    public function cancelaPedidoAutomatic(int $cdusuario):bool {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT pe.cd_pedido AS 'cdped', date(pe.dt_criação) as 'datapedfeito' FROM `tb_pedido` AS pe JOIN tb_usuario AS us ON us.cd_usuario = pe.cd_usuario JOIN tb_login AS l ON l.cd_login = us.cd_login JOIN `tb_serviço` AS s ON s.cd_serviço = pe.cd_serviço WHERE s.cd_usuario != :cdus AND pe.cd_usuario = :cdus AND pe.ic_confirmado = 0 AND pe.vl_pedido != 0 AND pe.ic_cancelado = 0"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara o select para execução
        $stmt->bindValue(':cdus', $cdusuario);

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $rsltPedidoFeito = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $contaLinha = $stmt->rowCount(); # armazena numa variável o valor de quantas linhas existem no retorno desse select
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }

        if ($contaLinha >= 1) {
            foreach ($rsltPedidoFeito as $key => $value) {
                $dt_min = date('Y-m-d', strtotime($rsltPedidoFeito[$key]['datapedfeito'] . " +5 days"));
                if (strtotime($rsltPedidoFeito[$key]['datapedfeito']) > strtotime($dt_min)) {
                    $this->negaValPedido($rsltPedidoFeito[$key]['cdped']);
                    return true;
                } else {
                    return true;
                }
            }
        } else {
            return true;
        }
    }

    public function cancelaComissaoAutomatic(int $cdusuario):bool {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT pe.cd_pedido AS 'cdped', date(pe.dt_criação) as 'datapedfeito' FROM `tb_pedido` AS pe JOIN tb_usuario AS us ON us.cd_usuario = pe.cd_usuario JOIN tb_login AS l ON l.cd_login = us.cd_login JOIN `tb_serviço` AS s ON s.cd_serviço = pe.cd_serviço WHERE s.cd_usuario = :cdus AND pe.ic_cancelado = 0 AND pe.vl_pedido is null AND pe.ic_confirmado = 0"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara o select para execução
        $stmt->bindValue(':cdus', $cdusuario);

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $rsltPedidoFeito = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $contaLinha = $stmt->rowCount(); # armazena numa variável o valor de quantas linhas existem no retorno desse select
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }

        if ($contaLinha >= 1) {
            foreach ($rsltPedidoFeito as $key => $value) {
                $dt_min = date('Y-m-d', strtotime($rsltPedidoFeito[$key]['datapedfeito'] . " +5 days"));
                if (strtotime($rsltPedidoFeito[$key]['datapedfeito']) > strtotime($dt_min)) {
                    $this->negaPedido($rsltPedidoFeito[$key]['cdped']);
                    return true;
                } else {
                    return true;
                }
            }
        } else {
            return true;
        }
    }

    public function searchPedidoEsp(int $cdpedido):mixed {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT pe.nm_pedido as 'tituloped', pe.ds_pedido as 'descped', s.nm_serviço as 'tituloserv', pe.vl_pedido as 'valorpedido', pe.ic_cancelado as 'indicadorcancel', pe.ic_confirmado as 'indicadorconf', l.nm_email as 'emailuser' FROM tb_serviço AS s JOIN tb_pedido AS pe ON s.cd_serviço = pe.cd_serviço JOIN tb_usuario AS us ON us.cd_usuario = s.cd_usuario JOIN tb_login AS l ON l.cd_login = us.cd_login WHERE pe.cd_pedido = :cdped"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':cdped', $cdpedido); 

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $resultados = $stmt->fetch(PDO::FETCH_ASSOC);         
            $resultstr = serialize($resultados); # transforma o array em string
            return $resultstr; # retorna a string
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
    }

    public function searchPedidoStatus(int $cdpedido, string $usernm):mixed {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql1 = "SELECT pe.nm_pedido as 'tituloped', pe.vl_pedido as 'valorpedido' FROM tb_pedido AS pe WHERE pe.cd_pedido = :cdped"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt1 = $banco->prepare($sql1); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt1->bindValue(':cdped', $cdpedido); 

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            
            $stmt1->execute(); # executa a query preparada 
            $resultados1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            if (isset($resultados1)) {
                $resposta1 = true;
            } else {
                $resposta1 = false;
            }
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }

        if ($resposta1) {
            $sql2 = "SELECT tb_login.nm_email FROM tb_usuario JOIN tb_login ON tb_login.cd_login = tb_usuario.cd_login WHERE nm_username = :nmuser"; # declara query do select que irá verificar se o username solicitante existe
            $stmt2 = $banco->prepare($sql2); # prepara o select para execuçãp
            $stmt2->bindValue(':nmuser', $usernm); #substitui o placeholder da query preparada

            /*Try catch que tentará executar o select e contar quantas linhas foram retornadas*/
            try {
                $stmt2->execute(); # executa a query preparada 
                $useremail = $stmt2->fetchColumn();
                $resultados = array(
                    "tituloped" => $resultados1['tituloped'],
                    "valorpedido" => $resultados1['valorpedido'],
                    "emailuser" => $useremail,
                );
                $resultstr = serialize($resultados); # transforma o array em string
                return $resultstr; # retorna a string
            } catch (\PDOException $e) {
                exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage());  # retorna erro, caso houver, e sai do script
                return false;
            }
        }
    }

    private function verificaDados(int $cdserv, string $username):bool {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático
        
        $sql = "SELECT `cd_serviço` FROM `tb_serviço` WHERE `cd_serviço` = :cdserv"; # declara query do select que irá verificar se o serviço existe
        $stmt = $banco->prepare($sql); # prepara o select para execuçãp
        $stmt->bindValue(':cdserv', $cdserv); #substitui o placeholder da query preparada
        
        /*Try catch que tentará executar o select e contar quantas linhas foram retornadas*/
        try {
            $stmt->execute(); # executa a query preparada 
            $contaLinha = $stmt->rowCount(); # armazena numa variável o valor de quantas linhas existem no retorno desse select
        } catch (\PDOException $e) {
            exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        
        if ($contaLinha === 1) { # estrutura condicional que irá verificar se o valor de linhas do select anterior é igual a um, ou seja, se o select retorna que o serviço existe, e caso tenha retornado...
            $this->setCdServiço($cdserv);
            $sql2 = "SELECT cd_usuario FROM tb_usuario JOIN tb_login ON tb_login.cd_login = tb_usuario.cd_login WHERE nm_username = :nmuser"; # declara query do select que irá verificar se o username solicitante existe
            $stmt2 = $banco->prepare($sql2); # prepara o select para execuçãp
            $stmt2->bindValue(':nmuser', $username); #substitui o placeholder da query preparada

            /*Try catch que tentará executar o select e contar quantas linhas foram retornadas*/
            try {
                $stmt2->execute(); # executa a query preparada 
                $contaLinha2 = $stmt2->rowCount(); # armazena numa variável o valor de quantas linhas existem no retorno desse select
                $cduser = $stmt2->fetchColumn();
            } catch (\PDOException $e) {
                exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage());  # retorna erro, caso houver, e sai do script
                return false;
            }

            if ($contaLinha2 === 1) { # estrutura condicional que irá verificar se o valor de linhas do select anterior é igual a 1, ou seja, se o select retornou algo, e caso tenha retornado...
                $this->setCdUsuario($cduser);
                return true;
            } else {
                ob_end_clean();
                echo "Houve um erro na seleção do usuário solicitante. Tente novamente.";  # exibe ao usuário que o username escolhido já foi cadastrado.
                return false; # retorna a saída como falsa
            }
        } else { # caso não, retorna erro
            ob_end_clean();
            echo "Houve um erro na seleção do serviço relacionado ao pedido solicitado. Tente novamente.";  # exibe ao usuário que o username escolhido já foi cadastrado.
            return false; # retorna a saída como falsa
        }
    }
    #Métodos Especias - Getter e Setters para os atributos
    /*GETTERS*/
    public function getNmPedido() {
        return $this->nmPedido;
    }
    public function getDsPedido() {
        return $this->dsPedido;
    }
    public function getIcCancelado() {
        return $this->icCancelado;
    }
    public function getVlPedido() {
        return $this->vlPedido;
    }
    public function getDsResposta() {
        return $this->dsResposta;
    }
    public function getCdUsuario() {
        return $this->cdUsuario;
    }
    public function getCdServiço() {
        return $this->cdServiço;
    }
    //*SETTERS*/
    public function setNmPedido(string $nmPedido) {
        $this->nmPedido = $nmPedido;
    }
    public function setDsPedido(string $dsPedido) {
        $this->dsPedido = $dsPedido;
    }
    
    private function setCdServiço($cdServiço) {
        $this->cdServiço = $cdServiço;
    } 
    public function setIcCancelado($icCancelado) {
        $this->icCancelado = $icCancelado;
    } 
    public function setVlPedido($vlPedido) {
        $this->vlPedido = $vlPedido;
    }
    public function setDsResposta($dsResposta) {
        $this->dsResposta = $dsResposta;
    } 
    public function setCdUsuario($cdUsuario) {
        $this->cdUsuario = $cdUsuario;
    }
}

?>