$(document).ready(function () {

  $("div.item").click(function (e){
      var divid = $(this).attr('id'),
          titulo = $("div#"+ divid +" [name='titulo-item']").text(), 
          userA = $("div#"+ divid +" [name='username-item']").text(),
          username = userA.replace("@", "");

      window.location.href="/Github/Kamaleao/app/public/view/pós_login/anuncio/anuncio?username=" + username + "&titulo=" + titulo;
  });
});

function abreModal() {
  $("#md-pr").removeClass("md-ct-pos").addClass("md-ct"); 
  $("#md-pedido").removeClass("md-ct-pos").addClass("md-pedido"); 
}

function fechaModal() {
  $("#md-pr").removeClass("md-ct").addClass("md-ct-pos"); 
  $("#md-pedido").removeClass("md-pedido").addClass("md-ct-pos");
  $("#fazPedidoReturn.form-message").empty();
  $("#fazPedidoReturn.form-message").removeClass("erro");
  $("#fazPedidoReturn.form-message").removeClass("sucesso");
  $("#fazPedidoReturn.form-message").attr("hidden", "true");
  $("input#titulo").val("");
  $("textarea#descricao").val("");
}

$(document).ready(function () {

  $("button#solicitaPedido").click(function (e){
    e.preventDefault();  

    var cdServ = $("p#hiddenpedido").text(),
        nmUser = $("p#hiddenpedidouser").text(), 
        titulo = $("input#titulo").val(),
        descricao = $("textarea#descricao").val();

    $.post("/GitHub/Kamaleao/app/private/Controller/controllerFazPedido.php", {nmuser: nmUser, cd_serviço: cdServ, titulo: titulo, desc: descricao},
      function (data) {
        if (data == true) {
          $("#fazPedidoReturn.form-message").removeClass("erro");
          $("#fazPedidoReturn.form-message").removeAttr("hidden");
          $("#fazPedidoReturn.form-message").addClass("sucesso");
          $("#fazPedidoReturn.form-message").empty();
          var sucesso = "<i class='fas fa-exclamation-triangle'></i> <span> O pedido foi realizado!</span>";
          $(sucesso).appendTo("#fazPedidoReturn.form-message");
          setTimeout(function () {
            fechaModal();
          }, 1000);
        } else {
          $("#fazPedidoReturn.form-message").removeClass("sucesso");
          $("#fazPedidoReturn.form-message").removeAttr("hidden");
          $("#fazPedidoReturn.form-message").addClass("erro");
          var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + data + "</span>";
          var mes = $("#fazPedidoReturn.form-message").html();
          if (mes.includes("realizado") == false) {
            $("#fazPedidoReturn.form-message").empty();
            $(erro).appendTo("#fazPedidoReturn.form-message");
          }
        }  
      });
  });
});