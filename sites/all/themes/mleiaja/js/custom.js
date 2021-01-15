(function ($) {

    noticiasJson = '';
    siteUrl = 'http://m.leiaja.com';

    //Url da p√°gina
//    var urlPagina = window.location.href;
//    var parameterP = getUrlParameter('p');

    getJsonNoticias();


    function getJsonNoticias(caderno = '', numeroDeItens = '') {

        var pCaderno = getUrlParameter('p');

        if (caderno == '' && numeroDeItens == '' && pCaderno == undefined) {

            $.getJSON("/mobile/mobile.json", function (data) {
                noticiasJson = data;
                monstarHome(noticiasJson);
            });

        } else {
            $.getJSON("/mobile/" + pCaderno + "/mobile.json", function (data) {
                noticiasJson = data;
                monstarHome(noticiasJson);
            });
    }
    }

    function gerarNoticia(noticiasJson) {

        var qtdNoticias = $("#main-container").children(".blocoNode").size();
        var sliceJson = noticiasJson.slice(qtdNoticias, qtdNoticias + 10);
        $.each(sliceJson, function (index, noticia) {
            montarHtml(noticia);
        });

    }

    function monstarHome(noticiasJson) {
        sliceJson = noticiasJson.slice(0, 10);
        $.each(sliceJson, function (index, noticia) {
            montarHtml(noticia);
        });
    }

    function montarHtml(noticia) {
        var caderno = noticia.caderno;
        var nomeCaderno = caderno.replace('caderno_', '');
        var html = '<article class="thumbnail blocoNode ' + nomeCaderno + '">';
        var categoria = (noticia.subCategoria != null) ? noticia.subCategoria + ' | ' + noticia.created : noticia.created;

        if (noticia.image == 1) {
            html += '<a href="' + siteUrl + noticia.nodeUrl + '">' +
                    '<img src="' + noticia.imageUrl.replace('LEIAJAURL', siteUrl) + '">' +
                    '</a>';
        }
        html += '<a href="' + siteUrl + noticia.nodeUrl + '">' +
                '<h1>' + noticia.titulo + '</h1>' +
                '</a>' +
                '<div class="col-xs-10 no-padding">' +
                '<h2>' + categoria + '</h2>' +
                '</div>' +
                '<div class="col-xs-2 no-padding">' +
                '<a href="#" data-toggle="modal" data-target="#modal-share-' + noticia.nid + '"><img class="share" src="/sites/all/themes/mleiaja/img/icon_share_' + nomeCaderno + '.svg"></a>' +
                '</div>' +
                '<hr>' +
                '<!-- ComeÁa Modal Compartilhar -->' +
                '<div id="modal-share-' + noticia.nid + '" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">' +
                '<div class="modal-dialog modal-sm">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<h5 class="modal-title" id="modal-share-title">Compartilhar</h5>' +
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>' +
                '<div class="modal-body">' +
                '<div class="col-xs-4 align-center">' +
                '<div class="" data-href="' + siteUrl + noticia.nodeUrl + '" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=' + siteUrl + noticia.nodeUrl + '" class="fb-xfbml-parse-ignore facebook"><img src="sites/all/themes/mleiaja/img/icon_facebook.svg" alt="Compartilhar no Facebook"></a></div>' +
                '</div>' +
                '<div class="col-xs-4 align-center"><a target="_blank" href="https://twitter.com/intent/tweet?text=' + noticia.titulo + ': ' + siteUrl + noticia.nodeUrl + '" class="twitter"><img src="sites/all/themes/mleiaja/img/icon_twitter.svg" alt="Compartilhar no Twitter"></a></div>' +
                '<div class="col-xs-4 align-center">' +
                '<a target="_blank" href="https://api.whatsapp.com/send?text=' + noticia.titulo + ': ' + siteUrl + noticia.nodeUrl + '" class="whatsapp"><img src="sites/all/themes/mleiaja/img/icon_whatsapp.svg" alt="Compartilhar no Whatsapp"></a>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<!-- Termina Modal Compartilhar -->' +
                '</article>';

        $('#main-container').append(html);
    }

    $(window).scroll(function () {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            $('div#loading-icon').show();
            gerarNoticia(noticiasJson);
            $('div#loading-icon').hide();
        }
    });

    function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                SparameterName,
                i;
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName['1'];
            }
        }
    }

    $(".campo-busca button").click(function () {
//        var searchValeu = $(".campo-b/usca input").val().replace(/\s/g, '+');
        var searchValeu = $(".campo-busca input").val();

        if (searchValeu !== '') {

            $(location).attr('href', 'http://www.leiaja.com/search/site/' + searchValeu);

        }
    });

}(jQuery));
