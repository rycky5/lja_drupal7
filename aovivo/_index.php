<?php
 $vConf = parse_ini_file("admin/config.ini");
 $TextoTwitter = "Acompanhe os programas do LeiaJÃ¡ em tempo real, na pÃ¡gina do aovivo";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<head>
  <title>Portal Leiaj&aacute; - Transmiss&atilde;o AO VIVO</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <meta name="description" content="Portal Leiaj&aacute;" />
  <meta name="keywords" content="LeiaJa" />
  <meta name="robots" content="ALL" />
  <meta name="robots" content="noarchive" />
  <meta name="distribution" content="Global" />
  <meta name="rating" content="General" />
  <meta name="author" content="redacao@leiaja.com.br" />
  <meta name="language" content="pt-br" />
  <meta property="og:image" content="images/logo.png" />
  <link rel="stylesheet" href="css/style.css?<?= mktime() ?>" type="text/css" media="Screen" />
  <script src="jquery.js" type="text/javascript"></script>
  <link rel="shortcut icon" href="../favicon.ico" />
  
  <meta name="og:title" content="Leiaja.com Tudo que vocÃª precisa saber" />
  <meta name="og:description" content="<?php echo $vConf["programname1"]; ?>" />
  <meta name="og:image" content="http://www.leiaja.com/aovivo/images/logo.png" />
  
<!--  <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <meta http-equiv="PRAGMA" content="NO-CACHE">-->
  <meta name="copyright" content="LeiaJÃ¡">
  <meta name="keywords" content="notÃ­cia, politica, carreiras, educaÃ§Ã£o, esporte, cultura, tecnologia, multimidÃ­a, rÃ¡dio, tv leiajÃ¡, empreendedorismo, leiajÃ¡imagens, vestibular, empregos, opiniÃ£o, hallsocial, f1team, acerto de contas,revistas, compras, computador, corpo, saÃºde, moda, carros, cinema, crianÃ§as, diversÃ£o, arte, economia, internet, jogos, novelas, tempo, trÃ¢nsito, Ãºltimas notÃ­cias, viagem, jornalismo, informaÃ§Ã£o, entretenimento, lazer, anÃ¡lise, internet, televisÃ£o, fotografia, imagem, som, Ã¡udio, vÃ­deo, fotos, humor, mÃºsica, EleiÃ§Ãµes, Pesquisa Eleitoral, EleiÃ§Ãµes Municipais, PolÃ­tica, eleitores, urnas, TRE, Prefeitos, <?= @$vMetaKeyWords ?>" />
  <meta name="robots" content="ALL" />
  <meta name="distribution" content="Global" />
  <meta name="rating" content="General" />
  <meta name="author" lang="pt-br" content="LeiaJÃ¡" />
  
</head>
<body>
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
<iframe frameborder='0' height='26' scrolling='no' src='http://barra.leiaja.com?aovivo' width='100%'></iframe>
<div class="corpo">
    	<div class="topo">
        	<h1 class="logo"><img src="images/logo.png" alt="LeiaJa.com" width="476" height="186" /></h1>
        </div><!--fim topo-->
        <div class="conteudo">
        	<div class="bloco_esquerda">
           	  <div class="player_titulo">
                    <p>AO VIVO</p>
                    <h3><?php echo $vConf["programname1"]; ?></h3>
                    <div>
                        <span class="ativo">
                            <em><a href="/aovivo/">Canal</a></em>
                            <strong><a href="/aovivo/">1</a></strong>
                        </span>
                        <span>
                            <em><a href="/aovivo/index2.php">Canal</a></em>
                            <strong><a href="/aovivo/index2.php">2</a></strong>
                        </span>
                    </div>
               </div>
               <div class="player">
					<span id="spanVideo"><iframe src="http://fast.player.liquidplatform.com/pApiv2/embed/47066d9515050a600e98981ebf00155a?autoStart=true&title=LeiaJa&alternateLive=http://slrp.sambavideos.sambatech.com/liveevent/leiaja_47066d9515050a600e98981ebf00155a/livestream/playlist.m3u8" width="615" height="420" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" msallowfullscreen="true"></iframe></span>
               </div>
            </div><!--fim bloco esquerda-->
            <div class="bloco_direita">
            	<div class="titulo_menor"><img src="images/tit_proximoseventos.jpg" width="330" height="40" alt="PrÃ³ximos eventos" /></div>
                <div class="fb-like" data-href="http://www.facebook.com/LeiaJaOnline" data-width="270" data-show-faces="false"></div>
                 <p class="texto_menor"><?php echo $vConf["texto"] ?></p>
                <span class="compartilhe">COMPARTILHAR
                    <a class="popup" href="https://www.facebook.com/sharer/sharer.php?u=http://www.leiaja.com/aovivo?<?= rand(0, 99999)?>"><img src="images/r_facebook.png" alt="Facebook" width="26" height="25" border="0" /></a>
                    <a class="popup" href="https://twitter.com/share?text=<?php print $TextoTwitter?>" ><img src="images/r_twitter.png" alt="Twitter" width="26" height="25" border="0" /></a>
                </span>
          </div><!--fim bloco direita-->
          <div class="bloco_esquerda">
           <div id="fb-root"></div>
            <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
                fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));
            </script>
            <div class="fb-comments" data-href="http://www.leiaja.com/aovivo" data-width="600" data-num-posts="5"></div>
          </div><!--fim bloco esquerda-->
          <div class="bloco_direita">
            	<div class="titulo_menor"><img src="images/tit_noticias.jpg" width="330" height="40" alt="Sobre o vÃ­deo" /></div>
                    <div class="noticias texto_noticias">
                    </div>
          </div><!--fim bloco direita-->
        </div><!--fim conteudo-->
    </div><!--fim corpo-->
    <div class="rodape"></div><!--fim rodape-->

<script src="//static.getclicky.com/js" type="text/javascript"></script>
<script type="text/javascript">try{ clicky.init(66504528); }catch(e){}</script>
<noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/66504528ns.gif" /></p></noscript>
  
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

<script type="text/javascript">
  function refreshCount(){
       $.get('count.php', function(rs){
            if (!isNaN(rs)) {
              $('#number').text(rs);
            }
          });
  }
  function carregarXML(){
    $('.noticias').load('class/LeitorXML.php');
  }

  $(document).ready(function(){
    //refreshCount();
    //setInterval(refreshCount, 60000);

    carregarXML();
    setInterval(carregarXML, 300000);
  });
</script>
<script>
   (function($){
    $(document).ready(function(){
        $('.popup').click(function(event) {
          var width  = 575,
              height = 400,
              left   = ($(window).width()  - width)  / 2,
              top    = ($(window).height() - height) / 2,
              url    = this.href,
              opts   = 'status=1' +
                       ',width='  + width  +
                       ',height=' + height +
                       ',top='    + top    +
                       ',left='   + left;

          window.open(url, 'twitter', opts);
          return false;
        });
      });
   })(jQuery);
</script>
</body>
</html>