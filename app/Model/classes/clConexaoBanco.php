<?php
/* escrita por: Carolina Sena, no dia 24.09.2021*/
//Classe cuja função é requisitar uma conexão com o banco de dados. Exclusivamente.
class ConexaoBanco {
    //Seta constantes para a classe que servirão como parametros a serem passados quando a classe PDO for instanciada, sendo:
    private const bd_dns = "mysql:host=localhost; dbname=db_kamaleao; charset=utf8"; #parte do dns
    private const bd_user = "root"; #usuário
    private const bd_pword = ""; # senha - Gab@101203
    //Atributo estático que tem dois valores possíveis = um objeto PDO || valor nulo
    private static $instance;

    //Método que irá realizar a conexão 
    public static function abreConexao() {
        if (!isset(self::$instance)) { #condicional que verifica se instance foi setado, e se não foi, prossegue
            try { #faz um try catch para instanciar o PDO
                self::$instance = new PDO(self::bd_dns, self::bd_user, self::bd_pword);
            } catch (\PDOException $e) { #lança a excessão caso haja erro
                exit("Houve um erro. Error Num: " . $e->getCode() . ". Mensagem do Erro: " . $e->getMessage()); #se tiver erro/exec -> sai do script e exibe uma mensagem
            }
        }
        return self::$instance; # retorna o valor da instancia, independente de qual seja

    }
    //Método para encerrar conexão
    public static function fechaConexao() {
        if (isset(self::$instance)) { #condicional que verifica se instance foi setado, e se já tiver sido, prossegue
            self::$instance = null; # substitui o valor setado por um valor nulo, interrompendo a conexão antes estabelecida.
            return self::$instance; #retorna o valor (nulo) setado anteriormente
        }
    }

    //Métodos Especiais
    /*Construtor*/
    private function __construct() { //setado como private para impedir instanciamento manual da classe
        die("Erro! Esta classe não deve ser instanciada."); #Quando é tentado a instancia, sai do script e exibe uma mensagem de erro
    }
    /*Clone*/
    private function __clone() {  //setado como private para impedir clonagem da classe
        die("Erro! Esta classe não deve ser instanciada."); #Quando é tentado o clone, sai do script e exibe uma mensagem
    } 

}
