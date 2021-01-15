<?php
//Bloco que vai gerar as ultimas notícias por caderno - view ultimas noticias
$arg1 = (isset($_GET['c']) && !empty($_GET['c'])) ? $_GET['c'] : 'all';
$objArrUltimas = views_get_view_result('ultimas_noticias', 'cadernos', $arg1);
?>
<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/estilo.css"/>
<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/grid.css"/>
<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/box0019_4x8_1_iframe/css/box.css"/>

 
<div class="zbox hgd8 wgd4 box0019 ultimasNoticias iframeinterna" style="margin:0px;">
  <h1><b>Últimas</b> <span>Notícias</span></h1>
  <ul class="ultimasNoticiasLista cinza">
    <?php 
    foreach($objArrUltimas as $key => $ultimas): 
        if($key < 5):
    ?>      
        <li><a target="_parent" title="<?= $ultimas->node_title ?>" href="<?= url(drupal_lookup_path('alias', 'node/'.$ultimas->nid), array('absolute' => true)); ?>"><strong><?= format_date($ultimas->node_created,'hora') ?></strong> - <?= $ultimas->node_title ?></a></li>
    <?php 
        endif;
    endforeach; 
    ?>
  </ul>
</div>