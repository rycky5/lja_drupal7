<?php
//Tpl do bloco Últimas Notícias dos cadernos - Gerado por views
//nome da view:
$nameView = "ultimas_noticias";
//displayName da view:
$displayName = 'cadernos';
//array de cadernos
$cadernos  =  array('noticias', 'politica','carreiras','esportes','cultura','tecnologia','multimidia');
//pegando o caderno que é passado pela url
$url = arg(0);
//setando o caderno a qual os nodes devem ser retornados;
$caderno = "caderno_".(in_array($url, $cadernos)?$url:"noticias");
//setando a view;
$view = views_get_view($nameView);
//setando o caderno a ser retornado
$view->display[$displayName]->display_options["arguments"]["type"]["default_argument_options"]["argument"]=$caderno;
//setando o display a ser executado;
$view->set_display($displayName);
$view->pre_execute();
$view->execute();
//setando o resultado da consulta em uma variavel;
$nodes = $view->result;
?>
<div class="ultimasCaderno margin-bottom15">
  <h3><a class="cinza" title="Últimas Notícias" href="http://www1.leiaja.com/ultimas/<?= $url ?>">Últimas Notícias</a></h3>
  <ul class="ultimas ultimasHome">
    <? foreach($nodes as $not): ?>      
      <li><span>&raquo;</span><a title="<?= $not->node_title ?>" href="<?= url(drupal_lookup_path('alias', 'node/'.$not->nid), array('absolute'=> true)); ?>"><strong><?= format_date($not->node_created,'hora') ?></strong> - <?= $not->node_title ?></a></li>
    <? endforeach; ?>
  </ul>
</div>