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
 * @ingroup themeable
 */
$objUser = user_load($uid);
$vUserName = $objUser->name;
$vUserRoles = $objUser->roles;
$cadernoSettings = getCadernoNode($node->type);
$objFieldCategoria = $node->$cadernoSettings['field'];
$classNoticia = str_replace('caderno_', '', $node->type);

//Opengraph
if (!empty($node->field_capa)) {
    //Recuperando a uri da imagem de capa
    $imagem = $node->field_capa[key($node->field_capa)][0]["uri"];
    $strImagem = file_create_url($imgCapa);
} elseif (!empty($node->field_imagem_topo)) {
    //Recuperando a uri da imagem de topo
    $imagem = $node->field_imagem_topo[key($node->field_imagem_topo)][0]['uri'];
    $strImagem = file_create_url($imagem);
} elseif (!empty($node->field_image)) {
    //Recuperando a uri da imagem
    $imagem = $node->field_image[key($node->field_image)][0]["uri"];
    $strImagem = file_create_url($imagem);
} else {
    $strImagem = "http://www.leiaja.com/images/leiaja_acento.jpg";
}

$vMetaSiteName = array(
    '#tag' => 'meta',
    '#attributes' => array(
        'property' => 'og:site_name',
        'content' => 'LeiaJá'
    )
);
drupal_add_html_head($vMetaSiteName, 'meta_site_name');

$vMetaPhone = array(
    '#tag' => 'meta',
    '#attributes' => array(
        'property' => 'og:phone_number',
        'content' => '+55 81 3334-3333'
    )
);
drupal_add_html_head($vMetaPhone, 'meta_phone');

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
        'content' => (!empty($node->body[key($node->body)][0]['summary'])) ? strip_tags(truncate_utf8($node->body[key($node->body)][0]['summary'], 255, TRUE)) : strip_tags(truncate_utf8($node->body[key($node->body)][0]['value'], 255, TRUE))
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
drupal_add_html_head($vMetaImagem, 'meta_imagem');

$vMetaEmail = array(
    '#tag' => 'meta',
    '#attributes' => array(
        'property' => 'og:email',
        'content' => 'redacao@leiaja.com.br'
    )
);
drupal_add_html_head($vMetaEmail, 'meta_email');

$vMetaUrl = array(
    '#tag' => 'meta',
    '#attributes' => array(
        'property' => 'og:url',
        'content' => url('node/' . $node->nid, array('absolute' => TRUE))
    )
);
drupal_add_html_head($vMetaUrl, 'meta_url');
?>
<article class="mnode thumbnail <?= $classNoticia; ?>">
    <?php
    if (!empty($node->field_imagem_topo)):
        ?>
        <img src="<?= file_create_url($node->field_imagem_topo[key($node->field_imagem_topo)][0]['uri']) ?>" alt="<?= $node->field_imagem_topo[key($node->field_imagem_topo)][0]['alt'] ?>" title="<?= $node->field_imagem_topo[key($node->field_imagem_topo)][0]['title'] ?>">
        <?php
    elseif (!empty($node->field_image) && count($node->field_image[key($node->field_image)]) == 1) :
        ?>
        <img src="<?= file_create_url($node->field_image[key($node->field_image)][0]['uri']) ?>" alt="<?= $node->field_image[key($node->field_image)][0]['alt'] ?>" title="<?= $node->field_image[key($node->field_image)][0]['title'] ?>">
        <?php
    endif;
    ?>
    <div class="col-xs-10 no-padding">
        <?php if (!empty($objFieldCategoria[key($objFieldCategoria)][0]['taxonomy_term']->name)) : ?>
            <h2><?= $objFieldCategoria[key($objFieldCategoria)][0]['taxonomy_term']->name; ?></h2>
        <?php endif; ?>
    </div>
    <div class="col-xs-2 no-padding">
        <a href="#" data-toggle="modal" data-target="#modal-share"><img class="share" src="/<?php print drupal_get_path('theme', $GLOBALS['theme']) ?>/img/icon_share_<?= $classNoticia ?>.svg"></a>
    </div>
    <div class="col-xs-12 no-padding">
        <h1><?= stripslashes($title); ?></h1>
    </div>
    <?php
    if (!empty($node->body[key($node->body)][0]['summary'])):
        ?>
        <div class="col-xs-12 no-padding">
            <h3><?= $node->body[key($node->body)][0]['summary'] ?></h3>
        </div>
        <?php
    endif;
    ?>

    <div class="col-xs-12 no-padding">
        <?php
        $file = drupal_get_path('theme', 'leiaja2') . '/images/' . semAcentos($node->field_fonte[$node->language][0]['value']) . '.jpg';

        if (!empty($node->field_fonte)) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . base_path() . $file)) {
                if ($node->field_fonte[$node->language][0]['value'] == 'LeiaJá' && !in_array('administrator', $vUserRoles)) {
                    echo '<h4><img height="18" src="/' . $file . '" title=""> por ' . $vUserName . ' |  ' . $date . '</h4>';
                } else {
                    echo '<h4><img height="18" src="/' . $file . '" title=""> | ' . $date . '</h4>';
                }
            } else {
                echo '<h4>' . $node->field_fonte[$node->language][0]['value'] . ' por ' . $vUserName . ' | ' . $date . '</h4>';
            }
        } else {
            echo '<h4>por ' . $vUserName . ' | ' . $date . '</h4>';
        }
        ?>
    </div>
    <div class="col-xs-12 no-padding">
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
        if (!empty($node->field_noticias_relacionadas)) {
            $node->body[key($node->body)][0]['value'] = str_replace('[@#relacionadas#@]', theme('block-noticias-rel-3', array('nids' => $noticiasRelacionadas)), $node->body[key($node->body)][0]['value']);
        }
        //Removendo a hash ##RECOMENDA##
        $node->body[key($node->body)][0]['value'] = str_replace('##RECOMENDA##', '', $node->body[key($node->body)][0]['value']);
        //Printando o corpo da node
        print $node->body[key($node->body)][0]['value'];
        ?>
    </div>
    <div class="col-xs-12 no-padding numero-comentario">
        <a href="#" data-toggle="modal" data-target="#modal-comments">Comentários</a>
    </div>
    <!-- Começa Modal Comentários -->
    <div id="modal-comments" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-comments-title">Comentários</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> 
                <div class="modal-body">
                    <div class="fb-comments" data-href="<?= url($node_url, array('absolute' => true)); ?>" data-numposts="5" data-colorscheme="light"></div>
                </div>
            </div>
        </div>
    </div>
    <hr>
</article>
<!-- Termina model Comentários
<!-- Começa Modal Compartilhar -->
<div id="modal-share" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-share-title">Compartilhar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-xs-4 align-center">
                    <div class="" data-href="<?= url($node_url, array('absolute' => true)); ?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= url($node_url, array('absolute' => true)); ?>" class="fb-xfbml-parse-ignore facebook"><img src="/<?php print drupal_get_path('theme', $GLOBALS['theme']) ?>/img/icon_facebook.svg" alt="Compartilhar no Facebook"></a></div>
                </div>
                <div class="col-xs-4 align-center">
                    <a target="_blank" href="https://twitter.com/intent/tweet?text=<?= $title; ?>: <?= url($node_url, array('absolute' => true)); ?>" class="twitter">
                        <img src="/<?php print drupal_get_path('theme', $GLOBALS['theme']) ?>/img/icon_twitter.svg" alt="Compartilhar no Twitter">
                    </a>
                </div>
                <div class="col-xs-4 align-center">
                    <a href="https://api.whatsapp.com/send?text=<?= $title; ?>: <?= url($node_url, array('absolute' => true)); ?>" class="whatsapp"><img src="/<?php print drupal_get_path('theme', $GLOBALS['theme']) ?>/img/icon_whatsapp.svg" alt="Compartilhar no Whatsapp"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Termina Modal Compartilhar -->
