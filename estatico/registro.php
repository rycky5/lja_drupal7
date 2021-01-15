<?php
/**
 * Arquivo que conterá a função de registro no drupal de forma a possibilitar que os usuários possam
 * realizar login nas notícias estáticas 
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */
// Iniciando a sessão
session_start();

// Lendo as livrarias
$strCaminho = getcwd()."/../sites/all/libraries/curl/cURL.php";

include_once $strCaminho;
if(!empty ($_POST)){
  // Criando o objeto Curl
  $objCurl = new cURL();

  // Acessando a url afim de realizar o login e senha pelo drupal
  $objRetorno = json_decode($objCurl->post($_SERVER["SERVER_NAME"]."/usuario/estatico", $_POST));

  // Caso o retonor seja true o usuário fez login e starto a sessão local
  if(!empty ($objRetorno) && $objRetorno->bolRetorno){
    
    // Recuperando o objeto usuario
    $objUser = $objRetorno->objUsuario;
    
    // Setando o usuário na sessão
    $_SESSION["user"] = $objUser;
    
  }
  
  // Iniciando o array de retorno
  $arrRetorno = array();
  $arrRetorno["bolRetono"] = $objRetorno->bolRetorno;
  $arrRetorno["strMensagem"] = $objRetorno->strMensagem;
  
  echo json_encode($arrRetorno);
  
}else{
  // Destruindo a sessão 
  session_destroy();
  
  // Caso não seja um post redireciono o usuário para a home
  header("Location: /");
}
