

<?php
//Novo TPL para o novo blodo de "Últimas Notícias", criada com Views
?>


<?php
$resultViews = views_get_view_result('ultimas_noticias', 'block_1');
?>
<link rel="stylesheet" href="/sites/all/themes/leiaja/css/boxes/box0019_4x7_1_iframe/css/box.css"/>

 
<div class="hgd7 ultimasCaderno box0019" style="margin:0px;border:0px">
  <h3><a class="cinza" title="Últimas Notícias" href="http://www1.leiaja.com/ultimas">Últimas Notícias</a></h3>
  <ul class="ultimas ultimasHome">
    <? foreach ($resultViews as $value): ?>
      <li><span>&raquo;</span><a title="<?= $value->node_title ?>" href="<?= url(drupal_lookup_path('alias', 'node/'.$value->nid), array('absolute' => true)); ?>"><strong><?= date('G:i', $value->node_created) ?></strong> - <?= $value->node_title ?></a></li>
    <? endforeach; ?>
  </ul>
</div>


