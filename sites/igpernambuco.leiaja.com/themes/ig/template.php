<?php
// includes necessários
require_once 'template.api.inc';


// Includes necessários
module_load_include('inc', 'montarcapa', 'montarcapa.api');

/**
 * Método que será execultado pre html
 * @param  $vars
 */
function ig_preprocess_html(&$vars)
{
//  drupal_add_css("/sites/all/modules/leiaja/modules/agenda_recife/css/jquery.mCustomScrollbar.css");
//  drupal_add_js("/sites/all/modules/leiaja/modules/agenda_recife/js/jquery.mousewheel.min.js");
//  drupal_add_js("/sites/all/modules/leiaja/modules/agenda_recife/js/jquery.mCustomScrollbar.js");
  
  drupal_add_css(drupal_get_path('theme', 'ig').'/css/estilo.css');
  drupal_add_css(drupal_get_path('theme', 'ig').'/css/grid.css');
  drupal_add_js(drupal_get_path('theme', 'ig').'/js/modal.js');
  
  
  // If on an individual node page, add the node type to body classes.
  if ($node = menu_get_object()) {
      if(!empty($node->field_capa['und'][0]['uri']))
        $vars['vMetaImagem'] = image_style_url('large', $node->field_capa["und"][0]['uri']);
      else if(!empty($node->field_image['und'][0]['uri']))
        $vars['vMetaImagem'] = image_style_url('large', $node->field_image["und"][0]['uri']);
      else if(!empty($node->field_imagem['und'][0]['uri']))
        $vars['vMetaImagem'] = image_style_url('large', $node->field_imagem["und"][0]['uri']);
      
      $vars['vMetaTitulo'] = $node->title;
      $vars['vMetaDescription'] = (!empty($node->body[$node->language][0]['summary'])) ? $node->body[$node->language][0]['summary'] : $node->title;
  }else{
    $vars['vMetaTitulo'] = "";
    $vMetaImagem = '';
    $vMetaTitle = '';
    $vMetaDescription = '';
    $vMetaRefresh = '';
    $vMetaImagem = array(
      '#tag' => 'meta', 
      '#attributes' => array(
        'property' => 'og:image',
        'content' => "http://i0.ig.com/barraiG/v2/logo_ig_canais.gif",
      )
    );
    drupal_add_html_head($vMetaImagem, 'meta_image');
    $vMetaTitle = array(
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'og:title',
        'content' =>  'IG Pernambuco | LeiaJá'
      )
    );
    
    drupal_add_html_head($vMetaTitle, 'meta_title');
    $vMetaDescription = array(
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'og:description',
        'content' =>  ''
      )
    );
    
    drupal_add_html_head($vMetaDescription, 'meta_description');
    $vMetaRefresh = array(
      '#tag' => 'meta',
      '#attributes' => array(
        'http-equiv' => 'refresh',
        'content' => '180'
      )
    );
    drupal_add_html_head($vMetaRefresh, 'meta-refresh');
  }
}


/**
 * Implementação do hook_preprocess_page.
 * Ações executadas antes do processamento da Page.
 *
 * @param Array $vars
 */
function ig_preprocess_page(&$vars)
{
  // Caso seja uma visualização de notícia para gerar estatico
  if(@$_GET["node"] == true && $_GET["estatico"] == true){
    $vars['theme_hook_suggestions'][0] = 'page__node'; 
  }
}

/**
 * Implementação do Hook processado antes da exibição do NODE.
 *
 * Aqui é realizada a consulta de sugestões de conteúdo baseado nas tags do node.
 *
 * @param Array $vars Váriaveis de escopo.
 */
function ig_preprocess_node(&$vars)
{
  $vars['jornalista'] = false;
  if(!empty($vars['node']->field_fonte[$vars['node']->language][0]['value']) && !empty($vars['node']->uid)){
    $vars['jornalista'] = (semAcentos($vars['node']->field_fonte[$vars['node']->language][0]['value']) == 'leiaja' && getUserImprensa($vars['node']->uid))? 'true': 'false';
  }
}


function getBrowser(){
  // Recuperando o user agente
  $useragent = $_SERVER['HTTP_USER_AGENT'];
 
  return api_getBrowser();
}