<?php

/**
 * @file
 * Bartik's theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template normally located in the
 * modules/system folder.
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
 * - $hide_site_name: TRUE if the site name has been toggled off on the theme
 *   settings page. If hidden, the "element-invisible" class is added to make
 *   the site name visually hidden, but still accessible.
 * - $hide_site_slogan: TRUE if the site slogan has been toggled off on the
 *   theme settings page. If hidden, the "element-invisible" class is added to
 *   make the site slogan visually hidden, but still accessible.
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
 * - $page['header']: Items for the header region.
 * - $page['featured']: Items for the featured region.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['triptych_first']: Items for the first triptych.
 * - $page['triptych_middle']: Items for the middle triptych.
 * - $page['triptych_last']: Items for the last triptych.
 * - $page['footer_firstcolumn']: Items for the first footer column.
 * - $page['footer_secondcolumn']: Items for the second footer column.
 * - $page['footer_thirdcolumn']: Items for the third footer column.
 * - $page['footer_fourthcolumn']: Items for the fourth footer column.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see bartik_process_page()
 */

?>
<script type="text/javascript" src="/<?= drupal_get_path('theme', 'agenda_recife')."/js/carrossel.js" ?>"></script>

<?php foreach($arrNode as $strChave=>$arrArrDados) { 
 ?>
    <script type="text/javascript">
      
      var arrFotos<?= $strChave ?> = new Array();
      <?php 
        $intContador = 0;
        foreach($arrNode[$strChave]["arrObjNodeCarrocel"] as $key => $not):
          $vLink = url(drupal_lookup_path('alias',"node/".$not->nid));
          $vIndice = $key+1;
          
          // Retirando as hash de marcação
          $not->body["und"][0]["value"] = str_replace("[@#podcast#@]", "",  $not->body["und"][0]["value"]);
          $not->body["und"][0]["value"] = str_replace("[@#video#@]",   "",  $not->body["und"][0]["value"]);
          $not->body["und"][0]["value"] = str_replace("[@#galeria#@]", "",  $not->body["und"][0]["value"]);
          
      ?>
        arrFotos<?= $strChave ?>[<?= $intContador++ ?>] = {"nid" : <?= $not->nid ?>,"title" : "<?= addslashes($not->title) ?>","link" : "<?= $vLink ?>","imagem_thumb" : "<?= image_style_url('home_thumb', $not->field_capa["und"][0]["uri"]); ?>","imagem_grd" : "<?= image_style_url('large', $not->field_capa["und"][0]["uri"]) ?>","imagem_med" : "<?= image_style_url('carrocel_agenda', $not->field_capa["und"][0]["uri"]) ?>","user" : "<?=$GLOBALS['user']->uid.';'.$not->nid?>","resumo":"<?=  (!empty ($not->body["und"][0]["summary"])) ? strip_tags(addslashes(trim($not->body["und"][0]["summary"]))) : strip_tags(addslashes(trim(substr($not->body["und"][0]["value"], 0, 80)))); ?>","subcategoria" : "Agenda Recife"};      
      <?php endforeach; ?>
      (function ($) {
          $(document).ready(function(){
            initCarrossel('peq', false, arrFotos<?= $strChave ?>, 'noticiaSlide<?= $strChave ?>');
          });
      })(jQuery);
    </script>
    <!-- box -->
    <div class="divBox" id="<?= $strChave ?>">
      <h1><span><a href="/categoria/<?= semAcentos($arrNode[$strChave]["name"], "-"); ?>"><?= $arrNode[$strChave]["name"]; ?></a></span></h1>
      <div>
        <div class="slideNoticias">
          <!-- Carrocel Imagens <?= $strChave ?> --> 
          <div id="noticiaSlide<?= $strChave ?>" class="main_view margin-left25">				
            <div class="window" style="float:left; width:345px; height:300px;">
              <div class="image_reel"></div>
            </div>
            <div class="pagingMenor divPaginacao"></div>
            <div class="divContentImg divContentImgMenor">
            <div class="divContentImgEsquerda"></div>
            </div>
          </div>
          <!-- Fim Carrocel Imagens <?= $strChave ?> -->
        </div>
        <div class="listaNoticias">
          <ul>
            <?php 
              // Percorrendo o array de objeto node lateral
              foreach($arrNode[$strChave]["arrObjNodeLateral"] as $objNode) {
                $strLink = url(drupal_lookup_path('alias',"node/".$objNode->nid));
            ?>
                <li>
                  <div>
                      <a href="<?= $strLink ?>">
                        <img width="122" height="122" src="<?= image_style_url('home_thumb_agenda', $objNode->field_capa["und"][0]["uri"]); ?>" />
                      </a>
                  </div>
                  <h2>
                      <a href="<?= $strLink ?>">
                        <?= api_getChapeuByTid($objNode->field_chapeu["und"][0]["tid"]); ?>
                      </a>
                  </h2>
                  <p>
                      <a href="<?= $strLink ?>">
                        <?= $objNode->title; ?>
                      </a>
                  </p>
                  <a href="<?= $strLink ?>" class="lermais" title="Ler toda a matéria">
                      <span>
                        ler mais
                      </span>
                  </a>
                </li>
            <?php
              }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <!-- /box -->
<?php
  }
?>