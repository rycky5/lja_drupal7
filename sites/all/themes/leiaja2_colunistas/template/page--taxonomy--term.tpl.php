<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 */
$resultViewsPagPost = views_get_view_result('posts_de_colunistas', 'pag_posts_colunista');
$resultViewsHomePost = views_get_view_result('posts_de_colunistas', 'home_posts_colunistas');

$setArray = array();
if (!empty($resultViewsPagPost)) {
    $setArray = $resultViewsPagPost;
    $pagincao = 1;
} else {
    $setArray = $resultViewsHomePost;
}

$colunaTid = $setArray[0]->_field_data['nid']['entity']->field_catcolunista['pt-br'][0]['tid'];
$objTaxy = taxonomy_term_load($colunaTid);
$colunaTt = $objTaxy->name;
drupal_set_title($colunaTt);
$colunaDesc = $objTaxy->description;
$colunaEstilo = 'caderno_' . $objTaxy->field_parent['und'][0]['value'];
$urlColuna = drupal_lookup_path('alias', 'taxonomy/term/' . $colunaTid);
$script = (empty($objTaxy->field_script[key($objTaxy->field_script)][0]['value'])) ? '' : $objTaxy->field_script[key($objTaxy->field_script)][0]['value'];

$pathLeiaja = drupal_get_path('theme', 'leiaja');


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
        'content' => $title,
    ),
);
drupal_add_html_head($vMetaTitle, 'meta_title');

$vMetaDescription = array(
    '#tag' => 'meta',
    '#attributes' => array(
        'property' => 'og:description',
        'content' => (!empty($node->body[key($node->body)][0]['summary'])) ? $node->body[key($node->body)][0]['summary'] : truncate_utf8($node->body[key($node->body)][0]['value'], 255, TRUE),
    ),
);
drupal_add_html_head($vMetaDescription, 'meta_description');

$vMetaImagem = array(
    '#tag' => 'meta',
    '#attributes' => array(
        'property' => 'og:image',
        'content' => $strImagem,
    ),
);
drupal_add_html_head($vMetaImagem, 'meta_image');
?>
<!-- header -->
<?php
$themePath = drupal_get_path('theme', 'leiaja2_colunistas');
include_once $themePath . '/template/header.php';
?>
<div class="region region-content">
    <div id="block-system-main" class="block block-system">
        <!-- section -->
        <section id="content" class="template-colunistas">

            <div class="containerInterna ">
                <div  class="colLeft">
                    <div class="inner_top <?= $cadernoSettings['cor'] ?>">
                        <div class="breadcrumb">
                            <span><a href="http://www.leiaja.com">www.<strong>leiaja</strong>.com/</a></span>

                            <h2 class="tituloH2 tituloH2Colunista cinza"><a title="Colunistas" class="cinza" target="_parent" href="/colunistas">Colunistas</a></h2>

                        </div>
                    </div>

                    <div class="inner_content">

                        <div class="foto-colunista">
                            <img src="/<?= $pathLeiaja ?>/images/foto-colunista-<?= $colunaTid; ?>.jpg" alt="<?= $colunaTt ?>" />
                        </div>


                        <?php
                        if ((arg(0) == 'carreiras' && arg(1) == 'concursos' && empty($_GET['page'])) || (arg(0) != 'carreiras' && arg(1) != 'concursos')):
                            ?>

                            <div class="content-colunistas">
                                <h2 class="title_default"><?= $colunaTt; ?></h2>
                                <?= $colunaDesc; ?>
                            </div>  

                            <div class="content_aviso">
                                <h5>Os Blogs Parceiros e Colunistas do Portal LeiaJa.com são formados por autores convidados pelo domínio notável das mais diversas áreas de conhecimento. Todos as publicações são de inteira responsabilidade de seus autores, da mesma forma que os comentários feitos pelos internautas.</h5>
                            </div>

                            <div class="content_list">                                
                                <?php
                                if ($setArray or ! empty($setArray)) {
                                    foreach ($setArray as $key => $node) {
                                        print render(node_view($node->_field_data["nid"]["entity"]));
                                    }
                                } else {
                                    print '<h2>Não há resultados para esse endereço!</h2>';
                                }
                                ?>   
                            </div>

                            <div class="divPaginacao">
                                <div class="paginacao2">
                                    <?php
                                    if ($pagincao !== 1) {
                                        print theme_pager(array('element' => 0, 'quantity' => 10));
                                    }
                                    ?>
                                </div>
                            </div>

                            <?php
                        endif;
                        ?>
                        <?php
                        if (arg(0) == 'carreiras' && arg(1) == 'concursos'):
                            ?>
                            <div class="content_list">
                                <?= views_embed_view('ultimas_noticias', 'ultimas_concurso') ?>
                            </div>
                            <?php
                        endif;
                        ?>
                    </div>
                </div>
                <?php
                if (arg(0) != 'colunistas' && arg(0) != 'especiais'):
                    ?>
                    <aside>
                        <div class="colRight">
                            <?php print render($page['sidebar']) ?>                       
                        </div>
                    </aside>
                    <?php
                endif;
                ?>
            </div>

        </section>
        <!-- /section -->

    </div>
</div>
<?php
print $objTaxy->field_script[key($objTaxy->field_script)][0]['value'];
include_once $themePath . '/templates/footer.php';
?>
<!-- /footer -->