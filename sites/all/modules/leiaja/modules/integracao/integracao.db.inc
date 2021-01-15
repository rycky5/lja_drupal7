<?php
/*
 *  Arquivo onde estão localizadas funções de recuperação e persistência de dados
 *  na base de dados.
 *
 *  @package    Integracao
 *  @subpackage Integracao
 *  @author     Thiago Galvão Soares (galvao@sereducacional.com)
 *
 */

/**
 * Salva na coluna customizada chamada 'hash' e criada na tabela node pelo
 * LeiaJá.
 *
 * @param Integer $pNid
 * @param String  $pOrigem
 *
 */
function atualizaNodeOrigem($pNid, $pOrigem)
{
  return db_update('node')
          ->fields(array('hash' => $pOrigem,))
          ->condition('nid', $pNid, '=')
          ->execute();
}

/**
 * Método que irá cadastrar o relacionamento entre a noticia de especial com a do leiaja
 * 
 * @param type $intNidLj
 * @param type $intNidSj 
 */
function db_inserirRelaciaoEspecial($intNidLj, $intNidSj){
  try {
    $objQuery = db_insert("tb_node_sinc");
    $objQuery->fields(array("nid_lj"=>$intNidLj, "nid_sj"=> $intNidSj));
    $objQuery->execute();
  } catch (Exception $exc) {
    throw new Exception($exc->getMessage());
  }
}

/**
 * Método que irá verificar se a notícia já está sinconizada com o leiaja
 * 
 * @param int $intNidSj
 * @return boolean 
 */
function db_existe_leiaja($intNidSj){
  $objSincronizacao = false;
  try {
    $objQuery = db_select("tb_node_sinc", "ns");
    $objQuery->fields("ns");
    return $objQuery->condition("nid_sj", $intNidSj)
             ->execute()->fetch();
  } catch (Exception $exc) {
    echo $exc->getTraceAsString();
  }

}