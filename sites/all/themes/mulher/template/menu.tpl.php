<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<iframe width="100%" height="26" frameborder="0" scrolling="no" src="http://barra.leiaja.com/?mulher"></iframe>
<div class="divTop">
  <div class="divBgRightPai"></div>
  <div class="topContent">
    <div class="divBgRightFilha">
      <div class="facebook">
      <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.leiaja.com%2Fespecial%2Fmulher&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:23px; margin:36px 0 0 5px; *float:right;" allowtransparency="true"></iframe>
      </div>
    </div>
    <div class="logo">
      <a href="/especial/mulher" title="Dia Internacional da Mulher">
        <h2>Dia</h2>
        <h3>Internacional da</h3>
        <h1>MULHER</h1>
      </a>
    </div>
    <div class="divContainerUl">
      <ul>
        <li class="inicio"><a href="/especial/mulher" title="início">início</a ><span></span></li>
        <li class="oEspecial"><a href="/especial/mulher/2012/o-especial" title="o especial">o especial</a ><span></span></li>
        <li class="expediente"><a href="/especial/mulher/2012/expediente" title="expediente">expediente</a></li>
      </ul>
    </div>
  </div>
</div>
<script type="text/javascript">
  var arrFotos = new Array();
  <?php
    foreach($vCarrossel as $key => $not):
      $vLink = url(drupal_lookup_path('alias',"node/".$not->nid));
      $vIndice = $key+1;
  ?>
      arrFotos[<?= $key ?>] = {"nid" : <?= $not->nid ?>,"title" : "<?= addslashes($not->title) ?>","link" : "<?= $vLink ?>","imagem_thumb" : "<?= image_style_url('home_thumb', $not->uri); ?>","imagem_grd" : "<?= image_style_url('large', $not->uri) ?>","imagem_med" : "<?= image_style_url('medium', $not->uri) ?>","user" : "<?=$GLOBALS['user']->uid.';'.$not->nid?>","resumo":"<?= addslashes(trim(truncate_utf8($not->body_summary,100,true,true))); ?>","subcategoria" : "<?= $not->subcategoria ?>"};
  <?php endforeach; ?>
  (function ($) {
    
    var videoHomeCarrossel = {
          init: function () {
						videoHomeCarrossel.qtd = $('.divCarrocel .content1 li').size()
						videoHomeCarrossel.qtd = parseFloat(videoHomeCarrossel.qtd);
            videoHomeCarrossel.bind();
              var content = $('.divCarrocel .content1'),
                  html     = content.html();
              content.append(html);
              content.append(html);
            videoHomeCarrossel.verificaPagina();
            $('.divCarrocel a').css('visibility', 'visible');
						$('.liMulher img').hover( function(){
							$('.divCarrocelTextos').hide();
							var img = $(this).attr('class'),
									valor = img.split('img');

							$('#textoMulher'+valor[1]).show();
							$('.divCarrocel .content1 li').removeClass('ativo');
							$(this).parent().addClass('ativo');
							$('.divCarrocel li .'+img).parent().addClass('ativo');
						});
          },
					qtd: 0,
          bind: function () {
            $('.divCarrocel a').bind('click', function () {
           	  $('.divCarrocel a').unbind('click');
              if($(this).hasClass('passadorRight')) {
                videoHomeCarrossel.pagina = videoHomeCarrossel.pagina + 1;
                videoHomeCarrossel.move('-');
              } else {
                videoHomeCarrossel.pagina = videoHomeCarrossel.pagina - 1;
                videoHomeCarrossel.move('+');
              }
            });
            $('.divCarrocel .liMulher img').live('click', function () {
							var elem = $(this).attr('class');
							elem = elem.split('img');
							elem = elem[1];
							location.href = 'http://www.leiaja.com'+$('#textoMulher'+elem+' .saibaMais').attr('href');
            });
						
          },
          move: function (sinal) {
            $('.divCarrocel .content1').animate({
              marginLeft: sinal+'=189'
            }, 500, function() {
              videoHomeCarrossel.verificaPagina();
              videoHomeCarrossel.bind();
            });   
          },
          verificaPagina: function() {
						numero = videoHomeCarrossel.qtd;
            if( (videoHomeCarrossel.pagina%numero) === 0) {
              //$('.divCarrocel a.passadorLeft').css('visibility', 'hidden');
              $('.divCarrocel .content1').css('margin-left', (-189*numero)+'px');
            }
          },
          pagina: 0
        }
    
    
    $(document).ready(function(){
      initCarrossel();
      videoHomeCarrossel.init();
    });
  })(jQuery);
</script>
<div class="divCarrocel">
  <div class="divCarrocelContainer">
    <div class="divCarrocelContent">
      <div class="textoGeral"><h4>ELAS FAZEM A DIFERENÇA !</h4></div>
      <a href="javascript:void(0);" title="" class="passadorLeft"></a>
      <div class="divContainerUl">
        <ul class="content1">
          <li class="liMulher"><img class="img1" src="/<?=drupal_get_path('theme', 'mulher')?>/images/foto1Pequena.jpg" /><span></span></li>
          <li class="liMulher"><img class="img2" src="/<?=drupal_get_path('theme', 'mulher')?>/images/foto2Pequena.jpg" /><span></span></li>
          <li class="liMulher"><img class="img3" src="/<?=drupal_get_path('theme', 'mulher')?>/images/foto3Pequena.jpg" /><span></span></li>
          <li class="liMulher"><img class="img4" src="/<?=drupal_get_path('theme', 'mulher')?>/images/foto4Pequena.jpg" /><span></span></li>
          <li class="liMulher"><img class="img5" src="/<?=drupal_get_path('theme', 'mulher')?>/images/foto7Pequena.jpg" /><span></span></li>
          <li class="liMulher"><img class="img6" src="/<?=drupal_get_path('theme', 'mulher')?>/images/foto8Pequena.jpg" /><span></span></li>
          <li class="liMulher"><img class="img7" src="/<?=drupal_get_path('theme', 'mulher')?>/images/foto9Pequena.jpg" /><span></span></li>
          <li class="liMulher"><img class="img8" src="/<?=drupal_get_path('theme', 'mulher')?>/images/foto10Pequena.jpg" /><span></span></li>
        </ul>
      </div>
      <a href="javascript:void(0);" title="" class="passadorRight"></a>
    </div>
    <div class="divCarrocelTextos" id="textoMulher1" style="display:none;">
      <div class="divContainerH2">
        <h2 class="nome">Lara</h2>
        <h2 class="sobrenome" style="margin:48px 0 0 7px;position:absolute;">Klaus</h2>
      </div>
      <div class="divContainerH4">
        <h4>"A competência da mulher e do homem é a mesma. O que cada um tem que fazer é se aperfeiçoar"</h4>
      </div>
       <a href="/especial/mulher/2012/perfil-lara-klaus" title="Saiba +" class="saibaMais">Saiba +</a>
    </div>
    <div class="divCarrocelTextos" id="textoMulher2">
      <div class="divContainerH2">
        <h2 class="nome">Rosinha</h2>
        <h2 class="sobrenome">Leão</h2>
      </div>
      <div class="divContainerH4">
        <h4>"Nunca desisto de nada. Agradeço muito a Deus por tudo o que consegui"</h4>
      </div>
       <a href="/especial/mulher/2012/perfil-rosinha-leao" title="Saiba +" class="saibaMais">Saiba +</a>
    </div>
    <div class="divCarrocelTextos" id="textoMulher3" style="display:none;">
      <div class="divContainerH2">
        <h2 class="nome">Shirlande</h2>
        <h2 class="sobrenome">Pereira</h2>
      </div>
      <div class="divContainerH4">
        <h4>"Respeito ao próximo. Não importa o que você faz da sua vida íntima"</h4>
      </div>
       <a href="/especial/mulher/2012/perfil-shirlande-pereira" title="Saiba +" class="saibaMais">Saiba +</a>
    </div>
    <div class="divCarrocelTextos" id="textoMulher4" style="display:none;">
      <div class="divContainerH2">
        <h2 class="nome">Léa</h2>
        <h2 class="sobrenome" style="margin:48px 0 0 7px;position:absolute;">Lucas</h2>
      </div>
      <div class="divContainerH4">
        <h4>"Eu não paro um minuto. Pra mim a vida inteira é um carnaval"</h4>
      </div>
       <a href="/especial/mulher/2012/perfil-lea-lucas" title="Saiba +" class="saibaMais">Saiba +</a>
    </div>
    <div class="divCarrocelTextos" id="textoMulher5" style="display:none;">
      <div class="divContainerH2">
        <h2 class="nome">Ana</h2>
        <h2 class="sobrenome" style="margin:48px 0 0 7px;position:absolute;">Karina</h2>
      </div>
      <div class="divContainerH4">
        <h4>"Tive que lutar muito para perder a timidez na vida profissional. Ou eu perdia a timidez ou não ia dar certo"</h4>
      </div>
       <a href="/especial/mulher/2012/perfil-ana-karina" title="Saiba +" class="saibaMais">Saiba +</a>
    </div>
    <div class="divCarrocelTextos" id="textoMulher6" style="display:none;">
      <div class="divContainerH2">
        <h2 class="nome">Esmeralda </h2>
        <h2 class="sobrenome">Carmelita</h2>
      </div>
      <div class="divContainerH4">
        <h4>"Formei meus filhos vendendo bala e agora eu faço o que mais gosto: dirigir"</h4>
      </div>
       <a href="/especial/mulher/2012/perfil-esmeralda-carmelita" title="Saiba +" class="saibaMais">Saiba +</a>
    </div>
    <div class="divCarrocelTextos" id="textoMulher7" style="display:none;">
      <div class="divContainerH2">
        <h2 class="nome">Roberta</h2>
        <h2 class="sobrenome">Uchôa</h2>
      </div>
      <div class="divContainerH4">
        <h4>"Gosto de me relacionar com as pessoas, mas não gosto muito de estar com ninguém todo dia"</h4>
      </div>
       <a href="/especial/mulher/2012/perfil-roberta-uchoa" title="Saiba +" class="saibaMais">Saiba +</a>
    </div>
    <div class="divCarrocelTextos" id="textoMulher8" style="display:none;">
      <div class="divContainerH2">
        <h2 class="nome">Dona</h2>
        <h2 class="sobrenome" style="margin:48px 0 0 7px;position:absolute;">Nilza</h2>
      </div>
      <div class="divContainerH4">
        <h4>"Se eu botei no mundo, eu tinha que assumir. Depender de pensão alimentícia pra mim era a pior coisa do mundo"</h4>
      </div>
       <a href="/especial/mulher/2012/perfil-dona-nilza" title="Saiba +" class="saibaMais">Saiba +</a>
    </div>
  </div>
</div>
<?php if (getenv('APPLICATION_ENV') == 'production') : ?>
    <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
  
    <!-- GA Leiajá -->
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-24818943-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>    

    <script src="//static.getclicky.com/js" type="text/javascript"></script>
    <script type="text/javascript">try{ clicky.init(66504528); }catch(e){}</script>
    <script type="text/javascript" id="navegg" src="http://navdmp.com/all.js?12723"></script>
<? endif; ?>