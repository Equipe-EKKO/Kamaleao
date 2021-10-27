<?php
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (ConexaoBanco -- classe que realiza a conexão com o banco de dados | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once 'classes/clConexaoBanco.php';
require_once 'classes/clUsuario.php';
require_once 'classes/clPerfilProprio.php';
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #arquivo de configuracao

// Função chamada no controller para verificar se o username e o email escolhido na atualização estão disponíveis
function atualizaUsuario (string $user) { # define que o parametro a ser passado deve ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Verifica se o username estão disponíveis. Dependendo do caso, uma mensagem diferente será exibida
        => Utiliza uma instância da Classe usuário serializada no model que realiza o Login */
    $usuario = unserialize($_SESSION['usuario']);
    $cdupt = $usuario->getCdUpdate();
    $message = "";
    if ((!empty($user) || isset($user) || $user != "" || $user != null)) {
        if ($usuario->verificaUsername($user)) {
            //n sei que atualiza
            $usuario->atualizarUsername($user, $cdupt);
            return true;
        } else {
            /*$message = "Este username não está disponível. Tente novamente!";
            return $message;*/
            return false;
        }
    } else {
        $message = "O campo inserido está vazio. Não há como atualizar.";
        return $message;
    }
}
// Função chamada no controller para verificar se o username e o email escolhido na atualização estão disponíveis
function atualizaEmail (string $email) { # define que o parametro a ser passado deve ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Verifica se o username estão disponíveis. Dependendo do caso, uma mensagem diferente será exibida
        => Utiliza uma instância da Classe usuário serializada no model que realiza o Login */
    $usuario = unserialize($_SESSION['usuario']);
    $cdupt = $usuario->getCdUpdate();
    $message = "";
    if ((!empty($email) || isset($email) || $email != "" || $email != null)) {
        if ($usuario->verificaEmail($email)) {
            //n sei que atualiza
            $usuario->atualizarEmail($email, $cdupt);
            return true;
        } else {
            /*$message = "Este email não está disponível. Tente novamente!";
            return $message;*/
            return false;
        }
    } else {
        $message = "O campo inserido está vazio. Não há como atualizar.";
        return $message;
    }
}
// Função chamada no controller para verificar se o username e o email escolhido na atualização estão disponíveis
function atualizaSenha (string $senha):bool { # define que o parametro a ser passado deve ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Verifica se o username estão disponíveis. Dependendo do caso, uma mensagem diferente será exibida
        => Utiliza uma instância da Classe usuário serializada no model que realiza o Login */
    $usuario = unserialize($_SESSION['usuario']);
    $cdupt = $usuario->getCdUpdate();
    if ((!empty($senha) || isset($senha) || $senha != "" || $senha != null)) {
        $usuario->atualizarSenha($senha, $cdupt);
        return true;
    } else {
        /*$message = "O campo inserido está vazio. Não há como atualizar.";
        return $message;*/
        return false;
    }
}
// Função chamada no controller para verificar se o username e o email escolhido na atualização estão disponíveis
function atualizaChavePix (string $cpix):bool { # define que o parametro a ser passado deve ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Verifica se o username estão disponíveis. Dependendo do caso, uma mensagem diferente será exibida
        => Utiliza uma instância da Classe usuário serializada no model que realiza o Login */
    $usuario = unserialize($_SESSION['usuario']);
    $cdupt = $usuario->getCdUpdate();
    if ((!empty($cpix) || isset($cpix) || $cpix != "" || $cpix != null)) {
        $usuario->setarChavePix($cpix, $cdupt);
        return true;
    } else {
        /*$message = "O campo inserido está vazio. Não há como atualizar.";
        return $message;*/
        return false;
    }
}
// Função chamada no controller para verificar se o username e o email escolhido na atualização estão disponíveis
function atualizaDesc (string $desc):bool { # define que o parametro a ser passado deve ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Verifica se o username estão disponíveis. Dependendo do caso, uma mensagem diferente será exibida
        => Utiliza uma instância da Classe usuário serializada no model que realiza o Login */
    $usuario = unserialize($_SESSION['usuario']);
    $cdupt = $usuario->getCdUpdate();
    if ((!empty($desc) || isset($desc) || $desc != "" || $desc != null)) {
        $usuario->perfil->updateDescricao($desc, $cdupt);
        return true;
    } else {
        /*$message = "O campo inserido está vazio. Não há como atualizar.";
        return $message;*/
        return false;
    }
}



