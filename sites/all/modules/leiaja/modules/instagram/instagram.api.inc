<?php

function api_instagramResult($vars = array()) {

  // Lendo as livrarias
  $arrLibraries = libraries_get_libraries();
  
  // Incluindo o arquivo necessário
  require_once DRUPAL_ROOT .  '/' . $arrLibraries["curl"] . "/cURL.php";

  // Tempo limite de loading
  $objCurl = new cURL(300);

  //tag para usar no instagram
  $tag = $vars['tag'];
  //url para paginação
  $strLink = $vars["strLink"];
  //Estilo do nome
  $type_name = $vars['type_name'];
  // Resolução da imgagem
  $resolution_image = "standard_resolution";

  // Verificando se algo foi postado
  $strLink = (empty($strLink)) ? "https://api.instagram.com/v1/tags/" . $tag . "/media/recent?access_token=277595305.5b9e1e6.63f7e2286bb3444eb8ce063a21099d15" : $strLink;
                                                                                                           // 277595305.5b9e1e6.63f7e2286bb3444eb8ce063a21099d15
  // Dando get nessa url
  $strRetorno = $objCurl->get($strLink);
  // Pegando o objeto JSON e passando pra php
  $objFeedInstangram = json_decode($strRetorno);

  // Recuperando as imagens marcadas no instangram com a hash
  $arrObjFeedInstangrando = $objFeedInstangram->data;
  
  $result = array();
  // Realizando o foreach para pegar as imagens postadas
  foreach ($arrObjFeedInstangrando as $key => $objFeed) {
    $result[$key]['image'] = $objFeed->images->{$resolution_image}->url;
    $text = strip_tags($objFeed->caption->text);
//    $text = preg_replace('/[^a-z0-9# @]/i', '', $text);
//    $result[$key]['text'] = resume($text, 135);
    $result[$key]['text'] = substr($text, 0, 85);

    $result[$key]['user'] = $objFeed->user->{$type_name};
    $result[$key]['maxId'] = $objFeedInstangram->pagination->next_url;
  }
  if ($vars['paginacao']):
    //setando a paginacao ao array;
    $result['paginacao'] = $objFeedInstangram->pagination;
  endif;

  //  $resultJson = stripslashes();
  $resultJson = json_encode($result);

  return $resultJson;
}

/**
 * Função onde salvará a hashtag
 * 
 */
function api_save_hashtag($hashtag) {
  variable_set('instagram_hashtag', $hashtag);
}

