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
  if(empty ($arrDados["subject"]))                            throw new Exception("O 'Assunto' do comentário não foi informado!!!");
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
  $objComentário = new stdClass();
  $objComentário->uid = $user->uid;
  $objComentário->subject = $arrDados["subject"];
  $objComentário->comment_body = $arrDados["comment_body"];
  $objComentário->created   = REQUEST_TIME;
  $objComentário->nid       = $objNode->nid;
  
  // Salvando o comentário na base
  $objComentário = comment_submit($objComentário);
  comment_save($objComentário);
}