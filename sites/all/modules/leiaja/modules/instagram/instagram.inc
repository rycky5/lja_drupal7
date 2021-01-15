<?php

module_load_include('inc', 'instagram', 'instagram.api');

/**
 * Função onde salvará a hashtag
 * 
 */
function instagram_save_hashtag_submit() {

  $post = $_POST["hashtag"];

  $hashtag = empty($post) ? FALSE : $post;

  if ($hashtag) {
    api_save_hashtag($hashtag);
  }
}

/**
 * esta função retorna o valor:::
 */
function instagramResult($parms = array()) {

  $hashtag = "vemprarua";

  $ajaxReturn = empty($parms['ajax']) ? FALSE : TRUE;

  $vars = array();
  $vars['tag'] = empty($hashtag) ? 'leiaja' : $hashtag;
  $vars['type_name'] = empty($parms['type_name']) ? 'full_name' : $parms['type_name'];
  $vars['resolution_image'] = empty($parms['resolution_image']) ? "standard_resolution" : $parms['resolution_image'];
  $vars['paginacao'] = empty($parms['paginacao']) ? FALSE : $parms['paginacao'];
  $vars['strLink'] = empty($_POST["strLink"]) ? '' : $_POST["strLink"];

   // criando chave
  $strChaveCache = "protestos";
  
  // Gerando chave
  $cache = cache_get($strChaveCache, 'cache_page');
  
  if(empty ($cache->data)){
    
    // Setando a cache
    $result = api_instagramResult($vars);
    
    // Setando em cache
    cache_set($strChaveCache,$result,'cache_page', 3*60);
    

  }else{
    $result = $cache->data;
  }
  
  if($ajaxReturn){
    echo $result;die;
  }else
    return $result;
  
}

/**
 * Função para retornar valor o json do instagram via get ou post
 * 
 * 
 * os $_REQUEST a receber:
 * 
 * instagram_type_name = type_name; @String
 * instagram_resolution_image = resolution_image; @String
 * instagram_paginacao  = paginação   @boolean
 * instagram_strLink = link para a proxima page do instagram @String
 * 
 */
function instagramResultAjax() {

  $vars = array();
  $vars['ajax'] = TRUE;
  $vars['type_name'] = empty($_REQUEST['instagram_type_name']) ? 'full_name' : $_REQUEST['instagram_type_name'];
  $vars['resolution_image'] = empty($_REQUEST['instagram_resolution_image']) ? "low_resolution" : $_REQUEST['instagram_resolution_image'];
  $vars['paginacao'] = empty($_REQUEST['instagram_paginacao']) ? FALSE : $_REQUEST['instagram_paginacao'];
  $vars['strLink'] = empty($_REQUEST["instagram_strLink"]) ? '' : $_REQUEST["instagram_strLink"];

  $result = instagramResult($vars);

  print $result;
}