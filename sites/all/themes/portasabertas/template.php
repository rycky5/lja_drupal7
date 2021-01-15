<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja').'/template.db.inc';
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja').'/template.api.inc';
/**
 * Override or insert variables into the page template.
 */
function portasabertas_preprocess_page(&$vars) {
  drupal_add_css(drupal_get_path('module', 'portasabertas') . '/css/estilo.css');  
  drupal_set_title('Especial Portas Abertas');
  
  if(arg(0) == 'especial' && arg(1) == 'portasabertas' && arg(2) === null){
    //$vParams = array('pQtd' => 1, 'pDestaque' => true, 'pPromovido' => true, 'pSubcategoria' => 'portasabertas');
    //$vars['vDestaque'] = getConteudo("'especial'", $vParams);
    /*$vParams = array('pQtd' => 1, 'pDestaque' => true, 'pPromovido' => true);
    $vars['vDestaque'] = getConteudo("'caderno_multimidia'", $vParams);

    //$vParams = array('pQtd' => 5, 'pDestaque' => true, 'pIgnore' => "{$vars['vDestaque'][0]->nid}", 'pSubcategoria' => 'portasabertas');
    //$vars['vLateral'] = getConteudo("'especial'", $vParams);
    $vParams = array('pQtd' => 5, 'pDestaque' => true, 'pIgnore' => "{$vars['vDestaque'][0]->nid}");
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
    }*/
    $vParams['pNoPage'] = true;
    $vParams['pQtd'] = 12;
    $vParams['pSubcategoria'] = 'portasabertas';
    //$vParams['pSubcategoria'] = 'portasabertas';
    //$vParams['pIgnore'] = $nidsIgnore;
    $vars['vLista'] = getConteudo("'especial'", $vParams);    
    //$pParams['caderno'] = "'caderno_multimidia'";
    //$vars['vLista'] = getConteudo("'especial'", $vParams);    
    //$pParams['caderno'] = "'especial'";
    //$pParams['noTag'] = false;
    //$pParams['pQtdPagina'] = '10';
    //$vUrl = 'especial/portasabertas';
    //$vars['vPaginacao'] = paginacao(getNodeCountByTerm(14386, $pParams),$vUrl, $pParams);
  }
}
