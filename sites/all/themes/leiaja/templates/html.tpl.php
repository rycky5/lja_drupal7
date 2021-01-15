<?php
// $Id: html.tpl.php,v 1.6 2010/11/24 03:30:59 webchick Exp $
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
  <?php 
      echo @$metaRefresh;
      echo @$metaImg;
  ?>
        <meta name="description" content="Tudo que você precisa saber. Notícias, Politica, Carreiras, Esportes, Cultura, Tecnologia, Multimídia e muito mais | LeiaJá" />
        <meta name="og:title" content="Leiaja.com Tudo que você precisa saber" />
        <meta name="og:description" content="Tudo que você precisa saber. Notícias, Politica, Carreiras, Esportes, Cultura, Tecnologia, Multimídia e muito mais" />
        <meta name="og:image" content="http://www.leiaja.com/images/leiaja_acento.jpg" />
  <?php
      print str_replace("[@#galeria#@]", "", str_replace("[@#podcast#@]", "", str_replace("[@#video#@]", "", str_replace ("thumbnail", "large", $head))));
  ?>
  
  <meta property="fb:page_id" content="205069329518304" />
  <?php if(!empty($vMetaVideo)): ?>
    <meta property="og:type" content="video" />
    <meta property="og:image" content="<?= $vMetaVideo['image'] ?>" />
    <meta property="og:title" content="<?= $vMetaVideo['title'] ?>" />
    <meta property="og:video" content="<?= $vMetaVideo['url'] ?>" />
    <meta property="og:video:type" content="video/mp4" />
    <meta property="og:video:width" content="398" />
    <meta property="og:video:height" content="224" />
    <meta property="og:site_name" content="LeiaJá" />
   <?php endif; ?>
   <link rel="image_src" href="<?= $vMetaImagem ?>" title="<?= $vMetaTitulo ?>" />
   
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <meta http-equiv="PRAGMA" content="NO-CACHE">
    <meta name="copyright" content="LeiaJá">
    <meta name="keywords" content="notícia, politica, carreiras, educação, esporte, cultura, tecnologia, multimidía, rádio, tv leiajá, empreendedorismo, leiajáimagens, vestibular, empregos, opinião, hallsocial, f1team, acerto de contas,revistas, compras, computador, corpo, saúde, moda, carros, cinema, crianças, diversão, arte, economia, internet, jogos, novelas, tempo, trânsito, últimas notícias, viagem, jornalismo, informação, entretenimento, lazer, análise, internet, televisão, fotografia, imagem, som, áudio, vídeo, fotos, humor, música, Eleições, Pesquisa Eleitoral, Eleições Municipais, Política, eleitores, urnas, TRE, Prefeitos, <?= @$vMetaKeyWords ?>" />
    <meta name="robots" content="ALL" />
    <meta name="distribution" content="Global" />
    <meta name="rating" content="General" />
    <meta name="author" lang="pt-br" content="LeiaJá" />
   <meta property="fb:app_id" content="224681850906688"/>
  <title><?php print $head_title; ?></title>
  <!-- Dr6DCQNpbe1hEQIfkpqFjJZixuU -->
  <meta name="google-site-verification" content="rAsZePaDPDq7vSPxpqus1jGbqHpQ9fnv3ugcrmPLwIY" />
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <script type="text/javascript" src="/sites/all/libraries/lazyload/jquery.lazyload.min.js" defer="defer"></script>
  <script type="text/javascript" src="/sites/all/libraries/lazyload/jquery.init.lazy.js" defer="defer"></script>
</head>
<body>
  <script type="text/javascript" src="http://barra.ne10.uol.com.br/parceiro/leia-ja-418.js"></script> 
 <div id="div-barraLeiaja"></div><script type="text/javascript">
    var PATHR = '<?= base_path()?>';
  </script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=224681850906688&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

  <?php  print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
  <div id="divContainerPreview" class="divContainerPreview" style="display:none;">
  <a href="javascript:void(0)" onclick="return previewNoticiaFechar();" class="divFecharPreview"></a>
  <div class="bgTopPreview"></div>
  <div id="divContentPreview" class="divContentPreview">
  </div>
  <div class="bgBottomPreview"></div>
  </div>
  <div class="telaEscura">
      <img class="lodingTotal" title="<?=base_path(true)?>" src="<?= '/'.drupal_get_path('theme', 'leiaja')?>/images/loaderTotal.gif" alt="Carregando" />
  </div>
  
<style>
  .bpbuscaofertas .Widget960x300{width:948px !important;margin:25px 0 0 !important;}
  .bpbuscaofertas .Widget960x300 .header{width:927px !important;}
  .bpbuscaofertas .Widget960x300 .offers li{width:218px !important;}
  .bpbuscaofertas .Widget960x300 .footer {width: 926px !important;}
</style>
<?php if (getenv('APPLICATION_ENV') == 'production') : ?>
    <!-- Tag do analitycs e comScore do ig --> 
    <script type="text/javascript">
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
    <script id="navegg" type="text/javascript" src="http://tag.navdmp.com/tm12723.js"></script>
    <script type="text/javascript" src="http://scripts.webspectator.com/ws-B6A33305.js" ></script>
    <script type="text/javascript" src="//wfpscripts.webspectator.com/bootstrap/ws-B6A33305.js"></script>
    <script type="text/javascript" src="http://as.ebz.io/api/choixPubJS.htm?pid=722623&screenLayer=1&mode=NONE&home=http://www.leiaja.com"></script>
<? endif; ?>
</body>
</html>