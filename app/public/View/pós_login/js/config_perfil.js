window.onload = function () {
    var conteudo = $("main").detach();

    $(document).ready(function () {
        /* AJAX PRA CONFIRMAÇÃO DA SENHA */
        $("#confSenha").submit(function (e) {
            e.preventDefault(); // Stop form from submitting normally

            var psword = $('#senha').val();
        
            $.post("/GitHub/Kamaleao/app/private/Controller/controllerVerificaSenha.php", { senha: psword }, function (resposta) {
                if (resposta == 1) {
                    $("#md-pr").removeClass("md-ct").addClass("md-ct-pos");
                    $("#md-pr").remove();
                    $(conteudo).appendTo("div.container");
                    $("main").removeClass("main-initial").addClass("main");
                    var asterisco 
                    var asterisco = $("p#senha").detach();


                    //asterisco.length;
                } else {
                    $("p.form-message").removeAttr("hidden");
                    $("p#resultfirst").addClass("erro");
                    var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + resposta + "</span>";
                    $("p.form-message").empty();
                    $(erro).appendTo("p.form-message");
                }
            });
        });
    });
}

function abreModal(modal){
    if(modal == 'username' ){ //se o parametro da função for username ele...
        $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct"); //remove a classe que deixa a div invisível e adiciona a classe de background do modal
        $("#username").addClass("md").removeClass("md-ct-pos"); //adiciona a classe de modal para o username 
        $("#desc").removeClass("md").addClass("md-ct-pos"); //e faz o inverso com as outras
        $("#email").removeClass("md").addClass("md-ct-pos");
        $("#senha").removeClass("md").addClass("md-ct-pos");
        $("p.form-message").empty();
        $("p#resultsec").removeClass("sucesso");
        $("p#resultsec").removeClass("erro");


        $('#attUser').focus(function (e) { 
            e.preventDefault();
            $(this).val("");
            $("p.form-message").empty();
            $("p#resultsec").removeClass("sucesso");
            $("p#resultsec").removeClass("erro");
        });

        /*AJAX PRA TROCAR O USERNAME*/
        $("#trocaUsername").submit(function (e) {
            e.preventDefault(); // Stop form from submitting normally
            var usernm = $('#attUser').val();
        
            $.post("/GitHub/Kamaleao/app/private/Controller/controllerAlteraUsername.php", { username: usernm }, function (resposta) {
                if (resposta == 1) {
                    $("p.form-message").removeAttr("hidden");
                    $("p#resultsec").addClass("sucesso");
                    var sucesso = "<i class='fas fa-exclamation-triangle'></i> <span> Seu username foi atualizado!</span>";
                    $(sucesso).appendTo("p.form-message");

                    setTimeout(function () {
                        fechaModal();
                      }, 1000);

                    $("p#atualUsername").empty();
                    $("<span>@" + usernm +"</span>").appendTo("p#atualUsername");
                    
                } else {
                    $("p.form-message").removeAttr("hidden");
                    $("p#resultsec").addClass("erro");
                    var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + resposta + "</span>";
                    var mes = $("p.form-message").html();
                    if (mes.includes("atualizado") == false) {
                        $("p.form-message").empty();
                        $(erro).appendTo("p.form-message");
                    }
                }
            });
        });


    }
    else if(modal == 'desc' ){
        $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
        $("#desc").addClass("md").removeClass("md-ct-pos");
        $("#username").removeClass("md").addClass("md-ct-pos");
        $("#email").removeClass("md").addClass("md-ct-pos");
        $("#senha").removeClass("md").addClass("md-ct-pos");
        $("p.form-message").empty();
        $("p#resultthird").removeClass("sucesso");
        $("p#resultthird").removeClass("erro");

        $('#descricao').focus(function (e) { 
            e.preventDefault();
            $(this).val("");
            $("p.form-message").empty();
            $("p#resultthird").removeClass("sucesso");
            $("p#resultthird").removeClass("erro");
        });

        /*AJAX PRA TROCAR O USERNAME*/
        $("#trocaDesc").submit(function (e) {
            e.preventDefault(); // Stop form from submitting normally
            var desc = $('#descricao').val();
        
            $.post("/GitHub/Kamaleao/app/private/Controller/controllerAlteraDescricao.php", { descricao: desc }, function (resposta) {
                if (resposta == 1) {
                    $("p.form-message").removeAttr("hidden");
                    $("p#resultthird").addClass("sucesso");
                    var sucesso = "<i class='fas fa-exclamation-triangle'></i> <span> Sua descrição foi atualizada!</span>";
                    $(sucesso).appendTo("p.form-message");

                    setTimeout(function () {
                        fechaModal();
                      }, 1000);

                    $("p#atualDesc").empty();
                    $("<span>" + desc +"</span>").appendTo("p#atualDesc");
                    
                } else {
                    $("p.form-message").removeAttr("hidden");
                    $("p#resultthird").addClass("erro");
                    var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + resposta + "</span>";
                    var mes = $("p.form-message").html();
                    if (mes.includes("atualizada") == false) {
                        $("p.form-message").empty();
                        $(erro).appendTo("p.form-message");
                    }
                }
            });
        });
    }
    else if(modal == 'email' ){
        $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
        $("#email").addClass("md").removeClass("md-ct-pos");
        $("#username").removeClass("md").addClass("md-ct-pos");
        $("#desc").removeClass("md").addClass("md-ct-pos");
        $("#senha").removeClass("md").addClass("md-ct-pos");
        $("p.form-message").empty();
        $("p#resultfourth").removeClass("sucesso");
        $("p#resultfourth").removeClass("erro");

        $('#attEmail').focus(function (e) { 
            e.preventDefault();
            $(this).val("");
            $("p.form-message").empty();
            $("p#resultfourth").removeClass("sucesso");
            $("p#resultfourth").removeClass("erro");
        });

        /*AJAX PRA TROCAR O USERNAME*/
        $("#trocaEmail").submit(function (e) {
            e.preventDefault(); // Stop form from submitting normally
            var email = $('#attEmail').val();
            
            $.post("/GitHub/Kamaleao/app/private/Controller/controllerAlteraEmail.php", { email: email }, function (resposta) {
                if (resposta == true) {
                    $("p.form-message").removeAttr("hidden");
                    $("p#resultfourth").addClass("sucesso");
                    var sucesso = "<i class='fas fa-exclamation-triangle'></i> <span> Seu email foi atualizado!</span>";
                    $(sucesso).appendTo("p.form-message");

                    setTimeout(function () {
                        fechaModal();
                      }, 1000);

                    $("p#atualEm").empty();
                    $("<span>" + email +"</span>").appendTo("p#atualEm");
                    
                } else {
                    $("p.form-message").removeAttr("hidden");
                    $("p#resultfourth").addClass("erro");
                    var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + resposta + "</span>";
                    var mes = $("p.form-message").html();
                    if (mes.includes("atualizado") == false) {
                        $("p.form-message").empty();
                        $(erro).appendTo("p.form-message");
                    }                    
                }
            });
        });
    }
    else if(modal == 'senha' ){
        $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
        $("#senha").addClass("md").removeClass("md-ct-pos");
        $("#username").removeClass("md").addClass("md-ct-pos");
        $("#desc").removeClass("md").addClass("md-ct-pos");
        $("#chavepix").removeClass("md").addClass("md-ct-pos");
        $("#email").removeClass("md").addClass("md-ct-pos");
        $("p.form-message").empty();
        $("p#resultsixth").removeClass("sucesso");
        $("p#resultsixth").removeClass("erro");

        $('#attSenha').focus(function (e) { 
            e.preventDefault();
            $(this).val("");
            $("p.form-message").empty();
            $("p#resultsixth").removeClass("sucesso");
            $("p#resultsixth").removeClass("erro");
        });
        $('#confsenha').focus(function (e) { 
            e.preventDefault();
            $(this).val("");
            $("p.form-message").empty();
            $("p#resultsixth").removeClass("sucesso");
            $("p#resultsixth").removeClass("erro");
        });

        /*AJAX PRA TROCAR O USERNAME*/
        $("#trocaSenha").submit(function (e) {
            e.preventDefault(); // Stop form from submitting normally
            var senha = $('#attSenha').val();
            var csenha = $('#confsenha').val();

        
            $.post("/GitHub/Kamaleao/app/private/Controller/controllerAlteraSenha.php", { senha: senha, confsenha: csenha }, function (resposta) {
                if (resposta == 1) {
                    $("p.form-message").removeAttr("hidden");
                    $("p#resultsixth").addClass("sucesso");
                    var sucesso = "<i class='fas fa-exclamation-triangle'></i> <span> Sua senha foi atualizada!</span>";
                    $("p.form-message").empty();
                    $(sucesso).appendTo("p.form-message");

                    setTimeout(function () {
                        fechaModal();
                      }, 1000);
                
                } else {
                    $("p.form-message").removeAttr("hidden");
                    $("p#resultsixth").addClass("erro");
                    var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + resposta + "</span>";
                    var mes = $("p.form-message").html();
                    if (mes.includes("atualizado") == false) {
                        $("p.form-message").empty();
                        $(erro).appendTo("p.form-message");
                    }
                }
                $('#attSenha').val("");
                $('#confsenha').val("");
            });
        });
    }
}

function fechaModal() { //isso aqui faz tudo pegar a classe de desaparecer!!!
    $('input').val("");
    $("#username").removeClass("md").addClass("md-ct-pos");
    $("#desc").removeClass("md").addClass("md-ct-pos");
    $("#email").removeClass("md").addClass("md-ct-pos");
    $("#chavepix").removeClass("md").addClass("md-ct-pos");
    $("#senha").removeClass("md").addClass("md-ct-pos");
    $("#md-pr2").removeClass("md-ct").addClass("md-ct-pos");
    $("p.form-message").empty();
}

