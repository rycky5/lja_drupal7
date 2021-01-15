<?php
/**
 * Arquiovo que conterá os hooks do thema multimídia
 * 
 * @author Alberto Medeiros
 * 
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja').'/template.api.inc';
// Includes necessários
require_once drupal_get_path('theme', 'leiaja').'/template.db.inc';
require_once drupal_get_path('theme', 'leiaja').'/template.api.inc';

/**
 * Método que será execultado pre html
 * @param  $vars
 */
function multimidia_preprocess_html(&$vars)
{
  $vars["strScript"] = "<!-- /* CODIGO QUE DEVE SER INCLUIDO LOGO APOS A TAG <BODY> */ -->
                <script language='javascript'>
                OAS_VARS('/multimidia', 'Middle,Middle1,Middle2,Right,Top,Top2,x06,x07,x30');
                OAS_START();
                </script>";
  
  #includes dos arquivos necessários
  drupal_add_css(drupal_get_path('theme', 'multimidia').'/css/multimedia.css');
  drupal_add_css(drupal_get_path('theme', 'multimidia').'/css/estilo.css');
  drupal_add_css(drupal_get_path('theme', 'multimidia').'/css/grid.css');
  drupal_add_js(drupal_get_path('theme', 'multimidia').'/js/layout.js');
  drupal_add_js(drupal_get_path('theme', 'multimidia').'/js/script.js');
  drupal_add_js(drupal_get_path('theme', 'multimidia').'/js/utils.js');
//  drupal_add_js(drupal_get_path('module', 'capa') . '/js/abas.js');
  
  
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
    $vMetaImagem = '';
    $vMetaTitle = '';
    $vMetaDescription = '';
    $vMetaRefresh = '';
    $vMetaImagem = array(
      '#tag' => 'meta', 
      '#attributes' => array(
        'property' => 'og:image',
        'content' => url('http://agendarecife.leiaja.com/sites/agendarecife.leiaja.com/themes/agenda_recife/images/imgLogoDireita.png',array('absolute' => true)),
      )
    );
    drupal_add_html_head($vMetaImagem, 'meta_image');
    $vMetaTitle = array(
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'og:title',
        'content' =>  'Multimídia - LeiaJá'
      )
    );
    drupal_add_html_head($vMetaTitle, 'meta_title');
    $vMetaDescription = array(
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'og:description',
        'content' =>  'Especial multimídia com a agenda com os principais desafios que o próximo prefeito da cidade do Recife vai enfrentar, segundo a opinião do eleitor.'
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
 * Método que será execultado pre html
 * @param  $vars
 */
//function multimidia_preprocess_page(&$vars)
//{
////  $vars['main_menu'] = menu_main_menu();
////  init_menu($vars);
////  if(sizeof(arg())==1 && arg(0)=="multimidia"):
////    if(variable_get('capa_multimidia')!=1):
//////      $vars['theme_hook_suggestions'][] = 'multimidia__page__2';
////      //$vars['theme_hook_suggestions'][] = 'multimidia__page__'.variable_get('capa_multimidia');    
////    endif;
////  endif;
////  
////  echo "<pre>";
////  var_dump($vars);
////  die;
////  $vars['theme_hook_suggestions'][] = 'multimidia--page--2';
////  $vars['theme_hook_suggestions'][] = 'multimidia__page__'.variable_get('capa_multimidia');
////  Carrega e popula variáveis para montar Menu principal.
////  init_menu($vars);
////  exit();
////  $url = arg(1)."/".arg(2);
////  switch ($url) {
////    case "term/26":
////      $vars['theme_hook_suggestions'][] = 'multimidia__page__videos';
////      break;
////    case "imagens/":
////      $vars['theme_hook_suggestions'][] = 'multimidia__page__imagens';
////      break;
////
////    default:
////      $vars['theme_hook_suggestions'][] = 'multimidia__page__'.variable_get('capa_multimidia');
////      break;
////    }
//}
function multimidia_preprocess_page(&$vars)
{
  init_menu($vars);
  
   // Verifica se é exibição de um Node e carrega bradcrumb.
   if(!empty($vars['node']->nid)){
      // Recuperando a node
      $node = $vars['node'];
      
      // Caso a notícia esteja sendo exibida em modo full = interna e o campo redireciona esteja setado
      if(!empty ($node->field_redireciona['und'][0]['value'])){
          
        die("oi");
          // Atualizando os views das notícias
          api_atualizarViewNode($node->nid);

          // Redireciono a notícia para o link setado no campo redireciona
          header('Location: ' . $node->field_redireciona['und'][0]['value']);
      }
   }
}

?>