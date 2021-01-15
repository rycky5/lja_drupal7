<?php

/**
 * Arquivo resposável por conter as requisições de callback referente a listaufpe
 * 
 * @author Pedro Camará <pedrohcamara@gmail.com>
 */
module_load_include('inc', 'especiais', 'promocoes.api');

/**
 * Método de callback responsável por receber a requisição para Visualização da pagina de resultado
 * 
 */
function lista_promocoes(){
  $cache = cache_get('promocoes_lista');
  
  if(empty($cache)){
    $vars['termos'] = getTermos();
    $vars['participando'] = participando_promo_api();
    //var_dump($vars['participando']);
    $cache = theme('list_promos', $vars);
    
    if($_SERVER['SERVER_ADDR'] != '192.168.201.26')
      cache_set('promocoes_lista',$cache,'cache_page',CACHE_TEMPORARY);
        
    return $cache;
    
  }else{
    return $cache->data;
  }
  
}


function participar_promo($tid){
  $nid = participar_promo_api($tid);
  if($nid){
    echo 'true';
  }else{
    echo 'false';
  }
}

/**
 * Método que ira realizar um filtro / donwload da listagem de telefones 
 * 
 */
function listagem_promo(){
  // Caso seja postado algo
  
  if(!empty($_POST)){
    //var_dump($_POST);
//    // Recuperando os dados postados
//    $strUF      = (string) @$_POST["strUF"];
//    $strCidade  = (string) @$_POST["strCidade"];
//
//    // Criando o array que contera o filtro
//    $arrFiltro = array("strUF" => $strUF, "strCidade" => $strCidade);
//    try {
//
//      // Realizando o filtro
      api_listagem_promo(array('tid' => $_POST["promos"]));
//    } catch (Exception $exc) { }
  }else{
    $arrVars = array();
    
    // Criando o array que será renderizado para TPL
    $arrVars["arrPromos"]      = getTermos();
    
    // Renderizando o thema 
    return theme("list_parti", $arrVars);
  }
}



?>
