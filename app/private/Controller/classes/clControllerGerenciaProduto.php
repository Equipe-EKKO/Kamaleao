<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); # essa constante serve pra pegar qual é a raiz do documento e evitar erros independente do local de acesso
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-Produto.php');
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
//use Respect\Validation\Validator as v;

//Classe controller que entrega o produto
class ControllerEntregaProduto{
  private $cdPedido, $imgName, $imgSize, $imgType, $imgtmpName;
  private function validaProduto():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    if ($this->cdPedido == null || $this->cdPedido == 0 || $this->cdPedido == "" || $this->imgName == null || $this->imgSize == null || $this->imgSize == 0) {
      ob_end_clean();
      echo 'Verifique se os campos obrigatorios estão inseridos corretamente!';
      return false;
    } elseif (($this->imgType != "image/png") && ($this->imgType != "image/jpeg" ) && ($this->imgType != "image/jpg")) {
      ob_end_clean();
      echo 'A imagem está em um formato não suportado!';
      return false;
    } elseif ($this->imgSize > 524288000.0) {
      ob_end_clean();
      echo 'O arquivo adicionado é maior que 500MB.';
      return false;
    } else { 
      ob_end_clean();
      return true;
    }
  }
  public function __construct(int $cdPedido, $imgName, $imgSize, $imgType, $imgtmpName) /*os ultimos são relacionados ao $_FILES, não sei bem o tipo*/ {
    $this->cdPedido = $cdPedido;
    $this->imgName = $imgName;
    $this->imgSize = $imgSize;
    $this->imgType = $imgType;
    $this->imgtmpName = $imgtmpName;
    $this->validaProduto();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaProduto()) {
      if (recebeProdutoPost($this->cdPedido, $this->imgType, $this->imgtmpName)):
        ob_end_clean();
        echo true;
        return true;
      else:
        // ob_end_flush();
        return false;
      endif;
    } else {
      return false;
    }
  }
}