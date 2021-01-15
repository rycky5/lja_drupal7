<?php
//Template Principal
// $Id: page.tpl.php,v 1.9 2010/11/07 21:48:56 dries Exp $

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
 * - $page['content']: The main content of the current page.
 * - $page['content_bloco_2']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['triptych_first']: Items for the first triptych.
 * - $page['triptych_middle']: Items for the middle triptych.
 * - $page['triptych_last']: Items for the last triptych.
 * - $page['footer_fourthcolumn']: Items for the fourth footer column.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 */

$thumb = ($vLista[0]->uriThumbVideo)? 'uriThumbVideo' : 'uri';
//var_dump($vLista[0]);
?>
<?php require_once 'menu.tpl.php'; // Carrega Menu. ?>
<div class="divContainer">
  <div class="divContainerContent caderno_multimidia">
    <ul class="menu">
      <li><a href="<?=base_path()?>especial/portasabertas/2011/o-especial" title="O ESPECIAL">O ESPECIAL</a></li>
      <li><a href="<?=base_path()?>especial/portasabertas" title="NOTÍCIAS">NOTÍCIAS</a></li>
      <li><a href="<?=base_path()?>especial/portasabertas/2011/expediente" title="EXPEDIENTE">EXPEDIENTE</a></li>
    </ul>
    <div class="colunaEsquerda">      
<?
      //var_dump();
      //Resolver o chamada da home pois o render page content está retornando o nome do tema.
      //var_dump(render($page['content']));
      $param = arg(2);
      $node =  arg(0);
      //if('espparques' == render($page['content'])){
      if(is_null($param) && $node != 'node'){
        ?>
      <div class="colunas2 colunaprincipal">
      	<div class="divImgPrincipalHome">
          <a href="<?= url(drupal_lookup_path('alias',"node/".$vLista[0]->nid)); ?>">
            <img class="imgH2"  width="300" height="225" title="<?=$vLista[0]->title?>" alt="<?=$vLista[0]->title?>" src="<?= image_style_url('medium', $vLista[0]->uriThumbVideo); ?>">
          </a>
        </div>
        <div class="contentCol bordaBottom padding-bottom7">
        	<strong><a class="linksStrong vermelho" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[0]->nid)); ?>"><?=$vLista[0]->tag?></a></strong>
          <h2 class="noticiaH2">
          	<a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[0]->nid)); ?>"><?=$vLista[0]->title?></a>
          </h2>
        </div>
        <div class="contentCol bordaBottom padding-bottom7 padding-top7">
        	<strong><a class="linksStrong vermelho" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[1]->nid)); ?>"><?=$vLista[1]->tag?></a></strong>
          <h3 class="noticiaH3"><a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[1]->nid)); ?>"><?=$vLista[1]->title?></a></h3>
        </div>
      </div>
      <div class="colunas2 margin-bottom15">
        <div class="contentCol bordaBottom">
        	<a href="<?= url(drupal_lookup_path('alias',"node/".$vLista[2]->nid)); ?>">
                  <img width="100" height="75" class="imgH4" title="<?=$vLista[2]->title?>" alt="<?=$vLista[2]->title?>" src="<?= image_style_url('home_thumb', $vLista[2]->uriThumbVideo); ?>"></a>
        	<div class="containerImgH4">
          	<strong><a class="linksStrong verde" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[2]->nid)); ?>"><?=$vLista[2]->tag?></a></strong>
          	<h4 class="noticiaH4"><a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[2]->nid)); ?>"><?=$vLista[2]->title?></a></h4>
          </div>
        </div>
        <div class="contentCol bordaBottom margin-left25">
        	<a href="<?= url(drupal_lookup_path('alias',"node/".$vLista[3]->nid)); ?>">
                  <img width="100" height="75" class="imgH4" alt="<?=$vLista[3]->title?>" title="<?=$vLista[3]->title?>" src="<?= image_style_url('home_thumb', $vLista[3]->uriThumbVideo); ?>"></a>
        	<div class="containerImgH4">
          	<strong><a class="linksStrong verde" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[3]->nid)); ?>"><?=$vLista[3]->tag?></a></strong>
          	<h4 class="noticiaH4"><a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[3]->nid)); ?>"><?=$vLista[3]->title?></a></h4>
          </div>
        </div>
        <div class="contentCol bordaBottom margin-top15">
        	<a href="<?= url(drupal_lookup_path('alias',"node/".$vLista[4]->nid)); ?>">
                  <img width="100" height="75" class="imgH4" alt="<?=$vLista[4]->title?>" title="<?=$vLista[4]->title?>" src="<?= image_style_url('home_thumb', $vLista[4]->uriThumbVideo); ?>"></a>
        	<div class="containerImgH4">
          	<strong><a class="linksStrong laranja" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[4]->nid)); ?>"><?=$vLista[4]->tag?></a></strong>
          	<h4 class="noticiaH4"><a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[4]->nid)); ?>"><?=$vLista[4]->title?></a></h4>
          </div>
        </div>
        <div class="contentCol bordaBottom margin-left25 margin-top15">
        	<a href="<?= url(drupal_lookup_path('alias',"node/".$vLista[5]->nid)); ?>">
                  <img width="100" height="75" class="imgH4" alt="<?=$vLista[5]->title?>" title="<?=$vLista[5]->title?>" src="<?= image_style_url('home_thumb', $vLista[5]->uriThumbVideo); ?>"></a>
        	<div class="containerImgH4">
          	<strong><a class="linksStrong roxo" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[5]->nid)); ?>"><?=$vLista[5]->tag?></a></strong>
          	<h4 class="noticiaH4"><a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[5]->nid)); ?>"><?=$vLista[5]->title?></a></h4>
          </div>
        </div>   
        <div class="contentCol bordaBottom margin-top15 padding-bottom15">
          <strong><a class="linksStrong laranja" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[6]->nid)); ?>"><?=$vLista[6]->tag?></a></strong>
          <h5 class="noticiaH5"><a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[6]->nid)); ?>"><?=$vLista[6]->title?></a></h5>
        </div>
        <div class="contentCol bordaBottom margin-left25 margin-top15 padding-bottom15">
          <strong><a class="linksStrong azulClaro" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[7]->nid)); ?>"><?=$vLista[7]->tag?></a></strong>
          <h5 class="noticiaH5"><a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[7]->nid)); ?>"><?=$vLista[7]->title?></a></h5>
        </div>
        <div class="contentCol bordaBottom margin-top15">
        	<a href="<?= url(drupal_lookup_path('alias',"node/".$vLista[8]->nid)); ?>">
                  <img width="100" height="75"  class="imgH4" alt="<?=$vLista[8]->title?>" title="<?=$vLista[8]->title?>" src="<?= image_style_url('home_thumb', $vLista[8]->uriThumbVideo); ?>"></a>
        	<div class="containerImgH4">
          	<strong><a class="linksStrong verde" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[8]->nid)); ?>"><?=$vLista[8]->tag?></a></strong>
          	<h4 class="noticiaH4"><a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[8]->nid)); ?>"><?=$vLista[8]->title?></a></h4>
          </div>
        </div>
        <div class="contentCol bordaBottom margin-left25 margin-top15">
        	<a href="<?= url(drupal_lookup_path('alias',"node/".$vLista[9]->nid)); ?>">
                  <img width="100" height="75"   class="imgH4"  alt="<?=$vLista[9]->title?>" title="<?=$vLista[9]->title?>" src="<?= image_style_url('home_thumb', $vLista[9]->uriThumbVideo); ?>"></a>
        	<div class="containerImgH4">
          	<strong><a class="linksStrong verde" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[9]->nid)); ?>"><?=$vLista[9]->tag?></a></strong>
          	<h4 class="noticiaH4"><a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[9]->nid)); ?>"><?=$vLista[9]->title?></a></h4>
          </div>
        </div>
        <div class="contentCol margin-top15">
        	<a href="<?= url(drupal_lookup_path('alias',"node/".$vLista[10]->nid)); ?>">
                  <img  width="100" height="75"   class="imgH4"  alt="<?=$vLista[10]->title?>" title="<?=$vLista[10]->title?>" src="<?= image_style_url('home_thumb', $vLista[10]->uriThumbVideo); ?>"></a>
        	<div class="containerImgH4">
          	<strong><a class="linksStrong laranja" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[10]->nid)); ?>"><?=$vLista[10]->tag?></a></strong>
          	<h4 class="noticiaH4"><a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[10]->nid)); ?>"><?=$vLista[10]->title?></a></h4>
          </div>
        </div>
        <div class="contentCol margin-left25 margin-top15">
        	<a href="<?= url(drupal_lookup_path('alias',"node/".$vLista[11]->nid)); ?>">
                  <img width="100" height="75"  class="imgH4" alt="<?=$vLista[11]->title?>" title="<?=$vLista[11]->title?>" src="<?= image_style_url('home_thumb', $vLista[11]->uriThumbVideo); ?>">
                </a>
        	<div class="containerImgH4">
          	<strong><a class="linksStrong roxo" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[11]->nid)); ?>"><?=$vLista[11]->tag?></a></strong>
          	<h4 class="noticiaH4"><a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vLista[11]->nid)); ?>"><?=$vLista[11]->title?></a></h4>
          </div>
        </div>   
      </div>
    <?}else{
        //echo $node;
        print render($page['content']);
    }?>
    </div>
  </div>
</div>
<div class="divFooter"></div>
<script src="//static.getclicky.com/js" type="text/javascript"></script>
<script type="text/javascript">try{ clicky.init(66504528); }catch(e){}</script>