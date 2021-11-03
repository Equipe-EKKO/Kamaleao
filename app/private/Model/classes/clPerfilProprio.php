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
    /*public $listServiço;*/
    private $inventario, $comissao; # inventario: instancia de classe || comissao: instancia de classe
    //Métodos da classe abstrata sendo implementados
    function listarServiço() {
        
    }

    #Métodos da Classe PerfilPróprio em Si
    function baixarInventario() {

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
    function criarServiço(string $nm_serviço, $cd_usuario, $extimagem, string $tmpImg)/*:bool*/ {
        $nmtemp = explode(" ", $nm_serviço);
        $partnewname = strtolower(end($nmtemp)) . random_int(1, 999);
        $newname = $cd_usuario . "_serv_" . $partnewname . "." .$extimagem;
        $newfullpath = realpath(dirname(__FILE__, 2));
        if (move_uploaded_file($tmpImg, $newfullpath."/image/service/" . $newname)) {
            if ($objeto = (new UploadApi())->upload($newfullpath."/image/service/" . $newname , ["folder" => "img_service", "use_filename" => true, "unique_filename" => true, "overwrite" => false])){
                $arrayResult = (array) $objeto;
                if ($this->serviço->salvaServiço($cd_usuario, $arrayResult['url'])) {
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
    function excluirServiço() {

    }
    function avaliarComissao() {

    }

    #Métodos Especias - Getter e Setters para os atributos
    /* Construtor */
    public function __construct(string $user, string $desc) {
        $this->setUsername($user);
        $this->setFotoPerfil(null);
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
