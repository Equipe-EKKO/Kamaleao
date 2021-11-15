function abreModal(modal) {
  $("#md-pr").removeClass("md-ct-pos").addClass("md-ct"); // qualquer modal que vai ser aberto precisa do fundo
  if (modal == "add") {
    $("#add").removeClass("md-ct-pos").addClass("form_anuncio");
    $("#editar-excluir").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#modal-editar").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-titulo").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-preco").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-desc").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-licenca").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-categoria").removeClass("form_anuncio").addClass("md-ct-pos");
  
    $("form#add").submit(function (e) {

      e.preventDefault();

      var form_data = new FormData();
      form_data.append('titulo', $('input#titulo').val());
      form_data.append('descricao', $('#descricao').val());
      form_data.append('servfile', $('input#imagem').prop('files')[0]);
      form_data.append('precoMedio', $('input#preco').val());
      form_data.append('licenca', $('input[name="licenca"]:checked').val());
      form_data.append('select_cat', $('#select_cat').val());

      // desabilitar o botão de "submit" para evitar multiplos envios até receber uma resposta
      $("input.botao").prop("disabled", true);
      // processar
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "/GitHub/Kamaleao/app/private/Controller/controllerCriaServiço.php",
        data: form_data,
        processData: false, // impedir que o jQuery tranforma a "data" em querystring
        contentType: false, // desabilitar o cabeçalho "Content-Type"
        cache: false, // desabilitar o "cache"
        // manipular o sucesso da requisição
        success: function (resposta) {
          if (resposta == 1) {
            $("p.form-message").removeClass("sucesso");
            $("p.form-message").removeClass("erro");
            $("p.form-message").removeAttr("hidden");
            $("p.form-message").addClass("sucesso");
            $("p.form-message").empty();
            var sucesso = "<i class='fas fa-exclamation-triangle'></i> <span> Seu novo anúncio foi adicionado!</span>";
            $(sucesso).appendTo("p.form-message");
            setTimeout(function () {
              fechaModal('add');
              location.reload(true)

            }, 1000);

          } else {
            $("p.form-message").removeClass("sucesso");
            $("p.form-message").removeClass("erro");
            $("p.form-message").removeAttr("hidden");
            $("p.form-message").addClass("erro");
            var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + resposta + "</span>";
            var mes = $("p.form-message").html();
            if (mes.includes("atualizado") == false) {
              $("p.form-message").empty();
              $(erro).appendTo("p.form-message");
            }
          }
          // reativar o botão de "submit"
          $("input.botao").prop("disabled", false);
        },
        // manipular erros da requisição
        error: function (e) {
          alert(e);
          // reativar o botão de "submit"
          $("input.botao").prop("disabled", false);
        }
      });

    });

  } else if (modal == "editar-excluir") {
    $("#editar-excluir").removeClass("md-ct-pos").addClass("form_anuncio");
    $("#add").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#modal-editar").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-titulo").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-preco").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-desc").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-licenca").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-categoria").removeClass("form_anuncio").addClass("md-ct-pos");
  } else if  (modal == "conf-excluir") {
    $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
    $("#conf-excluir").addClass("form_anuncio").removeClass("md-ct-pos");
  } else if  (modal == "modal-editar") {
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#modal-editar").addClass("form_edit").removeClass("md-ct-pos");
    $("#editar-excluir").removeClass("form_anuncio").addClass("md-ct-pos");
  } else if (modal == "titulo") {
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-titulo").addClass("form_edit").removeClass("md-ct-pos");
    $("#modal-editar").removeClass("form_edit").addClass("md-ct-pos");
  } else if  (modal == "preco") {
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-preco").addClass("form_edit").removeClass("md-ct-pos");
    $("#modal-editar").removeClass("form_edit").addClass("md-ct-pos");
  } else if  (modal == "desc") {
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-desc").addClass("form_edit").removeClass("md-ct-pos");
    $("#modal-editar").removeClass("form_edit").addClass("md-ct-pos");
  } else if (modal == "licenca") {
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-licenca").addClass("form_edit").removeClass("md-ct-pos");
    $("#modal-editar").removeClass("form_edit").addClass("md-ct-pos");
  } else if (modal == "categoria") { // deu certo nao
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-categoria").addClass("form_edit").removeClass("md-ct-pos");
    $("#modal-editar").removeClass("form_edit").addClass("md-ct-pos");
  }
}

function fechaModal(modal) {
  if (modal == "add") {
    $("p.form-message").empty();
    $('.form_anuncio')[0].reset();
    $("#md-pr").removeClass("md-ct").addClass("md-ct-pos");
    $("#add").removeClass("form_anuncio").addClass("md-ct-pos");

  } else if (modal == "editar-excluir") {
    $("#md-pr").removeClass("md-ct").addClass("md-ct-pos");
    $("#editar-excluir").addClass("md-ct-pos").removeClass("form_anuncio");
  } else if  (modal == "conf-excluir") {
    $("#md-pr2").removeClass("md-ct").addClass("md-ct-pos");
    $("#conf-excluir").addClass("md-ct-pos").removeClass("form_anuncio");
  }
}

$(document).ready(function () {

  $("div.item").click(function (e){

    e.preventDefault();  

    var idSelector = this.id;

    var titulo = $("div#"+idSelector+" [name='titulo-item']").text(), 
        userA = $("div#"+idSelector+" [name='username-item']").text(),
        username = userA.replace("@", "");
    
    $.post("/GitHub/Kamaleao/app/private/Controller/controllerInfoServico.php", {titulo: titulo, username: username},function (resposta) {
        var a =  jQuery.parseJSON(resposta);
        $("p span#titSub").text(a.titulo);
        $("p span#valSub").text(a.valor);
        $("textarea#descSub").text(a.desc);
        $("p span#liSub").text(a.licenca);
        $("p span#catSub").text(a.categoria);
        $(".img-item").attr("src", a.urlfoto);
        abreModal("editar-excluir");
        $("#cdhidden").text(a.cdServ);
      });
  });
  
  $("button#exclui").click(function (e) { 
    e.preventDefault();

    var cdServ = $("p#cdhidden").text();

    $.get("/GitHub/Kamaleao/app/private/Controller/controllerDeletaServiço.php", {serviço: cdServ},
      function (data) {
        alert("Belo diz: " + data);
      }
    );
    
  });
});


