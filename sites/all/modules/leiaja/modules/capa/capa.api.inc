<?php
/**
 * Arquivo que conterá as validações do modulo
 * 
 * @author Alberto Medeiros 
 */
// includes necessários
module_load_include('inc', 'capa', 'capa.db');


/**
 * Método que irá validar/salvar os dados da montagem de capa 
 * 
 * @param array $arrDados 
 * @return void
 */
function api_salvar_capa(array $arrDados){
  
  // Válidando os dados para montagem da capa
  if(empty ($arrDados["arrDadosCapa"]))     throw new Exception("Favor Selecionar Blocos para a capa!");
  if($arrDados["intIdCapa"] == "")          throw new Exception("Favor Selecionar a capa para montagem!");
  if($GLOBALS['user']->uid == 0)            throw new Exception("Usuário não tem permissão para salvar a capa!");
  
  // Desativando a capa anterior
  db_excluir_capa($arrDados["intIdCapa"]);
  
  // Montando os dados para salvar a capa
  $arrDadosCapa = array();
  $arrDadosCapa["uid"] = $GLOBALS['user']->uid;
  $arrDadosCapa["criacao"] = date("Y-m-d H:i:s");
  $arrDadosCapa["capa"] = $arrDados["intIdCapa"];
  $arrDadosCapa["status"] = 1;
  
  // Salvando a capa e recuperando o id
  $intIdCapa = db_salvar_capa($arrDadosCapa);
  
  // Iniciando o array de dados de posição
  $arrDadosPosicao = array();
  $arrDadosPosicao["id_capa_posicao"] = $intIdCapa;
    
  // Percorrendo o array de posições para salvar as posições da capa
  foreach($arrDados["arrDadosCapa"] as $intPosicao => $arrDadosBloco){
    
    // Setando os dados das posições
    $arrDadosPosicao["entidade_pai"] = $arrDadosBloco[0];
    $arrDadosPosicao["delta"] = $arrDadosBloco[1];
    $arrDadosPosicao["posicao"] = ++$intPosicao;
    $arrDadosPosicao["tipo_entidade"] = "bloco";
    
    // Salvando a posição na base
    db_salvar_posicao($arrDadosPosicao);
  }
  
}


/**
 * Método que irá retornar um array de objetos dos blocos da capa
 * 
 * @param int $intCapa
 * @return ArrayObject 
 */
function api_listar_blocos_por_capa($intIdCapa){

  // Realizando casts
  $intIdCapa = (int) $intIdCapa;
  // Validando os capos
  if($intIdCapa == 0)   throw new Exception("Favor Informar a capa!");
  // Retornando o resultado
  return db_listar_blocos_por_capa($intIdCapa);
}

function api_view_block($arrObjNodes, $variaveis = array()){

  $result_views['arrObjNodes'] = $arrObjNodes ;
  $result_views['qtde'] = $variaveis['qtd'];
  $result_views['nome'] = $variaveis['viewname'];

  return theme($variaveis['theme'], $result_views);
}


/**
 * Método que irá retornar todas as capas ativas que podem ser configuradas
 * 
 * @return ArrayObject 
 */
function api_get_capa(){
  return db_get_capa();
}

/**
 * Método que irá retornar os blocos do sistema
 * 
 * @return ArrayObject 
 */
function api_list_blocks(){
  return  db_list_blocks();
}

//função para obter as views do cahce ou setar os resultados em cache
function getViews($vars = array()){
    
     //verificando qual o nome do cache.
     if(!empty($vars['view_dispaly'])){
        $nomeDisplay = $vars['view_dispaly'];
        $nomeCache = $vars['viewname'].'_'.$vars['view_dispaly'];
     }else{
        $nomeDisplay= NULL;
        $nomeCache=$vars['viewname'];
     }
     
//     if($vars['viewname'] == 'capa_multi_tvleiaja_abas'){
//        echo '<pre>';
//        var_dump($nomeCache);
//        die;
//     }
    
    $cacheViews = cache_get($nomeCache);
    if(empty($cacheViews)){
       $resultViews = views_get_view_result($vars['viewname'], $nomeDisplay);
       cache_set($nomeCache, $resultViews,'cache_page',CACHE_TEMPORARY);
       $retorno = $resultViews;
    }else{$retorno = $cacheViews->data;}
    
    return $retorno;
}

//função para obter o html dos blocos a serem usados nas tpl
function getHtmlBloco($arrObj, $nomeTema, $qtde){
  
   $arrayResul = array_splice($arrObj,$qtde); 
   $arrVars['arrObjNodes']  = $arrObj;
   $arrVars['qtde'] = $qtde;
   $result['array'] = $arrayResul;
   $result['html'] = theme($nomeTema, $arrVars);
    
    return $result;
}

function getViewCacheTt($vars = array()){
  $vars['qtd'];
  $result = array();
  $cacheViews = cache_get($vars['viewname']);
   
    if(empty($cacheViews->data)){
        $viewTt = views_get_view_result($vars['viewname']);
        $viewsImg = views_get_view_result('capa_multimidia_imagens');
        $viewPcast = views_get_view_result('capa_multimidia_podcasts');
        $viewVideo = views_get_view_result('capa_multimidia_videos');

        //excluindo os elemetos que pertencem aos arrays de Imagens, ou de Videos, ou de Podcast
        foreach ($viewTt as $key=>$value) {
             if($value->node_title == $viewsImg[$key]->node_title || $value->node_title == $viewPcast[$key]->node_title || $value->node_title == $viewVideo[$key]->node_title ){
                 unset($viewTt[$key]);
             }      
        }
        //extraindo as 7 primeiros occorencias do array 
        $result = array_slice($viewTt, 0, 7);
        //setando o cache
        cache_set($vars['viewname'], $result);
        $cacheViews = cache_get($vars['viewname']);
   }
       
    $cacheFinal = $cacheViews->data;
    $cacheTratarSobra = array_splice($cacheFinal,$vars['qtd']);
    //setando ($cacheTratarSobra - $vars['qtd'])  no cache
    cache_set($vars['viewname'], $cacheTratarSobra);

    return $cacheFinal;
}

// Refinando o resultado da views considerando a ornação dinâmica
function setVectorViews($qtde, $arrayObjs){
    
    $result_views = array();
    $cont=0;
    
    for($i=0;$i<$qtde;$i++){
      $result_views['arrObjNodes'][$i] = $arrayObjs[$i];
    }
    return $result_views;
}
/**
 *
 * @param type $node
 * @return type array com os campos do objeto passado
 */

function filtrarCampos($node){
    
//função ara transformar um objeto em array
  $obj['nid']  = $node->nid;
//função ara transformar um objeto em array
  $obj['image_style']  = (!empty($node->image_style)?$node->image_style:'medium');
  //setando o titulo à variável
  $obj['titulo']  = strip_tags($node->node_title);
  $chave = key($node->_field_data);
  //setando a data de criacao
  $obj['criacao']  =  $node->_field_data[$chave]["entity"]->created;
  //setando a data de criacao
  $obj['atualizacao']  =  $node->_field_data[$chave]["entity"]->changed;
  
  //setando a img de capa à variável
  $imgCapa        = $node->_field_data[$chave]["entity"]->field_capa["pt-br"][0]["uri"];
  //setando a img à variável
  $imagem         = $node->_field_data[$chave]["entity"]->field_image["pt-br"][0]["uri"];
  //fazendo a verificação se a img de capa existe. caso exista para ser setada à variavel;
  $img            = (!empty($imgCapa)?$imgCapa:$imagem);
  //setando a uri
  $obj['uri']     = $img;
  //funcao retorna a url da imagem no image_style desejado.
//  $obj['urlImg']  = image_style_url($obj['image_style'],$img); 
  $obj['urlImg']  = image_static_url($obj['image_style'],$img);  
  //podcast
  $obj['podcast']  = $node->_field_data[$chave]["entity"]->field_audiost["und"][0]["value"];
  if($obj['podcast'])
    $obj['podcast_id']  = api_recuperar_idVideo($obj['podcast']);
  
  /**
   * Tratamento do conteúdo:
   * setando o conteúdo à variável efetuando o tratamento necessário.
   */
  //variavel que recebe o corpo
  $corpo    = $node->_field_data[$chave]["entity"]->body["pt-br"][0]["value"];
  //variavel que recebe o corpo
  $resumo   = $node->_field_data[$chave]["entity"]->body["pt-br"][0]["summary"];
  //variavel que verifica se o resumo foi setado.
  $conteudo = (!empty($resumo)?$resumo:$corpo);
  //setando à posição conteúdo no array com o objeto
  $obj['conteudo'] = truncate_utf8($conteudo,400,true, true);
  //verificando se há alguma tag multimidia(galeria, podcast,video)
  $search=array('[@#galeria#@]','[@#podcast#@]','[@#video#@]','##RECOMENDA##');
  foreach($search as $tag):
    $obj['conteudo']  = str_replace($tag, "", $obj['conteudo']);
  endforeach;
  $obj['conteudo']  = strip_tags($obj['conteudo']);
  /**
   * fim tratamento do conteúdo;
   */
  
  //variavel que recebe o type
  $tipoConteudo   = $node->_field_data[$chave]["entity"]->type;
  //variavel recebe as variaveis do objeto
  $vars = get_object_vars($node);
  //funcao retorna a categoria do node;
  $nomeTaxy       = getCategoria($vars);
  //atribuindo a variavel o valor do chapeu;
  if(!empty($node->{$nomeTaxy})){
   $obj['chapeu']  = $node->{$nomeTaxy}[0]['rendered']['#title'];
  //atribuindo a variavel o link da categoria/chapeu;
  $obj['linkChapeu']  =  url(drupal_lookup_path('alias',$node->{$nomeTaxy}[0]['rendered']['#href']));
  }
  //setando o link
  $obj['link']     = url(drupal_lookup_path('alias',"node/".$node->nid));
  //retornando objeto com os campos.
  return $obj;
}

///**
// * Método que irá
// * @param String $string
// * @return String 
// */
//function retiraHash($string) {
//    // Retirando as hash de marcação
//    return str_replace("[@#galeria#@]", "", str_replace("[@#podcast#@]", "", str_replace("[@#video#@]", "", $string)));
//}

/**
 * Método que irá receber o array de notícias e irá validar a montagem para a imagem de capa
 * 
 * @param array $arrObjNodes
 * @return Array
 */
function api_corrigeImageCapa(array $arrObjNodes){
  
  if(is_array($arrObjNodes)){
    foreach($arrObjNodes as $intChave => $objViewNode){
      
      //fazendo a verificação se a img de capa existe. caso exista para ser setada à variavel;
      $arrCapa  = (!empty($objViewNode->field_field_capa))
                    ? $objViewNode->field_field_capa
                    : $objViewNode->field_field_image;
      
      // Setando a imagem de capa
      $objViewNode->field_field_capa = $arrCapa;
      
      // Setando de novo no array
      $arrObjNodes[$intChave] = $objViewNode;
    }
  }
  // Retornando a categoria
  return $arrObjNodes;
}

/**
 * Método que irá receber a notícia e irá retornar o sub caderno dela
 * 
 * @param stdClass $node 
 * @return Array
 */
function api_getCategoria($node){
  // Iniciando a váriável
  $arrSubCaderno = array();
  
  //variavel recebe as variaveis do objeto
  $vars = get_object_vars($node);
  
  // Pegando o caderno
  $strField = api_getCategoriaPorCaderno($node->_field_data[$chave]["entity"]->type);
  
  //atribuindo a variavel o valor do chapeu;
  if(!empty($node->{$strField})){
    // Pegando o titulo do subcaderno
    $arrSubCaderno['chapeu']  = $node->{$strField}[0]['rendered']['#title'];
    //atribuindo a variavel o link da categoria/chapeu;
    $arrSubCaderno['linkChapeu']  =  url(drupal_lookup_path('alias',$node->{$strField}[0]['rendered']['#href']));
    
    $obj = taxonomy_term_load($node->_field_data[$chave]["entity"]->field_tags["pt-br"][0]["tid"]);
    
    // Primeira tag
    $arrSubCaderno['intTidTag'] = $obj->tid;
    $arrSubCaderno['strTag'] =  $obj->name;
  }
  
  // Retornando a categoria
  return $arrSubCaderno;
}


/**
 * Método que irá retornar o nome do fiel do caderno
 * 
 * @param String $strCaderno 
 * @return String $strField
 */
function api_getCategoriaPorCaderno($strCaderno){
  
  // Iniciando a variável field
  $strField = "";
  
  // Selecioando o nome do field
  switch($strCaderno){
    case "caderno_esportes":
        $strField =  "field_field_catesporte";
      break;
  }
  // Retornando o field
  return $strField;
}

/**
 * Método que irá receber a notícia e ira retornar a string da imagem
 * 
 * @param stdClass $not
 * @return String 
 */
function getImgCapa($not){
  //setando a img de capa à variável
  $imgCapa        = @$not->_field_data[0]["entity"]->field_capa["pt-br"][0]["uri"];
  //setando a img à variável
  $imagem         = @$not->_field_data[0]["entity"]->field_image["pt-br"][0]["uri"];
  //fazendo a verificação se a img de capa existe. caso exista para ser setada à variavel;
  return (!empty($imgCapa)?$imgCapa:$imagem);
}

function api_getCache($cid = ''){

  //setando o cache na variavel
  $cacheNidCapa = cache_get($cid,'cache_page');
  //verificando se o cache foi setado;
  if(empty($cacheNidCapa->data) or !$cacheNidCapa):
    $arrCapa = array("capa"=>db_getCapa());
    //setando o cache com a chave passada no parametro
    //declarando a variavel array que receberá os nid's;
    $arrNids = array();
    //setando os nid's ao array;
    $arrObjNid = db_getCapa();
    foreach ($arrObjNid as $value) {
      $arrNids[] = $value->nid;
    }
    //separando os nid's por vírgula para ser passado na view.
    $vNotIn = implode(',',$arrNids);
    
    cache_set($cid,$vNotIn,'cache_page',CACHE_TEMPORARY);
    variable_set('flag_bloco_geral', 0);
    
    return $vNotIn;
  endif;
  
  return $cacheNidCapa->data;
}

function setIgnoreCapa($cid, $strIgnore){
  // Set ids para o ignore
  cache_set($cid, $strIgnore);
}

/**
 *
 * @return type string;
 */
function api_getNidIgnore(){
  // add à variavel os nids que já foram usados na montagem da capa
  $arrObjNid = api_getCache('nidsCapa');
  
  return $arrObjNid;
}

function api_IgnoreBlocoGeral($nids){
    
    $flag = variable_get('flag_bloco_geral');
    
    if(!$flag or ($flag!==1)){
        //setando o cache com a chave passada no parametro
        cache_set('nidsCapa', $nids,'cache_page',CACHE_TEMPORARY);
        variable_set('flag_bloco_geral', 1);
    }
}