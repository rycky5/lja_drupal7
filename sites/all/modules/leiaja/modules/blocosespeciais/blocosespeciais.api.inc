<?php
/**
 * Arquivo que conterá as regras de negócio do módulo
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */

// Includes necessários
module_load_include('inc', 'blocosespeciais', 'blocosespeciais.db');
module_load_include('inc', 'capa', 'capa.api');


function api_salvar_capa_ig($arrDados){
    
  if(empty ($arrDados))    throw new Exception("Erro: Não foi informado nenhum dado!!!");
  
  // Criando o array que conterá as nodes da paca
  $arrDadosCapa = array();
  $arrNodeCapa = array();
  $arrCapa = array();
  
  // Percorrendo o array de post
  foreach($arrDados["capa"] as $intchave=>$strDados){
    // Criando o array
    $arrCapa = explode(";", $strDados);
    
    // Setando os dados 
    $arrNodeCapa[$intchave]["posicao"] = $arrCapa[0];
    $arrNodeCapa[$intchave]["nid"]     = $arrCapa[1];
    $arrNodeCapa[$intchave]["origem"]  = $arrCapa[2];
  }
  
  // Pegando os dados pra salvar a capa
  $arrDadosCapa["uid"] = $GLOBALS['user']->uid;
  $arrDadosCapa["data_cadastro"] = date("Y-m-d H:i:s");
  $arrDadosCapa["status"] = 1;
  $arrDadosCapa["tipo_capa"] = $arrDados["template"];
  $arrDadosCapa["tipo_bloco"] = $arrDados["tipoBloco"];
  
  // Salvando na base os dados da capa e da node
  db_salvar_capa_ig($arrDadosCapa, $arrNodeCapa);
  
}

/**
 * Método que ira retornar as notícias de um determinado caderno
 * 
 * @param String $vCaderno
 * @return ArrayObject 
 */
function api_noticiasPorCaderno($vCaderno = false)
{
  
  // Váriavel que contera as ultimas notícias
  $vUltimas = null;
    
  // Recuperando a variavel do servidor
  $arrServidores = variable_get("arrServidores");

  // Caso seja um conteudo de outro servidor
  if(!empty ($arrServidores[$vCaderno])){
    $vUltimas = db_noticiasPorBlogs($vCaderno);
  }else{
    // caso seja um conteudo interno do leiaja
    $vUltimas = db_noticiasPorCaderno($vCaderno);
  }
  
  // Retornando o array de notícias
  return $vUltimas;
}


/**
 * Método que irá retornar as notícias que ira montar o template da capa
 * 
 * 
 * Cotem Dependência do método  api_ajax_carreganode
 * 
 * @return ArrayObject 
 */
function api_carregaNodesTemplate($intCapa = null, $tipo_bloco = null){
  
  // Verificando se o id da capa foi informado
  $intCapa = (empty ($intCapa)) ? 1 : $intCapa;
  //Verificando se o tipo do bloco foi informado
  $tipo_bloco = (empty($tipo_bloco)) ? "leiaja" : $tipo_bloco;
  
  // Cirando o array de noticias que será retornado para montar a capa
  $arrObjNodeCapa = array();
  
  // Carregando a lista de notícias da capa do IG
  $arrObjNodeLista = db_getCapaAtiva($intCapa, $tipo_bloco);
  
  // Se for vazio o retorno
  if(!empty ($arrObjNodeLista)){
    // Percorrendo as nodes da capa
    foreach ($arrObjNodeLista as $objNode){
      // Iniciando o array de busca
      $arrDados = array();
      $arrDados["intNId"] = $objNode->nid;
      $arrDados["strOrigem"] = $objNode->origem;
      
      
      // Recuperando a node
      $objNodeCapa = api_ajax_carreganode($arrDados);
      @$objNodeCapa->posicao  = $objNode->posicao;
      @$objNodeCapa->origem   = $objNode->origem;
      @$objNodeCapa->nid      = $objNode->nid;

      // Setando no array de nodes
      $arrObjNodeCapa[] = $objNodeCapa;
      
    }
    
  }else{
    $arrObjNodeCapa = false;
  }
  
  // Retornando o array que deverá montar a capa
  return $arrObjNodeCapa;
}

/**
 * Método que ira retornar um objeto customizado de notícia
 * 
 * ********************************************************
 * Esse método é usado acima para carregar as nodes para popular a capa
 * ******************************************************
 * 
 * @param array $arrDados
 * @return stdClass 
 */
function api_ajax_carreganode($arrDados){
  
  // Recuperando os ids que estão montado a parte superior
  $strNidIgnode = getIgnoreCapa();
  
  // Setando os identificadores a serem ignorados
  $arrDados["strNidIgnode"] = $strNidIgnode;
  
  // Retornando a node
  $objNode = db_ajax_carreganode($arrDados);
  
  if($arrDados["strOrigem"] == "default"){
    /************************ 
     * FORMATANDO A NOTÍCIA DO LEIAJÁ
     **************$objNode**********/

    // Método que recebe a node e ira retornar a categoria
    $strCategoria = api_getFieldCategoriaPorCaderno($objNode);

    // Pegando a chave
    $strLinguagem = key($objNode->{$strCategoria});

    // Lendo o subcaderno da notícia
    $objSubCaderno = api_getSubCaderno($objNode->{$strCategoria}[$strLinguagem][0]["tid"]);

    // Pegando a chave
    $strLinguagem = key($objNode->field_tags);

    // Lendo o Chapeu
    $objTaxonomia = api_getSubCaderno($objNode->field_tags[$strLinguagem][0]["tid"]);

    // Criando o objeto node que irá ser retornado 
    $objNodeRetorno = api_getNodesCapa($arrDados);
    
    $objNodeRetorno->imagem = str_replace("http://igpernambuco.leiaja.com", "", image_style_url('medium', api_getImageCapa($objNode)));
    $objNodeRetorno->subcategoria = $objSubCaderno->name;
    $objNodeRetorno->chapeu = $objTaxonomia->name;
    
  }else // Caso a notícia seja de outro servidor a mesma deverá vir formatada
    $objNodeRetorno = $objNode;
  
  // Retornando o objeto node montado
  return $objNodeRetorno;
}


/**
 * Método que irá retornar o nome do fiel de categoria do caderno pela node informada
 * 
 * @param sdtClass $node 
 * @return String $strField
 */
function api_getFieldCategoriaPorCaderno($node){
  
  // Iniciando a variável field
  $strField = "";
  
  // Selecioando o nome do field
  switch($node->type){
    case "caderno_esportes":
        $strField =  "field_catesporte";
      break;
    case "caderno_carreiras":
        $strField =  "field_catnegocios";
      break;
    case "caderno_cultura":
        $strField =  "field_catcultura";
      break;
    case "caderno_tecnologia":
        $strField =  "field_cattecnologia";
      break;
    case "caderno_noticias":
        $strField =  "field_catnoticia";
      break;
    case "caderno_multimidia":
        $strField =  "field_catradiotv";
      break;
    case "caderno_colunistas":
        $strField =  "field_catcolunista";
      break;
    case "caderno_politica":
        $strField =  "field_catpolitica";
      break;
    case "blogs_da_redacao":
        $strField =  "field_catblog";
      break;
  }
  // Retornando o field
  return $strField;
}

/**
 * Método que irá receber a notícia e irá retornar a imagem que deve ser usada se imagem de capa ou imagem
 * 
 * @param strClass $objNode
 * @return String
 */
function api_getImageCapa($objNode){
  
  // Liguagem
  $strImagemCapa = key($objNode->field_capa);
  $strImagem     = key($objNode->field_image);
  
  //setando a img de capa à variável
  $imgCapa        = $objNode->field_capa[$strImagemCapa][0]["uri"];
  //setando a img à variável
  $imagem         = $objNode->field_image[$strImagem][0]["uri"];
  
    
  //fazendo a verificação se a img de capa existe. caso exista para ser setada à variavel;
  return (!empty($imgCapa)?$imgCapa:$imagem);
}

/**
 * Método que irá retornar o sub caderno ou a taxonomia informada 
 * 
 * @param int $intTId
 * @return stdClass 
 */
function api_getSubCaderno($intTId){
  
  // Lendo a taxonomia
  $objTaxonomia = taxonomy_term_load($intTId);
  
  // Retornando a taxonomia 
  return $objTaxonomia;
}


/**
 * Método que irá retornar os nodes da capa ativos
 * 
 * @return ArrayObject 
 */
function api_getCapaAtiva(){
  
  
  // Carregando a lista de notícias da capa do IG
  $arrObjNodeLista = db_getCapaAtiva();
  
  // Se for vazio o retorno
  if(!empty ($arrObjNodeLista)){
    // Percorrendo as nodes da capa
    foreach ($arrObjNodeLista as $objNode){

      $arrDados = array();
      $arrDados["intNId"] = $objNode->nid;
      $arrDados["strOrigem"] = $objNode->origem;

      // Recuperando a node
      $objNodeCapa = api_getNodesCapa($arrDados);
      
      // Setando no array de nodes
      $arrObjNodeCapa[] = $objNodeCapa;
    }
  }else{
    $arrObjNodeCapa = false;
  }
  // Retornando o array que deverá montar a capa
  return $arrObjNodeCapa;
  
  
}


/**
 * Método que ira retornar um objeto customizado de notícia
 * 
 * ********************************************************
 * Esse método é usado acima para carregar as nodes para popular a capa
 * ******************************************************
 * 
 * @param array $arrDados
 * @return stdClass 
 */
function api_getNodesCapa(array $arrDados){
  
  
  // Retornando a node
  $objNode = db_ajax_carreganode($arrDados);
  
  if($arrDados["strOrigem"] == "default")
    // Retornando a node formatada
    return api_formataNodeCapa($objNode);
  else
    // Caso a notísia seja de outro servidor a mesma já foi previamente formatada
    return $objNode;
}

/**
 * Método que irá receber a node por parametro e irá retornar a mesma formatada
 * 
 * @param stdClass $objNode
 * @return stdClass 
 */
function api_formataNodeCapa($objNode){
  /************************ 
   * FORMATANDO A NODTÍCIA
   ************************/
  
  
  // Método que recebe a galeria
  $strCategoria = api_getFieldCategoriaPorCaderno($objNode);
  
  // Pegando a chave
  $strLinguagem = key(@$objNode->{$strCategoria});
  
  // Lendo o subcaderno da notícia
  $objSubCaderno =  api_getSubCaderno(@$objNode->{$strCategoria}[$strLinguagem][0]["tid"]);
 
  // Pegando a chave
  $strLinguagem = key(@$objNode->field_tags);
  
  // Lendo o Chapeu
  $objTaxonomia = api_getSubCaderno($objNode->field_tags[$strLinguagem][0]["tid"]);
  
  // Pegando a linguagem da chamada de capa
  $strLinguagemChamada = key($objNode->field_chamada_capa);
  
  // Chamada de capa
  $strChamadaDeCapa = @$objNode->field_chamada_capa[$strLinguagemChamada][0]["value"];
  
  // Criando o objeto node que irá ser retornado 
  $objNodeRetorno                 = new stdClass();
  $objNodeRetorno->nid            = $objNode->nid;
  $objNodeRetorno->summary        = (!empty ($objNode->body["pt-br"][0]["summary"])) ? $objNode->body["pt-br"][0]["summary"] : limitaTexto(retiraHash(strip_tags($objNode->body["pt-br"][0]["value"])), 96);
  $objNodeRetorno->title          = (!empty ($strChamadaDeCapa)) ? $strChamadaDeCapa : $objNode->title;
  $objNodeRetorno->imagem         =  api_getImageCapa($objNode);// Imagem seja de capa ou a primeira da galeria
  $objNodeRetorno->subcategoria   = $objSubCaderno->name; // Taxonomia do sub caderno
  $objNodeRetorno->tidSubCaderno  = $objSubCaderno->tid;// TID Sub caderno da notícia
  $objNodeRetorno->chapeu         = $objTaxonomia->name;// Tag
  $objNodeRetorno->tidChapeu      = $objTaxonomia->tid;// Tid do chapeu que é a primeira tag
  $objNodeRetorno->abrirLeiaja    = verificaConteudoMultimidia($objNode)->abrirLeiaja; // Caso necessário abrir no leiaja essa flag será o delimitador
  $objNodeRetorno->origem         = "default"; // Origem da notícia pra saber de onde ela é
  $objNodeRetorno->linkSubCaderno = url(drupal_lookup_path('alias',"taxonomy/term/". $objNodeRetorno->tidSubCaderno));
  $objNodeRetorno->linkChapeu     = "http://www.leiaja.com"  .  url(drupal_lookup_path('alias',"taxonomy/term/". $objNodeRetorno->tidChapeu));
  $objNodeRetorno->link           = getLinkNode($objNode);
  
  // Recuperando a linguagem do campo redireciona
  $strLinguagem = key($objNode->field_redireciona);
  
  // Setando o campo redireciona
  $objNodeRetorno->redireciona    = $objNode->field_redireciona[$strLinguagem][0]["value"];
  
  // Verificando se o subcaderno apronta pra outro dominio
  if(!strstr($objNodeRetorno->linkSubCaderno, "http://")){
    $objNodeRetorno->linkSubCaderno = "http://www.leiaja.com"  .  $objNodeRetorno->linkSubCaderno;
  }
  
  
  //Retornando o objeto node montado
  return $objNodeRetorno;  
}

/**
 * Método que ira trazer as ultimas galerias do portal
 * 
 * @return ArrayObject
 */
function api_getGaleriasPortal($intInicio = 0, $intFim = 5){
    // Casts Necessários
    $intInicio = (int) $intInicio;
    $intFim = (int) $intFim;
    
    // Recuperando o cache
    $objCache = cache_get('galeriasPortal'.$intInicio.$intFim);
    
    // caso o cache tenha expirado
    if(empty($objCache)){
      // Recuperando as notícias
      $arrObjNode = db_getGaleriasPortal($intInicio, $intFim);
      // Setando o cache 
      cache_set('galeriasPortal'.$intInicio.$intFim,$arrObjNode,'cache_page', time() + 5 * 60);
      
      // Retornando as nodes
      return $arrObjNode;
    }else// Caso tenha cache retorno o resultado do mesmo
      return $objCache->data;
}

/**
 * Método que irá receber a notícia e irá retonar a visualização do seu html montado
 * 
 * @param stdClass $objNode
 * @return String 
 */
function api_render_node($objNode){
  
  // Validando o parametro
  if(!is_object($objNode))    throw new Exception("Erro: Houve algum erro no site! Descupenos os transtorno!");
  
  // Renderizando a node
  $strHtmlNode = render(node_view($objNode));
  
  // Retornando  a visualização da notícia
  return $strHtmlNode;
}


/**
 * Método que irá retornar um Json com as ultimas notícias do leiaja
 * 
 * ****
 *  Será utilizado para integração com o IG
 * ****
 * 
 * @return Json
 */
function api_ajax_integracao_ig(){
  //  Recuperando a capa montada para o IG
  $arrObjNode = db_getCapaAtiva(2);
  
  // Recuperando a ultima node inserida na lista
  $strData = db_getUltimaAtualizacao(2);
  
  // Pegando a data de atualização
  $strDataAtualizacao = $strData;
  
  // Array para carregar as nodes
  $arrDados = array();
  
  // Array com as chamadas
  $arrChamadas = array();
  foreach($arrObjNode as $intChave => $objNodeView){
    // Setando a origem
    $arrDados["strOrigem"] = $objNodeView->origem;
    
    // Setando o id da node
    $arrDados["intNId"] = $objNodeView->nid;
    
    // Recuperando a node
    $objNode = api_getNodesCapa($arrDados);
    
    // Caso a origem seja default
    if($objNodeView->origem == "default"){
      // Caso tenha um redirecionae a imagem tenha galeria
      if($objNode->abrirLeiaja)
        $strLink = (!empty ($objNode->redireciona)) ? $objNode->redireciona : "http://www.leiaja.com" .  url(drupal_lookup_path('alias',"node/".$objNode->nid));
      else
        $strLink = (!empty ($objNode->redireciona)) ? $objNode->redireciona : "http://pernambuco.ig.com.br/" .  url(drupal_lookup_path('alias',"node/".$objNode->nid));
    }else{
      $strLink = $objNode->link;
    }
    // incrementando a chave
    $intChave++;
    
    // Pegando a linguagem
    $strLinguagemChamada = key($objNode->field_chamada_capa);
    
    // Chamada de capa
    $strChamada = @$objNode->field_chamada_capa[$strLinguagemChamada][0]["value"];

    // Pegando a chamda de capa
    $strChamadaDeCapa = (!empty ($strChamada)) ? $strChamada : $objNode->title;
    
    $strImagem = ($intChave == 2 || $intChave == 5) ? 
                                          ($objNodeView->origem == "default") ? image_style_url('large', $objNode->imagem) : $objNode->imagem
                                      : "";
    // Criando o array com a chamada
    $arrChamada = array(
                          "chapeu" => (!empty ($objNode->subcategoria)) ? $objNode->subcategoria : $objNode->chapeu,
                          "titulo" => $strChamadaDeCapa,
                          "olho" => "",
                          "link" => $strLink,
                          "imagem" => $strImagem
                        );
    
    // Setando o obeto node no array de nodes
    $arrChamadas["chamada{$intChave}"] = $arrChamada;
  }
  
  // Criando o array que será retornado como json
  $arrDados = array("noticias"=>
                            array("dataAtualizacao"=>$strDataAtualizacao,
                                  "chamadas"=>$arrChamadas));
  
  // Retornando o resultado
  return $arrDados;
}

/**
 * Método que irá retornar os identificadores que estão sendo usados na capa
 * 
 * @return string 
 */
function getIgnoreCapa(){
    
    // Recuperando o cache
    $objCache = cache_get("ignorenodetopo", "cache_page");
    
    // caso o cache tenha expirado
    if(empty($objCache)){
        
      // Carregando a lista de notícias da capa do IG
      $arrObjNode = db_getCapaAtiva();
      
      // Iniciando array
      $arrNid = array();

      // Realizando a interação
      foreach($arrObjNode as $objNode){
        $arrNid[] = $objNode->nid;
      }

      // Iplodindo os arrays que estão na caba
      $strNidIgnode = implode(",", $arrNid);
      
      // Setando o cache 
      cache_set('ignorenodetopo',$strNidIgnode,'cache_page', time() + 5 * 60);
      
      // Retornando as nodes
      return $strNidIgnode;
    }else// Caso tenha cache retorno o resultado do mesmo
      return $objCache->data;
}

/**
 * Método que irá montar o link da notícia 
 * 
 * @param stdClass $objNode
 * @param bolean $debug
 * @return string 
 */
function getLinkNode($objNode, $debug = false){
  
  // Criando link
  $objNodeMultimidia = verificaConteudoMultimidia($objNode, true);
  
  // Criando o link
  $strLink =   'href="' . (($objNodeMultimidia->abrirLeiaja) ? 'http://www.leiaja.com' : '');
  $strLink .=   url(drupal_lookup_path('alias',"node/".$objNode->nid)) .'"';
  
  // Retornando o link
  return $strLink;
}


/**
 * Método que irá receber o array de notícias e irá validar a montagem para a imagem de capa
 * 
 * @param array $arrObjNodes
 * @return Array
 */
function api_getImageCapaView(array $arrObjNodes){
  
  // Validações
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
 * Método que irpa receber a node por url e irá  tratalá para usar o lazy loading
 * 
 * @param stdClass $objNode
 * @param String $strEstilo
 * @param int $intAltura
 * @param int $intLargura
 * @param array $arrClasses
 * @return string 
 */
function api_geraImagem($objNode, $strEstilo, $intLargura = 250, $intAltura = 250,$arrClasses = array()){
  
  // Criando o array de notícias
  $img = array();
  $img['style']   = $strEstilo;
  $img['uri']     = $objNode->imagem;
  $img['class']   = $arrClasses;
  $img['alt']     = $objNode->title;
  $img['title']   = $objNode->title;
  $img['width']   = $intLargura;
  $img['height']  = $intAltura;

  // Retornando a img
  return image_static_lazy($img);
}

//Recupera as nodes do bloco leiaja
function api_getNodesInLeiajaBlock(){
  $db_nodes = db_getCapaAtiva('2', 'leiaja');
  $obj_node = '';
  $nodes = array();
  
  foreach($db_nodes AS $node){
    $obj_node = node_load($node->nid);
    $nodes[] = api_formataNodeCapa($obj_node);
  }
  return $nodes;
}
//Recupera as nodes do bloco carnaval
function api_getNodesInCarnavalBlock(){
  $db_nodes = db_getCapaAtiva('2', 'carnaval');
  $obj_node = '';
  $nodes = array();
  
  foreach($db_nodes AS $node){
    $obj_node = node_load($node->nid);
    $nodes[] = api_formataNodeCapa($obj_node);
  }
  return $nodes;
}
//Recupera as nodes do bloco Copa
function api_getNodesInCopaBlock(){
  $db_nodes = db_getCapaAtiva('2', 'copa');
  $obj_node = '';
  $nodes = array();
  
  foreach($db_nodes AS $node){
    $obj_node = node_load($node->nid);
    $nodes[] = api_formataNodeCapa($obj_node);
  }
  return $nodes;
}
//Recupera as nodes do bloco eleicoes
function api_getNodesInEleicoesBlock(){
  $db_nodes = db_getCapaAtiva('2', 'eleicoes');
  $obj_node = '';
  $nodes = array();
  
  foreach($db_nodes AS $node){
    $obj_node = node_load($node->nid);
    $nodes[] = api_formataNodeCapa($obj_node);
  }
  return $nodes;
}
//Recupera as nodes do bloco saojoao
function api_getNodesInSaoJoaoBlock(){
  $db_nodes = db_getCapaAtiva('2', 'saojoao');
  $obj_node = '';
  $nodes = array();
  
  foreach($db_nodes AS $node){
    $obj_node = node_load($node->nid);
    $nodes[] = api_formataNodeCapa($obj_node);
  }
  return $nodes;
}