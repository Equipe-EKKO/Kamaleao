$(document).ready(function () {

    $("div.item").click(function (e){
        var divid = $(this).attr('id'),
            titulo = $("div#"+ divid +" [name='titulo-item']").text(), 
            userA = $("div#"+ divid +" [name='username-item']").text(),
            username = userA.replace("@", "");

        window.location.href="/Github/Kamaleao/app/public/view/pós_login/anuncio/anuncio?username=" + username + "&titulo=" + titulo;
    });
});