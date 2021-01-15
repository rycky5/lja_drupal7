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
if($content){
   echo render($content);
}
?>
<div id="noticias">
  <h1 class="<?=@$name;?> bg"><?=@ucfirst($name);?></h1>
  <? 
  if($vNoticiasScroll){
    foreach($vNoticiasScroll AS $key => $value){
  ?>
      <div class="<?=($count == 0)? 'destaque1 '.$name : 'destaque2 '.$name;?>">
	<p class="foto"><a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid));?>"><img alt="<?=$value->title?>" src="<?= image_style_url('home_thumb', $value->uri); ?>" alt="<?=$vCapa[3]->title;?>"></a></p>
        <h1><?=$value->subcategoria;?></h1>
	<p class="titulo">
	  <a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid));?>">
	    <?=$value->title?>
	  </a>
	</p>
      </div>
  <? 
      $count ++;
    }
  }
  $count = 0;
  ?>
  <? 
  if($vNoticiasSemFoto){
    foreach($vNoticiasSemFoto AS $key => $value){?>
      <div class="<?=($count == 0)? 'destaques '.$name : 'destaquesmini  '.$name;?>">
	<h1><?=$value->subcategoria;?></h1>
	<p class="titulo">
	<a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid));?>">
	  <?=$value->title?>
	</a>
	</p>
      </div>
  <? 
    $count++;
    }
  }
  ?>
</div>
<?if($vUltimas){?>
<div id="ultimasNoticias">
  <h1 class="cabecalho">
	<span>Últimas Notícias</span>
	<a href="http://www1.leiaja.com/ultimas">Ir para Últimas Notícias</a>
  </h1>
  <ul class="ul">
	<? foreach($vUltimas AS $key => $value){?>
	  <li class="<?=$name;?>">
		<a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid));?>">
		  <?= $value->hora?> - <?=$value->title?>
		</a>
	  </li>
	<? }?>
  </ul>
</div>
<?}?>