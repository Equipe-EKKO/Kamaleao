<?php
/* escrita por: Carolina Sena, no dia 13.10.2021*/
require_once 'clConexaoBanco.php'; # requere a classe ConexaoBanco usada nos filhos
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); # requere a Config usada nos filhos

//Classe cuja função é representar um ou mais objetos de Anuncio
class Anuncio {
    #Atributos
    public $nmAnuncio, $dsAnuncio, $nmVersao, $dsVersao, $vlAnuncio; # nmAnuncio: string || dsAnuncio: string || qtVersao: inteiro || dsVersao: string || vlAnuncio: float
    private $qtVersao; # nmVersao: string 

    #Métodos Especias - Getter e Setters para os atributos
    /*GETTERS*/
    public function getNmAnuncio() {
        return $this->nmAnuncio;
    }
    public function getDsAnuncio() {
        return $this->dsAnuncio;
    }
    public function getQtVersao() {
        return $this->qtVersao;
    }
    public function getDsVersao() {
        return $this->dsVersao;
    }
    public function getNmVersao() {
        return $this->nmVersao;
    }
    public function getVlAnuncio() {
        return $this->vlAnuncio;
    }
    //*SETTERS*/
    public function setNmAnuncio(string $nmAnuncio) {
        $this->nmAnuncio = $nmAnuncio;
    }
    public function setDsAnuncio(string $dsAnuncio) {
        $this->dsAnuncio = $dsAnuncio;
    }
    public function setQtVersao(int $qtVersao = 1) {
        $this->qtVersao = $qtVersao;
    }
    public function setDsVersao($dsVersao) {
        $this->qtVersao == 1 ? $this->dsVersao = $this->getDsAnuncio() : $this->dsVersao = $dsVersao;
    }
    public function setNmVersao(string $nmVersao) {
        $this->qtVersao == 1 ? $this->nmVersao = $this->getNmAnuncio() : $this->nmVersao = $nmVersao;
    }
    public function setVlAnuncio(float $vlAnuncio) {
        $this->vlAnuncio = $vlAnuncio;
    }
    
}

?>