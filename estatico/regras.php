<?php
/**
 * Arquivo que conterá as validações para estatico
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 * 
 */

/**
 * Método que irá validar se é um arquivo estático 
 * 
 */
function validaEstatico(){
  
  // Iniciando a variável de retorno
  $bolRetorno = false;
  
  // Flag que irá identificar se o site está aberto no sgc
  $bolSGC = false;
  
  // Criando a uri da notícia
  $strUri = preg_replace("/\?[0-9a-zA-Z=:#&]*/", "", $_SERVER['REQUEST_URI']);
  $strUri = preg_replace("/(2011)|(2012)/", "2013", $_SERVER['REQUEST_URI']);

  // Explodindo a url
  $arrUrl = explode("/", $_SERVER ['REQUEST_URI']);
    
  try {
    
    // Calidações para modo de notícias
    if(strstr($_SERVER['REQUEST_URI'],'preview=true')) throw new Exception("Previw de página");
    if(strstr($_SERVER['REQUEST_URI'],'print=true')) throw new Exception("Print de notícia");
    
    // Criando o array com os dominios
    $arrSitesEstatico = array("www.leiaja.com", "www3.leiaja.com", "www4.leiaja.drupal.721.com");
    $arrNaoSitesEstatico = array("blogs", "colunistas", "tags");
    
    // Validações para saber se a url pode ser ou não estatica
    if(!in_array($_SERVER["SERVER_NAME"], $arrSitesEstatico))                 throw new Exception("Não é o leiajá");
    if(count($arrUrl) > 2 && in_array($arrUrl[1], $arrNaoSitesEstatico))      throw new Exception("Não pode ser estático");
    if(!file_exists(DRUPAL_ROOT  .$strUri . @$arrUrl[3] . ".php"))      throw new Exception("Não existe o aquivo");
    
    // Caso todas as validações estejam corretas seto o retorno para verdadeiro e digo que pode ser estatico
    $bolRetorno = true;
  } catch (Exception $exc) { 
    // Criando o array com os dominios
    $arrDominioIG = array("igpernambuco.leiaja.com", "pernambuco.ig.com.br");
    
    // Verificando se é o ig se for seto o status para 200
    if(in_array($_SERVER["SERVER_NAME"], $arrDominioIG) && count($arrUrl) > 2)   header("HTTP/1.1 200 OK");
  }
  
  // retornando o estatus 
  return $bolRetorno;
  
}


/**
 * Método que irá carregar de forma definitiva a noticia caso a mesma não tenha um método de redirecionamento
 * 
 * 
 */
function carregaNoticia(){
  // Criando a uri da notícia
  $strUri = preg_replace("/\?[0-9a-zA-Z=:#&]*/", "", $_SERVER['REQUEST_URI']);
  $strUri = preg_replace("/(2011)|(2012)/", "2013", $_SERVER['REQUEST_URI']);
  
  // Explodindo a url
  $arrUrl = explode("/", $_SERVER ['REQUEST_URI']);
  
  // Caso exista um método de redirecionamento redireciono pra url especifica
  if(file_exists(DRUPAL_ROOT.$strUri."redireciona.php")){
    include_once(DRUPAL_ROOT.$strUri."redireciona.php");
  }
  
  // incluindo as variaveis para montar a notícia
  include_once(DRUPAL_ROOT.$strUri."variaveis.php");
  
  // Include no arquivo miolo
  include_once(DRUPAL_ROOT."/".$arrUrl[1]."/index_".$arrUrl[1].".php");
}
