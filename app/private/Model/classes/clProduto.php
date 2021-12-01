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
        $banco = ConexaoBanco::abreConexao(); # faz a conexão com o banco de dados através do método estático

        $sql = "SELECT nm_produto FROM `tb_produto` WHERE cd_pedido = :cdped"; # declara query do select que irá retornar todos os valores da tabela categoria divididos nas colunas id e nome da categoria
        $stmt = $banco->prepare($sql); # prepara o select para execução
        $stmt->bindValue(':cdped', $cd_pedido);

        /*Try catch que tentará executar o select, guardar num array associado (associa o nome das colunas com os resultados) que o select retornou*/
        try {
            $stmt->execute(); # executa a query preparada 
            $nm_produto = $stmt->fetchColumn();
        } catch (\PDOException $e) {
            exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); # retorna erro, caso houver, e sai do script
            return false;
        }
        /* Aqui tem que puxar a nmproduto do banco */
        $nmtemp = explode(" ", $nm_produto);
        $partnewname = strtolower(end($nmtemp)) . random_int(1, 999);    
        $newname = $cd_pedido . "_product_" . $partnewname . "." . $extimagem;    
        $newfullpath = realpath(dirname(__FILE__, 2));
        if (move_uploaded_file($tmpImg, $newfullpath."/image/product/" . $newname)) {
            if ($objeto = (new UploadApi())->upload($newfullpath."/image/product/" . $newname , ["folder" => "img_product", "use_filename" => true, "unique_filename" => true, "overwrite" => false, "type" => "private"])) {
                $arrayResult = (array) $objeto;
                if ($this->entregaProduto($cd_pedido, $arrayResult['url'], $arrayResult['public_id'])) {
                    $old = getcwd(); // Save the current directory
                    chdir($newfullpath."/image/product/");
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
                    chdir($newfullpath."/image/product/");
                    if (unlink($newname)) {
                        chdir($old); // Restore the old working directory
                        $resposta  = ob_get_flush();
                        ob_end_clean();
                        echo "Erro ao salvar o produto no banco de dados. <br> " . $resposta;
                        return false;
                    }
                }
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

    private function entregaProduto(string $cd_pedido, string $URLProdImg, string $publicid):bool {
        /*Conexão com o Banco*/
        $banco = ConexaoBanco::abreConexao(); # chama a função estática da classe ConexaoBanco para abrir a conexão com o servidor MYSQL
        $sql = "UPDATE tb_produto SET cd_url_produto = :cdurlimg, cd_publicid_img = :publicid WHERE cd_pedido = :cdped";  # declara a query do insert na tabela imagem do banco de dados, que só é feito após o insert na tabela serviço
        $stmt = $banco->prepare($sql); # prepara a query com o insert para a execução
        /*Substitui os placeholders da query preparada*/
        $stmt->bindValue(':cdurlimg', $URLProdImg);
        $stmt->bindValue(':publicid', $publicid);
        $stmt->bindValue(':cdped', $cd_pedido);

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