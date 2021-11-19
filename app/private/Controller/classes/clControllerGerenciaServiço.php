<?php
ob_start();
define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT']); # essa constante serve pra pegar qual é a raiz do documento e evitar erros independente do local de acesso
require_once (DIR_ROOT . '/Github/Kamaleao/app/private/Model/main-Serviço.php');
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php');
use Respect\Validation\Validator as v;

//Classe controller cria serviço
class ControllerCriaServiço{
  private $titulo, $descricao, $preçoMedio, $licença, $optionCategoria, $imgName, $imgSize, $imgType, $imgtmpName;
  private function validaServiço():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    if ($this->titulo == null|| $this->descricao == null || $this->preçoMedio == null || $this->licença == null || $this->imgName == null || $this->imgSize == null || $this->imgSize == 0) {
      ob_end_clean();
      echo 'Verifique se os campos obrigatorios estão inseridos corretamente!';
      return false;
    } else if (v::NumericVal()->validate($this->preçoMedio) == false){
      ob_end_clean();
      echo 'Digite um preço válido!';
      return false;
    } elseif (v::stringType()->length(1, 50)->validate($this->titulo) == false) {
      ob_end_clean();
      echo 'O título só pode ter 50 caracteres.';
      return false;
    }elseif (v::stringType()->length(1, 280)->validate($this->descricao) == false) {
      ob_end_clean();
      echo 'A descrição só pode ter 280 caracteres.';
      return false;
    }elseif (($this->imgType != "image/png") && ($this->imgType != "image/jpeg" ) && ($this->imgType != "image/jpg")) {
      ob_end_clean();
      echo 'A imagem está em um formato não suportado!';
      return false;
    }elseif ($this->imgSize > 52428800.0) {
      ob_end_clean();
      echo 'O arquivo adicionado é maior que 50MB.';
      return false;
    } else { 
      ob_end_clean();
      return true;
    }
  }
  public function __construct(string $titulo, string $descriçao, float $preçoMedio, int $licença, int $optionCategoria, $imgName, $imgSize, $imgType, $imgtmpName) /*os ultimos são relacionados ao $_FILES, não sei bem o tipo*/ {
    $this->titulo = $titulo;
    $this->descricao = $descriçao;
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
      if (recebeServPost($this->titulo, $this->descricao, $this->preçoMedio, $this->licença, $this->optionCategoria, $this->imgType, $this->imgtmpName)):
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

//Classe controller exclui serviço
class ControllerDeletaServiço{
  private $cdServiço; #inteiro
  private function validaServiço():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    if ($this->cdServiço == null || $this->cdServiço == 0 || $this->cdServiço == "") {
      ob_end_clean();
      echo 'Verifique se os campos obrigatorios estão inseridos corretamente!';
      return false;
    } else { 
      ob_end_clean();
      return true;
    }
  }
  public function __construct(int $cdServiço){
    $this->cdServiço = $cdServiço;
    $this->validaServiço();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaServiço()) {
      if (recebeServExcludePost($this->cdServiço)):
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

//Classe controller altera titulo
class ControllerAlteraTitulo{
  private $titulo, $cdServiço; #string || #inteiro  
  private function validaTituloServiço():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    if ($this->titulo == null) {
      ob_end_clean();
      echo 'Verifique se está inserido corretamente!';
      return false;
    } elseif (v::stringType()->length(1, 50)->validate($this->titulo) == false) {
      ob_end_clean();
      echo 'O título só pode ter 50 caracteres.';
      return false;
    } else { 
      ob_end_clean();
      return true;
    }
  }

  public function __construct(string $titulo, int $cdServiço) {
    $this->titulo = $titulo;
    $this->cdServiço = $cdServiço;
    $this->validaTituloServiço();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaTituloServiço()) {
      if(atualizaTitulo($this->titulo, $this->cdServiço)):
        ob_end_clean();
        echo true;
      else:
        echo ob_end_flush();
        return false;
      endif;
    }
  }
}
//Classe controller altera preço
class ControllerAlteraPreço{
  private $preçoMedio, $cdServiço; #float || #inteiro 
  private function validaPreçoServiço():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    if ($this->preçoMedio == null) {
      ob_end_clean();
      echo 'Verifique se está inserido corretamente!';
      return false;
    } else if (v::NumericVal()->validate($this->preçoMedio) == false){
      ob_end_clean();
      echo 'Digite um preço válido!';
      return false;
    } else { 
      ob_end_clean();
      return true;
    }
  }

  public function __construct(float $preçoMedio, int $cdServiço) {
    $this->preçoMedio = $preçoMedio;
    $this->cdServiço = $cdServiço;
    $this->validaPreçoServiço();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaPreçoServiço()) {
      if(atualizaPreço($this->preçoMedio, $this->cdServiço)):
        ob_end_clean();
        echo true;
      else:
        echo ob_end_flush();
        return false;
      endif;
    }
  }
}
//Classe controller altera descrição
class ControllerAlteraDescricao{
  private $descricao, $cdServiço; #string || #inteiro
  private function validaDescricaoServiço():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    if ($this->descricao == null) {
      ob_end_clean();
      echo 'Verifique se está inserido corretamente!';
      return false;
    } elseif (v::stringType()->length(1, 280)->validate($this->descricao) == false) {
      ob_end_clean();
      echo 'A descrição só pode ter 280 caracteres.';
      return false;
    } else { 
      ob_end_clean();
      return true;
    }
  }

  public function __construct(string $descricao, int $cdServiço) {
    $this->descricao = $descricao;
    $this->cdServiço = $cdServiço;
    $this->validaDescricaoServiço();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaDescricaoServiço()) {
      if(atualizaDescricaoAnuncio($this->descricao, $this->cdServiço)):
        ob_end_clean();
        echo true;
      else:
        echo ob_end_flush();
        return false;
      endif;
    }
  }
}
//Classe controller altera licença
class ControllerAlteraLicença{
  private $licença, $cdServiço; #inteiro || #inteiro
  private function validaLicençaServiço():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    if ($this->licença == null) {
      ob_end_clean();
      echo 'Verifique se está inserido corretamente!';
      return false;
    } else { 
      ob_end_clean();
      return true;
    }
  }

  public function __construct(int $licença, int $cdServiço) {
    $this->licença = $licença;
    $this->cdServiço = $cdServiço;
    $this->validaLicençaServiço();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaLicençaServiço()) {
      if(atualizaLicença($this->licença, $this->cdServiço)):
        ob_end_clean();
        echo true;
      else:
        echo ob_end_flush();
        return false;
      endif;
    }
  }
}
//Classe controller altera categoria
class ControllerAlteraCategoria{
  private $optionCategoria, $cdServiço; #inteiro || #inteiro
  private function validaCategoriaServiço():bool{ #Função bool para ver se todos os campos estão corretos para mandar ao model
    if ($this->optionCategoria == null) {
      ob_end_clean();
      echo 'Verifique se está inserido corretamente!';
      return false;
    } else { 
      ob_end_clean();
      return true;
    }
  }

  public function __construct(int $optionCategoria, int $cdServiço) {
    $this->optionCategoria = $optionCategoria;
    $this->cdServiço = $cdServiço;
    $this->validaCategoriaServiço();
    $this->chamaModel();
  }

  private function chamaModel() {
    if ($this->validaCategoriaServiço()) {
      if(atualizaCategoria($this->optionCategoria, $this->cdServiço)):
        ob_end_clean();
        echo true;
      else:
        echo ob_end_flush();
        return false;
      endif;
    }
  }
}
?>
