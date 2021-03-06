<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja').'/template.db.inc';
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja').'/template.api.inc';
/**
 * Override or insert variables into the page template.
 */
function espparques_preprocess_page(&$vars) {
  drupal_add_css(drupal_get_path('module', 'espparques') . '/css/estilo.css');  
  drupal_set_title('Especial Parques da Cidade');
  
  $vParams = array('pQtd' => 1, 'pDestaque' => true, 'pPromovido' => true, 'pSubcategoria' => 'parques');
  $vars['vDestaque'] = getConteudo("'especial'", $vParams);

  $vParams = array('pQtd' => 5, 'pDestaque' => true, 'pIgnore' => "{$vars['vDestaque'][0]->nid}", 'pSubcategoria' => 'parques');
  $vars['vLateral'] = getConteudo("'especial'", $vParams);
  $nidsIgnore = $vParams['pIgnore'].",".getIgnoreNid($vars['vLateral']);

  $vParams = array('pQtd' => 4);
  if(!empty($_GET['page'])){
    $vQtdPrimeiraPagina = 4;
    $vQtdDemaisPagina   = 10;

    if($_GET['page'] == 1){
      $vInicio = 0;
      $vLimit  = $vQtdPrimeiraPagina;
    }else{
      $vInicio = ((($_GET['page']-1)*$vQtdDemaisPagina)-($vQtdDemaisPagina-($vQtdPrimeiraPagina+1)));
      $vLimit    = $vQtdDemaisPagina;
    }
    $vParams = array('pQtd' => "$vInicio,$vLimit");
  }
  $vParams['pNoPage'] = true;
  $vParams['pSubcategoria'] = 'parques';
  $vParams['pIgnore'] = $nidsIgnore;
  $vars['vLista'] = getConteudo("'especial'", $vParams);    
  $pParams['caderno'] = "'especial'";
  $pParams['noTag'] = false;
  $pParams['pQtdPagina'] = '10';
  $vUrl = 'especial/parques';
  $vars['vPaginacao'] = paginacao(getNodeCountByTerm(14386, $pParams),$vUrl, $pParams);
}

function espparques_preprocess_block(&$vars){
  switch($vars['block']->delta){
    case '41':
    ## CAPA - Caderno MULTIMIDIA.
        $vars['theme_hook_suggestions'][] = 'block__block__41';
  	$vParams = array('pQtd' => 1, 'pDestaque' => true, 'pPromovido' => true);
  	$vars['vDestaqueTopo'] = getConteudo("'caderno_multimidia'", $vParams);
  	     
  	$vParams = array('pQtd' => 4, 'pPromovido' => true, 'pSubcategoria' => 'Fotos');
  	$vars['vGaleriasTopo'] = getConteudo("'caderno_multimidia'", $vParams);     

  	$vParams = array('pQtd' => 1, 'pPromovido' => true, 'pSubcategoria' => 'Podcasts');
  	$vars['vPodcast'] = getConteudo("'caderno_multimidia'", $vParams);     
  	
  	$vParams = array('pQtd' => 3, 'pPromovido' => true, 'pSubcategoria' => 'Vídeos');
  	$vars['vVideos'] = getConteudo("'caderno_multimidia'", $vParams);     
  	
  	$vParams = array('pQtd' => 3, 'pPromovido' => true, 'pSubcategoria' => 'Infográficos');
  	$vars['vInfograficos'] = getConteudo("'caderno_multimidia'", $vParams);
  	     
  	$vParams = array('pQtd' => 3, 'pPromovido' => true, 'pSubcategoria' => 'TV Leia Já');
  	$vars['vTvLeiaja'] = getConteudo("'caderno_multimidia'", $vParams);
    break;
    default:
    break;
  }
}