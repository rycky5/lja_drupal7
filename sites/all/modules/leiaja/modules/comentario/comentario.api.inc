<?php
/**
 * Arquivo que conterão as validações e regras de nogocio do módulo atual
 * 
 * @author Alberto Medeiros<alberto.medeiros@seredcucacional.com>
 */


/**
 * Método que irá salvar o comentário de forma customisada
 * 
 * @global type $user
 * @param array $arrDados 
 */
function api_salvar_comentario(array $arrDados){
  
  // Lendo as livrarias
  $arrLibraries = libraries_get_libraries();
  
  // Incluindo o arquivo necessário
  require_once $_SERVER['DOCUMENT_ROOT'].'/'.$arrLibraries["recaptcha"]."/recaptchalib.php";
  
  // Pegando o identificador da node
  $intNId = (int) $_GET["id"];
  
  // Recuperando a node da base
  $objNode = node_load($intNId);
  
  // Validações do método
  if(empty ($objNode))                                        throw new Exception("Não Foi possível recuperar a notícia!!!");
  //if(empty ($arrDados["subject"]))                            throw new Exception("O 'Assunto' do comentário não foi informado!!!");
  if(empty ($arrDados["comment_body"]["und"][0]["value"]))    throw new Exception("O 'Conteúdo' do comentário não foi informado!!!");
  
  // Chave publica do leiajá
  $privatekey = "6Ld8j9oSAAAAAJLdUPymsxsC8zv9pd1b5IE8N4lj";

  // Validando
  $resp = recaptcha_check_answer ($privatekey,
                              $_SERVER["REMOTE_ADDR"],
                              $arrDados["recaptcha_challenge_field"],
                              $arrDados["recaptcha_response_field"]);
  

  // Validando o captach
  if (!$resp->is_valid) throw new Exception("Erro: Favor digitar o codígo corretamente");
  
  // Recuperando o usuário
  global $user;
  
  // Criando o objeto que será salvo como o comentário
  $objComentario = new stdClass();
  $objComentario->uid = $user->uid;
  $objComentario->subject = $arrDados["subject"];
  $objComentario->comment_body = $arrDados["comment_body"];
  $objComentario->created   = REQUEST_TIME;
  $objComentario->nid       = $objNode->nid;
  
  //if(empty ($arrDados["subject"]))                            throw new Exception("O 'Assunto' do comentário não foi informado!!!");
  if(empty ($user->uid) || $user->uid == 0)    throw new Exception("Essa operação requer efetuar o login!!!");
  
  // Salvando o comentário na base
  $objComentario = comment_submit($objComentario);
  comment_save($objComentario);
}

/**
 * Método que irá salvar o comentário de forma customisada
 * 
 * @global type $user
 * @param array $arrDados 
 */
function api_salvar_estatico_comentario(array $arrDados){
  // Includes necessários
  module_load_include('inc', 'nodeestatica', 'nodeestatica.api');
  
  // Lendo as livrarias
  $arrLibraries = libraries_get_libraries();
  
  // Incluindo o arquivo necessário
  require_once $_SERVER['DOCUMENT_ROOT'].'/'.$arrLibraries["recaptcha"]."/recaptchalib.php";
  
  // Recuperando o usuário
  global $user;
  
  // decocando o base 64
  $strPost = base64_decode(base64_decode(@$_POST["form_id"]));

  // Explodindo o post
  $arrDadosNode = explode("-", $strPost);

  // Pegando o nid passado
  $intNid = (int) $arrDadosNode[0];
  
  // Pegando o id do usuário
  $intUId = $user->uid;
  
  // Recuperando a node da base
  $objNode = node_load($intNid);
  
  // Validações do método
  if(empty ($objNode))                                        throw new Exception("Não Foi possível recuperar a notícia!!!");
  //if(empty ($arrDados["subject"]))                            throw new Exception("O 'Assunto' do comentário não foi informado!!!");
  if(empty ($arrDados["comment_body"]["und"][0]["value"]))    throw new Exception("O 'Conteúdo' do comentário não foi informado!!!");

  // Chave publica do leiajá
  $privatekey = KEY_PRIVATE_RECAPTCHA;

  // Validando
  $resp = recaptcha_check_answer ($privatekey,
                              $_SERVER["REMOTE_ADDR"],
                              $arrDados["recaptcha_challenge_field"],
                              $arrDados["recaptcha_response_field"]);
  
  // Validando o captach
  if (!$resp->is_valid) throw new Exception("Erro: Favor digitar o codígo corretamente");
  
  // Recuperando o usuário
  $user = user_load($intUId);
  
  // Criando o objeto que será salvo como o comentário
  $objComentario = new stdClass();
  $objComentario->uid = $user->uid;
  $objComentario->subject = @$arrDados["subject"];
  $objComentario->comment_body = limitaTextoTags(@$arrDados["comment_body"], 500);
  $objComentario->created   = REQUEST_TIME;
  $objComentario->nid       = $objNode->nid;
  
  //if(empty ($arrDados["subject"]))                            throw new Exception("O 'Assunto' do comentário não foi informado!!!");
  if(empty ($user->uid) || $user->uid == 0)    throw new Exception("Essa operação requer efetuar o login!!!");
  
  // Formulário de login
  $form_state['uid'] = $user->uid;
  
  // Realizando o login do usuário
  user_login_submit(array(), $form_state);
  user_login_finalize($form_state['values']);
  
  // Salvando o comentário na base
  $objComentario = comment_submit($objComentario);
  comment_save($objComentario);
  
  // Salvando o estático do comentário
  atualizaComentario($objNode);
}

