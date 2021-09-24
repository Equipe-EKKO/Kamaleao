<?php

class Conexao {
    private const bd_dns = "mysql:host=localhost; dbname=db_kamaleao; charset=utf8";
    private const bd_user = "root";
    private const bd_pword = "";
    private static $instance;

    public static function tentaConexao() {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO(self::bd_dns, self::bd_user, self::bd_pword);
                echo "DEU CERTO SAPORRA";
                return self::$instance;
            } catch (\PDOException $e) {
                echo "Código do Erro: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage();
            }
        } else {
            return self::$instance;
        }
    }

    public static function quebraConexao() {
        if (isset(self::$instance)) {
            self::$instance = null;
        }
    }

    //Métodos Especiais
    private function __construct() {
        die("Não é pra instanciar cacete");
    }
    private function __clone() {
        die("Não quebre meu programa");
    } 

    
    
}
