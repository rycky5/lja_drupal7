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
   $privatekey = KEY_PRIVATE_RECAPTCHA;
  
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

  // Validando as permissões do usuário
  if(array_key_exists('3', $objUsuario->roles) || array_key_exists('4', $objUsuario->roles) || array_key_exists('5', $objUsuario->roles))
          throw new Exception("Seu usuáiro não tem permissão de logar!");
          
  // Iniciano o global user
  global $user;
  $user = $objUsuario;

 // Formulário de login
 $form_state['uid'] = $objUsuario->uid;
 // Realizando o login do usuário
 user_login_submit(array(), $form_state);
 user_login_finalize($form_state['values']);
}
