<?php
/**
 * Arquivo que conterá as persistencias do módulo 
 * 
 * @author Thiago Galvão    <galvao@sereducacional.com>
 * @version 2.0
 */

/**
 * Recupera do banco os Nids para ser gerado arquivos estáticos.
 * 
 * @return type
 */
function db_getCron()
{
  try {

    $vSelect = db_select('estatica_cron','c')
               ->fields('c', array('Nid'))
               ->orderBy('Id', 'ASC')
               ->range(0,75);
      
    return $vSelect->execute()->fetchAll();
  } catch (Exception $exc) {
    watchdog('Node Estática', "[db_getCron] ".$exc->getMessage() . $exc->getTraceAsString(), null, WATCHDOG_ERROR); 
  }    
}

/**
 * Remove Nid da cron.
 * 
 * @return boolean
 */
function db_deleteCron($pNid)
{
  try 
  {
    db_delete("estatica_cron")->condition("nid", $pNid)->execute();
  } 
  catch (Exception $exc) 
  {    
    watchdog('Node Estática', "[db_deleteCron] ".$exc->getMessage() . $exc->getTraceAsString(), null, WATCHDOG_ERROR);
  } 
}

/*
 * Excluir Alias gerados para o /node/{id}.
 */
function db_excluirAlias($idNode) 
{
  $vQuery = db_delete('url_alias');
  $vQuery->condition('source', "node/$idNode", '=');

  return $vQuery->execute();
}

/*
 * Funcao para carregar todos os alias de um determinado node.
 */
function db_loadUrlAlias($idNode) 
{
  $vQuery = db_select('url_alias', 'u');
  $vQuery->addField('u', 'alias');
  $vQuery->condition('source', "node/$idNode", '=');

  return $vQuery->execute()->fetchAll();
}

/**
 * Incluir links na tabela das mais lidas.
 * 
 */
function db_addGetClicky($pTitulo, $pUrl, $pCont, $pTipo)
{
  try {
    $sqlQuery = db_insert('top_view_getclick');
    
    $sqlQuery->fields(array(
          'titulo' => $pTitulo,
          'url' => $pUrl,
          'visitas' => $pCont,
          'tipo' => $pTipo,
    ));
    
    return $sqlQuery->execute();
  } 
  catch (Exception $exc) 
  {    
    watchdog('Node Estática', "[db_addGetClicky] ".$exc->getMessage() . $exc->getTraceAsString(), null, WATCHDOG_ERROR);
  } 

}

/**
 * Limpa tabela com estatísticas GetClicky.
 * 
 */
function db_clearGetClicky()
{
  try {
    return db_query('truncate table top_view_getclick');
  } 
  catch (Exception $exc) 
  {    
    watchdog('Node Estática', "[db_clearGetClicky] ".$exc->getMessage() . $exc->getTraceAsString(), null, WATCHDOG_ERROR);
  } 

}