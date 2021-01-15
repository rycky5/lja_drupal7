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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml" xml:lang="<?= $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?= $language->dir; ?>" <?= $rdf_namespaces; ?> itemscope="" itemtype="http://schema.org/Organization">
    <head profile="<?= $grddl_profile; ?>">
        <?php
        // Metatags escritas especificamente para node estática.
        if (arg(0) == 'nodeestatica'):
            ?>        
            <title><?php echo '<?= @str_replace("\"", "\'", stripcslashes(@$strTitulo)); ?>'; ?></title>
            <meta name="og:title" content="<?php echo '<?= @str_replace("\"", "\'", stripcslashes(@$strTitulo)); ?>'; ?>" />
            <meta name="og:description" content="<?php echo '<?= @$strDescricao; ?>'; ?>" />
            <meta name="og:image" content="<?php echo '<?= @str_replace("sgc.", "www.", @$strImagem) ?>'; ?>" />
            <link rel="image_src" href="<?php echo '<?= @str_replace("sgc.", "www.", @$strImagem) ?>'; ?>" title="<?php echo '<?= @str_replace("\"", "\'", stripcslashes(@$strTitulo)); ?>'; ?> | Leiajá" />
            <meta name="description" content="<?php echo '<?= !empty($strDescricao) ? @$strDescricao : "Tudo que você precisa saber. Notícias, Politica, Carreiras, Esportes, Cultura, Tecnologia, Multimídia e muito mais | LeiaJá"; ?>'; ?>" />
            <meta name="keywords" content="<?php echo '<?= !empty($strTags) ? $strTags : "notícia, politica, carreiras, educação, esporte, cultura, tecnologia, multimidía, rádio, tv leiajá, empreendedorismo, leiajáimagens, vestibular, empregos, opinião, hallsocial, f1team, acerto de contas,revistas, compras, computador, corpo, saúde, moda, carros, cinema, crianças, diversão, arte, economia, internet, jogos, novelas, tempo, trânsito, últimas notícias, viagem, jornalismo, informação, entretenimento, lazer, análise, internet, televisão, fotografia, imagem, som, áudio, vídeo, fotos, humor, música, Eleições, Pesquisa Eleitoral, Eleições Municipais, Política, eleitores, urnas, TRE, Prefeitos" ?>' ?>" />
            <?php
        else:
            echo '<meta name="description" content="Tudo que você precisa saber. Notícias, Politica, Carreiras, Esportes, Cultura, Tecnologia, Multimídia e muito mais | LeiaJá" />';
            echo '<meta name="keywords" content="notícia, politica, carreiras, educação, esporte, cultura, tecnologia, multimidía, rádio, tv leiajá, empreendedorismo, leiajáimagens, vestibular, empregos, opinião, hallsocial, f1team, acerto de contas,revistas, compras, computador, corpo, saúde, moda, carros, cinema, crianças, diversão, arte, economia, internet, jogos, novelas, tempo, trânsito, últimas notícias, viagem, jornalismo, informação, entretenimento, lazer, análise, internet, televisão, fotografia, imagem, som, áudio, vídeo, fotos, humor, música, Eleições, Pesquisa Eleitoral, Eleições Municipais, Política, eleitores, urnas, TRE, Prefeitos" />';
            ?>
            <title><?= $head_title ?></title>         
        <?php
        endif;
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="white" />
        <meta charset="UTF-8">
            <meta http-equiv="CACHE-CONTROL" content="NO-CACHE" />
            <meta http-equiv="PRAGMA" content="NO-CACHE" />
            <meta name="copyright" content="LeiaJá" />        
            <meta name="robots" content="ALL" />
            <meta name="distribution" content="Global" />
            <meta name="rating" content="General" />
            <meta name="author" lang="pt-br" content="LeiaJá" />
            <meta property="fb:app_id" content="224681850906688"/>
            <meta property="fb:page_id" content="205069329518304" />
            <meta property="fb:pages" content="205069329518304" /> 
            <meta name="google-site-verification" content="rAsZePaDPDq7vSPxpqus1jGbqHpQ9fnv3ugcrmPLwIY" />
            <link rel="shortcut icon" href="http://static1.leiaja.com/misc/favicon.ico" type="image/vnd.microsoft.icon" />

            <?php
            include_once 'scripts-ne10.php';
            ?>

            <?= $styles; ?>
            <?= $scripts ?>
            
            <!-- INSERIR NO HEAD DA PAGINA -->
            <!-- Google Tag Manager -->
            <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NXGH2Q"
                              height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <script>(function (w, d, s, l, i) {
                    w[l] = w[l] || [];
                    w[l].push({'gtm.start':
                                new Date().getTime(), event: 'gtm.js'});
                    var f = d.getElementsByTagName(s)[0],
                            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                    j.async = true;
                    j.src =
                            '//www.googletagmanager.com/gtm.js?id=' + i + dl;
                    f.parentNode.insertBefore(j, f);
                })(window, document, 'script', 'dataLayer', 'GTM-NXGH2Q');</script>
            <!-- End Google Tag Manager -->


            <script type="text/javascript">
                window._taboola = window._taboola || [];
                _taboola.push({article: 'auto'});
                !function (e, f, u, i) {
                    if (!document.getElementById(i)) {
                        e.async = 1;
                        e.src = u;
                        e.id = i;
                        f.parentNode.insertBefore(e, f);
                    }
                }(document.createElement('script'),
                        document.getElementsByTagName('script')[0],
                        '//cdn.taboola.com/libtrc/leiaja/loader.js',
                        'tb_loader_script');
            </script>

    </head>
    <body>
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.3&appId=224681850906688";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

        <?= $page_top; ?>
        <?= $page; ?>
<?= $page_bottom; ?>
<?php
include_once 'scripts.php';
?>
    </body>
</html>
