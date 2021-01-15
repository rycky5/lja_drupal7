<?php
/**
 * Arquivo que conterá as persistencia da entidade usuário
 * 
 * @author Alberto Medeiros
 * @version 1.0
 */

/**
 * Método que irá recuperar o usuário pelo logni e senha
 * 
 * @param array $arrDados
 * @return Objeto User
 */
function db_insert_user(array $arrDados){
  try {
    $objQuery = db_insert("users");
    $objQuery->fields($arrDados);
    $intUId = $objQuery->execute();
    
    $objQuery = db_insert("users_roles");
    $objQuery->fields(array("uid"=>$arrDados["uid"], "rid"=> 2));
    $objQuery->execute();
    
    return $intUId;
  } catch (Exception $exc) {
    throw new Exception($exc->getMessage());
  }
}

/**
 * Método que irá recuperar o usuário pelo logni e senha
 * 
 * @param array $arrDados
 * @return Objeto User
 */
function db_update_user(array $arrDados, $intUId){
  try {
    $objQuery = db_update("users");
    $objQuery->fields($arrDados);
    $objQuery->condition('uid',$intUId);
    return $objQuery->execute();
  } catch (Exception $exc) {
    throw new Exception($exc->getMessage());
  }
}

/**
 * Método que irá recuperar o usuário pelo logni e senha
 * 
 * @param array $arrDados
 * @return Objeto User
 */
function db_procurar_user_por_login(array $arrDados){
  try {
    return user_load(user_authenticate($arrDados["strLogin"], $arrDados["strSenha"]));
  } catch (Exception $exc) {
    throw new Exception($exc->getMessage());
  }
}

/**
 * Método que irá verificar se existe um usuário pelo login
 * 
 * @param int $strLogin
 * @return boolean
 */
function db_existe_por_login($strLogin){
  try {
    $objQuery = db_select("users", "u");
    $objQuery->fields("u");
    $objQuery->condition('u.name',trim($strLogin));
    return (count($objQuery->execute()->fetchAll()) > 0);
  } catch (Exception $exc) {
    throw new Exception($exc->getMessage());
  }
}

/**
 * Método que ira atualizar o campo de celular do usuário no leiajá
 * @param String $cel
 * @param int $uid 
 */
function db_updateCel($cel, $uid){ 
  try {
    // Setando a base do leiaja
    db_set_active("leiaja");
    
    $num_updated = db_update('field_data_field_cel') // Table name no longer needs {}
                  ->fields(array(
                    'field_cel_value' => $cel
                  ))
                  ->condition('entity_id', $uid, '=')
                  ->condition('field_cel_value', 'null', '=')
                  ->execute();
    
    // Setando a base do default
    db_set_active("default");
  } catch (Exception $exc) {
    throw new Exception($exc->getMessage());
  }
  
}


?>
