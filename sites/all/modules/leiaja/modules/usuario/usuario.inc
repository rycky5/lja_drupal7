<?php
/**
 * Arquivo que conterá as requisições de callback para o módulo usuári
 * 
 * @author Alberto Medeiros
 * @version 1.0
 */
// includes
module_load_include('inc', 'usuario', 'usuario.api');



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
 * Método responsavel por receber a requisição para que o usuário possa se logar em modo estatico
 */
function usuario_login_estatico(){
  if(!empty ($_POST)){
    $strMensagem = "Logado com sucesso!";
    $bolRetorno  = false;
    $objUsuario = null;
    try {
      // Pegando as requisições
      $strLogin = $_POST["name"];
      $strSenha = $_POST["pass"];
      
      // Criando o array para realizar o login e senha
      $arrDados = array("strLogin" => $strLogin, 
                        "strSenha" => $strSenha,
                        "recaptcha_challenge_field"=> $_POST["recaptcha_challenge_field"],
                        "recaptcha_response_field"=>$_POST["recaptcha_response_field"]);
     
      // Realizando o login do usuário na base do leiajá
      api_usuario_login($arrDados);
      
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
  }else{
    // Caso não haja post redireciono para página inicial
    Header("Location: /");
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
