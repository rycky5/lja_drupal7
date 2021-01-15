jQuery( document ).ready(function($) {

		$(window).scroll(function () {
			if ($(this).scrollTop() > 164) {
				$("body").addClass('headerfixed');
			} else {
				$("body").removeClass('headerfixed');
			}
		});

        function createCookie(name, value, days) {
            var expires;

            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            } else {
                expires = "";
            }
            document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
        }

        function readCookie(name) {
            var nameEQ = encodeURIComponent(name) + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
            }
            return null;
        }

        function eraseCookie(name) {
            createCookie(name, "", -1);
        }
        var ckleiaja = readCookie('leiajauf'),
            ufurl = document.location.href;
        if(ufurl.indexOf('/ce') >=0 || ckleiaja == 'CE') {
            ufurl = 'CEARÁ';
        } else if(ufurl.indexOf('/pb') >=0 || ckleiaja == 'PB') {
            ufurl = 'PARAÍBA';
        } else if(ufurl.indexOf('/pa') >=0 || ckleiaja == 'PA') {
            ufurl = 'PARÁ';
        } else if(ufurl.indexOf('/pe') >=0 || ckleiaja == 'PE') {
            ufurl = 'PERNAMBUCO';
        } else if(ufurl.indexOf('/sp') >=0 || ckleiaja == 'SP') {
            ufurl = 'SÃO PAULO';
        } else {
            ufurl = 'NACIONAL';
        }
        createCookie('leiajauf',ufurl,1);
        if(!$('span.selectuf')[0]) {
            var logoimg = $('header h1.logo img');
            $('header h1.logo').append(''+
            '<span class="selectuf">'+
            '<span class=selecfufbox style="width:'+logoimg.width()+'px">'+
            '    <a href="javascript:void(0)">'+ufurl+'</a>'+
            '    <span style="width:'+logoimg.width()+'px">'+
            '        <a href="/" title="BR">Nacional</a>'+
            '        <a href="/ce" title="CE">Ceará</a>'+
            '        <a href="/pb" title="PB">Paraíba</a>'+
            '        <a href="/pa" title="PA">Pará</a>'+
            '        <a href="/pe" title="PE">Pernambuco</a>'+
            '        <a href="/sp" title="SP">São Paulo</a>'+
            '    </span>'+
            '</span>'+
            '</span>');
            $('header .selectuf a').bind('click', function(){
                var ufurl = $(this).attr('title');
                $('header .selectuf>a').text(ufurl);
                createCookie('leiajauf',ufurl,1);
            });
        }
        $(".respo_menu" ).click(function() {
            $( ".menu > div > ul" ).slideToggle( "fast");
        });



});