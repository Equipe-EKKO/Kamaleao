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
