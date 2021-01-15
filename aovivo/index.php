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
        <div class="conteudo" style="height:100px;">
        	<h1>Sem transmiss&atilde;o no momento.</h1>
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

<!--
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
-->

</body>
</html>