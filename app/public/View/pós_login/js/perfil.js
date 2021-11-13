function abreModal(modal) {
  if (modal == "add") {
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#editar-excluir").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#formAnuncio").addClass("form_anuncio").removeClass("md-ct-pos");

    $("#formAnuncio").submit(function (e) {
      e.preventDefault();

      var form_data = new FormData();
      form_data.append('titulo', $('input#titulo').val());
      form_data.append('descricao', $('input#descricao').val());
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
              fechaModal();
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

  }
  if (modal == "editar-excluir") {
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#formAnuncio").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#editar-excluir").addClass("form_anuncio").removeClass("md-ct-pos");
    $("#conf-excluir").addClass("md-ct-pos").removeClass("form_anuncio");
  }
  if (modal == "conf-excluir") {
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#conf-excluir").addClass("form_anuncio").removeClass("md-ct-pos");
    $("#editar-excluir").removeClass("form_anuncio").addClass("md-ct-pos");
  }

  if (modal == "modal-editar") {
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#modal-editar").addClass("form_edit").removeClass("md-ct-pos");
    $("#editar-excluir").removeClass("form_anuncio").addClass("md-ct-pos");
  }

  if (modal == "titulo") {
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-titulo").addClass("form_edit").removeClass("md-ct-pos");
    $("#modal-editar").removeClass("form_edit").addClass("md-ct-pos");
  }

  if (modal == "preco") {
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-preco").addClass("form_edit").removeClass("md-ct-pos");
    $("#modal-editar").removeClass("form_edit").addClass("md-ct-pos");
  }

  if (modal == "desc") {
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-desc").addClass("form_edit").removeClass("md-ct-pos");
    $("#modal-editar").removeClass("form_edit").addClass("md-ct-pos");
  }

  if (modal == "licenca") {
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-licenca").addClass("form_edit").removeClass("md-ct-pos");
    $("#modal-editar").removeClass("form_edit").addClass("md-ct-pos");
  }

  if (modal == "categoria") { // deu certo nao
    $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-categoria").addClass("form_edit").removeClass("md-ct-pos");
    $("#modal-editar").removeClass("form_edit").addClass("md-ct-pos");
  }
}7
function fechaModal(modal) {
    $("p.form-message").empty();
    $('#formAnuncio')[0].reset();
    $("#md-pr").removeClass("md-ct").addClass("md-ct-pos");
    $("#modal-editar").addClass("md-ct-pos").removeClass("form_edit");
    $("#alt-titulo").addClass("md-ct-pos").removeClass("form_edit");
    $("#alt-desc").addClass("md-ct-pos").removeClass("form_edit");
    $("#alt-preco").addClass("md-ct-pos").removeClass("form_edit");
    $("#alt-categoria").addClass("md-ct-pos").removeClass("form_edit");
    $("#alt-licenca").addClass("md-ct-pos").removeClass("form_edit");

    if (modal == "conf-excluir") {
      $("#md-pr").removeClass("md-ct-pos").addClass("md-ct");
      $("#formAnuncio").removeClass("form_anuncio").addClass("md-ct-pos");
      $("#editar-excluir").addClass("form_anuncio").removeClass("md-ct-pos");
      $("#conf-excluir").addClass("md-ct-pos").removeClass("form_anuncio");
    }
}
