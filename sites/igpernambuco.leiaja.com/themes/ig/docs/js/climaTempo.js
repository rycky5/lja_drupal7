
        
		var E13706cidadeprevisao = null;
        var cidadesRetornadas = null;
        $(document).ready(function() {
            $("input#txt_cidadeprevisao").autocomplete({
                source: function(request, response) {   
                    if (cidadesRetornadas == null) {
                        cidadesRetornadas = function(data){
                            if (data && data.hits) {
                                response($.map(data.hits.hits, function(item){
                                    var estado = ('' + item._source.cidade.estado).toUpperCase();
                                    return {
                                        label: item._source.cidade.nome + '-' + estado,
                                        value: item._source.cidade.nome,
                                        codigo: item._source.cidade.codigo
                                    }
                                }))
                            } 
                            else {
                                window.alert('Dados não retornados do servidor.');
                            }
                        };
                    }
                    $.ajax({
                        type: "GET",
                        url: "http://ultimosegundo.ig.com.br/_servicos/ig/cidade/_search",
                        dataType: 'jsonp',
                        data: {
                            size : "10",
                            q : "nome:" + request.term.toLowerCase() + "*"
                        },                      
                        jsonpCallback : 'cidadesRetornadas'
                    });             
                },
                delay:100,
                minLength:1,
                dataType: 'json',
                select: function(event, ui) {
                    if (ui.item) {
                        $('#nome_cidade').text(ui.item.label);
                        E13706cidadeprevisao = ui.item.label + '-' + ui.item.codigo;
                        setCookie('cidadeprevisao', ui.item.label + '-' + ui.item.codigo);
                        carregarPrevisaoCidade(ui.item.codigo);
                    } else {
                        $('#nome_cidade').text('');
                    }
                }
            });
            // Configura o ganho do foco do autocomplete:
            $("input#txt_cidadeprevisao").focus(function(event, ui) {
                if (this.value.length > 0) {
                    this.value = ''
                }
            });
            // Configura a perda do foco do autocomplete:
            $("input#txt_cidadeprevisao").blur(function(event, ui) {
                if (this.value.length == 0) {
                    this.value = 'Digite o nome da cidade';
                }
            });
            var temCookie = carregarPrevisaoCidadeSalva();
            if(!temCookie){
                if((!tempoEstado) || (!tempoCidade)){
                    var tempoEstado = "null";
                    var tempoCidade = "null";
                };
                var mapaEstadoCapitaisCodigo = {
                    "e_acre" : "6",
                    "e_sao_paulo" : "558",
                    "e_sergipe" : "384",
                    "e_minas_gerais" : "107",
                    "e_distrito_federal" : "61",
                    "e_mato_grosso_do_sul" : "212",
                    "e_mato_grasso" : "218",
                    "e_parana" : "271",
                    "e_santa_catarina" : "377",
                    "e_ceara" : "60",
                    "e_goiais" : "88",
                    "e_paraiba" : "256",
                    "e_amapa" : "39",
                    "e_alagoas" : "8",
                    "e_amazonas" : "25",
                    "e_rio_grande_do_norte" : "334",
                    "e_tocantins" : "593",
                    "e_rio_grande_do_sul" : "363",
                    "e_rondonia" : "343",
                    "e_pernambuco" : "259",
                    "e_rio_de_janeiro" :"321",
                    "e_bahia" : "56",
                    "e_maranhao" : "94",
                    "e_piaui" : "264",
                    "e_espirito_santo" : "84"
                };
                var mapaCapitaisCodigo = {
                    "rio_branco" : "6",
                    "sao_paulo" : "558",
                    "aracaju" : "384",
                    "belo_horizonte" : "107",
                    "brasilia" : "61",
                    "campo_grande" : "212",
                    "cuiaba" : "218",
                    "curitiba" : "271",
                    "florianopolis" : "377",
                    "fortaleza" : "60",
                    "goiania" : "88",
                    "joao_pessoa" : "256",
                    "macapa" : "39",
                    "maceio" : "8",
                    "manaus" : "25",
                    "natal" : "334",
                    "palmas" : "593",
                    "porto_alegre" : "363",
                    "porto_velho" : "343",
                    "recife" : "259",
                    "rio_de_janeiro" : "321",
                    "salvador" : "56",
                    "sao_luis" : "94",
                    "teresina" : "264",
                    "vitoria" : "84"
                };
                var mapaCapitaisCodigoNome = {
                    "6" : "Rio Branco-AC",
                    "558" : "São Paulo-SP",
                    "384" : "Aracaju-SE",
                    "107" : "Belo Horizonte-MG",
                    "61" : "Brasília-DF",
                    "212" : "Campo Grande-MS",
                    "218" : "Cuiabá-MT",
                    "271" : "Curitiba-PR",
                    "377" : "Florianópolis-SC",
                    "60" : "Fortaleza-CE",
                    "88" : "Goiânia-GO",
                    "256" : "João Pessoa-PB",
                    "39" : "Macapá-AP",
                    "8" : "Maceió-AL",
                    "25" : "Manaus-AM",
                    "334" : "Natal-RN",
                    "593" : "Palmas-TO",
                    "363" : "Porto Alegre-RS",
                    "343" : "Porto Velho-RO",
                    "259" : "Recife-PE",
                    "321" : "Rio de Janeiro-RJ",
                    "56" : "Salvador-BA",
                    "94" : "Sao Luis-MA",
                    "264" : "Teresina-PI",
                    "84" : "Vitoria-ES"
                };
                if((tempoEstado!="null") && (tempoCidade == "null")){
                   var  cidade = mapaEstadoCapitaisCodigo[tempoEstado];
                };  
                if ((tempoEstado!="null") && (tempoCidade != "null") ){
                   var cidade = mapaEstadoCapitaisCodigo[tempoEstado];
                };   
                if ((tempoEstado=="null") && (tempoCidade != "null") ){
                   var cidade = mapaCapitaisCodigo[tempoCidade];
                };
                if(cidade){
                    $('#nome_cidade').text(mapaCapitaisCodigoNome[cidade]);
                    E13706cidadeprevisao = mapaCapitaisCodigoNome[cidade];
                    setCookie('cidadeprevisao', mapaCapitaisCodigoNome[cidade]+'-' + cidade);
                    carregarPrevisaoCidade(cidade);
                }else{
                    $('#nome_cidade').text("Recife-PE");
                    E13706cidadeprevisao = "Recife-PE";
                    setCookie('cidadeprevisao', 'Recife-PE-259');
                    carregarPrevisaoCidade("259");
                };   
            }
        });
function E13706_removerDiacriticos(s) {
    var diacritics = [
    [/[\300-\306]/g, 'A'],
    [/[\340-\346]/g, 'a'],
    [/[\310-\313]/g, 'E'],
    [/[\350-\353]/g, 'e'],
    [/[\314-\317]/g, 'I'],
    [/[\354-\357]/g, 'i'],
    [/[\322-\330]/g, 'O'],
    [/[\362-\370]/g, 'o'],
    [/[\331-\334]/g, 'U'],
    [/[\371-\374]/g, 'u'],
    [/[\321]/g, 'N'],
    [/[\361]/g, 'n'],
    [/[\307]/g, 'C'],
    [/[\347]/g, 'c']
    ];
    for (var i = 0; i < diacritics.length; i++) {
        s = s.replace(diacritics[i][0], diacritics[i][1]);
    }
    return s;
}
        /**
         * Carrega a previsão da cidade salva em cookie, se existir.
         */
         function carregarPrevisaoCidadeSalva() {
            var cookie = getCookie('cidadeprevisao');
            if (cookie != null) {
                var nome = cookie.split('-')[0]  + '-'+ cookie.split('-')[1];
                var codigo = cookie.split('-')[2];
                E13706cidadeprevisao = cookie;
                $('#nome_cidade').text(nome);
                carregarPrevisaoCidade(codigo);
                return true;
            }
            else{
                return false;
            }
        }
        function setCookie(key, value) {  
            var expires = new Date();  
            expires.setTime(expires.getTime() + 31536000000); //1 year
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();  
        }
        function getCookie(key) {  
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        }
        /**
         * Função que carrega a previsão da cidade cujo código foi informado.
         */
         function carregarPrevisaoCidade(codigo) {
            $.ajax({
                type: "GET",
                url: "http://ultimosegundo.ig.com.br/_servicos/ig/previsao_cidade/"+ codigo , 
                dataType: 'jsonp',
                jsonpCallback : 'previsaoCidadeRetornada'
            });
        }
        /**
         * Função a ser executada quando a previsão da cidade é retornada.
         */
         function previsaoCidadeRetornada(data) {
            if (data && data._source.previsao_cidade.previsao) {
                $.each(data._source.previsao_cidade.previsao, function(indice, previsao) {
                    // Devemos usar apenas as três primeiras previsões para esse boxe.
                    if (indice <= 2) {
                        $('#E13706>ul li:nth-child('+ (indice + 1) +')').css('visibility', 'hidden');
                        // Atualização dos valores da máxima e da mínima:
                        $('#E13706>ul li:nth-child('+ (indice + 1) +')>ul>li:eq(0)>cite').text(previsao.minima);
                        $('#E13706>ul li:nth-child('+ (indice + 1) +')>ul>li:eq(1)>cite').text(previsao.maxima);
                        // Atualização da imagem da span:
                        spanUsada = $('#img'+ (indice + 1));
                        spanUsada.removeClass();
                        spanUsada.addClass('sprite')
                        spanUsada.addClass(recuperarImagem(previsao))
                        // Visibilidade do link:
                        $('#E13706>h4>a').css('visibility', 'visible');
                        $('#E13706>ul li:nth-child('+ (indice + 1) +')').css('visibility', 'visible');
                    } 
                });
			} else {
   				 window.alert('Não há previsão disponível para a cidade.');
			}
		}
        // Mapa contendo a relação das imagens com as informações provenientesdo ClimaTempo:
        var mapa = new Array();
        mapa['1'] = 'img1' // Sol.      
        mapa['1n'] = 'img2' // Noite sem nuvens.        
        mapa['2'] = 'img4' // Sol com algumas nuvens.
        mapa['2r'] = 'img7' // Sol com muitas nuvens.
        mapa['2n'] = 'img3' // Noite com algumas nuvens.
        mapa['2rn'] = 'img6' // Noite com muitas nuvens.
        mapa['3'] = 'img5' // nublado.
        mapa['3n'] = 'img8' // nublado.
        mapa['4'] = 'img13' // Sol  e chuva.
        mapa['4r'] = 'img10' // Sol com muitas nuvens e chuva.
        mapa['4n'] = 'img12' // Noite chuvosa.
        mapa['4rn'] = 'img9' // Noite nublada e chuvosa.
        mapa['5'] = 'img14' // Chuvoso.
        mapa['5n'] = 'img11' // Chuvoso.
        mapa['6'] = 'img15' // Chuva e trovoadas.
        mapa['6n'] = 'img15' // Chuva e trovoadas.
        mapa['7'] = 'img19' // Geada. 
        mapa['7n'] = 'img19' // Geada. 
        mapa['8'] = 'img18' // Neve. 
        mapa['8n'] = 'img18' // Neve. 
        mapa['9'] = 'img16' // Nevoeiro 
        mapa['9n'] = 'img17' // Névoa 
        function recuperarImagem(previsao){
            return mapa[previsao.ico_manha];
        }
        function previsaoCidadeCompletaSolicitada() {
            var cidadeURL = E13706_removerDiacriticos(E13706cidadeprevisao.split('-')[0].toLowerCase().replace(/\s/g, '+'));
            var url = 'http://ultimosegundo.ig.com.br/brasil/tempo/?cidadeprevisao='+ E13706cidadeprevisao;
            window.location = url;
        }
		


