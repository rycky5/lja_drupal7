var start = 0;
var count = 10;
var _renderItem = function(data) {
    var card =  '<article class="thumbnail ' + data.caderno + '"><a class="fotocapa" href="#"><img src="' + data.imageUrl + '"></a><div class="col-xs-10 no-padding"><a href="#"><h1 class="noticia-titulo">' + data.caderno + '</h1></a></div><div class="col-xs-2 no-padding"><a href="#" data-toggle="modal" data-target="#modal-share"><img class="share" src="img/icon_share_' + data.caderno + '.svg"></a></div><div class="col-xs-12 no-padding"><h2>' + data.caderno + '</h2></div><div class="col-xs-12 no-padding"><h4> | ' + data.created + '</h4></div><hr></article>';                               
    return card;
}       

$(window).scroll(function() {
    //verificar se existe alguma outra requisição ajax em andamento
    if ($(window).data('ajax_in_progress') === true)
        return;
    //verificar a posição de scroll
    if ($(window).scrollTop() == $(document).height() - $(window).height()) {
        //marcar ajax_in_progress como verdadeiro
        $(window).data('ajax_in_progress', true);
        //monstrar o gif de carregando no rodapé da página
        $('div#loading-icon').show();
        //requisição ajax
        $.ajax({
            url: "http://www.leiaja.com/admin-capa/ajax/get-noticias?count=" + count + "&offset=" + start,
            success: function(response) {
                //continuar se tudo deu certo
                if (response) {
                    var jsonData = JSON.parse(response);
                    //selecionar a div que vai receber o json
                    $container = $("#main-container");
                    var newElements = "";
                    //começa o loop
                    for (var i = 0; i < jsonData.length; i++) {
                        //colocando os dados em template
                        var item = $(_renderItem(jsonData[i]));
                        $container.append(item);
                    }
                    $('div#loading-icon').hide();
                    $(window).data('ajax_in_progress', false);
                } else {
                    $('div#loading-icon').html('<center>Sem mais notícias para exibir</center>');
                    $(window).data('ajax_in_progress', false);
                }
            }
        });
    }
});