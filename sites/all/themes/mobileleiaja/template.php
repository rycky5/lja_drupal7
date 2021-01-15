<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja').'/template.db.inc';
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja').'/template.api.inc';


function googleAnalyticsGetImageUrl() {
  // Copyright 2009 Google Inc. All Rights Reserved.
  $GA_ACCOUNT = "MO-24818943-1";
  $GA_PIXEL   = "/ga.php";
  
  $url = "";
  $url .= $GA_PIXEL . "?";
  $url .= "utmac=" . $GA_ACCOUNT;
  $url .= "&utmn=" . rand(0, 0x7fffffff);

  $referer = $_SERVER["HTTP_REFERER"];
  $query = $_SERVER["QUERY_STRING"];
  $path = $_SERVER["REQUEST_URI"];

  if (empty($referer)) {
    $referer = "-";
  }
  $url .= "&utmr=" . urlencode($referer);

  if (!empty($path)) {
    $url .= "&utmp=" . urlencode($path);
  }

  $url .= "&guid=ON";

  return str_replace("&", "&amp;", $url);
}

  
function mobileleiaja_preprocess_html(&$vars){
    $vars['classes_array'] = null;
}


// $Id: template.php,v 1.13 2011/04/04 08:00:00 dries Exp $
function mobileleiaja_preprocess_page(&$vars)
{
  if(strstr($_SERVER['REQUEST_URI'],'/multimidia/podcast') OR strstr($_SERVER['REQUEST_URI'],'/multimidia/')){
  	$vars['theme_hook_suggestions'][] = 'page';

  }elseif(arg(0) == 'taxonomy' && arg(1) == 'term' && (strstr($_SERVER['REQUEST_URI'],'/colunistas/') || strstr($_SERVER['REQUEST_URI'],'/blogs/'))){

	$vars['theme_hook_suggestions'][0] = 'page__blogs_redacao';
	//var_dump($vars['theme_hook_suggestions']);
	$vTid = arg(2);
	$vars['vInfoTerm']  = getColunistaInfo($vTid);
	$vUrl = drupal_lookup_path('alias', arg(0).'/'.arg(1).'/'.arg(2));
	$pParams = array('pQtd' => 3, 'tags' => true);

	$vars['vNodeTerm']    = getConteudobyTerm(arg(2), $pParams);

  }elseif(arg(0) == 'ultimas'){
    $vars['theme_hook_suggestions'][] = 'page';
  }
}

/*function mobileleiaja_preprocess_views_view(&$vars)
{
  if ($vars['name'] == 'frontpage'){
    getConteudoCapa('capa', $vars);
    usort($vars['vUltimas'], 'sortByUri');
    $vars['vCapa'] = $vars['vUltimas'];
    $arrTipos = "'caderno_noticias','caderno_carreiras','caderno_esportes','caderno_cultura','caderno_tecnologia'";
    $vars['vUltimas'] = getConteudo($arrTipos, array('pQtd' => 6));
    $vars['vColunistas'] = getColunistaUltimas(2);
    $vars['vVideo'] = getConteudoMultimidiaCapa(array('pQtd' => 1, 'pDias' => 15, 'pSubcategoria' => 'Fotos', 'pPromovido' => true));
    $vars['vGaleria'] = getConteudo("'caderno_multimidia'", array('pQtd' => 6, 'pSubcategoria' => 'Fotos'));

  }elseif($vars['name'] == 'multimidia'){
    $vars['content'] = getBlocos(array('20'));

  }elseif($vars['name'] == 'colunistas' OR $vars['name'] == 'blogs'){

    ## CAPA - Caderno COLUNISTAS/Blogs.
    $vars['theme_hook_suggestions'][] = 'views_view__blogs';
    $vars['vBlogsParceiros'] = getBlogsParceiros();
    $vars['vColunistas'] = getColunistaUltimas(100);
    $vars['vBlogsRedacao'] = getColunistaUltimas(100, array('pType'=>'blogs_da_redacao'));
    $vars['vTotalCol'] = getCountTerm();

  }elseif($vars['name'] == 'ultimas'){
    $arrTipos = "'caderno_noticias','caderno_carreiras','caderno_esportes','caderno_cultura','caderno_tecnologia'";
    $vars['vUltimas'] = getConteudo($arrTipos, array('pQtd' => 30));
  }else{
    $vars['theme_hook_suggestions'][] = 'views_view__caderno';
    $vars['vUltimas'] = getConteudo("'caderno_{$vars['name']}'", array('pQtd' => 4));

    $vParams = array('pQtd' => 4, 'pDestaque' => true, 'pPromovido' => true, 'pFotos' => true);
    $vars['vNoticiasScroll'] = getConteudo("'caderno_{$vars['name']}'", $vParams);

    $vParams3 = array('pQtd' => 4, 'pSemDestaque' => true, 'pSemFoto' => true);
    $vars['vNoticiasSemFoto'] = getConteudo("'caderno_{$vars['name']}'", $vParams3);

  }

}*/

function mobileleiaja_preprocess_block(&$vars){
  switch($vars['block']->delta){
    case '19':
      $vParams = array('pQtd' => 1, 'pSubcategoria' => 'Podcasts', 'pDestaque' => true);
      $vars['destaque'] = getConteudo("'caderno_multimidia'", $vParams);
      $vParams = array('pQtd' => 4, 'pSubcategoria' => 'Podcasts');
      $vars['lista'] = getConteudo("'caderno_multimidia'", $vParams);
    break;
    case '20':
      $vParams = array('pQtd' => 1, 'pSubcategoria' => 'Fotos', 'pDestaque' => true);
      $vars['destaque'] = getConteudo("'caderno_multimidia'", $vParams);
      $vParams = array('pQtd' => 8, 'pSubcategoria' => 'Fotos');
      $vars['lista'] = getConteudo("'caderno_multimidia'", $vParams);
    break;
    default:
    break;
  }
}

/**
 * Hook para NODE
 * @param Array $vars
 */
function mobileleiaja_preprocess_node(&$vars)
{
  $vars['classe'] =  str_replace('caderno_', '', $vars['node']->type);
  $arrTipos = array('caderno_noticias','caderno_carreiras','caderno_esportes','caderno_cultura','caderno_tecnologia'/*,'caderno_multimidia'*/);
  if(!empty($vars['node']->field_catcolunista[$vars['node']->language][0]["taxonomy_term"]->vid)){
  $col = getColunistaInfo($vars['node']->field_catcolunista[$vars['node']->language][0]["taxonomy_term"]->tid);
  $vars['classe'] =  str_replace('caderno_', '', $col->style);
  }elseif(!empty($vars['node']->field_catblog[$vars['node']->language][0]["taxonomy_term"]->vid)){
  $blog = getColunistaInfo($vars['node']->field_catblog[$vars['node']->language][0]["taxonomy_term"]->tid);
  $vars['classe'] = strtolower($blog->name);
  }
  //$vars['class'] = $vars['node'];//->field_catcolunista[$vars['node']->language][0]["taxonomy_term"]->tid;
  
// Verifica se é exibição de um node de conteúdo e carrega as tags e o bloco para recomendação de conteúdo (Leia Também).
  if(!$vars['is_front'] && empty($vars['view']->name) && in_array($vars['type'],$arrTipos) && arg(0) == 'node'){
    foreach($vars['node']->field_tags[$vars['node']->language] as $tax)
      $arrTax[] = $tax['taxonomy_term']->tid;

    $vLeiaTambem = '';
    if(!empty($arrTax))
      $vLeiaTambem = getRecomendacao($arrTax, $vars['node']->nid,5);

    $vHtmlLeiaTambem = '';
    if(!empty($vLeiaTambem)){
      $vHtmlLeiaTambem = '<div id="ultimasNoticias">
                            <h1 class="cabecalho"><span>Notícias relacionadas</span></h1>
                            <ul class="ul">';

      foreach($vLeiaTambem as $reco)
        $vHtmlLeiaTambem .= '<li class="'.str_replace('caderno_', '', $reco->caderno).'"><a href="'.url(drupal_lookup_path('alias',"node/".$reco->nid)).'" title="">'.$reco->title.'</a></li>';

      $vHtmlLeiaTambem .= '</ul></div>';
    }

    $vars['vLeiaTambem']     = $vLeiaTambem;
    $vars['vLeiaTambemHtml'] = $vHtmlLeiaTambem;
  };

}