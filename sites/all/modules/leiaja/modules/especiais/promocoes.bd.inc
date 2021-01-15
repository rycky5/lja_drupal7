<?php

/**
 * Arquivo resposável por conter todo acesso ao banco do módulo vídeo sambatech
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */


/**
 * Função Responsável por arualizar os views dos vídeos na base
 *
 * @param array $arrDadosVideo 
 */
function getTermosdb($pParams){
    try{
      $news_items = array();
      //Verifica as promoções ativas. order by weight DESC
      $termos = db_select('taxonomy_term_data', 'ttd')->fields('ttd', array('tid'));
      $termos->join('field_data_field_data_exibicao', 'de', 'de.entity_id = ttd.tid');
      $termos->join('taxonomy_vocabulary', 'tv', 'tv.vid = ttd.vid');
      $termos->condition('tv.machine_name', 'promocoes', '=');
      $termos->where("STR_TO_DATE(de.field_data_exibicao_value, '%Y-%m-%d %H:%i:%s') >= now()");
      $termos->orderBy('ttd.weight', 'ASC');
      $termos = $termos->execute()->fetchAllKeyed();
      if (isset($termos)) {
        $news_items_tids = array_keys($termos);
        $news_items = taxonomy_term_load_multiple($news_items_tids);
      }
      return $news_items;
    }catch (Exception $objEx){
      // Lançando a excessão 
      throw new Exception($objEx->getMessage());
    }
}


function participar_promo_db($tid){
  if($GLOBALS['user']->uid != 0){
    
    $result = listar_participante($tid);
    
    if($result){
      return false;
    }

    $nid = db_insert('tb_participante_promo') // Table name no longer needs {}
      ->fields(array(
        'uid' => $GLOBALS['user']->uid,
        'tid' => $tid,
        'data' => date('Y-m-d H:m:s'),
      ))
      ->execute();

    return true;
  
  }else{
    return false;
  }
  
}

function listar_participante($tid = ''){
  
   $result = db_select('tb_participante_promo', 'pp')
    ->fields('pp', array('tid'))
    ->condition('uid', $GLOBALS['user']->uid,'=');
    if(!empty($tid)){
      $result->condition('tid', $tid,'=');
    }
    $result = $result->execute()
    ->fetchCol();
   
   return $result;
  
}

function db_listagem_participantes(array $arrFiltro){
//   => $strUF, "strCidade" => $strCidade
          
  $strTid = (strlen(trim($arrFiltro["tid"])) > 0) ? " AND pp.tid = '{$arrFiltro["tid"]}'" : "";
  
  $strSql = "SELECT
              ft.field_cel_value AS cel,
              u.mail,
              u.name,
              td.name AS promo
            FROM
              users u 
              INNER JOIN tb_participante_promo pp ON pp.uid = u.uid $strTid
              INNER JOIN taxonomy_term_data td ON pp.tid = td.tid
              LEFT JOIN field_data_field_cel ft ON u.uid = ft.entity_id";
  
  try {
    $arrReturn = db_query($strSql);
    
    $arrObjUsuario = $arrReturn->fetchAll();
  } catch (Exception $exc) {}

  return $arrObjUsuario;
}

?>