<?php
ob_start();
/* escrita por: Carolina Sena, no dia 29.11.2021*/
require_once 'clConexaoBanco.php'; # requere a classe ConexaoBanco usada nos filhos
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); # requere a Config usada nos filhos
use Cloudinary\Api\Upload\UploadApi;

//Classe cuja função é representar um ou mais objetos de Serviço
class Produto {
    #Atributos
    public $nmProduto, $URLProduto; # nmProduto: string || URLProduto: string com url de imagem
    private $cdProduto, $cdPedido; // cdProduto e cdPedido: inteiro

    public function salvaProduto(int $cd_pedido, $extimagem, string $tmpImg):bool {
        /* Aqui tem que puxar a nmproduto do banco */
        $nmtemp = explode(" ", $imgName);
        $partnewname = strtolower(end($nmtemp)) . random_int(1, 999);    
        $newname = $cd_pedido . "_product_" . $partnewname . "." . $extimagem;    
        $newfullpath = realpath(dirname(__FILE__, 2));
        if (move_uploaded_file($tmpImg, $newfullpath."/image/product/" . $newname)) {
            if ($objeto = (new UploadApi())->upload($newfullpath."/image/product/" . $newname , ["folder" => "img_product", "use_filename" => true, "unique_filename" => true, "overwrite" => false, "type" => "private"])) {
                $arrayResult = (array) $objeto;
                /*  if ($this->salvaFotoPerfil($cd_usuario, $arrayResult['url'], $arrayResult['public_id'])) {
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
                    }*/
            } else {    
                $old = getcwd(); // Save the current directory
                chdir($newfullpath."/image/product/");
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

    #Métodos Especias - Getter e Setters para os atributos
    /* Construtor */
    public function __construct(string $nmProduto, int $cdPedido) {
        $this->setNmProduto($nmProduto);
        $this->setCdPedido($cdPedido);
    }
    /*GETTERS*/
    public function getNmProduto() {
        return $this->nmProduto;
    }
    public function getURLProduto() {
        return $this->URLProduto;
    }
    public function getCdProduto() {
        return $this->cdProduto;
    }
    public function getCdPedido() {
        return $this->cdPedido;
    }
    /*SETTERS*/
    public function setNmProduto(string $nmProduto) {
        $this->nmProduto = $nmProduto;
    }
    public function setURLProduto(string $URLProduto) {
        $this->URLProduto = $URLProduto;
    }
    private function setCdProduto(int $cdProduto) {
        $this->cdProduto = $cdProduto;
    } 
    public function setCdPedido(int $cdPedido) {
        $this->cdPedido = $cdPedido;
    } 

}

?>