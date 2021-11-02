<?php
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
#requere as classes necessárias para o funcionamento (Conexão para fazer o CRUD e Perfil para herdar da classe mãe)
require_once 'clPerfil.php';
use Cloudinary\Api\Upload\UploadApi;
use serviço;

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
    function criarServiço(string $nm_serviço, $cd_usuario, $extimagem, string $tmpImg):bool {
        $nmtemp = explode(" ", $nm_serviço);
        $partnewname = end($nmtemp);
        $newname = $cd_usuario . "_serv_" . $partnewname . $extimagem;
        if (move_uploaded_file($tmpImg, "/image/service/" . $newname)) {
            if ($objeto = (new UploadApi())->upload("/image/service/" . $newname , ["folder" => "img_service", "use_filename" => true, "unique_filename" => true, "overwrite" => false])){
                $arrayResult = (array) $objeto;
                if ($this->serviço->salvaServiço($cd_usuario, $arrayResult['url'])) {
                    fclose("/image/service/" . $newname);
                    $old = getcwd(); // Save the current directory
                    chdir("/image/service/");
                    unlink($newname);
                    chdir($old); // Restore the old working directory
                    return true;
                } else {
                    echo "Houve um problema em salvar o serviço no banco de dados. <br>";
                    return false;
                }
            } else {
                echo "A imagem não pode ser salva no Cloudinary.";
                return false;
            }    
        } else {
            echo "Problema em salvar a imagem (temporariamente) no servidor";
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
        /*foreach ($this->Serviço as $key => $Serviço) {
            return $Serviço[$key];
        }*/
        
    }
    public function getInventario() {
        return $this->inventario;
    }
    public function getComissao() {
        return $this->comissao;
    }
    /*SETTERS*/
    public function setServiço(Serviço $Serviço) {
        $this->Serviço = $Serviço;
    }

    public function setInventario(/*Inventario*/ $inventario) {
        $this->inventario = $inventario;
    }

    public function setComissao(/*Comissao*/ $comissao) {
        $this->comissao = $comissao;
    }
}
