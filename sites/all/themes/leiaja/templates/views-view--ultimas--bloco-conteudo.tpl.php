<?php

/**
 * @file
 * Main view template.
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
 *
 * @ingroup views_templates
 */
// Recuperando o resultado da views
$noticias = $view->result;

module_load_include('inc', 'capa', 'capa.api');

// Método que irá corrígir as imagens de capa
$noticias = api_corrigeImageCapa($noticias);

?>
<ul class="listaResultado resultadoBusca">
<? 
  foreach ($noticias AS $key => $value): 
?>
  <?php
    if(!empty ($value->field_field_capa[0]["rendered"]["#item"]["uri"])){
  ?>
    <li class="ljhasimg">
      <img src="<?= image_style_url('home_cadernos', $value->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" height="143" width="191"  alt="<?=$value->node_title ?>" class="imgH6Grande" />
  <?
    } else {
  ?>
    <li>
  <?
    }

  ?>
  
  <h6><?= format_date($value->node_created, 'long');?></h6>
  <h4><a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid)); ?>"><?=$value->node_title;?></a></h4>
  <p>
    <a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid)); ?>">
      <?php echo str_replace("[@#galeria#@]", "", str_replace("[@#podcast#@]", "", str_replace("[@#video#@]", "", !empty($value->_field_data["nid"]["entity"]->body["pt-br"][0]["summary"])? $value->_field_data["nid"]["entity"]->body["pt-br"][0]["summary"] : truncate_utf8(strip_tags($value->_field_data["nid"]["entity"]->body["pt-br"][0]["value"]), '120', TRUE, TRUE)))); ?>
    </a>
  </p>
  <h5 class="fonte">
    Por <?= $value->_field_data["nid"]["entity"]->field_fonte["pt-br"][0]["value"]; ?>
  </h5>
  <div class="tagsExibir">
    <h5>Tags:</h5>
    <ul class="tags">
      <?foreach($value->field_field_tags AS $tKey => $tValue){
        ?>
        <li><a href="<?=url(drupal_lookup_path('alias',"taxonomy/term/".$tValue["rendered"]["#options"]["entity"]->tid));?>" title="<?=$tValue["rendered"]["#title"]?>"><?=$tValue["rendered"]["#title"]?></a></li>
      <?}?>
    </ul>
  </div>
</li>
<? endforeach; ?>
</ul>
<div class="divPaginacao">
  <?php print $pager; ?>
</div>