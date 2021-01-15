<?php 
//Arquivo para as interações com o banco de dados do módulo Widget

/**
 * Método que irá retornar os ultimos posts dos colunistas
 * 
 * @param int $limite
 * @return ArrayObject
 */
function getColunistasPagIG($limite = NULL){
  // Subquery Para pegar os TIDs dos colunistas
  $subQuery = db_select('taxonomy_index','ti');
  $subQuery->addExpression('MAX(ti.nid)','nid');
  $subQuery->addField('ti','tid','tid');
  $subQuery->addField('td','name','name');
  $subQuery->addField('td','parent','parent');
  $subQuery->innerJoin('taxonomy_term_data','td','td.tid = ti.tid AND td.vid = 10 AND ti.tid <> 36894');
  $subQuery->groupBy('ti.tid');

  // Query pra pegar os ultimos posts destes colunistas
  $result = db_select("node", 'n');
  $result->fields("n", array('nid','title','created'));
  $result->fields("col", array('name','tid','parent'));
  $result->innerJoin($subQuery,'col','n.nid = col.nid');
  if($limite != NULL){$result->range(0, $limite);}
  $result->orderBy('n.created', 'DESC');

  $result = $result->execute()->fetchAll();

  // Retornando o resultado
  return $result;
        
}

// Obtêm o último post de todos os colunistas do LeiaJa
function getBlogsRedacaoIG($limite = NULL){
    
$subQuery = db_select('taxonomy_index','ti');
    $subQuery->addExpression('MAX(ti.nid)','nid');
    $subQuery->addField('ti','tid','tid');
    $subQuery->addField('td','name','name');
    $subQuery->innerJoin('taxonomy_term_data','td','td.tid = ti.tid AND td.vid = 12');
    $subQuery->groupBy('ti.tid');

$result = db_select("node", 'n');
    $result->fields("n", array('nid','title','created'));
    $result->fields("col", array('name','tid'));
    $result->innerJoin($subQuery,'col','n.nid = col.nid');
    if($limite != NULL){$result->range(0, $limite);}
    $result->orderBy('n.created', 'DESC');
    $result = $result->execute()->fetchAll();
        
    return $result;
        
}

