<?php
/**
 * Arquivo que conterá as validações para a entidade de usuário
 * 
 * @author Alberto Medeiros
 * @version 1.0
 */

// includes
module_load_include('inc', 'usuario', 'usuario.db');

/**
 * Método responsável por logar o usuário na base do leiaja
 * 
 * @param array $arrDados 
 */
function api_usuario_login(array $arrDados){
  
  // Validações
  if(strlen(trim($arrDados["strLogin"])) == 0)    throw new Exception("Favor informar o 'LOGIN'");
  if(strlen(trim($arrDados["strSenha"])) == 0)    throw new Exception("Favor informar a 'SENHA'");
  
   // Lendo as livrarias
   $arrLibraries = libraries_get_libraries();
   // Incluindo o arquivo necessário
   require_once $_SERVER['DOCUMENT_ROOT'].'/'.$arrLibraries["recaptcha"]."/recaptchalib.php";

   // Chave publica do leiajá
   $privatekey = "6Ld8j9oSAAAAAJLdUPymsxsC8zv9pd1b5IE8N4lj";
  
   $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $arrDados["recaptcha_challenge_field"],
                                $arrDados["recaptcha_response_field"]);
   
  // Validando o captach
  if (!$resp->is_valid) throw new Exception("Erro: Favor digitar o codígo corretamente" .$resp->error);
  
  // realizando a consulta na base do leiaja
  $objUsuario = user_load(user_authenticate($arrDados["strLogin"], $arrDados["strSenha"]));

  // Validando se o usuário foi encontrado no leiajá
  if($objUsuario->uid == 0) throw new Exception("Usuário não encontrado!");


  global $user;
  $user = $objUsuario;

 // Formulário de login
 $form_state['uid'] = $objUsuario->uid;
 // Realizando o login do usuário
 user_login_submit(array(), $form_state);
 user_login_finalize($form_state['values']);
}



/**
 * Método que ira atualizar o campo de celular do usuário no leiajá
 * @param String $cel
 * @param int $uid 
 */
function api_updateCel($cel, $uid){ 
  return db_updateCel($cel, $uid);
}

?>
