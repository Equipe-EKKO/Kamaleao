<?php
require_once "classes/autoloadClass.php";
#requere os arquivos contendo as classes necessárias para o funcionamento do programa principal direcionado ao login (ConexaoBanco -- classe que realiza a conexão com o banco de dados | Usuario -- subclasse de Participante | Administrador -- subclasse Participante)
require_once (DIR_ROOT . '/GitHub/Kamaleao/config.php'); #arquivo de configuracao

// Função chamada no controller para verificar se a foto escolhida na atualização pode ser usada
function atualizaFotoPerfil(string $imgType, $imgtmpName, string $imgName):bool { # define que o parametro a ser passado deve ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Verifica se o username está disponível. Dependendo do caso, uma mensagem diferente será exibida
        => Utiliza uma instância da Classe usuário serializada no model que realiza o Login */
    $temp = explode("/", $imgType);
    $extension = end($temp);
    $usuario = unserialize($_SESSION['usuario']);
    $cdupt = $usuario->getCdUpdate() - 1;
    if ((!empty($imgtmpName) || isset($imgtmpName) || $imgtmpName != "" || $imgtmpName != null)) {
        if ($usuario->perfil->updateFotoPerfil($imgName, $cdupt, $extension, $imgtmpName)) {
            $usuario->pegaFotoPerfil();
            return true;
        }
        /*$message = "Este username não está disponível. Tente novamente!";
        return $message;*/
        return false;
        
    }
    /*$message = "O campo inserido está vazio. Não há como atualizar.";
    return $message;*/
    return false;
}

// Função chamada no controller para verificar se o username escolhido na atualização estão disponíveis
function atualizaUsuario(string $user):bool { # define que o parametro a ser passado deve ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Verifica se o username está disponível. Dependendo do caso, uma mensagem diferente será exibida
        => Utiliza uma instância da Classe usuário serializada no model que realiza o Login */
    $usuario = unserialize($_SESSION['usuario']);
    $cdupt = $usuario->getCdUpdate();
    if ((!empty($user) || isset($user) || $user != "" || $user != null)) {
        if ($usuario->verificaUsername($user)) {
            //n sei que atualiza
            $usuario->atualizarUsername($user, $cdupt);
            $usuario->atualizaPosConfig();
            return true;
        }
        /*$message = "Este username não está disponível. Tente novamente!";
        return $message;*/
        return false;
        
    }
    /*$message = "O campo inserido está vazio. Não há como atualizar.";
    return $message;*/
    return false;
}
// Função chamada no controller para verificar se o email escolhido na atualização estão disponíveis
function atualizaEmail (string $email) { # define que o parametro a ser passado deve ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Verifica se o email está disponível. Dependendo do caso, uma mensagem diferente será exibida
        => Utiliza uma instância da Classe usuário serializada no model que realiza o Login */
    $usuario = unserialize($_SESSION['usuario']);
    $cdupt = $usuario->getCdUpdate();
    $message = "";
    if ((!empty($email) || isset($email) || $email != "" || $email != null)) {
        if ($usuario->verificaEmail($email)) {
            //n sei que atualiza
            $usuario->atualizarEmail($email, $cdupt);
            $usuario->atualizaPosConfig();
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
// Função chamada no controller para verificar se a senha escolhido na atualização pode ser usada
function atualizaSenha (string $senha):bool { # define que o parametro a ser passado deve ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Verifica se a senha está pronta para ser colocada como nova Dependendo do caso, uma mensagem diferente será exibida
        => Utiliza uma instância da Classe usuário serializada no model que realiza o Login */
    $usuario = unserialize($_SESSION['usuario']);
    $cdupt = $usuario->getCdUpdate();
    if ((!empty($senha) || isset($senha) || $senha != "" || $senha != null)) {
        $usuario->atualizarSenha($senha, $cdupt);
        $usuario->atualizaPosConfig();
        return true;
    } else {
        /*$message = "O campo inserido está vazio. Não há como atualizar.";
        return $message;*/
        return false;
    }
}
// Função chamada no controller para verificar se a descrição escolhido na atualização pode ser usada
function atualizaDesc (string $desc):bool { # define que o parametro a ser passado deve ter tipo primitivo como string, lembrando que os valores passados serão os posts estabelecidos no controller
    /* De uma maneira geral, o programa segue a seguinte lógica:
        => Verifica se a descrição está pronta para ser colocada como nova. Dependendo do caso, uma mensagem diferente será exibida
        => Utiliza uma instância da Classe usuário serializada no model que realiza o Login */
    $usuario = unserialize($_SESSION['usuario']);
    $cdupt = $usuario->getCdUpdate();
    if ((!empty($desc) || isset($desc) || $desc != "" || $desc != null)) {
        $usuario->perfil->updateDescricao($desc, $cdupt);
        $usuario->atualizaPosConfig();
        return true;
    } else {
        /*$message = "O campo inserido está vazio. Não há como atualizar.";
        return $message;*/
        return false;
    }
}



