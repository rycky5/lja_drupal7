<?php
/**
 * Arquivo que conterá a função de cadastrar o comentário do usuário e gerar o arquivo estático com o comentário
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */
// Iniciando a sessão
session_start();

// Lendo as livrarias
$strCaminho = getcwd()."/../sites/all/libraries/curl/cURL.php";

include_once $strCaminho;

// Caso tenha sessão e hava post
if(!empty ($_POST) && @$_SESSION["user"]){
 
    // Criando o objeto Curl
    $objCurl = new cURL(300);

    // decocando o base 64
    $strPost = base64_decode(base64_decode(@$_POST["form_id"]));

    // Explodindo o post
    $arrDados = explode("-", $strPost);

    // Pegando o nid passado
    $intNid = (int) @$arrDados[0];
    $intUid = (int) @$_SESSION["user"]->uid;
    
    // Criando a url de post
    $strUrlPost = $_SERVER["SERVER_NAME"]."/comentario/estatico/salvar?nid=".$intNid."&uid=".$intUid;
    
    // Acessando a url afim de realizar o login e senha pelo drupal
    $objRetorno = json_decode($objCurl->post($strUrlPost, $_POST));
    
    // Iniciando o array de retorno
    $arrRetorno = array();
    $arrRetorno["bolRetono"] = @$objRetorno->bolRetorno;
    $arrRetorno["strMensagem"] = @$objRetorno->strMensagem;

    // Retornando via json o array retorno
    echo json_encode($arrRetorno);
}else{
  // Destruindo a sessão 
  session_destroy();
  
  // Caso não seja um post redireciono o usuário para a home
  header("Location: /");
}
