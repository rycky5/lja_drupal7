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
Teste em page.tpl.php
<?
/*
<div id="page-wrapper"><div id="page">
  <div class="divBannerTop">
	<div class="divBannerTopContent">
      <div class="banner1"><?php print render($page['banner1']); ?><!-- /.section, /#banner1 --></div>
      <div class="publicidadeTop"><b></b></div>
    </div>
  </div>
  <?php require_once 'menu.tpl.php'; // Carrega Menu. ?>
    <?if(!empty($cobertura) && count($vNoticiasTagFotos) > 2 && count($vNoticiasTag) > 1 ){
    ?>
  <div class="divContainerNoticiaDestaque caderno_<?=@semAcentos(strtolower($vCadernoNome));?>" id="divContainer">
    <div class="divContentNoticiaDestaque Content5Noticia">
    <div class="col1">
    <h2><a href="<?= url(drupal_lookup_path('alias',"node/".$vNoticiasTag[0]->nid)); ?>" class="links"><?=truncate_utf8($vNoticiasTag[0]->title,58,true,true);?></a></h2>
    </div>
    <div class="col2">
      <div class="contentCol bordaBottom padding-bottom15">
        <a href="<?= url(drupal_lookup_path('alias',"node/".$vNoticiasTagFotos[0]->nid)); ?>"><img src="<?= image_style_url('home_thumb', $vNoticiasTagFotos[0]->uri); ?>" alt="<?=$vNoticiasTagFotos[0]->title;?>" class="imgH4"></a>
        <div class="containerImgH4">
          <h4 class="noticiaH4"><a href="<?= url(drupal_lookup_path('alias',"node/".$vNoticiasTagFotos[0]->nid)); ?>" class="links"><?=truncate_utf8($vNoticiasTagFotos[0]->title,58,true,true);?></a></h4>
        </div>
      </div>
      <div class="contentCol margin-top10">
      	<h3 class="noticiaH3"><a href="<?= url(drupal_lookup_path('alias',"node/".$vNoticiasTag[1]->nid)); ?>" class="links"><?=truncate_utf8($vNoticiasTag[1]->title,58,true,true);?></a></h3>
      </div>
    </div>
    <div class="col3">
      <div class="contentCol">
        <a href="<?= url(drupal_lookup_path('alias',"node/".$vNoticiasTagFotos[1]->nid)); ?>"><img height="102.9" width="137.9" src="<?= image_style_url('home_cadernos', $vNoticiasTagFotos[1]->uri); ?>" alt="<?=$vNoticiasTagFotos[1]->title;?>" class="margin-bottom14"></a>
        <h4 class="noticiaH4 padding-bottom4px"><a href="<?= url(drupal_lookup_path('alias',"node/".$vNoticiasTagFotos[1]->nid)); ?>" class="links"><?=truncate_utf8($vNoticiasTagFotos[1]->title,58,true,true);?></a></h4>
      </div>
      <div class="contentCol margin-left25">
        <a href="<?= url(drupal_lookup_path('alias',"node/".$vNoticiasTagFotos[2]->nid)); ?>"><img height="102.9" width="137.9" src="<?= image_style_url('home_cadernos', $vNoticiasTagFotos[2]->uri); ?>" alt="<?=$vNoticiasTagFotos[2]->title;?>" class="margin-bottom14"></a>
        <h4 class="noticiaH4 padding-bottom4px"><a href="<?= url(drupal_lookup_path('alias',"node/".$vNoticiasTagFotos[2]->nid)); ?>" class="links"><?=truncate_utf8($vNoticiasTagFotos[2]->title,58,true,true);?></a></h4>
      </div>
      <a href="<?=$linkTag;?>" class="links linkcobertura">Confira a cobertura completa</a>
    </div>
  </div>
</div>
<?}?>
<div <?=(!empty($cobertura))?'':'id="divContainer"';?> class="divContainer bgBranco <?= (@$node->type) ?  $node->type : '';?> caderno_<?=@semAcentos(strtolower($vCadernoNome));?>">
	<div class="divContainerContent">
	<? if(@$node->type): // Exibe a barra de navegação caso seja um node.4?>
  	<!--Brad camb-->
    <div class="divMapeamento">
    	<ul>
      	<li><a title="Leia Já" href="<?= base_path() ?>">LeiaJá</a><span class="seta"></span></li>
	<? if(!empty($vCrumb->machine_name)){?>
          <li><a title="<?= $vCrumb->categoria ?>" href="<?= base_path().$vCrumb->machine_name ?>"><?= $vCrumb->categoria ?></a><span class="seta"></span></li>
          <li><a class="active" title="<?= $vCrumb->subcategoria ?>" href="<?= url(drupal_lookup_path('alias','taxonomy/term/'.$vCrumb->tid)) ?>"><?= $vCrumb->subcategoria ?></a></li>
        <? }else{?>
          <li><a title="<?= ucwords(drupal_lookup_path('alias',"node/".arg(1)));?>" href="<?= base_path().drupal_lookup_path('alias',"node/".arg(1)); ?>"><?= ucwords(drupal_lookup_path('alias',"node/".arg(1))); ?></a></li>
        <? }?>
      </ul>
      <div class="divContentMapeamento">
      	<a id="aRecomendarTopo" title="Recomendar" href="javascript:void(0);">Recomendar</a>
        <a id="aRecomendarTopoBotao" class="btCompartilhar" title="Recomendar" href="javascript:void(0);"></a>
        <span>|</span>
        <a id="aPrintTopo" title="Imprimir" href="javascript:void(0);">Imprimir</a>
        <a id="aPrintTopoBotao" class="btImprimir" title="Imprimir" href="javascript:void(0);"></a>
      </div>
    </div>
    <!--Fim do Brad camb-->
    <? endif; ?>
    
    <?php if(@$is_caderno) : ## Verifica se é capa do caderno.?>
  	  <div class="divSubCadernos">
    	<h2 class="cinza"><?= $vCadernoNome ?></h2>
        <ul>
          <?php 
            // Constrói os submenus/tags
            foreach($vSubCategorias[arg(0)] as $sub){
          ?>
            <li><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$sub['tid'])); ?>"><?= $sub['title'] ?></a></li>  
          <?php
            }
          ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="colunaEsquerda" <?= (!empty($sem_colunadireita)? 'style="width:950px;"' : '');?>>
      <?php print render($page['content']); ?><!-- /.section, /#content -->
      <?= render($vBlocos['ultimasNoticias']); ?>
      <?php print render($page['content2']); ?><!-- /.section, ./#content2 -->
    </div>
    <?php if(empty($sem_colunadireita)): ?>
      <div class="colunaDireita">
        <?php print render($page['colunaDireita']); ?><!-- /.section, ./#colunaDireita -->
      </div>
    <?php endif; ?>
    <?= render($page['shop']) ?><!-- /.section, /#shop -->
    <style>
        .Widget960x300{width:948px;}
        .Widget960x300 .footer{width:928px;}
        .Widget960x300 .offers li{margin:0 8px;}
        .tabs{margin:0 10px 0 0;}
        #buscaofertas-373865{float:left;}
    </style>
  </div>
</div>
<?php require_once 'rodape.tpl.php'; */?>