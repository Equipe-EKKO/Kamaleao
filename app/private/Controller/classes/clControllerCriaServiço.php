<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); # essa constante serve pra pegar qual é a raiz do documento e evitar erros independente do local de acesso
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-Serviço.php');
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Respect\Validation\Validator as v;

class ControllerCriaServiço{
  private $titulo, $descriçao, $preçoMedio, $licença, $optionCategoria, $imgName, $imgSize, $imgType, $imgtmpName;
  private function validaServiço():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    if ($this->titulo == null || $this->preçoMedio == null || $this->licença == null || $this->imgName == null || $this->imgSize == null || $this->imgSize == 0) {
      echo 'Verifique se os campos obrigatorios estão inseridos corretamente!';
      return false;
    }else if (v::NumericVal()->validate($this->preçoMedio) == false){
      echo 'Digite um preço válido!';
      return false;
    }else if (v::image()->validate($this->imgName) == false){
      echo 'A imagem está em um formato não suportado!';
      return false;
    }elseif (v::stringType()->length(1, 50)->validate($this->titulo) == false) {
      echo 'O título só pode ter 50 caracteres.';
    }elseif (v::stringType()->length(1, 280)->validate($this->descriçao) == false) {
      echo 'A descrição só pode ter 280 caracteres.';
    }elseif ($this->imgType != "image/png" || $this->imgType != "image/jpeg" || $this->imgType != "image/jpg") {
      echo 'O arquivo adicionado não é suportado.';
    }elseif ($this->imgSize > 52428800.0) {
      echo 'O arquivo adicionado é maior que 50MB.';
    } else { 
      return true;
    }
  }
  public function __construct(string $titulo, string $descriçao, float $preçoMedio, int $licença, int $optionCategoria, $imgName, $imgSize, $imgType, $imgtmpName) /*os ultimos são relacionados ao $_FILES, não sei bem o tipo*/ {
    $this->titulo = $titulo;
    $this->descriçao = $descriçao;
    $this->preçoMedio = $preçoMedio;
    $this->licença = $licença;
    $this->optionCategoria = $optionCategoria;
    $this->imgName = $imgName;
    $this->imgSize = $imgSize;
    $this->imgType = $imgType;
    $this->imgtmpName = $imgtmpName;
    $this->validaServiço();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaServiço()) {
      if (recebeServPost($this->titulo, $this->descriçao, $this->preçoMedio, $this->licença, $this->optionCategoria, $this->imgType, $this->imgtmpName)):
        ob_end_clean();
        echo true;
      else:
        $rs = ob_get_flush();
        echo $rs;
      endif;
    }
  }
}
?>
