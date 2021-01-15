<?php
/**
 * Arquivo que conterá a persistência do modulo de montagem de capa
 * 
 * @author Alberto Medeiros
 */

/**
 * Método que irá salvar as posições da capa na base
 * 
 * @param array $arrDadosCapa 
 */
function db_salvar_capa(array $arrDadosCapa){
  
  try {
    $intIdCapa = db_insert("tb_capa")
                ->fields($arrDadosCapa)
                ->execute();
    
    // Retornando o identificador da capa
    return $intIdCapa;
  } catch (Exception $exc) {
    throw new Exception($exc->getMessage());
  }
}

/**
 * Método que irá excluir a capa pelo seu identificador
 * 
 * @param string $strIdCapa 
 */
function db_excluir_capa($strIdCapa){
  // Dados para serem atualizados
  $arrDados = array();
  $arrDados["status"] = 0;
  try {
    $intIdCapa = db_update("tb_capa")
                ->fields($arrDados)
                ->condition('id_capa',$strIdCapa)
                ->execute();
    
  } catch (Exception $exc) {
    throw new Exception($exc->getMessage());
  }
}

/**
 * Método que irá salvar as posições dos blocos da capa
 * 
 * @param array $arrDadosPosicao
 * @return int $intIdPosicao 
 */
function db_salvar_posicao(array $arrDadosPosicao){
  try {
    $intIdCapa = db_insert("tb_capa_posicao")
                ->fields($arrDadosPosicao)
                ->execute();
    
    // Retornando o identificador da capa
    return $intIdCapa;
  } catch (Exception $exc) {
    throw new Exception($exc->getMessage());
  }
}

/**
 * Método que irá retornar um array de objetos dos blocos da capa
 * 
 * @param int $intCapa
 * @return ArrayObject 
 */
function db_listar_blocos_por_capa($intCapa){
  try {
    // Criando o objeto query
    $objQuery = db_select("tb_capa_posicao", "pc")
                ->fields("pc");
    $objQuery->innerJoin("tb_capa", "c", "pc.id_capa_posicao = c.id_capa AND status = 1");
    $objQuery->condition("c.capa", $intCapa)
            ->orderBy("posicao", "ASC");
    return $objQuery->execute()->fetchAll();
  } catch (Exception $exc) {
    throw new Exception($exc->getMessage());
  }
}

/**
 * Método que irá retornar todas as capas ativas que podem ser configuradas
 * 
 * @return ArrayObject 
 */
function db_get_capa(){
  try {
    $objQuery = db_select("tb_capa_id", "cpi")
              ->fields("cpi")
              ->condition("status", "1");
  
    // Execultando a query e retornando o resultado
    return $objQuery->execute()->fetchAll();
  } catch (Exception $exc) {  }
}


/**
 * Loads blocks' information from the database.
 *
 * @return
 *   An array of blocks grouped by region.
 */
function db_list_blocks() {

  $query = db_select('block', 'b');
  $result = $query
    ->fields('b')
//    ->condition('b.status', 1)
//    ->condition('b.module', "capa")
    ->orderBy('b.module')
    ->groupBy("b.delta")
    ->execute();

//echo "<pre>";
//var_dump($result->fetchAll());
//die;
  return $result->fetchAll();
}

/**
 * Método que irá retornar um o resultado com os nid's ativos na capa do leiaja
 * 
 * @param int $intCapa
 * @return ArrayObject 
 */
function db_getCapa(){
  try {
    // Criando o objeto query
    $query = 'SELECT t.nid FROM tbcapa as t where status = 1;';
    $obQuery = db_query($query);
    
    return $obQuery->fetchAll();
    
  } catch (Exception $exc) { }
}