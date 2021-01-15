<?php

/**
 * Função que recebe array de objetos Node e retorna string com NIDs.
 *
 * @param Array     $pArr
 * @return String
 */
function getIgnoreNid($pArr = array())
{
    $vIgnore = null;

    foreach($pArr as $vNot)
      $vIgnore[] = $vNot->nid;

    return implode(',',$vIgnore);
}

/**
 * Função que prepara array e envia para o template as avariaves para montagem do MENU.
 *
 * @param type $vars
 */
function init_menu(&$vars)
{

    $vSubCategoriasCache = cache_get('cacheSubCategorias','cache');

    if(empty($vSubCategoriasCache)){
        db_set_active("default"); //"default"
        // Popular variável com as subcategorias de acordo com a taxonomia.
        $result = db_query("SELECT t.tid,t.name,tv.machine_name
                       FROM taxonomy_term_data t
                       INNER JOIN taxonomy_vocabulary as tv ON tv.vid = t.vid
                       WHERE tv.machine_name <> 'tags'
                       ORDER BY t.weight ASC;");

        $vSubCategorias = $result->fetchAll();

       foreach ($vSubCategorias as $sub){
   	$arrSubCategorias[$sub->machine_name][] = array('tid' => $sub->tid, 'title' => $sub->name);
       }

       // Grava ou atualiza o cache.
       cache_set('cacheSubCategorias',$arrSubCategorias,'cache',60*30);
    }else{
      $arrSubCategorias = $vSubCategoriasCache->data;
    }
    $vars['vSubCategorias'] = $arrSubCategorias;

    $vars['corCategoria']  = array('noticias' => 'vermelho',
                                  'carreiras' => 'roxo',
                                  'esportes' => 'verde',
                                  'tecnologia' => 'azulClaro',
                                  'cultura' => 'laranja',
                                  'multimidia' => 'azulClaro');
}

/**
 *
 * Função que verifica se a url é de um subcaderno;
 */
function isSubcaderno()
{
	$url = $_SERVER['REQUEST_URI'];
	if(strstr($url,'/noticias/') || strstr($url,'/cultura/')||strstr($url,'/esportes/')
	  ||strstr($url,'/tecnologia/')||strstr($url,'/carreiras/')||strstr($url,'/negocios/')||strstr($url,'/politica/')){
	  	return true;
	  }
	return false;

}

/**
 *
 * Função que faz a paginação
 * @param unknown_type $pTotal
 * @param unknown_type $pGetUrl
 * @param array $pParams[pQtdPagina]
 */

function paginacao($pTotal, $pGetUrl = '', $pParams = array())
{
   require_once 'lib/class.pagination.php';

	$vPagina = (empty($_GET['page'])) ? 1 : $_GET['page'];

	$oPagination = new Pagination($vPagina, (!empty($pParams['pQtdPagina']) ? $pParams['pQtdPagina'] : 2));
	$oPagination->setTotalRecords($pTotal);

	$oPagination->setGetVars(base_path().$pGetUrl.'?');

	return $oPagination->getFULLNavCP();
}

/*
 * Retorna conteudo HTML processado dos blocos passados no parametro.
 * 
 */
function getBlocos($delta)
{
  $vBlocos = array();
  foreach($delta AS $key => $value){
    if(is_array($value)){
      $vBlocos[] = block_load($value[0],$value[1]);
    }else{
      $vBlocos[] = block_load('block',$value);
    }
  }
     
  return _block_get_renderable_array(_block_render_blocks($vBlocos));
}

function sortByUri($a, $b)
{
  if(empty($a->uri) && !empty($b->uri)){
    return 1;
  }elseif(empty($b->uri) && !empty($a->uri)){
    return -1;
  }else{
    return 0;
  }
}

/**
 * Função que retorna true se o parâmetro for um caderno no formato 'caderno_$note'
 *
 * @param type $note
 */
function varIsCaderno($note)
{
  $cadernos = array('caderno_noticias','caderno_politica','caderno_carreiras','caderno_esportes','caderno_cultura','caderno_tecnologia','caderno_multimidia');

  return in_array($note, $cadernos);
}
/*
 * 
 * Função que identifica qual o template deve ser usado no bloco cadernos (caderno.tpl.php).
 */
function verificaBloco(&$vars, $caderno)
{
    $result ='';
    $vCacheId = 'verificaBloco'.$caderno;
    $verificaCache = cache_get($vCacheId, 'cache');

    if(!$verificaCache){
        $query = db_select('tbblococobertura', 'tbc');
        $query->fields('tbc',array('tid','template','status','cobertura_completa','estilo_caderno','imgbackground','caderno'));
        $query->condition('caderno',$caderno,'=');
        $query->condition('status','1','=');
        $query->orderBy('id','DESC');
        $query->range('0','1');
        //die($query);
        $result = $query->execute()->fetchAll();
        cache_set($vCacheId, $result, 'cache', time() + 60*30);
    }else{
        $result = $verificaCache->data;
    }
    
  if($result){
    switch ($result[0]->template){
        case '1':
            $vars['ComFotos'] = 1;
            $vars['SemFotos'] = 0;
        break;
        case '2':
            $vars['ComFotos'] = 0;
            $vars['SemFotos'] = 1;
        break;
        case '3':
            $vars['ComFotos'] = 2;
            $vars['SemFotos'] = 1;
        break;
        case '4':
            $vars['ComFotos'] = 1;
            $vars['SemFotos'] = 3;
        break;
        case '5':
            $vars['ComFotos'] = 3;
            $vars['SemFotos'] = 2;
        break;
        case '6':
            $vars['ComFotos'] = 1;
            $vars['SemFotos'] = 5;
        break;
        case '8':
            $vars['vCarrocel']    =  getConteudo("'caderno_cultura'", array("pSubcategoria"=>"Sâo João", 'pFotos' => true, 'pPromovido' => true, 'pDestaque' => true, 'pQtd' => 5));
            $vars['vComFoto']     =  getConteudo("'caderno_cultura'", array("pSubcategoria"=>"Sâo João", 'pFotos' => true, 'pPromovido' => true, 'pQtd' => 3, 'pIgnore' => getIgnoreNid($vars['vCarrocel'])));
            $vars['vSemFoto']     =  getConteudo("'caderno_cultura'", array("pSubcategoria"=>"Sâo João", 'pSemFoto' => true, 'pPromovido' => true, 'pDestaque' => true, 'pQtd' => 3));
            $vars['numTemplate']  = '8';
            $vars['cobertura']    = true;
            $vars['vNoticiasTag'] = $vars['vNoticiasTagFotos'] = array('1');
            $vars['ComFotos']     = 0;
            $vars['SemFotos']     = 0;
            
          return true;  
        break;
    }
        $ignore = '';
        $vars['cobertura']         = true;
        $vars['numTemplate']       = $result[0]->template;
        $vars['imgbackground']     = $result[0]->imgbackground;
        $vars['coberturaCompleta'] = $result[0]->cobertura_completa;
        $vars['linkTag']           = url(drupal_lookup_path('alias',"taxonomy/term/".$result[0]->tid));
        $vars['tid']               = $result[0]->tid;
        $vars['caderno']           = $result[0]->caderno;
        $vars['estiloCaderno']     = $result[0]->estilo_caderno;

        if(!empty($vars['ComFotos'])){
            $vParams = array('limit' => $vars['ComFotos'], 'pFotos' => true);
            $vars['vNoticiasTagFotos'] = getNoticiaByTag($result[0]->tid, $vParams);
            $ignore = getIgnoreNid($vars['vNoticiasTagFotos']);
        }

        if(!empty($vars['SemFotos'])){
            $vParams = array('limit' => $vars['SemFotos'], 'pIgnore' => $ignore);
            $vars['vNoticiasTag'] = getNoticiaByTag($result[0]->tid, $vParams);
        }

        return true;
  }
    return FALSE;
}

/**
 * Método que ira receber a node e irá retornar o embed conforme seu tipo
 * 
 * @param String $node
 * @param String $strTipo
 * @return string 
 */
function getEmbedNoticia($node, $strTipo){
  $strEmbed = "";
  switch ($strTipo){
    case 'imagem':
          $strEmbed = '<div class="detalhesVideo detalhesGaleria">
                        <span>Embed</span>
                        <div class="bgInputEmbed">
                            <input name="embed" type="text" value="<iframe src=\'http://'.(str_replace('sgc.', 'www.', $_SERVER['HTTP_HOST'])).'/galeria/'.urlencode(base64_encode($node->nid)).'\' scrolling=\'no\' frameborder=\'0\' width=\'625\' height=\'590\'></iframe>" onclick="this.focus();this.select();" />
                        </div>
                      </div>';
          break;
   case 'videost':
          // incluindo os arquivos necessários
          module_load_include('inc', 'videosambatech', 'videosambatech.api');

          // Liguagem
          $strLinguagem = (!empty ($node->field_videost[$node->language][0]["value"])) ? $node->language : "und";

          // Embed para Vídeo Samba TECH
          $strEmbed = '<div class="detalhesVideo">
                          <span>Embed</span>
                          <div class="bgInputEmbed">
                              <input name="embed" type="text" value=\'' . $node->field_videost[$strLinguagem][0]["value"] . '\' onclick="this.focus();this.select();" />
                          </div>
                        </div>';
          
          // Removendo embed temporáriamente para sambatech;
          $strEmbed = '';

          break;
    case 'audiost':
            // incluindo os arquivos necessários
            module_load_include('inc', 'videosambatech', 'videosambatech.api');

            // Liguagem
            $strLinguagem = (!empty ($node->field_videost[$node->language][0]["value"])) ? $node->language : "und";

            // Embed para Vídeo Samba TECH
            $strEmbed = '<div class="detalhesAudioST">
                            <span>Embed</span>
                            <div class="bgInputEmbed">
                                <input name="embed" type="text" value=\'' . $node->field_audiost[$strLinguagem][0]["value"] . '\' onclick="this.focus();this.select();" />
                            </div>
                          </div>';

            break;
      case 'video':
            $strEmbed = '<div class="detalhesVideo">
                          <span>Embed</span>
                                                      <div class="detalhesAudioST">
                          <div class="bgInputEmbed">
                              <input name="embed" type="text" value=\'<iframe src="http://'.(str_replace('sgc.', 'www.', $_SERVER['HTTP_HOST'])).'/galeria/'.urlencode(base64_encode($node->nid)).'\' scrolling=\'no\' frameborder=\'0\' width=\'625\' height=\'590\'></iframe>" onclick="this.focus();this.select();" />
                          </div>
                                                      </div>
                        </div>';
            break;
  }
  
  // Retornando o Embed
  return $strEmbed;
}

/**
 * 
 */
function api_getNodeBlogs(){
  // Setando a variável para persistencia em base
  $arrServidores = variable_get("arrServidores");  
  //recebe a quantidade de blogs do servidor de blogs
  $blogs=db_getNodeBlogs();
  
  //tratamento para adicionar parametros aos blogs do servidor de blogs
  foreach ($blogs as $key => $value) {
    $value->subcategoria =$arrServidores['blog_social']['strChapeu'];
    $value->dominio =$arrServidores['blog_social']['strDominio'];
    $value->imagem_url =$arrServidores['blog_social']['strImagem'];
    $value->title = (!empty ($value->chamada_capa)) ? $value->chamada_capa : $value->title;
    $value->parent='blog_social';
  }  
  
  return $blogs;  
}
/*
 * Método utilizado para auxiliar na ordenação do array.
 * @return -1 ou 1 de acordo com a data de criação do objeto.
 */
function sortByCreated($a, $b)
{
  if ($a->created == $b->created) {
    return 0;
  }
  return ($a->created < $b->created) ? 1 : -1;
}

/*
 * Método recebe 1 array de objetos blogs do servidor local
 * @return ArrayObject
 */  
function api_compara_node($arrayBlogRedacao = array(),$qtdPosts = 4){  
  //recebe array de objetos com os blogs do servidor de blogs através da funcao api_getNodeBlogs
  $arrayBlogs=api_getNodeBlogs();
  $addElement0=true;
  $blogsOrdenados=array();

  //merge em todos os blogs;
  $blogsOrdenados=array_merge($arrayBlogRedacao,$arrayBlogs);
  //ordena todos os blogs por ordem de criação
  usort($blogsOrdenados, 'sortByCreated');

  //deixar a quantidade de noticias de blogs desejada.
  while (count($blogsOrdenados)>$qtdPosts){
    array_pop($blogsOrdenados);
  }
  return $blogsOrdenados;  
}

/**
 * Método que ira retornar o alias da notícia caso seja passado a chave de banco o mesmo irá setar o banco ativo
 * e irá recurar essa node no servidor desejado
 * 
 * @param Int $intNId
 * @param String $strChaveBanco
 * @return String 
 */
function api_get_alias($intNId, $strChaveBanco = null){
  // Criando a variável que conterá a url
  $strUrl = null;
  
  db_set_active($strChaveBanco);
  
  // Lendo a notícia para saber sua rigem
  $objNode = node_load($intNId);
  
  // Recuperando o prefixo das tabelas
  $strPrefixo = api_get_prefixo($objNode->type);
  
  // recuperando o alias da node
  $objUrl = db_query("select alias from {$strPrefixo}url_alias where source = 'node/{$intNId}'")->fetch();
  
  db_set_active("default");
  
  // Retornando a alias
  return $objUrl->alias;
}

function api_get_prefixo($strPrefixo){
  // Iniciando a variavel com que cnoterá um prefixo
  $strPrefixoTable = "";
  
  // Realizando o switch
  switch ($strPrefixo){
    case 'blog_hallsocial':
        $strPrefixoTable = "nasocial_";
      break;
  }
  
  return $strPrefixoTable;
}
/*
 * 
 * Método que retorna as notícias referentes a categoria desejada.
 */
function api_getNodes_asmais($pagina,$pDias = 7){  
  $type="";
  
  switch ($pagina) {
    case "politica":
      $type='caderno_politica';
      break;
    case "noticias":
      $type='caderno_noticias';
      break;
    case "carreiras":
      $type='caderno_carreiras';
      break;
    case "cultura":
      $type='caderno_cultura';
      break;
    case "esportes":
      $type='caderno_esportes';
      break;
    case "tecnologia":
      $type='caderno_tecnologia';
      break;
    case "multimidia":
      $type='caderno_multimidia';
      break;
    default:
      break;
  }  
  return getConteudoMaisLido($pDias,4,$type);
}


/**
* Método que ira formatar a data vinda do banco de dados
* 
* @param type $strData
* @return string 
*/
function formatarBancoData($strData, $strFormato = "dd/mm"){
 // Explodindo a data pelo delimitador
 $arrDataCompleta = explode(" ", $strData);
 
 // Explodindo a data pelo delimitador
 $arrData = explode("-", $arrDataCompleta[0]);
 
 
 switch ($arrData) {
   case 'dd/mm/yyyy':
       $strDataFormatada = $arrData[2] . "/" . $arrData[1] . "/" . $arrData[0];
     break;
   case 'dd/mm':
       $strDataFormatada = $arrData[2] . "/" . $arrData[1] ;
     break;
   default:
       $strDataFormatada = $arrData[2] . "/" . $arrData[1] ;
     break;
 }
 
 // Retornando a data formatada
 return $strDataFormatada;
}

function api_getColunistaNode($idNode){  
  return getColunistaNode($idNode);
}

function api_getColunistabyNodebyField($idNode){  
  return getColunistabyNodebyField($idNode);
}

/**
 * Método que irá passar os identificadores das nodes a serem ignorados e o Caderno a qual os nodes pertecem
 * 
 * @param String $strIdIgnode
 * @param String $strChave 
 */
function api_ignoreIdCobertura($strIdIgnode, $strChave){
  // Recuperando os ids do cache
  $cache = cache_get($strChave);
  
  $strIdcache = (!empty ($cache->data)) ? $cache->data . ", " . $strIdIgnode : $strIdIgnode;
  if(!empty ($strIdIgnode)){
    // Setando os ids a serem ignorados
    cache_set($strChave, $strIdcache, 'cache_page', CACHE_TEMPORARY);
  }
}

/**
 * Método que irá receber um array com as notícias que deverão ser ignoradas e retornara uma string com os identificadores da mesmas
 * 
 * @param array $arrNodesIgnore
 * @return String 
 */
function api_criaIgnore($arrNodesIgnore){
  
  // Validações 
  if(!is_array($arrNodesIgnore)) return "";
  
  // realizando a interação
  foreach($arrNodesIgnore as $key => $value){
    // Caso tenha um nid
    if(!empty ($value->nid))
      $arrNid[] = $value->nid;
  }
  
  // retornando a string com os id a serem ignorados
  return implode(",", $arrNid);
}


/**
 * Método que irá retornar o caderno e o subcaderno do node passado por parâmetro.
 * Função criada para identificar o subcaderno do caderno multimidia - imagem do dia;
 * @param type $arrObjNode
 */
function api_getCadernoSubcaderno($arrObjNode = array()){
  if(!empty($arrObjNode)):
    $nid        = "";
    foreach($arrObjNode as $key =>$value):
      if($arrObjNode[$key]['field_tags']):
        
        // Caso o campo esteja vazio
        if(empty ($arrObjNode[$key]['field_tags']["#object"]->type))
          break;
        
        $caderno = @$arrObjNode[$key]['field_tags']["#object"]->type;
        
        //capturando o subcaderno no field_catradiotv
        $subCaderno = @$arrObjNode[$key]['field_tags']["#object"]->field_catradiotv["pt-br"][0]["tid"];
        //capturando o nid do node;
        $nid = $arrObjNode[$key]['field_tags']["#object"]->nid;
        break;
      endif;
    endforeach;
  endif;
  //setando os valores em um array chaveado;
  $retorno = array('caderno'=>$caderno,'subCaderno'=>$subCaderno,'nid'=>$nid);
  //retornando o resultado da função;
  return $retorno;
}

/**
 * funcção criada para retornar a imagem do dia referente ao id passado;
 * @param type $arrDados
 * @return type
 */
function api_getImgUrl($arrDados = array('nid'=>'all')){
  //declaração das variáveis
  $language    = "";
  $field_image = "";
  $field_capa  = "";
  $nid         = "";
  $node        = "";
  $imagens = array();
  //setando nid à variavel $nid;
  $nid = $arrDados['nid'];
  //setando o resultado da views a variavel $node; o $nid é passado como parametro para a view e retornar apenas a node com o nid passado.
  $node = views_get_view_result('imagem_do_dia', 'cobertura',$nid);
  //verificando se existe ocorrencia retornada pela view na variavel $node;
  if(!empty($node)):
    //verificando se tem alguma imagem de capa setada
    if(!empty($node[0]->_field_data["nid"]["entity"]->field_capa)):
      //guardando o array em uma variavel
      $field_capa = $node[0]->_field_data["nid"]["entity"]->field_capa;
      //capturando a linguagem do field através da funcao key
      $language = key($field_capa);
      //retornando a imagem de capa com o style thumbnail para ser adicionada ao array
      $imagens[] = image_style_url('thumbnail', $field_capa[$language][0]['uri']);
    endif;
    //capturando o field_image e setando na variavel $field_image
    $field_image = $node[0]->_field_data["nid"]["entity"]->field_image;
    //verificando se o $fiel_image não está vazio com algum valor.
    if(!empty($field_image)):
      //capturando a linguagem do field;
      $language = key($field_image);
      //adicionando ao array cada imagem de galeria.
      foreach ($field_image[$language] as $key => $value) {
        $imagens[] =  image_style_url('thumbnail', $value['uri']);
      };
    endif;
  endif;
  
  return $imagens;
}

/**
 * 
 * @param type $qtd
 * @return array $arrNodesColunistas
 * Funçao api_getColunistasNodes recebe como parametro a quantidade de noticias que deseja retornar;
 */
function api_getColunistasNodes($qtd = 1){
  //colunistas 
  $colunistas = views_get_view_result('colunistas_taxonomy', 'colunista');

  // Realizando a interação para selecionar a ultima notícia 
  // de cada colunista do resultado da views
  foreach ($colunistas as $key => $value) {

    // TID do colunista
    $tid = $value->tid;

    // Recuperando a ultima notícia do colunista
    $conteudo = views_get_view_result('ultimas_de_colunista', 'conteudo', $tid);

    // Recuperanod o link da notícia
    $url_coluna = drupal_lookup_path('alias', 'taxonomy/term/' . $tid);

    // Criando o link da notícia
    $url_node = drupal_lookup_path('alias', 'node/' . $conteudo[0]->nid);

    // Recuperando o parentesco da taxonomia para indentificar a qual caderno ela pertence
    $parent = getParentByTid($tid);

    // Recuperando a data da node e definindo em padrão americano
    $node_created = date("Y-m-d H:i:s", $conteudo[0]->node_created);

    // Criando o array com as notícias
    $arrColuna[$key]["title_colunista"] = $value->taxonomy_term_data_name;
    $arrColuna[$key]["title_node"] = $conteudo[0]->node_title;
    $arrColuna[$key]["node_created"] = $node_created;
    $arrColuna[$key]["parent"] = $parent;
    $arrColuna[$key]["url_coluna"] = $url_coluna;
    $arrColuna[$key]["url_node"] = $url_node;
    $arrColuna[$key]["tid"] = $tid;
  }

  // Verificando qual é a maior data de criação
  usort($arrColuna, 'sortByNodeColunaCreated');
  /**
   * variavel utilizada para retornar a quantidade solicitada.
   */
  $arrNodesColunistas = array();
  for ($i = 0; $i < $qtd; $i++){
    $arrNodesColunistas[]=$arrColuna[$i];
  }
  
  return $arrNodesColunistas;
}

/**
 * Método que irá retornar um array de objeto para montagem do menu brad camp
 * 
 * @param int $intNid
 * @return ArrayObject
 */
function getMenuBradCumb($intNid){
  // Cast necessário
  $intNid = (int) $intNid;
  
  // Validação
  if($intNid == 0) return false;
  
  // Reornando
  return getCrumb($intNid);
}