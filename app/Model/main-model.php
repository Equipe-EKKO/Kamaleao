<?php
require_once 'classes/clConexaoBanco.php';
require_once 'classes/clParticipante.php';
require_once 'classes/clAdministrador.php';
//Atual arquivo para testes
$adm = new Administrador;
$adm->logarConta("carolsenase@gmail.com", "carolinwjs", "MarinaDiamandis");

?>