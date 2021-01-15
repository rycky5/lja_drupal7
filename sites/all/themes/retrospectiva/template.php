<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja').'/template.db.inc';
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja').'/template.api.inc';
/**
 * Override or insert variables into the page template.
 */
function retrospectiva_preprocess_page(&$vars) {
  drupal_add_css(drupal_get_path('module', 'retrospectiva') . '/css/estilo.css');  
  drupal_set_title('Especial Retrospectiva 2011');
  
  if(arg(0) == 'especial' && arg(1) == 'retrospectiva' && arg(2) === null){
    /*
    $vParams = array('pQtd' => 1, 'pDestaque' => true, 'pPromovido' => true, 'pSubcategoria' => 'retrospectiva');
    $vars['vDestaque'] = getConteudo("'especial'", $vParams);
     */
    $vParams = array('pQtd' => 1);
    $vars['vDestaque'] = getConteudo("'caderno_multimidia'", $vParams);

    /*
    $vParams = array('pQtd' => 5, 'pDestaque' => true, 'pIgnore' => "{$vars['vDestaque'][0]->nid}", 'pSubcategoria' => 'retrospectiva');
    $vars['vLateral'] = getConteudo("'especial'", $vParams);
     */
    $vParams = array('pQtd' => 5,'pIgnore' => "{$vars['vDestaque'][0]->nid}");
    $vars['vLateral'] = getConteudo("'caderno_multimidia'", $vParams);
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
    $vParams['pSubcategoria'] = 'retrospectiva';
    $vParams['pIgnore'] = $nidsIgnore;
    /*
    $vars['vLista'] = getConteudo("'especial'", $vParams);    
    $pParams['caderno'] = "'especial'";
     */
    $vars['vLista'] = getConteudo("'caderno_multimidia'", $vParams);    
    $pParams['caderno'] = "'caderno_multimidia'";
    $pParams['noTag'] = false;
    $pParams['pQtdPagina'] = '10';
    $vUrl = 'especial/retrospectiva';
    $vars['vPaginacao'] = paginacao(getNodeCountByTerm(19313, $pParams),$vUrl, $pParams);
  }
}

function retrospectiva_preprocess_block(&$vars){
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