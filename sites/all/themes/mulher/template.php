<?php
require_once 'template.db.inc';

function mulher_preprocess_html(&$vars)
{
  if ($node = menu_get_object()) {
    if(!empty($node->field_imagecrop["und"][0]['uri'])){
      $vars['vMetaImagem'] = image_style_url('thumb_video_wide',$node->field_imagecrop["und"][0]['uri']);
    }else{
      $vars['vMetaImagem'] = 'http://static1.leiaja.com/sites/all/themes/leiaja/images/logocharts.png';
    }            
    $vars['vMetaTitulo'] = $node->title;
  }else{
    $vars['vMetaImagem'] = url('http://static1.leiaja.com/sites/all/themes/leiaja/images/logocharts.png');
    $vars['vMetaTitulo'] = $vars['head_title'];
  }
}
/**
 * Override or insert variables into the page template.
 */
function mulher_preprocess_page(&$vars) {
  //drupal_add_css(drupal_get_path('module', 'espmulher') . '/css/estilo.css');  
  //drupal_add_js(drupal_get_path('theme', 'leiaja') . '/js/jquery-1.6.2.js');  
  drupal_add_js(drupal_get_path('theme', 'leiaja') . '/js/script.js');  
  drupal_add_js(drupal_get_path('theme', 'leiaja') . '/js/carrossel.js');  
  
    drupal_set_title('Especial Da Mulher');
    //$caderno = "'caderno_multimidia'";
    //$subCaderno = null;
    $caderno = "'especial'";
    $subCaderno = 'mulher';
    $vars['theme_hook_suggestions'][] = 'page__front';
    $vParams = array('pQtd' => 5, 'pDestaque' => true, 'pPromovido' => true, 'pSubcategoria' => $subCaderno, 'pFotos' => true);
    $vars['vCarrossel'] = getConteudoMulher("$caderno", $vParams);
    $vParams = array('pQtd' => 6, 'pPromovido' => true, 'pIgnore' => getIgnoreNid($vars['vCarrossel']), 'pSubcategoria' => $subCaderno, 'pFotos' => true);
    $vars['vNoticias'] = getConteudoMulher("$caderno", $vParams);
    //$nidsIgnore = $vParams['pIgnore'].",".getIgnoreNid($vars['vLateral']);

    $vParams = array('pQtd' => 4);
}

function mulher_preprocess_block(&$vars){
  //exit;
  switch($vars['block']->delta){
    case '41':
    ## CAPA - Caderno MULTIMIDIA.
        $vars['theme_hook_suggestions'][] = 'block__block__41';
  	$vParams = array('pQtd' => 1, 'pDestaque' => true, 'pPromovido' => true);
  	$vars['vDestaqueTopo'] = getConteudoMulher("'caderno_multimidia'", $vParams);
  	     
  	$vParams = array('pQtd' => 4, 'pPromovido' => true, 'pSubcategoria' => 'Fotos');
  	$vars['vGaleriasTopo'] = getConteudoMulher("'caderno_multimidia'", $vParams);     

  	$vParams = array('pQtd' => 1, 'pPromovido' => true, 'pSubcategoria' => 'Podcasts');
  	$vars['vPodcast'] = getConteudoMulher("'caderno_multimidia'", $vParams);     
  	
  	$vParams = array('pQtd' => 3, 'pPromovido' => true, 'pSubcategoria' => 'Vídeos');
  	$vars['vVideos'] = getConteudoMulher("'caderno_multimidia'", $vParams);     
  	
  	$vParams = array('pQtd' => 3, 'pPromovido' => true, 'pSubcategoria' => 'Infográficos');
  	$vars['vInfograficos'] = getConteudoMulher("'caderno_multimidia'", $vParams);
  	     
  	$vParams = array('pQtd' => 3, 'pPromovido' => true, 'pSubcategoria' => 'TV Leia Já');
  	$vars['vTvLeiaja'] = getConteudoMulher("'caderno_multimidia'", $vParams);
    break;
    default:
    break;
  }
}

function mulher_preprocess_node(&$vars)
{
  
  if(!empty($vars['node']->field_subespecial["und"][0]["taxonomy_term"]->name) && $vars['node']->field_subespecial["und"][0]["taxonomy_term"]->name == 'Página'){
    //echo 'Página';
    $vars['theme_hook_suggestions'][] = 'node__pagina';
  }
  
  $vars['jornalista'] = false;
  if(!empty($vars['node']->field_fonte[$vars['node']->language][0]['value']) && !empty($vars['node']->uid)){
    $vars['jornalista'] = (semAcentos($vars['node']->field_fonte[$vars['node']->language][0]['value']) == 'leiaja' && getUserImprensa($vars['node']->uid))? 'true': 'false';
  }
}

