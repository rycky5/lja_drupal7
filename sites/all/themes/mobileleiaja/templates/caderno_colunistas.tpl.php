<?php
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */
$count = 0;
?>
 <div id="colunasBlogs">
  <h1 class="cabecalho"><span>Colunas</span></h1>
  <?foreach($vColunistas AS $key => $value){?>
  <div class="destaque2 <?=$value->parent;?> bg">
	<p class="foto">
	  <a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$value->tid));?>">
		<img alt="<?=$value->subcategoria?>" src="<?= base_path().drupal_get_path('theme', 'leiaja').'/images/foto-coluna-'.$value->tid.'.jpg'?>">
	  </a>
	</p>
	<h1><?=$value->coluna?></h1>
	<p class="titulo">
	  <a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid));?>"><?=$value->title?></a>
	</p>
  </div>
  <? }?>
            
  <h1 class="cabecalho"><span>Blogs da reda&ccedil;&atilde;o</span><a name="blogs"></a></h1>
  <? foreach($vBlogsRedacao AS $key => $value){?>
  <div class="destaque2 <?=$value->parent;?> bg">
    <p class="foto">
      <a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$value->tid));?>">
        <img alt="<?=$value->title?>" src="<?= base_path().drupal_get_path('theme', 'leiaja').'/images/blogs-redacao-'.$value->tid.'.jpg';?>">
      </a>
    </p>
    <h1><?=$value->subcategoria?></h1>
    <p class="titulo">
      <a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid));?>"><?=$value->title?></a>
    </p>
  </div>
  <? }?>
  <?/* foreach($vBlogsParceiros AS $key => $value){?>
  <div class="destaque2 cultura bg">
	<p class="foto">
	  <a href="#">
		<img alt="Tudo sobre moda, culinária e frescurinhas de mulher!" src="images/colunista.jpg">
	  </a>
	</p>
	<h1>Blog de algo</h1>
	<p class="titulo">
	  <a href="#">Tudo sobre moda, culinária e frescurinhas de mulher!</a>
	</p>
  </div>
  <? }*/?>
</div>