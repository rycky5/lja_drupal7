<?php


// Criando o array que conterá as notícias
$arrNodeJson = array();

// Se for a primeira tela sem filtro true
$bolCaderno = (arg(2) == "all") ? true : false;

if($bolCaderno){
  // Recuperando o resultado da views
  $arrObjNode =  $view->result;
}else{
  // Formatando a string
  $strCaderno =  "caderno_" . arg(2);
  
  // Recupernando a views pelo caderno informado
  $arrObjNode = views_get_view_result('app_android', 'app_android', $strCaderno);
}

// Realizando a interação para montagem do array de notícia
foreach($arrObjNode as $intChave => $objNodeView){
  // Recuperando a notícia
  $objNode = $objNodeView->_field_data["nid"]["entity"];
  
  // Recuperando o link da notícia
  $strLink = url(drupal_lookup_path('alias',"node/".$objNode->nid), array("absolute"=>true));
  
  $strChapeu = "";
  if($bolCaderno){
    // Recuperando os cadernos
    $arrCadernos = getCadernos();
    
    // Setando o caderno pelo tipo de conteúdo
    $strChapeu = $arrCadernos[$objNode->type];
  }else{
    // Recupernado o TID
    $intTid = $objNode->field_tags[key($objNode->field_tags)][0]["tid"];
    
    // Lendo a taxonomya na base
    $objTaxonomia = taxonomy_term_load($intTid);
    
    // Recuperando ao nome da taxonomia
    $strChapeu = $objTaxonomia->name;
  }
  
  // Criando o link da imagem de capa
  $strCapa = "";
  
  // Pegand a imagem de capa se não pego uma imagem
  if(!empty ($objNode->field_capa[key($objNode->field_capa)][0]["uri"]))
        $strCapa = $objNode->field_capa[key($objNode->field_capa)][0]["uri"]; 
  else  if(!empty ($objNode->field_image[key($objNode->field_image)][0]["uri"]))    
        $strCapa = $objNode->field_image[key($objNode->field_image)][0]["uri"];
  
  // Criando o link para a imagem
  $strCapa = ($strCapa != "") ? image_style_url('thumbnail', $strCapa) : "";
  
  // Criando a notícia que será renderizada no json
  $objNodeJson = new stdClass();
  
  // Setando os valores na notícia
  $objNodeJson->title   = $objNode->title;
  $objNodeJson->corpo   = str_replace("\"", "'", retiraHash($objNode->body[key($objNode->body)][0]["value"]));
  $objNodeJson->imagem  = $strCapa;
  $objNodeJson->data    = date("d/m/Y H:i", $objNode->created);
  $objNodeJson->chapeu  = $strChapeu;
  $objNodeJson->link    = $strLink;
  
  // Setando o objeto json
  $arrNodeJson[] = $objNodeJson;
}


echo json_encode($arrNodeJson);die;