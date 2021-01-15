<?php
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
  	if(md5(strtoupper($_POST['inpCaptcha'])) != $_SESSION['WoRD']){
  	  die('recaptcha');
  	}
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
