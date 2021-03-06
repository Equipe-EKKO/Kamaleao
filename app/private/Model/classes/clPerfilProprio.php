<?php
ob_start();
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
#requere as classes necessárias para o funcionamento (Conexão para fazer o CRUD e Perfil para herdar da classe mãe)
require_once 'clPerfil.php';
require_once "autoloadClass.php";
use Cloudinary\Api\Upload\UploadApi;

//Subclasse de Perfil cuja função é lidar com as funcionalidades CRUD da partição do Perfil no sistema
class PerfilProprio extends Perfil {
    #Atributos
    private $inventario, $comissao; # inventario: instancia de classe || comissao: instancia de classe
    # Métodos da classe abstrata sendo implementados
    //Método que faz um select de todos os serviços que o dono do perfil já anunciou
    function listarServiços() {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT s.nm_serviço AS 'titulo', s.vl_serviço AS 'preço', img.cd_url_serviço as 'url_da_imagem',l.nm_username AS 'username' FROM `tb_serviço` AS s JOIN tb_usuario AS us ON us.cd_usuario = s.cd_usuario JOIN tb_login AS l ON l.cd_login = us.cd_login JOIN tb_imagem AS img ON s.cd_serviço = img.cd_serviço WHERE l.nm_username = :username"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara o select para execução
        $stmt->bindValue(':username', $this->getUsername());

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $rsltService = $stmt->fetchAll(PDO::FETCH_ASSOC);           
            $rsltStrService = serialize($rsltService); # transforma o array em string
            return $rsltStrService; # retorna a string
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        
    }
    //Método que faz um select de todos os pedidos feitos para o dono do perfil
    function listarComissoes(string $nmDono) {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT cd_usuario FROM tb_usuario AS us JOIN tb_login AS l ON l.cd_login = us.cd_login WHERE l.nm_username = :nmusername "; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara o select para execução
        $stmt->bindValue(':nmusername', $nmDono);

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $cdDono = $stmt->fetchColumn();           
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }

        $sql = "SELECT pe.cd_pedido AS 'idpedido', pe.vl_pedido AS 'valorpedido', date(pe.dt_criação) as 'datapedido', l.nm_username AS 'username', pe.ic_confirmado as 'indicadorconf', pe.ic_cancelado as 'indicadorcancel', pro.cd_url_produto AS 'url_produto', (SELECT statuspag.nm_status FROM tb_status_pagamento statuspag JOIN tb_pagamento pag ON statuspag.cd_status = pag.cd_status JOIN tb_produto prod ON prod.cd_produto = pag.cd_produto JOIN tb_pedido pe ON pe.cd_pedido = prod.cd_produto LIMIT 1) AS 'statuspag' FROM `tb_pedido` AS pe JOIN tb_usuario AS us ON us.cd_usuario = pe.cd_usuario JOIN tb_login AS l ON l.cd_login = us.cd_login JOIN `tb_serviço` AS s ON s.cd_serviço = pe.cd_serviço LEFT JOIN tb_produto AS pro ON pe.cd_pedido = pro.cd_pedido WHERE s.cd_usuario = :cdus"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara o select para execução
        $stmt->bindValue(':cdus', $cdDono);

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $rsltComissao = $stmt->fetchAll(PDO::FETCH_ASSOC);           
            $rsltStrComissao = serialize($rsltComissao); # transforma o array em string
            return $rsltStrComissao; # retorna a string
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        
    }

    //Método que faz um select de todos os pedidos feitos pelo dono do perfil
    function listarPedidosFeitos(string $nmDono) {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT cd_usuario FROM tb_usuario AS us JOIN tb_login AS l ON l.cd_login = us.cd_login WHERE l.nm_username = :nmusername "; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara o select para execução
        $stmt->bindValue(':nmusername', $nmDono);

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $cdDono = $stmt->fetchColumn();           
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }


        $sql = "SELECT pe.cd_pedido AS 'idpedido', pe.vl_pedido AS 'valorpedido', date(pe.dt_criação) as 'datapedido', (SELECT nm_username FROM tb_login JOIN tb_usuario ON tb_login.cd_login = tb_usuario.cd_login JOIN `tb_serviço` AS s ON s.cd_usuario = tb_usuario.cd_usuario WHERE s.cd_usuario != :cdus LIMIT 1) AS 'username', pe.ic_cancelado as 'indicadorcancel', pe.ic_confirmado as 'indicadorconf', pro.cd_url_produto AS 'url_produto', (SELECT statuspag.nm_status FROM tb_status_pagamento statuspag JOIN tb_pagamento pag ON statuspag.cd_status = pag.cd_status JOIN tb_produto prod ON prod.cd_produto = pag.cd_produto JOIN tb_pedido pe ON pe.cd_pedido = prod.cd_produto LIMIT 1) AS 'statuspag'  FROM `tb_pedido` AS pe JOIN tb_usuario AS us ON us.cd_usuario = pe.cd_usuario JOIN tb_login AS l ON l.cd_login = us.cd_login JOIN `tb_serviço` AS s ON s.cd_serviço = pe.cd_serviço LEFT JOIN tb_produto AS pro ON pe.cd_pedido = pro.cd_pedido WHERE pe.cd_usuario = :cdus"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara o select para execução
        $stmt->bindValue(':cdus', $cdDono);

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $rsltPedidoFeito = $stmt->fetchAll(PDO::FETCH_ASSOC);           
            $rsltStrPedidoFeito = serialize($rsltPedidoFeito); # transforma o array em string
            return $rsltStrPedidoFeito; # retorna a string
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        
    }

    #Métodos da Classe PerfilPróprio em Si
    function listarInventario(string $nmDono) {
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT cd_usuario FROM tb_usuario AS us JOIN tb_login AS l ON l.cd_login = us.cd_login WHERE l.nm_username = :nmusername "; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara o select para execução
        $stmt->bindValue(':nmusername', $nmDono);

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $cdDono = $stmt->fetchColumn();           
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }


        $sql = "SELECT pe.cd_pedido AS 'idpedido', (SELECT nm_username FROM tb_login JOIN tb_usuario ON tb_login.cd_login = tb_usuario.cd_login JOIN `tb_serviço` AS s ON s.cd_usuario = tb_usuario.cd_usuario WHERE s.cd_usuario != :cdus LIMIT 1) AS 'username', pro.cd_produto, pro.cd_url_produto AS 'url_produto', pro.nm_produto AS 'nome_produto',(SELECT statuspag.nm_status FROM tb_status_pagamento statuspag JOIN tb_pagamento pag ON statuspag.cd_status = pag.cd_status JOIN tb_produto prod ON prod.cd_produto = pag.cd_produto JOIN tb_pedido pe ON pe.cd_pedido = prod.cd_produto WHERE pag.cd_status = 2 AND pag.vl_pagamento IS NOT NULL LIMIT 1) AS 'statuspag'  FROM `tb_pedido` AS pe JOIN tb_usuario AS us ON us.cd_usuario = pe.cd_usuario JOIN tb_login AS l ON l.cd_login = us.cd_login JOIN `tb_serviço` AS s ON s.cd_serviço = pe.cd_serviço LEFT JOIN tb_produto AS pro ON pe.cd_pedido = pro.cd_pedido WHERE pe.cd_usuario = :cdus AND pro.cd_url_produto IS NOT NULL"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara o select para execução
        $stmt->bindValue(':cdus', $cdDono);

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $rsltPedidoFeito = $stmt->fetchAll(PDO::FETCH_ASSOC);           
            $rsltStrPedidoFeito = serialize($rsltPedidoFeito); # transforma o array em string
            return $rsltStrPedidoFeito; # retorna a string
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
    }
    function excluiFotoPerfil(string $username) {
        /* Pra ver se já existe uma foto de perfil prévia */
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático
        
        $sql0 = "SELECT cd_usuario FROM tb_login JOIN tb_usuario ON tb_login.cd_login = tb_usuario.cd_login WHERE nm_username = :nmuser"; # declara query do select que irá verificar se o titulo escolhido já foi cadastrado anteriormente pelo usuário da conta
        $stmt0 = $banco->prepare($sql0); # prepara o select para execuçãp
        $stmt0->bindValue(':nmuser', $username); #substitui o placeholder da query preparada
        
        /*Try catch que tentará executar o select e contar quantas linhas foram retornadas*/
        try {
            $stmt0->execute(); # executa a query preparada 
            $cd_usuario = $stmt0->fetchColumn();
        } catch (\PDOException $e) {
            exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }

        $sql = "SELECT cd_public_id FROM tb_foto_perfil WHERE cd_usuario = :cdus"; # declara query do select que irá verificar se o titulo escolhido já foi cadastrado anteriormente pelo usuário da conta
        $stmt = $banco->prepare($sql); # prepara o select para execuçãp
        $stmt->bindValue(':cdus', $cd_usuario); #substitui o placeholder da query preparada
        
        /*Try catch que tentará executar o select e contar quantas linhas foram retornadas*/
        try {
            $stmt->execute(); # executa a query preparada 
            $publicid = $stmt->fetchColumn();
        } catch (\PDOException $e) {
            exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        if ($publicid == null) {
            return true;
        }
        if((new UploadApi())->destroy($publicid)):
            $sql2 = "UPDATE tb_foto_perfil SET cd_url_perfil = null, cd_public_id = null WHERE cd_usuario = :cduser";  # declara a query do insert na tabela imagem do banco de dados, que só é feito após o insert na tabela serviço
            $stmt2 = $banco->prepare($sql2); # prepara a query com o insert para a execução
            /*Substitui os placeholders da query preparada*/
            $stmt2->bindValue(':cduser', $cd_usuario);

            /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
            try {
                $stmt2->execute(); # executa a query preparada anteriormente
                return true; # retorna true se o processo dos dois inserts forem verdadeiros
            } catch (\PDOException $e) {
                exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
                return false;
            }
        else:
            return false;
        endif;

    }
    function updateFotoPerfil(string $imgName, $cd_usuario, $extimagem, string $tmpImg):bool {
        /* Pra ver se já existe uma foto de perfil prévia */
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático
        
        $sql = "SELECT cd_public_id FROM tb_foto_perfil WHERE cd_usuario = :cdus"; # declara query do select que irá verificar se o titulo escolhido já foi cadastrado anteriormente pelo usuário da conta
        $stmt = $banco->prepare($sql); # prepara o select para execuçãp
        $stmt->bindValue(':cdus', $cd_usuario); #substitui o placeholder da query preparada
        
        /*Try catch que tentará executar o select e contar quantas linhas foram retornadas*/
        try {
            $stmt->execute(); # executa a query preparada 
            $contaLinha = $stmt->rowCount(); # armazena numa variável o valor de quantas linhas existem no retorno desse select
            $publicid = $stmt->fetchColumn();
        } catch (\PDOException $e) {
            exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }

        if (!empty($publicid)) {
            if((new UploadApi())->destroy($publicid)):
                $nmtemp = explode(" ", $imgName);
                $partnewname = strtolower(end($nmtemp)) . random_int(1, 999);
                $newname = $cd_usuario . "_profile_" . $partnewname . "." . $extimagem;
                $newfullpath = realpath(dirname(__FILE__, 2));
                if (move_uploaded_file($tmpImg, $newfullpath."/image/profile/" . $newname)) {
                    if ($objeto = (new UploadApi())->upload($newfullpath."/image/profile/" . $newname , ["folder" => "img_profile", "use_filename" => true, "unique_filename" => true, "overwrite" => false])){
                        $arrayResult = (array) $objeto;
                        if ($this->salvaFotoPerfil($cd_usuario, $arrayResult['url'], $arrayResult['public_id'])) {
                            $old = getcwd(); // Save the current directory
                            chdir($newfullpath."/image/profile/");
                            if (unlink($newname)) {
                                chdir($old); // Restore the old working directory
                                return true;
                            }else {
                                chdir($old); // Restore the old working directory
                                return false;
                            }
                        } else {
                            (new UploadApi())->destroy($arrayResult['public_id']);
                            $old = getcwd(); // Save the current directory
                            chdir($newfullpath."/image/profile/");
                            if (unlink($newname)) {
                                chdir($old); // Restore the old working directory
                                $resposta  = ob_get_flush();
                                ob_end_clean();
                                echo "Erro ao salvar o serviço no banco de dados. <br> " . $resposta;
                                return false;
                            }
                        }
                    } else {
                        $old = getcwd(); // Save the current directory
                        chdir($newfullpath."/image/profile/");
                        unlink($newname);
                        chdir($old); // Restore the old working directory
                        ob_end_clean();
                        echo "A imagem não pode ser salva no Cloudinary.";
                        return false;
                    }
                } else {
                    ob_end_clean();
                    echo "Problema em salvar a imagem (temporariamente) no servidor.";
                    return false;
                }
            else:
                return false;
            endif;
        } else {
            $nmtemp = explode(" ", $imgName);
            $partnewname = strtolower(end($nmtemp)) . random_int(1, 999);
            $newname = $cd_usuario . "_profile_" . $partnewname . "." . $extimagem;
            $newfullpath = realpath(dirname(__FILE__, 2));
            if (move_uploaded_file($tmpImg, $newfullpath."/image/profile/" . $newname)) {
                if ($objeto = (new UploadApi())->upload($newfullpath."/image/profile/" . $newname , ["folder" => "img_profile", "use_filename" => true, "unique_filename" => true, "overwrite" => false])){
                    $arrayResult = (array) $objeto;
                    if ($this->salvaFotoPerfil($cd_usuario, $arrayResult['url'], $arrayResult['public_id'])) {
                        $old = getcwd(); // Save the current directory
                        chdir($newfullpath."/image/profile/");
                        if (unlink($newname)) {
                            chdir($old); // Restore the old working directory
                            return true;
                        }else {
                            chdir($old); // Restore the old working directory
                            return false;
                        }
                    } else {
                        (new UploadApi())->destroy($arrayResult['public_id']);
                        $old = getcwd(); // Save the current directory
                        chdir($newfullpath."/image/profile/");
                        if (unlink($newname)) {
                            chdir($old); // Restore the old working directory
                            $resposta  = ob_get_flush();
                            ob_end_clean();
                            echo "Erro ao salvar o serviço no banco de dados. <br> " . $resposta;
                            return false;
                        }
                    }
                } else {
                    $old = getcwd(); // Save the current directory
                    chdir($newfullpath."/image/profile/");
                    unlink($newname);
                    chdir($old); // Restore the old working directory
                    ob_end_clean();
                    echo "A imagem não pode ser salva no Cloudinary.";
                    return false;
                }
            } else {
                ob_end_clean();
                echo "Problema em salvar a imagem (temporariamente) no servidor.";
                return false;
            }
        }
    }
    function updateDescricao(string $desc, int $cdUpdate) {
        /*Agrupamento dos valores a serem inseridos*/
        $this->setDescricao($desc);
        /*Conexão com o Banco*/
        $banco = ConexaoBanco::abreConexao(); # chama a função estática da classe ConexaoBanco para abrir a conexão com o servidor MYSQL

        $sql = "UPDATE tb_usuario SET ds_usuario = :descricao WHERE cd_login = :cdUpdate"; # declara a query do insert na tabela login do banco de dados 
        $stmt = $banco->prepare($sql); # prepara a query para execução
        /*Substitui os valores de cada placeholder na query preparada*/
        $stmt->bindValue(':descricao', $desc); 
        $stmt->bindValue(':cdUpdate', $cdUpdate);

        /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
        try {
            $stmt->execute(); # executa a query preparada anteriormente
            return true;
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
            return false;
        }
    }
    function criarServiço(string $nm_serviço, $cd_usuario, $extimagem, string $tmpImg):bool {
        $nmtemp = explode(" ", $nm_serviço);
        $partnewname = strtolower(end($nmtemp)) . random_int(1, 999);
        $newname = $cd_usuario . "_serv_" . $partnewname . "." .$extimagem;
        $newfullpath = realpath(dirname(__FILE__, 2));
        if (move_uploaded_file($tmpImg, $newfullpath."/image/service/" . $newname)) {
            if ($objeto = (new UploadApi())->upload($newfullpath."/image/service/" . $newname , ["folder" => "img_service", "use_filename" => true, "unique_filename" => true, "overwrite" => false])){
                $arrayResult = (array) $objeto;
                if ($this->serviço->salvaServiço($cd_usuario, $arrayResult['url'], $arrayResult['public_id'])) {
                    $old = getcwd(); // Save the current directory
                    chdir($newfullpath."/image/service/");
                    if (unlink($newname)) {
                        chdir($old); // Restore the old working directory
                        return true;
                    }else {
                        chdir($old); // Restore the old working directory
                        return false;
                    }
                } else {
                    (new UploadApi())->destroy($arrayResult['public_id']);
                    $old = getcwd(); // Save the current directory
                    chdir($newfullpath."/image/service/");
                    if (unlink($newname)) {
                        chdir($old); // Restore the old working directory
                        $resposta  = ob_get_flush();
                        ob_end_clean();
                        echo "Erro ao salvar o serviço no banco de dados. <br> " . $resposta;
                        return false;
                    }
                }
            } else {
                $old = getcwd(); // Save the current directory
                chdir($newfullpath."/image/service/");
                unlink($newname);
                chdir($old); // Restore the old working directory
                ob_end_clean();
                echo "A imagem não pode ser salva no Cloudinary.";
                return false;
            }    
        } else {
            ob_end_clean();
            echo "Problema em salvar a imagem (temporariamente) no servidor.";
            return false;
        }
    }
    function avaliarComissao() {

    }
    private function salvaFotoPerfil(string $cd_usuario, string $URLSerImg, string $publicid):bool {
        /*seta os valores dos parametros*/
        /*Conexão com o Banco*/
        $banco = ConexaoBanco::abreConexao(); # chama a função estática da classe ConexaoBanco para abrir a conexão com o servidor MYSQL
        $sql = "UPDATE tb_foto_perfil SET cd_url_perfil = :cdurlimg, cd_public_id = :publicid WHERE cd_usuario = :cduser";  # declara a query do insert na tabela imagem do banco de dados, que só é feito após o insert na tabela serviço
        $stmt = $banco->prepare($sql); # prepara a query com o insert para a execução
        /*Substitui os placeholders da query preparada*/
        $stmt->bindValue(':cdurlimg', $URLSerImg);
        $stmt->bindValue(':publicid', $publicid);
        $stmt->bindValue(':cduser', $cd_usuario);

        /*Faz um try catch que tentará executar o insert e se não der certo, irá capturar o erro*/
        try {
            $stmt->execute(); # executa a query preparada anteriormente
            return true; # retorna true se o processo dos dois inserts forem verdadeiros
        } catch (\PDOException $e) {
            exit("Houve um erro. #Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se houver um erro, sai do script e exibe o problema
            return false;
        }
    }

    #Métodos Especias - Getter e Setters para os atributos
    /* Construtor */
    public function __construct(string $user, string $desc) {
        $this->setUsername($user);
        $this->setFotoPerfil("");
        $this->setDescricao($desc);
    }
    /*GETTERS*/
    public function getServiço() {
        return $this->serviço;
    }
    public function getInventario() {
        return $this->inventario;
    }
    public function getComissao() {
        return $this->comissao;
    }
    /*SETTERS*/
    public function setServiço(Serviço $Serviço) {
        $this->serviço = $Serviço;
    }

    public function setInventario(/*Inventario*/ $inventario) {
        $this->inventario = $inventario;
    }

    public function setComissao(/*Comissao*/ $comissao) {
        $this->comissao = $comissao;
    }
}
