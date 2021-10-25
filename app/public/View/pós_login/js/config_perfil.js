window.onload = function () {
    var conteudo = $("main").detach();

$(document).ready(function () {
    /* AJAX PRA MANDAR OS RESULTADOS.... SÓ DEUS NA CAUSA */    
    $("#confSenha").submit(function (e) {
        e.preventDefault(); // Stop form from submitting normally

        var psword = $('#senha').val();
        /*var $form = $("#confSenha"),
            psword = $form.find( "input[name='senha']" ).val(),
            url = $form.attr("action");*/
        
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

    function iniciaModal(modalID) {
        var modal = document.getElementById(modalID);
        modal.classList.add('show');
        modal.addEventListener('click', (e) => {
            if(e.target.id == modalID || e.target.className == 'close') {
                modal.classList.remove('show');
            }
        });
    }
    var modalbtn = document.getElementById('modal-btn');
    modalbtn.addEventListener('click', () => iniciaModal('modal1'));
});
}
