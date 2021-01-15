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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>

<head profile="<?php print $grddl_profile; ?>">
  
  <title><?php print $head_title; ?></title>
    
  <?php print $styles; ?>
  <?php print $scripts; ?>
  
  <link rel="image_src" href="<?= $vMetaImagem ?>" title="<?= $vMetaTitulo ?>" />  
  
  <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
  <meta http-equiv="PRAGMA" content="NO-CACHE">
  <meta name="copyright" content="LeiaJá">
  <meta name="keywords" content="Eleições, Pesquisa Eleitoral, Eleições Municipais, Política, eleitores, urnas, TRE, Prefeitos, LeiaJá, LeiaJa, Leia Já">
  <meta name="robots" content="ALL" />
  <meta name="distribution" content="Global" />
  <meta name="rating" content="General" />
  <meta name="author" lang="pt-br" content="LeiaJá" />

        <script>
            var unruly = window.unruly || {};
            unruly.native = unruly.native || {};
            unruly.native.siteId = 798358;
        </script>
    <script src="//video.unrulymedia.com/native/native-loader.js"></script>
    <!-- INSERIR NO HEAD DA PAGINA -->
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NXGH2Q"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NXGH2Q');</script>
    <!-- End Google Tag Manager -->


    <!-- Scripsts Publicidade NE10 --> 

<!-- 728 x 90 -->
 
<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
<script>
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
</script>
 
<script>
  googletag.cmd.push(function() {
    googletag.defineSlot('/1000621/portalleiaja-superbannermenor', [728, 90], 'div-gpt-ad-1486755874779-0').addService(googletag.pubads());
    googletag.enableServices();
  });
</script>
 
<!-- 970 x 90 -->
 
 
<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
<script>
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
</script>
 
<script>
  googletag.cmd.push(function() {
    googletag.defineSlot('/1000621/portalleiaja-superbanner', [970, 90], 'div-gpt-ad-1484136766272-0').addService(googletag.pubads());
    googletag.enableServices();
  });
</script>

<!-- 160 x 600 -->
 
<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
<script>
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
</script>
 
<script>
  googletag.cmd.push(function() {
    googletag.defineSlot('/1000621/portalleiaja-arranhaceu', [160, 600], 'div-gpt-ad-1484136991229-0').addService(googletag.pubads());
    googletag.enableServices();
  });
</script>
 
<!-- 300 x 600 -->
 
<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
<script>
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
</script>
 
<script>
  googletag.cmd.push(function() {
    googletag.defineSlot('/1000621/portalleiaja-halfpage', [300, 600], 'div-gpt-ad-1484137067322-0').addService(googletag.pubads());
    googletag.enableServices();
  });
</script>
 
<!-- 300 x 250 -->
 
 
<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
<script>
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
</script>
 
<script>
  googletag.cmd.push(function() {
    googletag.defineSlot('/1000621/portalleiaja-retangulo', [300, 250], 'div-gpt-ad-1484137139522-0').addService(googletag.pubads());
    googletag.enableServices();
  });
</script>

<!-- 300 x 100 -->
 
<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
<script>
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
</script>
 
<script>
  googletag.cmd.push(function() {
    googletag.defineSlot('/1000621/portalleiaja-retangulomenor', [300, 100], 'div-gpt-ad-1484137225856-0').addService(googletag.pubads());
    googletag.enableServices();
  });
</script>

<!-- Fim da Publicidade NE10 -->




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
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
<!-- Barras LeiaJá -->
<div class="barsfixed">
  <script id="barraleiajajs" type="text/javascript" src="http://barra.leiaja.com/barraleiaja.js?eleicoes"></script>
  <script type="text/javascript" src="http://barra.ne10.uol.com.br/parceiro/leia-ja-418.js"></script>
</div>

    <!--<Social connect>-->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
  <div id="tudo">




<style>
#skyscrapper { display:none; }
@media only screen and (min-width : 1125px) {
  #tudo .tudo { width:1125px !important;max-width:1126px !important; }
  #tudo .tudo .topo { margin-left: 83px }
  #skyscrapper { display:block;float:right;height:1px; }
  #skyscrapper .wsz {position:absolute;z-index:100;top:325px;margin-left:-160px;width:160px;height:600px;background:#f1f1f1; }
  #skyscrapper .wsz.bannerFixed { top:0px;position:fixed; }
}
</style>


  <!-- LeiaJá - WSS - (160x600) -->
<!--  <div class="tudo" style="min-height:0px;">
  <div id="skyscrapper">
  <div class="wsz" data-pid="5828">-->






<!-- BEGIN ADVERTPRO CODE -->
<script type="text/javascript">
    document.write('<scr' + 'ipt src="http://ads.leiaja.com/servlet/view/banner/javascript/zone?zid=28&pid=0&random=' + Math.floor(89999999 * Math.random() + 10000000) + '&millis=' + new Date().getTime() + '&referrer=' + encodeURIComponent(document.location) + '" type="text/javascript"></scr' + 'ipt>');
</script>
<!-- END ADVERTPRO CODE -->

<!-- 160x600 -->
<!--<script type="text/javascript">
var tg_unit = {
 "id":"682",
 "sizes": [[160,600]]
};
</script>-->

<script type="text/javascript" src="//cdn.trugaze.io/tg-ad.js"></script>



  <script type="text/javascript">
  
  (function ($) {
    $(document).ready(function () {
      // Fixar barra no topo.
        $(window).scroll(function () {
          if ($(this).scrollTop() > 325) {
            $("#skyscrapper .wsz:first").addClass('bannerFixed');
          } else {
            $("#skyscrapper .wsz").removeClass('bannerFixed');
          }
        });
    });
  })(jQuery);

  </script>

      </div>
      </div>
      </div>








  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>

  <?php print $page; ?>
  <?php print $page_bottom; ?>
  </div>
</body>
</html>
