<?php

//die('teste');
// $Id: html.tpl.php,v 1.6 2010/11/24 03:30:59 webchick Exp $
//echo 'Location: '.base_path().'meuleiaja';

/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?> itemscope="" itemtype="http://schema.org/Organization">
<head profile="<?php print $grddl_profile; ?>">
  <title><?php print $head_title; ?></title>

<meta name="google-site-verification" content="rAsZePaDPDq7vSPxpqus1jGbqHpQ9fnv3ugcrmPLwIY" />
<meta name="description" content="Tudo que você precisa saber. Notícias, Politica, Carreiras, Esportes, Cultura, Tecnologia, Multimídia e muito mais | LeiaJá" />
<meta name="og:title" content="Leiaja.com Tudo que você precisa saber" />
<meta name="og:description" content="Tudo que você precisa saber. Notícias, Politica, Carreiras, Esportes, Cultura, Tecnologia, Multimídia e muito mais" />
<meta name="og:image" content="http://www.leiaja.com/images/leiaja_acento.jpg" />

<meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta name="copyright" content="LeiaJá">
<meta name="keywords" content="notícia, politica, carreiras, educação, esporte, cultura, tecnologia, multimidía, rádio, tv leiajá, empreendedorismo, leiajáimagens, vestibular, empregos, opinião, hallsocial, f1team, acerto de contas,revistas, compras, computador, corpo, saúde, moda, carros, cinema, crianças, diversão, arte, economia, internet, jogos, novelas, tempo, trânsito, últimas notícias, viagem, jornalismo, informação, entretenimento, lazer, análise, internet, televisão, fotografia, imagem, som, áudio, vídeo, fotos, humor, música, Eleições, Pesquisa Eleitoral, Eleições Municipais, Política, eleitores, urnas, TRE, Prefeitos, <?= @$vMetaKeyWords ?>" />
<meta name="robots" content="ALL" />
<meta name="distribution" content="Global" />
<meta name="rating" content="General" />
<meta name="author" lang="pt-br" content="LeiaJá" />
<link rel="shortcut icon" href="http://static1.leiaja.com/misc/favicon.ico" type="image/vnd.microsoft.icon" />
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
  <script type="text/javascript" src="<?= base_path(true); ?>/sites/all/modules/social_connect/social_connect.js"></script>
  
  <link rel="stylesheet" href="/sites/all/themes/aovivo/css/style.css?<?= mktime() ?>" type="text/css" media="Screen" />
<!--  <script src="/sites/all/themes/aovivo/jquery.js" type="text/javascript"></script>-->
</head>
<body>
<iframe frameborder='0' height='26' scrolling='no' src='http://barra.leiaja.com?aovivo' width='100%'></iframe>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
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
(function ($) {
  function refreshCount(){
       $.get('count.php', function(rs){
            if (!isNaN(rs)) {
              $('#number').text(rs);
            }
          });
  }
  function carregarXML(){
    $('.noticias').load('/leitorrss/class/LeitorXML.php');
  }

  $(document).ready(function(){
    //refreshCount();
    //setInterval(refreshCount, 60000);

    carregarXML();
    setInterval(carregarXML, 300000);
  });
})(jQuery);
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