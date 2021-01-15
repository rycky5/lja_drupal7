<?php
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

  if(md5(strtoupper($_POST['inpCaptcha'])) != $_SESSION['WoRD']){
      //var_dump($_SESSION);
    die('recaptcha');
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
  
  $auto_user = user_save('', $user);
  
  $nid = db_insert('users_roles') // Table name no longer needs {}
  ->fields(array(
    'uid' => $auto_user->uid,
    'rid' => '1'
  ))
  ->execute();
  
  $del = db_delete('tbfbcontrato')
  ->condition('username', $_POST['name'])
  ->execute();
  
  $nid2 = db_insert('tbfbcontrato') // Table name no longer needs {}
  ->fields(array(
    'username' => $_POST['name'],
    'status' => '1',
    'facebook' => '0'
  ))
  ->execute();
  
  /*$profile = array('rtype' => '2');
  $thiscat = 'authenticated user';
    profile_save_profile($profile, $auto_user, $thiscat, 'true');*/
    $account = user_load(user_authenticate($_POST['name'], $_POST['senha']));
    global $user;
    $user = $account;
    user_login_finalize($form_state['values']);
    $fullname = verifyFullName();
    $_SESSION['name'] = $fullname["field_fullname_value"];
    //return json_encode('1');
    die('1');
    //drupal_goto('meuleiaja');
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