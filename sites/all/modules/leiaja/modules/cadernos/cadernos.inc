<?php

require_once DRUPAL_ROOT.'/'.drupal_get_path('theme', 'leiaja') .'/template.db.inc';
require_once DRUPAL_ROOT.'/'.drupal_get_path('theme', 'leiaja') .'/template.api.inc';
module_load_include('inc', 'paginas', 'paginas.db');
/**
 * Callback para a capa do caderno de Colunistas.
 *
 * @link /colunistas
 * @return type
 */
function page_colunistas2()
{
  global $theme_key;

  $vRetorno = '';
  $vCacheId = 'cadernoColunistas'.$theme_key;

  $vars['corCategoria'] = array( 'noticias' => 'vermelho',
                                  'carreiras' => 'roxo',
                                  'esportes' => 'verde',
                                  'tecnologia' => 'azulClaro',
                                  'cultura' => 'laranja',
                                  'multimidia' => 'azulClaro');

  $cache = cache_get($vCacheId, 'cache');

  if(!$cache){

    ## CAPA - Caderno COLUNISTAS/Blogs.
    $vars['vBlogsParceiros'] = db_getBlogsParceiros();
    $vars['vColunistas']     = db_getColunistaUltimas(100);
    $vars['vBlogsRedacao']   = db_getColunistaUltimas(100, array('pType'=>'blogs_da_redacao'));

    $query = new EntityFieldQuery;

    $tids = $query
      ->entityCondition('entity_type', 'taxonomy_term')
      ->propertyCondition('vid', 13)
      ->fieldCondition('field_espexibir', 'value', '1', '=')
      ->propertyOrderBy('weight')
      ->execute();
    $vars['vEspeciais'] = taxonomy_term_load_multiple(array_keys($tids["taxonomy_term"]));
    $vars['vTotalCol']  = db_getCountTerm();

    $vRetorno = theme('colunistas', $vars);

    cache_set($vCacheId, $vRetorno, 'cache', time() + 60*60);

   }else{
    $vRetorno = $cache->data;
  }

  // Adiciona Meta Refresh na home;
  $vMetaRefresh = array(
    '#tag' => 'meta',
    '#attributes' => array(
    'http-equiv' => 'refresh',
    'content' => '180'
    ),
  );

  drupal_add_html_head($vMetaRefresh, 'meta-refresh');

  return $vRetorno;
}