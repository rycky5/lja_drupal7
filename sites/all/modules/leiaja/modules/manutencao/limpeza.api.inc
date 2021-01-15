<?php
/*
 *  Arquivo onde estão localizadas funções de apoio ao negócio (helpers)
 *
 *  @package    Manutencao
 *  @subpackage Limpeza
 *  @author     Thiago Galvão Soares (galvao@sereducacional.com)
 */

module_load_include('inc','manutencao','limpeza.db');


/**
 * Inicia a Batch para excluir os nodes antigos.
 *
 */
function api_batch_limpeza()
{
  set_time_limit(0);

  $vNodesAntigo = db_getNodeAntigos();

  foreach ($vNodesAntigo as $key => $node) {
    //$operations[] = array('api_excuirNode', array($node->nid));
    $operations[] = array('node_delete', array($node->nid));
  }

  $batch = array(
    'title' => t('Limpando notícias antigas...'),
    'operations' => $operations,
    'init_message' => 'Iniciando...',
    'progress_message' => 'Processando @current de @total.',
    'error_message' => t('Um erro ocorreu durante o processamento'),
    'finished' => 'api_batch_limpeza_finished',
    'file' => drupal_get_path('module', 'manutencao') . '/limpeza.inc');

  batch_set($batch);
  batch_process('admin/manutencao/batchReport');
}

/**
 * Função chamada ao término da execução da batch de Limpeza.
 *
 */
function api_batch_limpeza_finished($success, $results, $operations)
{
  // The 'success' parameter means no fatal PHP errors were detected. All
  // other error management should be handled using 'results'.
  if ($success){
    $message = format_plural(count($results), 'Uma noticia apagada.', '@count noticias apagadas.');
  }else{
    $message = t('Finalizado com erros.');
  }

  drupal_set_message($message);
  $items = array();

  foreach ($results as $result) {
    $items[] = t('Apagando notícia %title.', array('%title' => $result));
  }

  $_SESSION['my_batch_results'] = $items;
}

/**
 * Exclui um node a partir do NID.
 *
 * @param type $pNid
 */
function api_excuirNode($pNid)
{
  return true;
}

