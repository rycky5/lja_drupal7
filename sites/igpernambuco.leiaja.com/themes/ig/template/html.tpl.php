<?php

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

$strDefer = "";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" 
      xmlns:fb="https://www.facebook.com/2008/fbml" 
      xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>

  <head profile="<?php print $grddl_profile; ?>">
  <?php 
      // Caso seja uma visualização de notícia para gerar estatico
      if(@$_GET["node"] == true && $_GET["estatico"] == true){
  ?>
        <meta name="description" content="[##descricao##] | LeiaJá" />
        <meta name="og:title" content="[##titulo##]" />
        <meta name="og:description" content="[##descricao##]" />
        <meta name="og:image" content="[##imagem##]" />
         <title>[##titulo##]</title>
   <?php
      }else{
        print $head; 
        echo "<title>{$head_title}</title>";
      }
  ?>
  <?php print $styles; ?>
  <?php print $scripts; ?>
  
  <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
  <meta http-equiv="PRAGMA" content="NO-CACHE">
  <meta name="copyright" content="IG Pernambuco">
  <meta name="keywords" content="notícia, politica, carreiras, educação, esporte, cultura, tecnologia, multimidía, rádio, tv leiajá, empreendedorismo, leiajáimagens, vestibular, empregos, opinião, hallsocial, f1team, acerto de contas,revistas, compras, computador, corpo, saúde, moda, carros, cinema, crianças, diversão, arte, economia, internet, jogos, novelas, tempo, trânsito, últimas notícias, viagem, jornalismo, informação, entretenimento, lazer, análise, internet, televisão, fotografia, imagem, som, áudio, vídeo, fotos, humor, música, Eleições, Pesquisa Eleitoral, Eleições Municipais, Política, eleitores, urnas, TRE, Prefeitos, <?= $vMetaTitulo ?>">
  <meta name="robots" content="ALL" />
  <meta name="distribution" content="Global" />
  <meta name="rating" content="General" />
  <meta name="author" lang="pt-br" content="IG Pernambuco" />
  
  <!-- metatags -->
  <meta name="og:image" content="http://static1.leiaja.com/images/leiaja_acento.jpg" />
  <meta name="description" content="Tudo que você precisa saber. Notícias, Politica, Carreiras, Esportes, Cultura, Tecnologia, Multimídia e muito mais | LeiaJá" />
  <meta name="og:description" content="Tudo que você precisa saber. Notícias, Politica, Carreiras, Esportes, Cultura, Tecnologia, Multimídia e muito mais | LeiaJá" />
  
  <link rel="shortcut icon" href="/<?= drupal_get_path('theme', 'ig').'/img/favicon.ico' ?>" mce_href="/<?= drupal_get_path('theme', 'ig').'/img/favicon.ico' ?>" type="image/x-icon" />
  <link rel="shortcut icon" href="/<?= drupal_get_path('theme', 'ig').'/img/favicon.ico' ?>" type="image/vnd.microsoft.icon" />
  
  <script type="text/javascript" src="/sites/all/libraries/lazyload/jquery.lazyload.min.js" <?= $strDefer ?>></script>
  <script type="text/javascript" src="/sites/all/libraries/lazyload/jquery.init.lazy.js" <?= $strDefer ?>></script>
  
  <!-- scripts necessários para funcionamento do componente de Mais Lidas -->
  <script src="http://www.apps.realtime.co/IBTX/raGGuI/IBTX.js"></script>
  <!-- scripts necessários para funcionamento do componente de Mais Lidas -->
  
  <!-- /* TAG MJX PARA O SITE: www.igbahia.com.br || CANAL: homepage */ -->
  <script type="text/javascript" <?= $strDefer ?>>
    var protocolo = ('https:' == document.location.protocol ? 'https://' : 'http://');
    document.write('<scr'+'ipt id="navegg" type="text/javascript" src="'+protocolo+'ads.statig.com.br/RealMedia/ads/Creatives/IGDefault/tag_navegg_parceiros/navegg_parceiros.js"></scr'+'ipt>');
  </script>
  <!-- /* COMECO DO CODIGO QUE DEVE SER INCLUIDO NO <HEAD> DA PAGINA */ -->
  <script language="javascript">
  <!--
  function OAS_VARS(OAS_page, OAS_pos) {
  OAS_site = 'www.igpernambuco.com.br';
  OAS_sitepage = OAS_site + OAS_page;
  OAS_listpos = OAS_pos;}
  OAS_url = 'http://adserver.ig.com.br/RealMedia/ads/';
  OAS_query = NVG_qry;
  OAS_target = '_blank';
  OAS_version = 10;
  OAS_rn = '001234567890'; OAS_rns = '1234567890';
  OAS_rn = new String(Math.random()); OAS_rns = OAS_rn.substring(2, 11);
  function OAS_NORMAL (pos) {
  document.write('<a href="' + OAS_url + 'click_nx.ads/' + OAS_sitepage + '/1' + OAS_rns + '@' + OAS_listpos + '!' + pos + '?' + OAS_query + '" target="'+ OAS_target + '">');
  document.write('<img src="' + OAS_url + 'adstream_nx.ads/' + OAS_sitepage + '/1' + OAS_rns + '@' + OAS_listpos + '!' + pos + '?' + OAS_query + '" border="0"></a>');}
  //-->
  </script>
  <script language="javascript">
  <!--
  function OAS_START() {
  OAS_version = 11;
  if (navigator.userAgent.indexOf('Mozilla/3') != -1 || navigator.userAgent.indexOf('Mozilla/4.0 WebTV') != -1)
  OAS_version = 10;
  if (OAS_version >= 11)
  document.write('<scrip' + 't language="javascript" src="' + OAS_url + 'adstream_mjx.ads/' + OAS_sitepage + '/1' + OAS_rns + '@' + OAS_listpos + '?' + OAS_query + '"><\/scrip' + 't>');}
  //-->
  </script>
  <script language="javascript">
  <!--
  document.write('');
  function OAS_AD(pos){
  if (OAS_version >= 11)
  OAS_RICH(pos);
  else
  OAS_NORMAL(pos);}
  //-->
  </script>
<!-- /TAGS DE PUBLICIDADE DO IG  -->
  
 <!-- Tag do analitycs e comScore do ig --> 
  <script type="text/javascript" <?= $strDefer ?>>
     var _gaq = _gaq || [];
     _gaq.push(['_setAccount', 'UA-3531175-1']);
     _gaq.push(['_trackPageview']);
     _gaq.push(['ig._setAccount', 'UA-24818943-1']);
     _gaq.push(['ig._trackPageview']);
     (function () {
         var ga = document.createElement('script');
         ga.type = 'text/javascript';
         ga.async = true;
         ga.src = ('https:' == document.location.protocol ? 'https://ssl' :
             'http://www') + '.google-analytics.com/ga.js';
         var s = document.getElementsByTagName('script')[0];
         s.parentNode.insertBefore(ga, s);
     })();
     var _comscore = _comscore || [];
     _comscore.push({
         c1: "2",
         c2: "6987205"
     });
     (function () {
         var s = document.createElement("script"),
             el = document.getElementsByTagName("script")[0];
         s.async = true;
         s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
         el.parentNode.insertBefore(s, el);
     })();
 </script>
 <noscript>
  <img src="http://b.scorecardresearch.com/p?c1=2&c2=6987205&cv=2.0&cj=1" />
 </noscript>
 <!-- / FIm Tag do analitycs e comScore do ig -->
</head>
<body class="<?php print $classes; ?> <?= (!empty ($_GET["node"])) ? "bodymodal": "" ?>" <?php print $attributes;?>>
  
<!-- SCRIPT IG QUE DEVE SER COLOCADO DENTRO DO BODY -->
<!-- /* CODIGO QUE DEVE SER INCLUIDO LOGO APOS A TAG <BODY> */ -->
<script language="javascript">
  OAS_VARS('/homepage', 'Middle1,Middle2,Right,Top2,x07,x15,x30');
  OAS_START();
</script>
<!-- /SCRIPT IG QUE DEVE SER COLOCADO DENTRO DO BODY -->

<script type="text/javascript">
  var PATHR = '<?= base_path()?>';
</script>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
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

<?php if ($_SERVER['SERVER_NAME'] == 'igpernambuco.leiaja.com' && empty($_GET["node"]) && arg(0) != "node") { ?>
  
  <script src="//static.getclicky.com/js" type="text/javascript"></script>
  <script type="text/javascript">try{ clicky.init(66504528); }catch(e){}</script>
  <noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/66504528ns.gif" /></p></noscript>
  
<? }elseif($_SERVER['SERVER_NAME'] == 'pernambuco.ig.com.br' || !empty($_GET["node"]) || arg(0) == "node"){ ?>

  <script src="//static.getclicky.com/js" type="text/javascript"></script>
  <script type="text/javascript">try{ clicky.init(100574233); }catch(e){}</script>
  <noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/100574233ns.gif" /></p></noscript>
  
<? } ?>
</body>
</html>