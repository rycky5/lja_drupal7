<?php
/**
 * Arquivo que conterá as requisições de callback para o módulo usuári
 * 
 * @author Alberto Medeiros
 * @version 1.0
 */
// includes
module_load_include('inc', 'usuario', 'usuario.api');


function user_edit(){
  drupal_add_js(drupal_get_path('theme', 'leiaja') . '/js/jquery.maskedinput-1.3.min.js');
  if($GLOBALS['user']->uid != 0){
	$vars['user'] = user_load($GLOBALS['user']->uid);
        $output = theme('alteracao', $vars);
   
	return $output;
  }else{
	header ('Location: '.base_path().'cadastro');
  }
}


function edit_ajax(){
  try {
  	 // Lendo as livrarias
         $arrLibraries = libraries_get_libraries();
         // Incluindo o arquivo necessário
         require_once $_SERVER['DOCUMENT_ROOT'].'/'.$arrLibraries["recaptcha"]."/recaptchalib.php";

         // Chave publica do leiajá
         $privatekey = "6Ld8j9oSAAAAAJLdUPymsxsC8zv9pd1b5IE8N4lj";

         $resp = recaptcha_check_answer ($privatekey,
                                      $_SERVER["REMOTE_ADDR"],
                                      $_POST["recaptcha_challenge_field"],
                                      $_POST["recaptcha_response_field"]);

        // Validando o captach
        if (!$resp->is_valid) die("Erro: Favor digitar o codígo corretamente" .$resp->error);
        
	if(!empty($_POST['uf'])){
	  $result = db_query('SELECT * FROM field_data_field_uf WHERE entity_id = :uid', array(':uid' => $GLOBALS['user']->uid));
	  if($result->rowCount() == 0){
	  	$nid = db_insert('field_data_field_uf')
		->fields(array(
		  'entity_type' => 'user',
		  'bundle' => 'user',
		  'deleted' => 0,
		  'entity_id' => $GLOBALS['user']->uid,
		  'revision_id' => $GLOBALS['user']->uid,
		  'language' => 'und',
		  'delta' => 0,
		  'field_uf_value' => $_POST['uf'],
		  'field_uf_format' => 'null',
		))
		->execute();
	  }else{
	  $num_updated = db_update('field_data_field_uf')
		->fields(array(
		  'field_uf_value' => $_POST['uf']
		))
		->condition('entity_id', $GLOBALS['user']->uid, '=')
		->execute();
	  	
	  };

	}
	//Include necessário para geração password.
        require_once $_SERVER['DOCUMENT_ROOT'].'/includes/password.inc';        
        
	if(!empty($_POST['senha'])){
	  $num_updated = db_update('users') // Table name no longer needs {}
		->fields(array(
		  'pass' => _password_crypt('sha512', $_POST['senha'], _password_generate_salt(DRUPAL_HASH_COUNT))
		))
		->condition('uid', $GLOBALS['user']->uid, '=')
		->execute();
	}
	//Se alterou o sexo(^~) entra no if.
	if (!empty($_POST['sexo'])){
	  $result = db_query('SELECT * FROM field_data_field_sexo WHERE entity_id = :uid', array(':uid' => $GLOBALS['user']->uid));
	  if($result->rowCount() == 0){
	  	$nid = db_insert('field_data_field_sexo') // Table name no longer needs {}
		->fields(array(
		//entity_type, bundle, deleted, entity_id, revision_id, language, delta, field_sexo_value
		  'entity_type' => 'user',
		  'bundle' => 'user',
		  'deleted' => 0,
		  'entity_id' => $GLOBALS['user']->uid,
		  'revision_id' => $GLOBALS['user']->uid,
		  'language' => 'und',
		  'delta' => 0,
		  'field_sexo_value' => $_POST['sexo'],
		))
		->execute();
	  }else{
	  $num_updated = db_update('field_data_field_sexo') // Table name no longer needs {}
		->fields(array(
		  'field_sexo_value' => $_POST['sexo']
		))
		->condition('entity_id', $GLOBALS['user']->uid, '=')
		->execute();
	  }
	}
	//if mudou a cidade entra no if
	if (!empty($_POST['cidade'])){
	  $result = db_query('SELECT * FROM field_data_field_cidade WHERE entity_id = :uid', array(':uid' => $GLOBALS['user']->uid));
	  if($result->rowCount() == 0){
	  	$nid = db_insert('field_data_field_cidade') // Table name no longer needs {}
		->fields(array(
		//entity_type, bundle, deleted, entity_id, revision_id, language, delta, field_cidade_value, field_cidade_format
		  'entity_type' => 'user',
		  'bundle' => 'user',
		  'deleted' => 0,
		  'entity_id' => $GLOBALS['user']->uid,
		  'revision_id' => $GLOBALS['user']->uid,
		  'language' => 'und',
		  'delta' => 0,
		  'field_cidade_value' => $_POST['cidade'],
		  'field_cidade_format' => 'null',
		))
		->execute();
	  }else{
	  $num_updated = db_update('field_data_field_cidade') // Table name no longer needs {}
		->fields(array(
		  'field_cidade_value' => $_POST['cidade']
		))
		->condition('entity_id', $GLOBALS['user']->uid, '=')
		->execute();
	  }
	}
	//if mudou a cel entra no if
	if (!empty($_POST['cel'])){
	  $result = db_query('SELECT * FROM field_data_field_cel WHERE entity_id = :uid', array(':uid' => $GLOBALS['user']->uid));
	  if($result->rowCount() == 0){
	  	$nid = db_insert('field_data_field_cel') // Table name no longer needs {}
		->fields(array(
		//entity_type, bundle, deleted, entity_id, revision_id, language, delta, field_cidade_value, field_cidade_format
		  'entity_type' => 'user',
		  'bundle' => 'user',
		  'deleted' => 0,
		  'entity_id' => $GLOBALS['user']->uid,
		  'revision_id' => $GLOBALS['user']->uid,
		  'language' => 'und',
		  'delta' => 0,
		  'field_cel_value' => $_POST['cel'],
		  'field_cel_format' => 'null',
		))
		->execute();
	  }else{
	  $num_updated = db_update('field_data_field_cel') // Table name no longer needs {}
		->fields(array(
		  'field_cel_value' => $_POST['cel']
		))
		->condition('entity_id', $GLOBALS['user']->uid, '=')
		->execute();
	  }
	}
	//if mudou a sms entra no if
	if (!empty($_POST['sms'])){
          $sms = ($_POST['sms'] == 'on')? '1' : '0';
	  $result = db_query('SELECT * FROM field_data_field_sms WHERE entity_id = :uid', array(':uid' => $GLOBALS['user']->uid));
	  if($result->rowCount() == 0){
	  	$nid = db_insert('field_data_field_sms') // Table name no longer needs {}
		->fields(array(
		//entity_type, bundle, deleted, entity_id, revision_id, language, delta, field_cidade_value, field_cidade_format
		  'entity_type' => 'user',
		  'bundle' => 'user',
		  'deleted' => 0,
		  'entity_id' => $GLOBALS['user']->uid,
		  'revision_id' => $GLOBALS['user']->uid,
		  'language' => 'und',
		  'delta' => 0,
		  'field_sms_value' => $sms,
		))
		->execute();
	  }else{
            $sms = ($_POST['sms'] == 'on')? '1' : '0';
            $num_updated = db_update('field_data_field_sms') // Table name no longer needs {}
		->fields(array(
		  'field_sms_value' => $sms
		))
		->condition('entity_id', $GLOBALS['user']->uid, '=')
		->execute();
	  }
	}
	//if mudou a spam entra no if
	if (!empty($_POST['spam'])){
          $spam = ($_POST['spam'] == 'on')? '1' : '0';
	  $result = db_query('SELECT * FROM field_data_field_spam WHERE entity_id = :uid', array(':uid' => $GLOBALS['user']->uid));
	  if($result->rowCount() == 0){
	  	$nid = db_insert('field_data_field_spam') // Table name no longer needs {}
		->fields(array(
		//entity_type, bundle, deleted, entity_id, revision_id, language, delta, field_cidade_value, field_cidade_format
		  'entity_type' => 'user',
		  'bundle' => 'user',
		  'deleted' => 0,
		  'entity_id' => $GLOBALS['user']->uid,
		  'revision_id' => $GLOBALS['user']->uid,
		  'language' => 'und',
		  'delta' => 0,
		  'field_spam_value' => $spam,
		))
		->execute();
	  }else{
            $spam = ($_POST['spam'] == 'on')? '1' : '0';
            $num_updated = db_update('field_data_field_spam') // Table name no longer needs {}
		->fields(array(
		  'field_spam_value' => $spam
		))
		->condition('entity_id', $GLOBALS['user']->uid, '=')
		->execute();
	  }
	}
	//Se alterou o nome completo entra no if
	if (!empty($_POST['fullname'])){
	  $result = db_query('SELECT * FROM field_data_field_fullname WHERE entity_id = :uid', array(':uid' => $GLOBALS['user']->uid));
	  if($result->rowCount() == 0){
	  	$nid = db_insert('field_data_field_fullname') // Table name no longer needs {}
		->fields(array(
		//entity_type, bundle, deleted, entity_id, revision_id, language, delta, field_fullname_value, field_fullname_format
		  'entity_type' => 'user',
		  'bundle' => 'user',
		  'deleted' => 0,
		  'entity_id' => $GLOBALS['user']->uid,
		  'revision_id' => $GLOBALS['user']->uid,
		  'language' => 'und',
		  'delta' => 0,
		  'field_fullname_value' => $_POST['fullname'],
		  'field_fullname_format' => 'null',
		))
		->execute();
	  }else{
	  $num_updated = db_update('field_data_field_fullname') // Table name no longer needs {}
		->fields(array(
		  'field_fullname_value' => $_POST['fullname']
		))
		->condition('entity_id', $GLOBALS['user']->uid, '=')
		->execute();
	  }
	}
	die('true');
  }catch (Exception $e){
	die('false');
  }
  
}


/**********************************************************
 *********** CADASTRO DE USUÁRIO **************************
 **********************************************************/

function user_register(){
  drupal_add_js(drupal_get_path('theme', 'leiaja') . '/js/jquery.maskedinput-1.3.min.js');
  if($GLOBALS['user']->uid == 0){
	$output = theme('cadastro', $vars);
	return $output;
  }else{
	header ('Location: '.base_path().'alteracao');
  }
}

/**
 * 
 * Enter description here ...
 */
function tryUsername(){
  echo json_encode(verifyUsername($_POST['name']));
//  echo $_POST['name'];
}

function tryMail(){
  echo json_encode(verifyMail($_POST['mail']));
//  echo $_POST['name'];
}

/**
 * 
 */
function register_ajax(){
  $GLOBALS['conf']['cache'] = FALSE;

  // Lendo as livrarias
   $arrLibraries = libraries_get_libraries();
   // Incluindo o arquivo necessário
   require_once $_SERVER['DOCUMENT_ROOT'].'/'.$arrLibraries["recaptcha"]."/recaptchalib.php";

   // Chave publica do leiajá
   $privatekey = "6Ld8j9oSAAAAAJLdUPymsxsC8zv9pd1b5IE8N4lj";
  
   $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
   
  // Validando o captach
  if (!$resp->is_valid) {
    echo json_encode("Erro: Favor digitar o codígo corretamente" .$resp->error);die;
  }
  
  $sms = ($_POST['sms'] == 'on')? '1' : '0';
  $spam = ($_POST['spam'] == 'on')? '1' : '0';
  $user = array(
    'name' => $_POST['name'], 
    'pass' => $_POST['senha'],
    'mail' =>  str_replace(" ","",$_POST['mail']),
    'init' => $_POST['mail'],
    'language' => 'pt-br',
    'status' => 1,
    'access' => REQUEST_TIME,
    'field_uf' => array(LANGUAGE_NONE => array(array('value' => $_POST['uf']))),
    'field_sexo' => array(LANGUAGE_NONE => array(array('value' => $_POST['Sexo']))),
    'field_cidade' => array(LANGUAGE_NONE => array(array('value' => $_POST['cidade']))),
    'field_fullname' => array(LANGUAGE_NONE => array(array('value' => $_POST['fullname']))),
    'field_data_nasc' => array(LANGUAGE_NONE => array(array('value' => '2011-01-01'))),
    'field_cel' => array(LANGUAGE_NONE => array(array('value' => $_POST['cel']))),
    'field_sms' => array(LANGUAGE_NONE => array(array('value' => $sms))),
    'field_spam' => array(LANGUAGE_NONE => array(array('value' => $spam)))
  );
  
  
  try {
      $auto_user = user_save('', $user);

      $nid = db_insert('users_roles') // Table name no longer needs {}
      ->fields(array(
        'uid' => $auto_user->uid,
        'rid' => '1'
      ))->execute();

      $del = db_delete('tbfbcontrato')
      ->condition('username', $_POST['name'])
      ->execute();

      $nid2 = db_insert('tbfbcontrato') // Table name no longer needs {}
      ->fields(array(
        'username' => $_POST['name'],
        'status' => '1',
        'facebook' => '0'
      ))->execute();

      $account = user_load(user_authenticate($_POST['name'], $_POST['senha']));
      global $user;
      $user = $account;
      user_login_finalize($form_state['values']);
      $fullname = verifyFullName();
      $_SESSION['name'] = $fullname["field_fullname_value"];
      //return json_encode('1');
      die('1');
  } catch (Exception $exc) {
    echo json_encode($exc->getMessage());die;
  }

}

function updateCel($cel, $uid){ 
  $num_updated = db_update('field_data_field_cel') // Table name no longer needs {}
    ->fields(array(
      'field_cel_value' => $cel
    ))
    ->condition('entity_id', $uid, '=')
    ->condition('field_cel_value', 'null', '=')
    ->execute();
}



function verifyUsername($username)
{
  $result = db_select('users', 'u')
    ->fields('u', array('uid'))
    ->condition('name', $username,'=')
    ->condition('status', 1,'=')
    ->execute()
    ->fetchAssoc();

    if($result){
      return false;
    }
    return true;
}

function verifyFullName($uid = 0){
  $uid = ($uid == 0 )? $GLOBALS['user']->uid : $uid;
  $result = db_select('field_revision_field_fullname', 'f')
    ->fields('f', array('field_fullname_value'))
    ->condition('entity_id', $uid,'=')
    ->execute()
    ->fetchAssoc();

  return $result;
}


/**********************************************************************************
 ******** MÉTODOS DE CUSTOMISAÇÃO DE LOGIN E SENHA ******************************** 
 ***********************************************************************************/

/**
 * Método responsavel por receber a requisição para que o usuário possa se logar
 */
function usuario_login(){
  if(!empty ($_POST)){
    $strMensagem = "Logado com sucesso!";
    $bolRetorno  = false;
    try {
      // Pegando as requisições
      $strLogin = $_POST["strLogin"];
      $strSenha = $_POST["strSenha"];
      
      // Criando o array para realizar o login e senha
      $arrDados = array("strLogin" => $strLogin, 
                        "strSenha" => $strSenha,
                        "recaptcha_challenge_field"=> $_POST["recaptcha_challenge_field"],
                        "recaptcha_response_field"=>$_POST["recaptcha_response_field"]);
     
      // Realizando o login do usuário na base do leiajá
      api_usuario_login($arrDados);
      
      // Se a urel não estiver vazia redireciono o usuário para a mesma informada
      if(!empty ($_POST["strUrl"])){
        $strUrl = $_POST["strUrl"];
        Header("Location: $strUrl");
      }
      
      $bolRetorno  = true;
    } catch (Exception $exc) {
       $strMensagem = $exc->getMessage();
    }
    
    // Criando o array de retorno
    $arrRetorno = array();
    $arrRetorno["strMensagem"]  = $strMensagem;
    $arrRetorno["bolRetorno"]   = $bolRetorno;
    
    // Retornando o json
    echo json_encode($arrRetorno);
  }
}

/**
 * Método que irá deslogar o usuário
 * 
 * @global type $user 
 */
function user_sair(){
  //user_logout();
  global $user;

  watchdog('user', 'Session closed for %name.', array('%name' => $user->name));

  module_invoke_all('user_logout', $user);

  // Destroy the current session, and reset $user to the anonymous user.
  session_destroy();

  // retornando via json
  echo json_encode(array("bolRetorno"=>true));
}
