<?php
/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 *
 */
//theme('block-noticias-rel-3');
//echo "<pre>";
//print_r($node);
//die();
$objUser = user_load($uid);
$vUserName = $objUser->name;
$vUserRoles = $objUser->roles;
$cadernoSettings = getCadernoNode($node->type);
$objFieldCategoria = $node->$cadernoSettings['field'];
$full_node_url = url(substr($node_url, 1), array('absolute' => true));

if (arg(0) != 'nodeestatica') {

    $strImagem = "";

    if (!empty($objNode->field_capa)) {
        //Recuperando a uri da imagem de capa
        $imagem = $objNode->field_capa[key($objNode->field_capa)][0]["uri"];
        $strImagem = image_static_url("large", $imgCapa);
    } elseif (!empty($objNode->field_image)) {
        //Recuperando a uri da imagem
        $imagem = $objNode->field_image[key($objNode->field_image)][0]["uri"];
        $strImagem = image_static_url("large", $imagem);
    } elseif (!empty($objNode->field_imagem_topo)) {
        //Recuperando a uri da imagem de topo
        $imagem = $objNode->field_imagem_topo[key($objNode->field_imagem_topo)][0]['uri'];
        $strImagem = image_static_url("large", $imagem);
    } else {
        $strImagem = "http://www.leiaja.com/images/leiaja_acento.jpg";
    }

    $vMetaTitle = array(
        '#tag' => 'meta',
        '#attributes' => array(
            'property' => 'og:title',
            'content' => $title
        )
    );
    drupal_add_html_head($vMetaTitle, 'meta_title');

    $vMetaDescription = array(
        '#tag' => 'meta',
        '#attributes' => array(
            'property' => 'og:description',
            'content' => (!empty($node->body[key($node->body)][0]['summary'])) ? $node->body[key($node->body)][0]['summary'] : truncate_utf8($node->body[key($node->body)][0]['value'], 255, TRUE)
        )
    );
    drupal_add_html_head($vMetaDescription, 'meta_description');

    $vMetaImagem = array(
        '#tag' => 'meta',
        '#attributes' => array(
            'property' => 'og:image',
            'content' => $strImagem
        )
    );
    drupal_add_html_head($vMetaImagem, 'meta_image');
}
//Recuperando a flag do script de embed de videos
$scriptVideoEmbed = field_get_items('node', $node, 'field_script_embed');

//Recuperando os ids das notícias relacionadas
$noticiasRelacionadas = array();
if (!empty($node->field_noticias_relacionadas)) {    
    $noticiasRelacionadas = explode('+', $node->field_noticias_relacionadas[key($node->field_noticias_relacionadas)][0]['safe_value']);    
    
    //Limitando as noticias relacionadas
    $nMax = 3;
    $nRemove = $nMax - count($noticiasRelacionadas);

    if ($nRemove < 0) {
        $noticiasRelacionadas = array_slice($noticiasRelacionadas, 0, $nRemove, TRUE);
    }
    
}
?>
<!-- section -->
<section id="content">
    <div class="containerInterna">





        <div class="inner_top <?= $cadernoSettings['cor'] ?>">
            <div class="breadcrumb">
                <span><a href="<?= LEIAJAURL ?>">www.<strong>leiaja</strong>.com/</a></span>
                <h2><a href="<?= $cadernoSettings['url'] ?>"><?= $cadernoSettings['tipo'] ?></a></h2>
                <h3><div class="seta-direita"></div><a href="<?= LEIAJAURL_WWW1 . url('taxonomy/term/' . $objFieldCategoria[key($objFieldCategoria)][0]['tid'], array('absolute' => FALSE)) ?>"><?= $objFieldCategoria[key($objFieldCategoria)][0]['taxonomy_term']->name ?></a></h3>
            </div>
            <div class="share">
                <ul>
                    <li>
                        <!--<iframe src="//www.facebook.com/plugins/like.php?href=&amp;&width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe>-->
                        <div class="fb-like" data-href="<?= $full_node_url ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
                    </li>
                    <li><script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
                    <g:plusone></g:plusone></li>
                    <li><a href="<?= $full_node_url ?>" class="twitter-share-button">Tweet</a>
                        <script>!function (d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                if (!d.getElementById(id)) {
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = p + '://platform.twitter.com/widgets.js';
                                    fjs.parentNode.insertBefore(js, fjs);
                                }
                            }(document, 'script', 'twitter-wjs');</script></li>
                </ul>
                <!--<a href="javascript:void(0);" class="print"><span class="fa fa-print"></span>Imprimir</a>-->
            </div>
        </div>

        <div class="inner_content">
            <div class="title">
                <h1><?= stripslashes($title) ?></h1>
                <?php
                if (!empty($node->body[key($node->body)][0]['summary'])):
                    ?>
                    <h2><?= $node->body[key($node->body)][0]['summary'] ?></h2>
                    <?php
                endif;
                ?>
                <div class="info">
                    <?php
                    $file = drupal_get_path('theme', 'leiaja2') . '/images/' . semAcentos($node->field_fonte[$node->language][0]['value']) . '.jpg';

                    if (!empty($node->field_fonte)) {
                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . base_path() . $file)) {
                            if ($node->field_fonte[$node->language][0]['value'] == 'LeiaJá' && !in_array('administrator', $vUserRoles)) {
                                echo '<span class="author"><img height="18" src="/' . $file . '" title=""></span>';
                                echo '<span class="author fa fa-user">por ' . $vUserName . '</span> <span class="date fa fa-calendar">' . $date . '</span>';
                            } else {
                                echo '<span class="author"><img height="18" src="/' . $file . '" title=""></span>';
                                echo '<span class="date fa fa-calendar">' . $date . '</span>';
                            }
                        } else {
                            echo '<span class="author">' . $node->field_fonte[$node->language][0]['value'] . '</span>';
                            echo '<span class="author fa fa-user">por ' . $vUserName . '</span> <span class="date fa fa-calendar">' . $date . '</span>';
                        }
                    } else {
                        echo '<span class="author fa fa-user">por ' . $vUserName . '</span> <span class="date fa fa-calendar">' . $date . '</span>';
                    }
                    ?>
                    <?php
                    $vDataRevisao = funcoes_getRevisao($node->nid);
                    if ($vDataRevisao):
                        ?>               
                        <span class="author fa">Atualizado em: <?= $vDataRevisao ?></span>
                        <?php
                    endif;
                    ?>

                </div>
            </div>
            <div class="content_text">
                <?php
                if (!empty($node->field_imagem_topo)):
                    ?>
                    <img width="957" height="436" src="<?= file_create_url($node->field_imagem_topo[key($node->field_imagem_topo)][0]['uri']) ?>" class="align_center" alt="<?= $node->field_imagem_topo[key($node->field_imagem_topo)][0]['alt'] ?>" title="<?= $node->field_imagem_topo[key($node->field_imagem_topo)][0]['title'] ?>" />

                    <span class="legendaFotoGrande">
                        <?= ($node->field_imagem_topo[key($node->field_imagem_topo)][0]['title']) ? $node->field_imagem_topo[key($node->field_imagem_topo)][0]['title'] : '' ?> 
                        <em><?= ($node->field_imagem_topo[key($node->field_imagem_topo)][0]['alt']) ? $node->field_imagem_topo[key($node->field_imagem_topo)][0]['alt'] : '' ?></em>
                    </span>

                    <?php
                endif;
                ?>
                <?php
                if (count($node->field_image[key($node->field_image)]) == 1):
                    ?>
                    <div class="imgLeft">
                        <img src="<?= image_style_url('400x300', $node->field_image[key($node->field_image)][0]['uri']) ?>"  alt="<?= $node->field_image[key($node->field_image)][0]['alt'] ?>" title="<?= $node->field_image[key($node->field_image)][0]['title'] ?>" />
                        <?php
                        if (!empty($node->field_image[key($node->field_image)][0]['title']) && !empty($node->field_image[key($node->field_image)][0]['alt'])):
                            ?>
                            <span class="legenda">
                                <?= ($node->field_image[key($node->field_image)][0]['title']) ? $node->field_image[key($node->field_image)][0]['title'] : '' ?> 
                                <em><?= ($node->field_image[key($node->field_image)][0]['alt']) ? $node->field_image[key($node->field_image)][0]['alt'] : '' ?></em></span>
                            <?php
                        endif;
                        ?>
                    </div>
                    <?php
                endif;
                ?>
                <?php
                //Verificando se o campo de galeria tem mais de uma foto e se existe a hash de galeria
                if (count($node->field_image[key($node->field_image)]) > 1 && strpos($node->body[key($node->body)][0]['value'], '[@#galeria#@]')) {
                    ob_start();
                    getGaleriaFull($node);
                    $galeria = ob_get_contents();
                    ob_end_clean();
                    $node->body[key($node->body)][0]['value'] = str_replace('[@#galeria#@]', $galeria, $node->body[key($node->body)][0]['value']);
                }
                //hash de video
                if (!empty($node->field_videost)) {
                    $embedVideo = ($scriptVideoEmbed[key($scriptVideoEmbed)]['value']) ? '<div class="embedvideobarra"><h5>Embed:</h5><input type="text" value="' . $node->field_videost[key($node->field_videost)][0]['safe_value'] . '"></div>' : '';
                    $scriptVideo = '<div class="embedvideoplayer">' . $node->field_videost[key($node->field_videost)][0]['value'] . $embedVideo . '</div>';
                    $node->body[key($node->body)][0]['value'] = str_replace('[@#video#@]', $scriptVideo, $node->body[key($node->body)][0]['value']);
                }
                //Hash de podcast
                if (!empty($node->field_audiost)) {
                    $node->body[key($node->body)][0]['value'] = str_replace('[@#podcast#@]', $node->field_audiost[key($node->field_audiost)][0]['value'], $node->body[key($node->body)][0]['value']);
                }
                //Hash de notícias relacionadas
                if(!empty($node->field_noticias_relacionadas)){
                    $node->body[key($node->body)][0]['value'] = str_replace('[@#relacionadas#@]', theme('block-noticias-rel-3', array('nids' => $noticiasRelacionadas)), $node->body[key($node->body)][0]['value']);
                }
                //Removendo a hash ##RECOMENDA##
                $node->body[key($node->body)][0]['value'] = str_replace('##RECOMENDA##', '', $node->body[key($node->body)][0]['value']);
                //Printando o corpo da node
                print $node->body[key($node->body)][0]['value'];
                ?>


                <script type="text/javascript">
                    jQuery('.embedvideoplayer').each(function () {
                        var iframeW = jQuery(this).find('iframe').width();
                        jQuery(this).find('.embedvideobarra').width(iframeW);
                        jQuery(this).find('.embedvideobarra input').width(iframeW - 120);
                    });
                </script>


                <div class="bottom_barra">

                    <div class="banner-footer">
                        <?php print render(block_get_blocks_by_region('banner_footer')); ?>
                    </div>

                    <div class="tagsExibir">
                        <h5>Tags:</h5>
                        <ul class="tags">
                            <?php
                            foreach ($node->field_tags[$node->language] as $tax):
                                if (!empty($tax['taxonomy_term']->tid)):
                                    ?>
                                    <li><a href="<?= url("taxonomy/term/" . $tax['taxonomy_term']->tid); ?>" title=""><?= $tax['taxonomy_term']->name; ?></a></li>
                                    <?php
                                endif;
                            endforeach;
                            ?>
                        </ul>
                    </div>
                    <?php
                    if (!empty($node->field_permlink)):
                        ?>    
                        <div class="permalink"><h5>Link:</h5>
                            <input type="text" value="<?= $node->field_permlink[$node->language][0]['value'] ?>" />
                        </div>
                        <?php
                    endif;
                    ?>

                </div>


            </div>
            <div class="bottom_inner">




                <div class="bannerNodeRodape">
                    <!-- LEIA JA - LL - 970x90 -->
                    <!--<script type="text/javascript">var ws_unit = { "id":"9334" };</script>
                    <script type="text/javascript" src="//wfpscripts.webspectator.com/ws-ad.js"></script>-->
                    <!-- BEGIN ADVERTPRO CODE -->
                    <script type="text/javascript">
                        document.write('<scr' + 'ipt src="http://ads.leiaja.com/servlet/view/banner/javascript/zone?zid=43&pid=0&random=' + Math.floor(89999999 * Math.random() + 10000000) + '&millis=' + new Date().getTime() + '&referrer=' + encodeURIComponent(document.location) + '" type="text/javascript"></scr' + 'ipt>');
                    </script>
                    <!-- END ADVERTPRO CODE -->
                </div>

                <div class="col left">
                    <h4><span>COMENTÁRIOS dos leitores</span></h4>
                    <div class="fb-comments" data-href="<?= $full_node_url ?>" data-numposts="5" data-colorscheme="light"></div>
                </div>
                <div class="col right">
                    <iframe src="<?= LEIAJAURL ?>/ultimas_dinamico?response_type=embed&c=<?= $node->type ?>&qnt=5&interna" scrolling="no" frameborder="0" width="330" class="zbox hgd10" style="margin-top:0px;border:0px;height:420px;margin-bottom:20px !important"></iframe>

                    <div class="bannerNodeRodape" style="display:block;margin:0px 16px">
                        <!-- LeiaJá - MREC - (300x250) -->
                        <!--<script type="text/javascript">var ws_unit = { "id":"5826" };</script>
                        <script type="text/javascript" src="//wfpscripts.webspectator.com/ws-ad.js"></script>-->
                        <!-- BEGIN ADVERTPRO CODE -->
                        <script type="text/javascript">
                            var bust = Math.floor(89999999 * Math.random() + 10000000);
                            var millis = new Date().getTime();
                            var referrer = encodeURIComponent(document.location);
                            document.writeln('<iframe src="http://ads.leiaja.com/servlet/view/banner/javascript/html/zone?zid=36&pid=0&refresh=30&refresh_limit=60&random=' + bust + '&millis=' + millis + '&referrer=' + referrer + '" height="250" width="300" hspace="0" vspace="0" frameborder="0" marginwidth="0" marginheight="0" scrolling="no">');
                            document.writeln('<a href="http://ads.leiaja.com/servlet/click/zone?zid=36&pid=0&lookup=true&random=' + bust + '&millis=' + millis + '&referrer=' + referrer + '" rel="nofollow" target="_blank">');
                            document.writeln('<img src="http://ads.leiaja.com/servlet/view/banner/javascript/image/zone?zid=36&pid=0&random=' + bust + '&millis=' + millis + '&referrer=' + referrer + '" height="250" width="300" hspace="0" vspace="0" border="0" alt="Click Here!">');
                            document.writeln('</a>');
                            document.writeln('</iframe>');
                        </script>
                        <!-- END ADVERTPRO CODE -->
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>
<!-- /section -->