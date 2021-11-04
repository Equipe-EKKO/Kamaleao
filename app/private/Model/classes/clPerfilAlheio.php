<?php
#requere as classes necessárias para o funcionamento (Conexão para fazer o CRUD e Perfil para herdar da classe mãe)
require_once 'clPerfil.php';
use Serviço;
use PerfilProprio;
//Subclasse de Perfil cuja função é lidar com as funcionalidades CRUD da partição do Perfil Alheio do sistema
class PerfilAlheio extends Perfil {
    #Atributos
    public $avaliacao; # avaliação: instancia de classe 
    private $perfilProprio; # perfilPróprio: instancia de perfilProprio

    #Métodos da classe abstrata sendo implementados
    function listarServiços() {
        // $this->listServiço[] = $this->getServiço();
    }
    
    #Métodos Especias - Getter e Setters para os atributos
    /*GETTERS*/
    public function getServiço() {
        /*foreach ($this->serviço as $key => $serviço) {
            return $serviço[$key];
        }*/
    }
    protected function getPerfilProprio() {
        return $this->perfilProprio;
    }

    /*SETTERS*/
    public function setPerfilProprio(PerfilProprio $perfilProprio) {
        $this->perfilProprio = $perfilProprio;
    }
    public function setUsername(string $username) { //seta que o tipo de dado a ser passado como parametro deve ser string
        // $username = $this->perfilProprio->getUsername();
        $this->username = $username; #seta o valor do username
    }
    public function setDescricao(string $descricao) {
        // $descricao = $this->perfilProprio->getDescricao();
        $this->descricao = $descricao;
    }
    public function setfotoPerfil($fotoPerfil) {
        $fotoPerfil = $this->perfilProprio->getFotoPerfil();
    }
}
