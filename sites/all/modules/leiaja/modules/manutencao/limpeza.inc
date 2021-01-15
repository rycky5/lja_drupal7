<?php
/*
 *  Arquivo onde estão localizadas funções de CALLBACK do hook_menu().
 *
 *  @package    Manutencao
 *  @subpackage Limpeza
 *  @author     Thiago Galvão Soares (galvao@sereducacional.com)
 *
 */

module_load_include('inc','manutencao','limpeza.api');

/**
 * Call back para iniciar o batch de limpeza dos nodes antigos.
 *
 *
 * @link /admin/manutencao/limpeza
 *
 */
function page_limpeza()
{
  //Cria a batch para excluir os nodes.
  api_batch_limpeza();
}

/**
 * Página de resumo do processo de integração através da Batch.
 *
 * @link admin/ws/batchReport
 *
 */
function page_batchReport()
{
  $vars['itens'] = (isset($_SESSION['my_batch_results'])) ? $_SESSION['my_batch_results'] : array();
  unset($_SESSION['my_batch_results']);

  return theme('batchReport', $vars);
}