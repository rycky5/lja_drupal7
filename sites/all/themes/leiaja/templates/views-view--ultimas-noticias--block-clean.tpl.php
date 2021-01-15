<?php
$resultViews = views_get_view_result('ultimas_noticias', 'block_clean');
?>

<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/estilo.css"/>
<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/grid.css"/>

<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/box0019_4x8_1_iframe/css/box.css"/>

 
<div class="zbox hgd8 wgd4 box0019 ultimasNoticias iframeinterna">
    <h1><b>Últimas</b> <span>Notícias</span></h1>
  <ul class="ultimasNoticiasLista cinza">
    <? foreach ($resultViews as $value): ?>
      <li><a target="_parent" title="<?= $value->node_title ?>" href="<?= url(drupal_lookup_path('alias', 'node/'.$value->nid), array('absolute' => true)); ?>"><strong><?= date('G:i', $value->node_created) ?></strong> - <?= $value->node_title ?></a></li>
    <? endforeach; ?>
  </ul>
</div>




