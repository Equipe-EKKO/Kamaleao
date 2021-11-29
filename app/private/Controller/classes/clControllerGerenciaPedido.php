<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); # essa constante serve pra pegar qual é a raiz do documento e evitar erros independente do local de acesso
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-Pedido.php');
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Respect\Validation\Validator as v;

//Classe controller cria serviço
class ControllerFazPedido{
  private $titulo, $descricao, $username, $cd_serviço, $dt_entrega; 
  private function validaPedido():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    $dt_min = date('Y-m-d', strtotime("+14 days"));
    if ($this->titulo == null|| $this->descricao == null || $this->username == null || $this->cd_serviço == null || $this->dt_entrega == null) {
      ob_end_clean();
      echo 'Verifique se os campos obrigatorios estão inseridos corretamente!';
      return false;
    } else if (v::noWhitespace()->validate($this->username) == false){
      ob_end_clean();
      echo 'Há um problema com o usuário solicitante! Tente Novamente';
      return false;
    } elseif (v::stringType()->length(1, 50)->validate($this->titulo) == false) {
      ob_end_clean();
      echo 'O título só pode ter 50 caracteres.';
      return false;
    } elseif (v::stringType()->length(1, 280)->validate($this->descricao) == false) {
      ob_end_clean();
      echo 'A descrição só pode ter 280 caracteres.';
      return false;
    } else if (v::date()->validate($this->dt_entrega) == false){ #verifica se a idade é maior que 15 anos
      ob_end_clean();
      echo 'O formato da data está errado.';
      return false;
    } else if (strtotime($this->dt_entrega) < strtotime($dt_min)){ #verifica se a idade é maior que 15 anos
      ob_end_clean();
      echo 'A comissão deve ter a data com distância de ao menos duas semanas desde a data que foi pedida.';
      return false;
    } else { 
      ob_end_clean();
      return true;
    }
    return false;
  }
  public function __construct(string $titulo, string $descriçao, string $username, int $cd_serviço, $dt_entrega) /*os ultimos são relacionados ao $_FILES, não sei bem o tipo*/ {
    $this->titulo = $titulo;
    $this->descricao = $descriçao;
    $this->username = $username;
    $this->cd_serviço = $cd_serviço;
    $this->dt_entrega = $dt_entrega;
    $this->validaPedido();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaPedido()) {
      if (recebePedidoPost($this->titulo, $this->descricao, $this->username, $this->cd_serviço, $this->dt_entrega)):
        ob_end_clean();
        echo true;
        return true;
      else:
        ob_end_flush();
        return false;
      endif;
    } else {
      return false;
    }
  }
}

//Classe controller nega pedido
class ControllerNegaPedido{
  private $cdPedido; #inteiro
  private function validaPedido():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    if ($this->cdPedido == null || $this->cdPedido == 0 || $this->cdPedido == "") {
      ob_end_clean();
      echo 'Verifique se os campos obrigatorios estão inseridos corretamente!';
      return false;
    } else { 
      ob_end_clean();
      return true;
    }
  }
  public function __construct(int $cdPedido){
    $this->cdPedido = $cdPedido;
    $this->validaPedido();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaPedido()) {
      if (recebePedidoNegaPost($this->cdPedido)):
        ob_end_clean();
        echo true;
        return true;
      else:
        ob_end_flush();
        echo false;
        return false;
      endif;
    } else {
      return false;
    }
  }
}

//Classe controller aceita pedido
class ControllerAceitaPedido{
  private $cdPedido, $preçoFinal; #inteiro || float
  private function validaPedido():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    if ($this->cdPedido == null || $this->cdPedido == 0 || $this->cdPedido == "" || $this->preçoFinal == null || $this->preçoFinal == 0 || $this->preçoFinal == "") {
      ob_end_clean();
      echo 'Verifique se os campos obrigatorios estão inseridos corretamente!';
      return false;
    } else if (v::NumericVal()->validate($this->preçoFinal) == false){
      ob_end_clean();
      echo 'Digite um preço válido!';
      return false;
    } else { 
      ob_end_clean();
      return true;
    }
  }
  public function __construct(int $cdPedido, float $preçoFinal){
    $this->cdPedido = $cdPedido;
    $this->preçoFinal = $preçoFinal;
    $this->validaPedido();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaPedido()) {
      if (recebePedidoAceitaPost($this->cdPedido, $this->preçoFinal)):
        ob_end_clean();
        echo true;
        return true;
      else:
        ob_end_flush();
        echo false;
        return false;
      endif;
    } else {
      return false;
    }
  }
}

//Classe controller aceita val pedido
class ControllerAceitaValPedido{
  private $cdPedido; #inteiro 
  private function validaPedido():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    if ($this->cdPedido == null || $this->cdPedido == 0 || $this->cdPedido == "") {
      ob_end_clean();
      echo 'Verifique se os campos obrigatorios estão inseridos corretamente!';
      return false;
    } else { 
      ob_end_clean();
      return true;
    }
  }
  public function __construct(int $cdPedido){
    $this->cdPedido = $cdPedido;
    $this->validaPedido();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaPedido()) {
      if (recebePedidoValAceitaPost($this->cdPedido)):
        ob_end_clean();
        echo true;
        return true;
      else:
        ob_end_flush();
        echo false;
        return false;
      endif;
    } else {
      return false;
    }
  }
}

//Classe controller nega val pedido
class ControllerNegaValPedido{
  private $cdPedido; #inteiro 
  private function validaPedido():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    if ($this->cdPedido == null || $this->cdPedido == 0 || $this->cdPedido == "") {
      ob_end_clean();
      echo 'Verifique se os campos obrigatorios estão inseridos corretamente!';
      return false;
    } else { 
      ob_end_clean();
      return true;
    }
  }
  public function __construct(int $cdPedido){
    $this->cdPedido = $cdPedido;
    $this->validaPedido();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaPedido()) {
      if (recebePedidoValNegaPost($this->cdPedido)):
        ob_end_clean();
        echo true;
        return true;
      else:
        ob_end_flush();
        echo false;
        return false;
      endif;
    } else {
      return false;
    }
  }
}

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