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
?>
<!-- 
<div id="page-wrapper">
 -->
  <div id="page">
	<div class="divBannerTop">
	  <div class="divBannerTopContent">
		<div class="banner1"><?php print render($page['banner1']); ?><!-- /.section, /#banner1 -->
		</div>
		<div class="publicidadeTop"><b></b>
		</div>
	  </div>
	</div>
	<?php require_once 'menu.tpl.php'; // Carrega Menu. ?>
	<div id="divContainer" class="divContainer bgBranco <?= (@$node->type) ?  $node->type : '';?>">
	  <div class="divContainerContent">
    <div class="colunaEsquerda">
    <?if(empty($_GET['page']) || $_GET['page'] == 1){?>
      <div class="colunas2_1">
        <a href="<?= url(drupal_lookup_path('alias',"node/".$vDestaque[0]->nid)); ?>" class="margin-top7">
	  <img height="225" width="300" src="<?= image_style_url('medium', $vDestaque[0]->$thumb); ?>" alt="<?= $vDestaque[0]->title ?>">
	</a>
        <div class="contentCol margin-top7 margin-bottom7">
          <strong>
				<span class="iconeMultimidiaMenor iconeVidMenor"></span>
            <a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$vDestaque[0]->tid2)); ?>" class="linksStrong preto">
              <?=$vDestaque[0]->tag?>
            </a>
          </strong>
          <h4 class="noticiaH4"><a class='previewmodal1 links cinza' href="<?= url(drupal_lookup_path('alias',"node/".$vDestaque[0]->nid)); ?>"><?= $vDestaque[0]->title ?></a></h4>
        </div>
	<?= render($vBlockBannerPequeno); ?>
      </div>
      <div class="colunas2_1 margin-left25">
        <?php foreach($vLateral AS $key => $value){?>
        
          <div class="contentCol bordaBottom <?=($key == 0)? '':'margin-top15';?>">
                  <a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid)); ?>">
                    <img class="imgH4" title="<?=$value->title;?>" alt="<?=$value->title;?>" width="100" height="75" src="<?= image_style_url('home_thumb', $value->$thumb); ?>"></a>
                  <div class="containerImgH4">
                  <strong>
                    <span class="iconeMultimidiaMenor iconeVidMenor"></span>
                    <a class="linksStrong preto" href="<?= url(drupal_lookup_path('alias',"node/".$value->nid));?>">
                      <?=$value->tag;?>
                    </a>
                  </strong>
                  <h4 class="noticiaH4">
                    <a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$value->nid));?>">
                      <?=$value->title;?>
                    </a>
                  </h4>
            </div>
          </div> 
        <? } 
        ?>
      </div>
    <?}?>
      <ul class="listaResultadoMultimidia resultadoBusca">
	<?foreach($vLista AS $key => $value){?>
      	<li>
          <a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid)); ?>">
            <img class="imgH6Grande" title="<?=$value->title;?>" src="<?= image_style_url('home_cadernos', $value->$thumb); ?>" alt="<?=$value->title;?>">
          </a>
          <h4><a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid)); ?>"><?=$value->title;?></a></h4>
          <p><a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid)); ?>"><?= (empty($value->sumary)) ? truncate_utf8(strip_tags(str_replace(array('##RECOMENDA##', '[@#galeria#@]', '[@#video#@]'), '',$value->body_value)),160,true,true) : $value->sumary;?></a></p>
        	<h5 class="fonte">Por <span><?= $value->fonte ?></span>, em <?= $value->data ?> - <?= $value->hora ?></h5>
        </li>
        <? }?>
      </ul>
    <div class="divPaginacao">
      <?=$vPaginacao;?>
    </div>
    </div>
    <div class="colunaDireita">
        <?php print render($page['colunaDireita']); ?><!-- /.section, ./#colunaDireita -->
    </div>
    <?= render($page['shop']) ?><!-- /.section, /#shop -->
  </div>
</div>
</div>
<?php require_once 'rodape.tpl.php'; ?>