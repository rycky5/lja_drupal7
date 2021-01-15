<?php
// incluindo o arquivo de banco do thema leiajá
require_once($_SERVER['DOCUMENT_ROOT'].'/' . drupal_get_path('theme', 'leiaja') .'/template.php');

function exibe_ultimas()
{
  $pParams = array();
  $pParams['caderno'] = "'caderno_noticias','caderno_politica','caderno_cultura','caderno_esportes','caderno_carreiras','caderno_tecnologia','caderno_multimidia'";
  $vUrl = 'ultimas';
  $caderno = arg(1);
  if(!empty($caderno) && varIsCaderno($caderno)){
  $vUrl = drupal_lookup_path('alias', arg(0).'/'.$caderno);
    $pParams['caderno'] = "'".$caderno."'";
    $vars['class'] = str_replace('caderno_', '', $pParams['caderno']);
  }
  $pParams['pQtd'] = 20;
  if(!empty($_GET['page']) && $_GET['page'] <> 1){
    $pParams['pQtd'] = '20 OFFSET '. $_GET['page']*20;
  }

  $pParams['pQtdPagina'] = 20;
  $vars['vPaginacao'] = paginacao(getNodeCountByTerm('', $pParams),$vUrl, $pParams);
  $pParams['vTags'] = true;
  $vars['noticias'] = getConteudo($pParams['caderno'], $pParams);
  $output = theme('ultimas', $vars);

  return $output;
}