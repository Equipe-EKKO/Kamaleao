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
                } else {
                    $("p.form-message").removeAttr("hidden");
                    var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + resposta + "</span>";
                    $("p.form-message").empty();
                    $(erro).appendTo("p.form-message");
                }
            });
        });
    });
}

function abreModal(modal){
    if(modal == 'username' ){
        $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
        $("#username").addClass("md").removeClass("md-ct-pos");
        $("#desc").removeClass("md").addClass("md-ct-pos");
        $("#email").removeClass("md").addClass("md-ct-pos");
        $("#chavepix").removeClass("md").addClass("md-ct-pos");
        $("#senha").removeClass("md").addClass("md-ct-pos");
    }
    else if(modal == 'desc' ){
        $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
        $("#desc").addClass("md").removeClass("md-ct-pos");
        $("#username").removeClass("md").addClass("md-ct-pos");
        $("#email").removeClass("md").addClass("md-ct-pos");
        $("#chavepix").removeClass("md").addClass("md-ct-pos");
        $("#senha").removeClass("md").addClass("md-ct-pos");
    }
    else if(modal == 'email' ){
        $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
        $("#email").addClass("md").removeClass("md-ct-pos");
        $("#username").removeClass("md").addClass("md-ct-pos");
        $("#desc").removeClass("md").addClass("md-ct-pos");
        $("#chavepix").removeClass("md").addClass("md-ct-pos");
        $("#senha").removeClass("md").addClass("md-ct-pos");
    }
    else if(modal == 'chavepix' ){
        $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
        $("#chavepix").addClass("md").removeClass("md-ct-pos");
        $("#username").removeClass("md").addClass("md-ct-pos");
        $("#desc").removeClass("md").addClass("md-ct-pos");
        $("#email").removeClass("md").addClass("md-ct-pos");
        $("#senha").removeClass("md").addClass("md-ct-pos");
    }
    else if(modal == 'senha' ){
        $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
        $("#senha").addClass("md").removeClass("md-ct-pos");
        $("#username").removeClass("md").addClass("md-ct-pos");
        $("#desc").removeClass("md").addClass("md-ct-pos");
        $("#chavepix").removeClass("md").addClass("md-ct-pos");
        $("#email").removeClass("md").addClass("md-ct-pos");
    }
}

function fechaModal(){
    $("#username").removeClass("md").addClass("md-ct-pos");
    $("#desc").removeClass("md").addClass("md-ct-pos");
    $("#email").removeClass("md").addClass("md-ct-pos");
    $("#chavepix").removeClass("md").addClass("md-ct-pos");
    $("#senha").removeClass("md").addClass("md-ct-pos");
    $("#md-pr2").removeClass("md-ct").addClass("md-ct-pos");
}
// function abreModal() {
//     var modalBg = document.querySelector('.modal-bg');
//     modalBg.classList.add('bg-active');
//     /* AJAX PRA ALTERAÇÃO DAS INFORMAÇÕES*/
//     $("#upd").submit(function (e) {
//         e.preventDefault(); // Stop form from submitting normally
//         var psword = $('#senha').val(), usernm = $('#username').val(), desc = $('#descricao').val(), email = $('#email').val(), cpix = $('#chavepix').val(), confpsword = $('#confsenha').val();
    
//         $.post("/GitHub/Kamaleao/app/private/Controller/controllerAlterarInformacoes.php", { senha: psword, username: usernm, descricao: desc, email: email, chavepix: cpix, confsenha: confpsword }, function (resposta) {
//             alert("A resposta eh:" + resposta);

//         });

//     });
// }

// function fechaModal(){
//     var modalBg = document.querySelector('.modal-bg');
//     modalBg.classList.remove('bg-active');
// }


