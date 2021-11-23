<?php
ob_start();
/* escrita por: Carolina Sena, no dia 23.11.2021*/
require_once 'clConexaoBanco.php'; # requere a classe ConexaoBanco usada nos filhos
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); # requere a Config usada nos filhos

//Classe cuja função é representar um ou mais objetos de Serviço
class Comissao {
    #Atributos
    public $nmPedido, $dsPedido, $icCancelado, $vlPedido, $icConfirmado, $cdServiço; # nmServiço: string || dsServiço: string || imtmpServiço: string com url de imagem || tipoLicença: inteiro || vlServiço: float
    private $nmuserSolicitante, $cdPedido; // cdDono: inteiro

    #Métodos Especias - Getter e Setters para os atributos
    /* Construtor */
    public function __construct(string $nmServiço, string $dsServiço, float $vlServiço, int $tipoLicença, int $cdCategoria) {
        $this->setNmServiço($nmServiço);
        $this->setDsServiço($dsServiço);
        $this->setVlServiço($vlServiço);
        $this->setTipoLicença($tipoLicença);
        $this->setCdCategoria($cdCategoria);
    }
    /*GETTERS*/
    public function getNmServiço() {
        return $this->nmServiço;
    }
    public function getDsServiço() {
        return $this->dsServiço;
    }
    public function getURLServiço() {
        return $this->URLServiço;
    }
    public function getTipoLicença() {
        return $this->tipoLicença;
    }
    public function getVlServiço() {
        return $this->vlServiço;
    }
    public function getCdCategoria() {
        return $this->cdCategoria;
    }
    public function getCdDono() {
        return $this->cdDono;
    }
    public function getCdServiço() {
        return $this->cdServiço;
    }
    //*SETTERS*/
    public function setNmServiço(string $nmServiço) {
        $this->nmServiço = $nmServiço;
    }
    public function setDsServiço(string $dsServiço) {
        $this->dsServiço = $dsServiço;
    }
    public function setURLServiço($URLServiço) /*tipo: caminho do file*/ {
        $this->URLServiço = $URLServiço;
    }
    public function setTipoLicença(int $tipoLicença) {
        $this->tipoLicença = $tipoLicença;
    }
    public function setVlServiço(float $vlServiço) {
        $this->vlServiço = $vlServiço;
    }
    public function setCdCategoria(int $CdCategoria) {
        $this->cdCategoria = $CdCategoria;
    }
    private function setCdDono($cdDono){
        $this->cdDono = $cdDono;
    }
    private function setCdServiço($cdServiço){
        $this->cdServiço = $cdServiço;
    } 
    
}

?>