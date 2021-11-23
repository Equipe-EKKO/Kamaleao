function abreModal(modal) {
  $("#md-pr").removeClass("md-ct-pos").addClass("md-ct"); // qualquer modal que vai ser aberto precisa do fundo
  if (modal == "add") {
    $("#add").removeClass("md-ct-pos").addClass("form_anuncio");
    $("#editar-excluir").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#modal-editar").removeClass("form_edit").addClass("md-ct-pos");
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
              location.reload(true);

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
  } else if (modal == "conf-excluir") {
    $("#md-pr3").removeClass("md-ct-pos").addClass("md-ct");
    $("#conf-excluir").addClass("form_anuncio").removeClass("md-ct-pos");
  } else if (modal == "modal-editar") {
    $("#modal-editar").removeClass("md-ct-pos").addClass("form_edit");
    $("#editar-excluir").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-titulo").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-preco").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-desc").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-licenca").removeClass("form_anuncio").addClass("md-ct-pos");
    $("#alt-categoria").removeClass("form_anuncio").addClass("md-ct-pos");
  } else if (modal == "titulo") {
    $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-titulo").addClass("form_anuncio").removeClass("md-ct-pos");
    $("p.form-message").empty();
    $("p#resultsec").removeClass("sucesso");
    $("p#resultsec").removeClass("erro");

    $('#alt-tit').focus(function (e) {
      e.preventDefault();
      $(this).val("");
      $("p.form-message").empty();
      $("p#resultsec").removeClass("sucesso");
      $("p#resultsec").removeClass("erro");
    });

    /*AJAX PRA TROCAR O TITULO*/
    $("#alt-titulo").submit(function (e) {
      e.preventDefault(); // Stop form from submitting normally
      var titulo = $('#alt-tit').val(),
        cdServ = $("p#hiddenedita1").text();

      $.post("/GitHub/Kamaleao/app/private/Controller/controllerAlteraTitulo.php", { titulo: titulo, cd_serviço: cdServ }, function (resposta) {
        if (resposta == 1) {
          $("p#resultsec").removeAttr("hidden");
          $("p#resultsec").addClass("sucesso");
          var sucesso = "<i class='fas fa-exclamation-triangle'></i> <span>O título do serviço foi atualizado!</span>";
          $(sucesso).appendTo("p#resultsec");

          setTimeout(function () {
            fechaModal('alt-titulo');
            fechaModal('modal-editar');
            location.reload(true);

          }, 1000);

        } else {
          $("p#resultsec").removeAttr("hidden");
          $("p#resultsec").addClass("erro");
          var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + resposta + "</span>";
          var mes = $("p#resultsec").html();
          if (mes.includes("atualizado") == false) {
            $("p#resultsec").empty();
            $(erro).appendTo("p#resultsec");
          }
        }
      });
    });
  } else if (modal == "preco") {
    $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-preco").addClass("form_anuncio").removeClass("md-ct-pos");
    $("p.form-message").empty();
    $("p#resultthird").removeClass("sucesso");
    $("p#resultthird").removeClass("erro");

    $('#alt-prec').focus(function (e) {
      e.preventDefault();
      $(this).val("");
      $("p.form-message").empty();
      $("p#resultthird").removeClass("sucesso");
      $("p#resultthird").removeClass("erro");
    });

    /*AJAX PRA TROCAR O PREÇO*/
    $("#alt-preco").submit(function (e) {
      e.preventDefault(); // Stop form from submitting normally
      var preco = $('#alt-prec').val(),
        cdServ = $("p#hiddenedita2").text();

      $.post("/GitHub/Kamaleao/app/private/Controller/controllerAlteraPreço.php", { preço: preco, cd_serviço: cdServ }, function (resposta) {
        if (resposta == 1) {
          $("p#resultthird").removeAttr("hidden");
          $("p#resultthird").addClass("sucesso");
          var sucesso = "<i class='fas fa-exclamation-triangle'></i> <span>O preço médio do serviço foi atualizado!</span>";
          $(sucesso).appendTo("p.form-message");

          setTimeout(function () {
            fechaModal('alt-preco');
            fechaModal('modal-editar');
            location.reload(true);
          }, 1000);

        } else {
          $("p#resultthird").removeAttr("hidden");
          $("p#resultthird").addClass("erro");
          var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + resposta + "</span>";
          var mes = $("p#resultthird").html();
          if (mes.includes("atualizado") == false) {
            $("p#resultthird").empty();
            $(erro).appendTo("p#resultthird");
          }
        }
      });
    });
  } else if (modal == "desc") {
    $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-desc").addClass("form_anuncio").removeClass("md-ct-pos");
    $("p.form-message").empty();
    $("p#resultfourth").removeClass("sucesso");
    $("p#resultfourth").removeClass("erro");

    $('#alt-desci').focus(function (e) {
      e.preventDefault();
      $(this).val("");
      $("p.form-message").empty();
      $("p#resultfourth").removeClass("sucesso");
      $("p#resultfourth").removeClass("erro");
    });

    /*AJAX PRA TROCAR A DESCRIÇÃO*/
    $("#alt-desc").submit(function (e) {
      e.preventDefault(); // Stop form from submitting normally
      var desc = $('#alt-desci').val(),
        cdServ = $("p#hiddenedita3").text();

      $.post("/GitHub/Kamaleao/app/private/Controller/controllerAlteraDescricaoAnuncio.php", { descricao: desc, cd_serviço: cdServ }, function (resposta) {
        if (resposta == 1) {
          $("p#resultfourth").removeAttr("hidden");
          $("p#resultfourth").addClass("sucesso");
          var sucesso = "<i class='fas fa-exclamation-triangle'></i> <span>A descrição do serviço foi atualizada!</span>";
          $(sucesso).appendTo("p#resultfourth");

          setTimeout(function () {
            fechaModal('alt-desc');
            fechaModal('modal-editar');
            location.reload(true);
          }, 1000);

        } else {
          $("p#resultfourth").removeAttr("hidden");
          $("p#resultfourth").addClass("erro");
          var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + resposta + "</span>";
          var mes = $("p#resultfourth").html();
          if (mes.includes("atualizada") == false) {
            $("p#resultfourth").empty();
            $(erro).appendTo("p#resultfourth");
          }
        }
      });
    });
  } else if (modal == "licenca") {
    $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-licenca").addClass("form_anuncio").removeClass("md-ct-pos");
    $("p.form-message").empty();
    $("p#resultfifth").removeClass("sucesso");
    $("p#resultfifth").removeClass("erro");

    /*AJAX PRA TROCAR A lICENÇA*/
    $("#alt-licenca").submit(function (e) {
      e.preventDefault(); // Stop form from submitting normally
      var lic = $('input[name="licenca2"]:checked').val(),
        cdServ = $("p#hiddenedita4").text();

      $.post("/GitHub/Kamaleao/app/private/Controller/controllerAlteraLicença.php", { licença: lic, cd_serviço: cdServ }, function (resposta) {
        if (resposta == 1) {
          $("p#resultfifth").removeAttr("hidden");
          $("p#resultfifth").addClass("sucesso");
          var sucesso = "<i class='fas fa-exclamation-triangle'></i> <span>A licença do serviço foi atualizada!</span>";
          $(sucesso).appendTo("p#resultfifth");

          setTimeout(function () {
            fechaModal('alt-licenca');
            fechaModal('modal-editar');
            location.reload(true);
          }, 1000);

        } else {
          $("p#resultfifth").removeAttr("hidden");
          $("p#resultfifth").addClass("erro");
          var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + resposta + "</span>";
          var mes = $("p#resultfifth").html();
          if (mes.includes("atualizada") == false) {
            $("p#resultfifth").empty();
            $(erro).appendTo("p#resultfifth");
          }
        }
      });
    });
  } else if (modal == "categoria") {
    $("#md-pr2").removeClass("md-ct-pos").addClass("md-ct");
    $("#alt-categoria").addClass("form_anuncio").removeClass("md-ct-pos");
    $("p.form-message").empty();
    $("p#resultsixth").removeClass("sucesso");
    $("p#resultsixth").removeClass("erro");

    /*AJAX PRA TROCAR A CATEGORIA*/
    $("#alt-categoria").submit(function (e) {
      e.preventDefault(); // Stop form from submitting normally
      var cat = $('#select_cat2').val(),
        cdServ = $("p#hiddenedita5").text();

      $.post("/GitHub/Kamaleao/app/private/Controller/controllerAlteraCategoria.php", { categoria: cat, cd_serviço: cdServ }, function (resposta) {
        if (resposta == 1) {
          $("p#resultsixth").removeAttr("hidden");
          $("p#resultsixth").addClass("sucesso");
          var sucesso = "<i class='fas fa-exclamation-triangle'></i> <span>A categoria do serviço foi atualizada!</span>";
          $(sucesso).appendTo("p#resultsixth");

          setTimeout(function () {
            fechaModal('alt-categoria');
            fechaModal('modal-editar');
            location.reload(true);
          }, 1000);

        } else {
          $("p#resultsixth").removeAttr("hidden");
          $("p#resultsixth").addClass("erro");
          var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + resposta + "</span>";
          var mes = $("p.form-message").html();
          if (mes.includes("atualizado") == false) {
            $("p#resultsixth").empty();
            $(erro).appendTo("p#resultsixth");
          }
        }
      });
    });
  }
  if (modal == "modal-pedido") {
    $("#md-pr4").removeClass("md-ct-pos").addClass("md-ct");
    $("#modal-pedido").removeClass("md-ct-pos").addClass("form_anuncio");
  }

  if (modal == "valor-pedido") {
    $("#md-pr5").removeClass("md-ct-pos").addClass("md-ct");
    $("#valor-pedido").removeClass("md-ct-pos").addClass("form_anuncio");
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
  } else if (modal == "conf-excluir") {
    $("#md-pr3").removeClass("md-ct").addClass("md-ct-pos");
    $("#conf-excluir").addClass("md-ct-pos").removeClass("form_anuncio");
  } else if (modal == "modal-editar") {
    $("#md-pr").removeClass("md-ct").addClass("md-ct-pos");
    $("#modal-editar").addClass("md-ct-pos").removeClass("form_edit");
  } else if (modal == "alt-titulo") {
    $("#md-pr2").removeClass("md-ct").addClass("md-ct-pos");
    $("#alt-titulo").addClass("md-ct-pos").removeClass("form_anuncio");
  } else if (modal == "alt-preco") {
    $("#md-pr2").removeClass("md-ct").addClass("md-ct-pos");
    $("#alt-preco").addClass("md-ct-pos").removeClass("form_anuncio");
  } else if (modal == "alt-desc") {
    $("#md-pr2").removeClass("md-ct").addClass("md-ct-pos");
    $("#alt-desc").addClass("md-ct-pos").removeClass("form_anuncio");
  } else if (modal == "alt-licenca") {
    $("#md-pr2").removeClass("md-ct").addClass("md-ct-pos");
    $("#alt-licenca").addClass("md-ct-pos").removeClass("form_anuncio");
    $('input[name="licenca2"]:checked').prop('checked', false);
    $("p.form-message").empty();
    $("p#resultfifth").removeClass("sucesso");
    $("p#resultfifth").removeClass("erro");
  } else if (modal == "alt-categoria") {
    $("#md-pr2").removeClass("md-ct").addClass("md-ct-pos");
    $("#alt-categoria3").addClass("md-ct-pos").removeClass("form_anuncio");
  } else if (modal == "modal-pedido") {
    $("#md-pr4").addClass("md-ct-pos").removeClass("md-ct");
    $("#md-pr3").removeClass("md-ct").addClass("md-ct-pos");
    $("#md-pr2").removeClass("md-ct").addClass("md-ct-pos");
    $("#md-pr").removeClass("md-ct").addClass("md-ct-pos");
    $("#modal-pedido").addClass("md-ct-pos").removeClass("form_edit");
  } else if (modal == "valor-pedido") {
    $("#md-pr5").addClass("md-ct-pos").removeClass("md-ct");
    $("#valor-pedido").addClass("md-ct-pos").removeClass("form_edit");
  }
}

$(document).ready(function () {

  $("div.aceitaCon").click(function (e) {

    e.preventDefault();

    var idSelector = this.id;

    $.post("/GitHub/Kamaleao/app/private/Controller/controllerInfoComissao.php", { idpedido: idSelector }, function (resposta) {

      var a = jQuery.parseJSON(resposta);

      $("p#titPed").text(a.tituloped);
      $("p#titServ").text(a.tituloserv);
      $("textarea#descPed").text(a.descped);
      $("span#idPed").text(idSelector);
      abreModal("modal-pedido");
    });
  });

  $("div.item").click(function (e) {

    e.preventDefault();

    var idSelector = this.id;

    var titulo = $("div#" + idSelector + " [name='titulo-item']").text(),
      userA = $("div#" + idSelector + " [name='username-item']").text(),
      username = userA.replace("@", "");

    $.post("/GitHub/Kamaleao/app/private/Controller/controllerInfoServico.php", { titulo: titulo, username: username }, function (resposta) {
      var a = jQuery.parseJSON(resposta);
      $("p span#titSub").text(a.titulo);
      $("p span#valSub").text("R$" + a.valor);
      $("textarea#descSub").text(a.desc);
      $("p span#liSub").text(a.licenca);
      $("p span#catSub").text(a.categoria);
      $(".img-item").attr("src", a.urlfoto);
      abreModal("editar-excluir");
      $(".cdhidden").text(a.cdServ);
    });
  });

  $("button#exclui").click(function (e) {
    e.preventDefault();

    var cdServ = $("p#hiddenexclui").text();

    $.get("/GitHub/Kamaleao/app/private/Controller/controllerDeletaServiço.php", { serviço: cdServ },
      function (data) {
        if (data == true) {
          $("#exclui-anuncio.form-message").removeClass("sucesso");
          $("#exclui-anuncio.form-message").removeClass("erro");
          $("#exclui-anuncio.form-message").removeAttr("hidden");
          $("#exclui-anuncio.form-message").addClass("sucesso");
          $("#exclui-anuncio.form-message").empty();
          var sucesso = "<i class='fas fa-exclamation-triangle'></i> <span> O anúncio foi excluído!</span>";
          $(sucesso).appendTo("#exclui-anuncio.form-message");
          setTimeout(function () {
            fechaModal('conf-excluir');
            fechaModal('editar-excluir');
            location.reload(true)
          }, 1000);
        } else {
          $("#exclui-anuncio.form-message").removeClass("sucesso");
          $("#exclui-anuncio.form-message").removeClass("erro");
          $("#exclui-anuncio.form-message").removeAttr("hidden");
          $("#exclui-anuncio.form-message").addClass("erro");
          var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + resposta + "</span>";
          var mes = $("#exclui-anuncio.form-message").html();
          if (mes.includes("excluído") == false) {
            $("#exclui-anuncio.form-message").empty();
            $(erro).appendTo("#exclui-anuncio.form-message");
          }
        }
      });
  });

  $("button#negaPedido").click(function (e) {
    e.preventDefault();

    var cdPedido = $("span#idPed").text();

    $.get("/GitHub/Kamaleao/app/private/Controller/controllerNegaPedido.php", { pedido: cdPedido },
      function (data) {
        if (data == true) {
          $("p.form-message").removeClass("sucesso");
          $("p.form-message").removeClass("erro");
          $("p.form-message").removeAttr("hidden");
          $("p.form-message").addClass("sucesso");
          $("p.form-message").empty();
          var sucesso = "<i class='fas fa-exclamation-triangle'></i> <span>O pedido foi negado.</span>";
          $(sucesso).appendTo("p.form-message");
          setTimeout(function () {
            fechaModal('conf-excluir');
            fechaModal('editar-excluir');
            location.reload(true)
          }, 1000);
        } else {
          $("p.form-message").removeClass("sucesso");
          $("p.form-message").removeClass("erro");
          $("p.form-message").removeAttr("hidden");
          $("p.form-message").addClass("erro");
          var erro = "<i class='fas fa-exclamation-triangle'></i> <span> " + data + "</span>";
          var mes = $("p.form-message").html();
          if (mes.includes("negado") == false) {
            $("p.form-message").empty();
            $(erro).appendTo(".form-message");
          }
        }
      });
  });
});

const postContainer = document.getElementById('posts-container')
const loading = document.querySelector('.loader');
const filter = document.getElementById('filter');

let limit = 5;
let page = 1;

async function getPosts() {
  const res = await fetch(
    `https://jsonplaceholder.typicode.com/posts?_limit=${limit}&_page=${page}`
  );

  const data = await res.json();

  return data;
}

async function showPosts() {
  const posts = await getPosts()
  posts.forEach(post => {
    const postEl = document.createElement('div');
    postEl.classList.add('post');
    postEl.innerHTML = `
      <div class="post-info">
        <h2 class="post-title">${post.title}</h2>
        <p class="post-body">${post.body}</p>
      </div>
    `;

    postContainer.appendChild(postEl)
  });
}


function filterPosts(e) {
  const term = e.target.value.toUpperCase();
  const posts = document.querySelectorAll('.post');

  posts.forEach(post => {
    const title = post.querySelector('.post-title').innerText.toUpperCase();
    const body = post.querySelector('.post-body').innerText.toUpperCase();

    if (title.indexOf(term) > -1 || body.indexOf(term) > -1) {
      post.style.display = 'flex';
    } else {
      post.style.display = 'none';
    }
  });
}
showPosts()


function showLoading() {
  loading.classList.add('show');

  setTimeout(() => {
    loading.classList.remove('show')

    setTimeout(() => {
      page++;
      showPosts();
    }, 300);
  }, 1000)
}

window.addEventListener('scroll', () => {
  const { scrollTop, scrollHeight, clientHeight } = document.documentElement;

  if (scrollTop + clientHeight >= scrollHeight - 5) {
    showLoading()
  }
});



filter.addEventListener('input', filterPosts)