<?php
#Require do autoload do composer
define('ROOT_PATH', dirname(__FILE__));
require_once ROOT_PATH . "/vendor/autoload.php";

date_default_timezone_set('America/Sao_Paulo');

session_start();
//Classe cuja função é não violar o encapsulamento da superglobal Session.
class Session{
    public static function setSession($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function getSession($key){
        return (isset($_SESSION[$key]) ? $_SESSION[$key] : null);
    }

    public static function unsetSession($key){
        unset($_SESSION[$key]);
    }
}
?>