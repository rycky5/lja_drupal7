<?php
/**
 * Arquivo que conterá a persistência a base
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */

// Includes necessários
module_load_include('inc', 'blocosespeciais', 'blocosespeciais.api');

/**
 *
 * @param type $arrDadosCapa 
 */
function db_salvar_capa_ig($arrDadosCapa, $arrDadosNodeCapa){
  
  try {
    
    // Desabilitado a capa antiga
    db_update("historico_capa")
            ->fields(array("status"=>0))
            ->condition("tipo_capa", $arrDadosCapa["tipo_capa"])
            ->condition("tipo_bloco", $arrDadosCapa["tipo_bloco"])
            ->execute();
    
    // Inserindo a capa na base
    $intIdCapa = db_insert("historico_capa")->fields($arrDadosCapa)->execute();
    
    foreach($arrDadosNodeCapa as $arrDados){
      // Inserindo as node da capa na base
      db_insert("historico_capa_node")
      ->fields(array("capa_id"=>$intIdCapa,
                   "nid"=>(int)$arrDados["nid"],
                   "posicao"=>(int)$arrDados["posicao"],
                   "origem"=>$arrDados["origem"]))->execute();
      
    }
  } catch (Exception $exc) {    throw new Exception($exc->getMessage());    }

}


function db_getCapaAtiva($intIdCapa = 1, $tipo_bloco){
  
  try {
    // Criand a query que ira retornar a capa ativa
    $arrObjCapaNode = db_query("SELECT
                            c.id,
                            cn.nid,
                            cn.posicao,
                            cn.origem
                          FROM
                            historico_capa c
                          INNER JOIN
                            historico_capa_node cn ON c.id = cn.capa_id
                          WHERE
                            c.status = 1 AND
                            c.tipo_capa = {$intIdCapa} AND
                            c.tipo_bloco = '{$tipo_bloco}'
                          ORDER BY
                            cn.posicao")->fetchAll();
    
    // Retornando o objeto com as nodes da capa ativa
    return $arrObjCapaNode;
  } catch (Exception $exc) {}
}
/**
 * Query com as ultimas notícias do portal com sincronização com o ig.
 *
 * @param type $pCaderno  Nome do caderno a ser carregado as últimas notícias.
 * @return type
 */
function db_noticiasPorCaderno($pCaderno = false)
{
  
 $vQuery = "SELECT
                  'default' as origem,
                  n.nid,
                  n.title,
                  cc.field_chamada_capa_value as chamada_capa,
                  date_format(FROM_UNIXTIME(n.created),'%d/%m %H:%i') AS datahora,
                  if(fm.uri IS NULL, f.uri, fm.uri) as uri
             FROM `node` AS n
             LEFT JOIN field_data_field_image as img ON n.nid = img.entity_id
             LEFT JOIN file_managed as f ON f.fid = img.field_image_fid
             LEFT JOIN field_data_field_capa as fc ON fc.entity_id = n.nid
             LEFT JOIN file_managed as fm ON fm.fid = fc.field_capa_fid
             LEFT JOIN field_data_field_chamada_capa as cc ON cc.entity_id = n.nid

             WHERE n.status=1";

  // Caso seja passado o caderno
  if($pCaderno)
    $vQuery .= " AND n.type = :strcaderno";

  $vQuery .= " GROUP BY n.nid ORDER BY n.created DESC LIMIT 100";
  try {
    // Setando o banco default
    db_set_active("default");
    $result = db_query($vQuery, array("strcaderno"=>$pCaderno));
  } catch (Exception $exc) {
  }

  return $result->fetchAll();
}



/**
 * Query que consulta as nodes que não estejam no leiajá
 *
 * @param string $strCaderno
 * @return ArrayObject Node
 */
function db_noticiasPorBlogs($strCaderno)
{
  $arrObjNode = array();

  try {
      // Setando o banco conforme chave passada
     db_set_active($strCaderno);
     $objQuery = db_select("node", "n");
     $objQuery->fields("n", array("nid", "title"));
     $objQuery->fields("fcc", array("field_chamada_capa_value"));
     $objQuery->leftJoin("field_data_field_chamada_capa",     "fcc",    "fcc.entity_id = n.nid");
     $objQuery->leftJoin("field_data_field_image",            "img",  "n.nid = img.entity_id");
     $objQuery->leftJoin("file_managed",                      "f",    "f.fid = img.field_image_fid");
     $objQuery->leftJoin("field_data_field_image_capa",       "fc",   "fc.entity_id = n.nid");
     $objQuery->leftJoin("file_managed",                      "fm",   "fm.fid = fc.field_image_capa_fid");
     $objQuery->addExpression("if(fm.uri IS NULL,f.uri,fm.uri)", "uri");
     $objQuery->addExpression("date_format(FROM_UNIXTIME(n.created),'%d/%m %H:%i')", 'datahora');
     $objQuery->addExpression("'" . $strCaderno . "'", 'origem');
     $objQuery->condition("n.status", 1 , "=");
     $objQuery->orderBy("n.created", "desc");

     // Execultando a consulta
     $arrObjNode = $objQuery->execute()->fetchAll();

     // Setando o banco default
     db_set_active("default");
  } catch (Exception $exc) {
    echo $exc->getMessage();die;
  }

  return $arrObjNode;
}


/**
 * Carrega informações do node para preview na montagem da capa.
 *
 */
function db_ajax_carreganode(array $arrDados)
{
  // Recuperando o NId
  $intNId = (int) $arrDados["intNId"];
  $vOrigem = $arrDados["strOrigem"];
  
  // caso o nid
  if(is_numeric($intNId)){
    // Caso o valor da origem não seja do leiaja
    if($vOrigem != "default"){
      // Objeto Node servidor
     $objNode = getNodeServidor($arrDados);
    }else{
      // Lendo a node na base
      $objNode = node_load($intNId);
    }
    // retornando o objeto node
    return $objNode;
  }else{// Caso o nid seja falso
    return false;
  }
}

/**
 * Método que ira trazer as ultimas galerias do portal
 * 
 * @return ArrayObject $arrObjNode
 */
function db_getGaleriasPortal($intInicio = 0, $intFim = 5){
  try {
    // Casts Necessários
    $intInicio = (int) $intInicio;
    $intFim = (int) $intFim;
    
      $arrRetorno = db_query("SELECT
                                n.nid
                            FROM
                              node as n
                            
                          WHERE
                             n.status = 1 AND (SELECT
                                                      count(img.field_image_fid) as qtd
                                                    FROM field_data_field_image as img
                                                    WHERE  n.nid = img.entity_id
                                                    group by
                                                            img.entity_id) > 1
                            AND n.status = 1 AND n.nid not in (SELECT
                                                  cn.nid
                                                FROM
                                                  historico_capa c
                                                INNER JOIN
                                                  historico_capa_node cn ON c.id = cn.capa_id
                                                WHERE
                                                  c.status = 1
                                                ORDER BY
                                                  cn.posicao)
                            ORDER BY
                              n.created DESC
                              
                            LIMIT {$intInicio}, {$intFim}")->fetchAllKeyed();
      
      $arrObjNode = node_load_multiple(array_keys($arrRetorno));          
     // retornando a query
     return $arrObjNode;
  } catch (Exception $exc) { }
}


/**
 * Método que irá retornar a ultima notícia add na lista que equipara a ultima atualização
 * 
 * @param array $addDados 
 */
function db_getUltimaAtualizacao($intQId){
  
  try {
    // Criand a query que ira retornar a capa ativa
    $objData = db_query("SELECT 
                                data_cadastro 
                              FROM 
                                  historico_capa c
                              WHERE
                                c.status = 1 AND
                                c.tipo_capa = {$intQId}")->fetch();
    
    return $objData->data_cadastro;
  } catch (Exception $exc) {  }

}


function db_getLista($intQId = 5){
  try {
    
    $strQuery = "SELECT nid FROM `leiaja`.`ig_nodequeue_nodes` where qid = {$intQId};";
    
    return db_query($strQuery)->fetchAll();
    
  } catch (Exception $exc) {  }
}