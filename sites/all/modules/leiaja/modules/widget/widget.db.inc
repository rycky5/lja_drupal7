<?php

//Arquivo para as interações com o banco de dados do módulo Widget
// Obtêm o último post de todos os colunistas do LeiaJa
function getColunistasPag($limite = NULL) {

  $subQuery = db_select('taxonomy_index', 'ti');
  $subQuery->addExpression('MAX(ti.nid)', 'nid');
  $subQuery->addField('ti', 'tid', 'tid');
  $subQuery->addField('td', 'name', 'name');
  $subQuery->addField('td', 'parent', 'parent');
  $subQuery->innerJoin('taxonomy_term_data', 'td', 'td.tid = ti.tid AND td.vid = 10');
  $subQuery->groupBy('ti.tid');

  $result = db_select("node", 'n');
  $result->fields("n", array('nid', 'title', 'created'));
  $result->fields("col", array('name', 'tid', 'parent'));
  $result->innerJoin($subQuery, 'col', 'n.nid = col.nid');
  if ($limite != NULL) {
    $result->range(0, $limite);
  }
  $result->orderBy('n.created', 'DESC');

  $result = $result->execute()->fetchAll();

  return $result;
}

function bd_getParentByTid($tid) {
  if (!empty($tid)) {
    $result = db_select("taxonomy_term_data", 't')
            ->fields("t", array('parent'))
            ->condition('vid', '10', '=')
            ->condition('tid', $tid, '=');


    $parent = $result->execute()->fetchColumn();
  } else {
    $parent = NULL;
  }
  return $parent;
}

// Obtêm o último post de todos os colunistas do LeiaJa
function getBlogsRedacao($limite = NULL) {

  $subQuery = db_select('taxonomy_index', 'ti');
  $subQuery->addExpression('MAX(ti.nid)', 'nid');
  $subQuery->addField('ti', 'tid', 'tid');
  $subQuery->addField('td', 'name', 'name');
  $subQuery->innerJoin('taxonomy_term_data', 'td', 'td.tid = ti.tid AND td.vid = 12');
  $subQuery->groupBy('ti.tid');

  $result = db_select("node", 'n');
  $result->fields("n", array('nid', 'title', 'created'));
  $result->fields("col", array('name', 'tid'));
  $result->innerJoin($subQuery, 'col', 'n.nid = col.nid');
  if ($limite != NULL) {
    $result->range(0, $limite);
  }
  $result->orderBy('n.created', 'DESC');
  $result = $result->execute()->fetchAll();

  return $result;
}

function db_getUltimasDinamico($arrParam){
    
    //Array com os cadernos do leiaja
    $arrCadernos = array(
        "caderno_esportes", 
        "caderno_carreiras", 
        "caderno_cultura", 
        "caderno_tecnologia", 
        "caderno_noticias", 
        "caderno_multimidia", 
        "caderno_colunistas", 
        "caderno_politica", 
        "blogs_da_redacao"
        );
    
    $query = db_select('node', 'n');
    
    $query->addField('n', 'nid');
    $query->condition('status', 1);
    //Verificando se o tipo do caderno esta vazio e se o valor existe no $arrCadernos
    if($arrParam['c'] && in_array($arrParam['c'], $arrCadernos)){
        //Tipo do caderno
        $query->condition('type', $arrParam['c']);
    }
    //Verificando se a noticias é promovida
    if($arrParam['p']){
        $query->condition('promote', 1);
    }
    //Verificando se a noticias eh destacada
    if($arrParam['d']){
        $query->condition('sticky', 1);
    }
    //Verificando a quantidade do retorno da query
    if($arrParam['qnt']){
        $query->range(0, $arrParam['qnt']);
    }else{
        $query->range(0, 5);
    }
    
    $query->orderBy('created', 'DESC');
    
    $result = $query->execute()->fetchAll();
    
    return $result;
            
    
}

//Verifica se um blog existe na tabela historico_feed_blogs
function db_blogExiste($id){
    
    $query = db_select('historico_feed_blogs', 'hfb');
    $query->fields('hfb');
    $query->condition('hfb.id', $id);
    
    $result = $query->execute();
    
    return $result->fetch();
    
}

//Função que vai inserir os valores com as notícias dos rss
function db_addNoticiaRss($arrDados){
    
    $nid = db_insert('historico_feed_blogs')
            ->fields($arrDados)
            ->execute();
    
    return $nid;
    
}

//Função que vai atualizar os valores das noticias do feed
function db_atualizarNoticiasRss($arrDados){
    
    $numUpdated = db_update('historico_feed_blogs')
            ->fields($arrDados)
            ->condition('id', $arrDados['id'])
            ->execute();
    
    return $numUpdated;
    
}

function db_getUltimasBlogs($qntd = 3){
    
    $query = db_select('historico_feed_blogs', 'hfb')
            ->fields('hfb')
            ->range(0, $qntd)
            ->orderBy('data_publicacao', 'DESC')
            ->execute();
    
    return $query->fetchAll();
    
}
