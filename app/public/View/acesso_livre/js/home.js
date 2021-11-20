$(document).ready(function () {

    $("div.item").click(function (e){
        var divid = $(this).attr('id');
    
        window.location.href="/Github/Kamaleao/app/public/view/pós_login/anuncio/anuncio?itemid=" + divid;
    });
});