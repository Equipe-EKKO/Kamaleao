$(function(){

    verificarCliqueMenu();

    function verificarCliqueMenu(){
        $('a').click(function(){
            var href = $(this).attr('href');
            $.ajax({
                'beforeSend': function(){
                    console.log("estamos chamando o beforesend!");
                },
                'timeout': 10000,
                'url':href,
                'error':function(){
                    console.log("ocorreu um erro seu babaca");
                },
                'success':function(data){
                    $('#dentro').html(data);
                }
            })
            return false;
        })
    }
});