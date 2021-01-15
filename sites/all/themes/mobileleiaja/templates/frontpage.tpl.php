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
 * 
 */
$class = '';
?>
<div id="noticias">
  <?foreach($vCapa AS $key => $value){
    if(!empty($value->title)){
  if(!empty($value->uri)){
    $foto = "<p class='foto'>
      <a href='".url(drupal_lookup_path('alias',"node/".$value->nid))."'>
            <img src='".image_style_url('home_thumb', $value->uri)."' alt='{$value->title}' />
      </a>
    </p>";
    $class = ($key == 0)? 'destaque1' : 'destaque2';
  }else{
    $class = 'destaques';
    $foto = '';
  }
  ?>
  <div class="<?="$class {$value->machine_name}"?>">
    <?=$foto?>
    <h1><?=$value->subcategoria;?></h1>
    <p class="titulo">
      <a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid));?>">
        <?=$value->title;?>
      </a>
    </p>
  </div>
  <?
    }
  }?>
    
</div>
<div id="ultimasNoticias">
  <h1 class="cabecalho">
    <span>&Uacute;ltimas Not&iacute;cias</span>
    <a href="http://www1.leiaja.com/ultimas">Ir para &Uacute;ltimas Not&iacute;cias</a>
  </h1>
  <ul class="ul"> 
  <? foreach ($vUltimas AS $key => $value){?>
    <li class="<?=$value->machine_name;?>">
      <a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid));?>">
        <?=$value->hora;?> - <?=$value->title;?>
      </a>
    </li>
  <? }?>
</ul>
</div>
<div id="colunasBlogs">
  <h1 class="cabecalho">
    <span>Colunas e Blogs</span>
    <a href="/caderno/colunistas">Ir para Colunas e Blogs</a>
  </h1>
  <? foreach ($vColunistas AS $key => $value){?>
  <div class="destaque2 <?=$value->parent?> bg">
	<p class="foto">
	  <a href="<?=$value->alias?>">
		<img src="<?= base_path().drupal_get_path('theme', 'leiaja').'/images/foto-coluna-'.$value->tid.'.jpg'?>" alt="<?=$value->title?>" />
	  </a>
	</p>
	<h1><?=$value->coluna;?></h1>
	<p class="titulo">
	  <a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid));?>"><?=$value->title?></a>
	</p>
  </div>
  <? }?>
</div>
<div id="multimidia">
  <h1 class="cabecalho2">
	<span>Multim&iacute;dia</span>
	<a href="/caderno/multimidia">Ir para Multim&iacute;dia</a>
  </h1>
    <div class="galeria">
      <div id="galerialista">
          <? echo "<table class='table lista' cellpadding=0 cellspacing=0><tr>";
      foreach($vGaleria AS $key => $value){
        echo "<td><a href='".url(drupal_lookup_path('alias',"node/".$value->nid))."'><img src='".image_style_url('home_thumb', $value->uri)."' /></a></td>";
        echo (($key+1)%3 == 0) ? '</tr><tr>' : '';
      }
       echo '</tr></table>'?>
      </div>
    </div>
</div>