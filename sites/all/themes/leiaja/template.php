<?php
require_once('template.db.inc');
require_once('template.api.inc');

//As cores padrão para os categorias no tema leiaja definida numa variável global
$coresTemp = array(
    'noticias' => 'vermelho',
    'carreiras' => 'roxo',
    'esportes' => 'verde',
    'tecnologia' => 'azulClaro',
    'cultura' => 'laranja',
    'politica' => 'cinza'
);
$GLOBALS['cores'] = $coresTemp;

/**
 * Implementação do hook_css_alter.
 * Objetivo é remover folhas de estilo não usadas.
 *
 * @param type $css
 */
function leiaja_css_alter(&$css)
{
  // Limpando CSS removendo estilos defaul do Drupal que não são usados.
  unset($css['modules/system/system.base.css']);
  unset($css['modules/system/system.menus.css']);
  unset($css['modules/system/system.messages.css']);
  unset($css['modules/system/system.theme.css']);
  unset($css['modules/comment/comment.css']);
  unset($css['modules/field/theme/field.css']);
  unset($css['sites/all/modules/futebol/css/forms.css']);
  unset($css['sites/all/modules/futebol/css/validationEngine.jquery.css']);
  unset($css['modules/node/node.css']);
  unset($css['modules/search/search.css']);
  unset($css['modules/user/user.css']);
  unset($css['sites/all/modules/video/css/video.css']);
}

/**
 * Implementação do hook_js_alter.
 * Objetivo é remover scripts não utilizados.
 *
 * @param type $javascript
 */
function leiaja_js_alter(&$javascript)
{
  unset($javascript['sites/all/modules/futebol/js/helpers.js']);
  unset($javascript['sites/all/modules/futebol/js/jquery.validationEngine-pt.js']);
  unset($javascript['sites/all/modules/futebol/js/jquery.validationEngine.js']);
}

/**
 * Implementação do hook_preprocess_html do tema.
 *
 * @param type $vars
 * @return type
 */
function leiaja_preprocess_html(&$vars)
{ 
  drupal_add_js(drupal_get_path('theme', 'leiaja') . '/js/script.js');
   
  // Exibe versão de Impressão.
  if(strstr($_SERVER['REQUEST_URI'],'print=true')){
    $vars['theme_hook_suggestions'] = array('html__print');
    
    $setContent = $vars['page']['content2'];
    if(!$setContent){$setContent = $vars['page']['content'];}
    
    $arrTemp= array_values($setContent['system_main']['nodes']);
    $vars['vContentPrint'] = $arrTemp[0]['body']['#object']->body['pt-br'][0]['value'];
    $vars['vSumaryPrint'] = $arrTemp[0]['body']['#object']->body['pt-br'][0]['summary'];
    $vars['vTtPrint'] = $arrTemp[0]['body']['#object']->title;
    $vars['vUriImgPrint'] = $arrTemp[0]['body']['#object']->field_image['pt-br'][0]['uri'];
    $vars['vFontePrint'] = $arrTemp[0]['body']['#object']->field_fonte['pt-br'][0]['safe_value'];
    $vars['vDataCriacaoPrint'] = $arrTemp[0]['body']['#object']->created;
    
    return;
  }

  // Pegando a base url da imagem
  $vars['vMetaImagem'] = url(base_path(true).'/images/logo_leiaja.jpg',array('absolute' => true));
  $vars['vMetaTitulo'] = $vars['head_title'];
  
  // Verifica se é exibição de um node.
  if ($node = menu_get_object()) {
              
    if(!empty($node->field_image['pt-br'][0]['uri'])){
        $vars['vMetaImagem'] = image_style_url('home_cadernos',$node->field_image['pt-br'][0]['uri']);
        $vars['vMetaTitulo'] = $node->title;
    }else if(!empty($node->field_capa['pt-br'][0]['uri'])){
        $vars['vMetaImagem'] = image_style_url('home_cadernos',$node->field_capa['pt-br'][0]['uri']);
        $vars['vMetaTitulo'] = $node->title;
    }else if($node->type == 'caderno_colunistas'){
        $vars['vMetaImagem'] = base_path(true).'/'.drupal_get_path('theme', 'leiaja').'/images/foto-coluna-'.$node->field_catcolunista['pt-br'][0]['tid'].'.jpg';
        $vars['vMetaTitulo'] = $node->title;
    }
      
  }else{  
    if(arg(0) != 'search' && arg(0) != 'ultimas'){
      // Setando a variavel meta metaRefresh
      $vars["metaRefresh"] = '<meta http-equiv="refresh" content="180" />';
    }
  }
  
  // Verifica se é capa do caderno Colunistas
  if(arg(0) == 'taxonomy' && arg(1) == 'term' && strstr($_SERVER['REQUEST_URI'],'/colunistas/')){

    // Criando a imagem do colunista
    $strCaminhoImagem = "http://static1.leiaja.com/sites/all/themes/leiaja/images/foto-colunista-".arg(2).".jpg";

    // Setando a variavel meta metaRefresh
    $vars["metaImg"] = '<meta property="og:image" content="'.$strCaminhoImagem.'" />';
  }
}

/**
 * Implementação do hook_preprocess_page.
 * Ações executadas antes do processamento da Page.
 *
 * @param Array $vars
 */
function leiaja_preprocess_page(&$vars)
{    
  //Customização para o POST do colunista.
  if(strstr($_SERVER['REQUEST_URI'],'/coluna/')){
      
    // Pegando a chave do campo
    $strChave = key($vars["node"]->field_catcolunista);
    
    // Criando a imagem do colunista
    $strCaminhoImagem = "http://static1.leiaja.com/sites/all/themes/leiaja/images/foto-colunista-".$vars["node"]->field_catcolunista[$strChave][0]["tid"].".jpg";
    
    // Criando a metatag
    $vMetaImagem = array(
      '#tag' => 'meta', 
      '#attributes' => array(
        'property' => 'og:image',
        'content' => $strCaminhoImagem,
      )
    );
    
    // setando no cabeçalho
    drupal_add_html_head($vMetaImagem, 'meta_image');
    
    $vars['theme_hook_suggestions'][] = 'page__caderno_colunistas';
  }
  
   // Verifica se é capa do caderno Colunistas
   if(arg(0) == 'taxonomy' && arg(1) == 'term' && strstr($_SERVER['REQUEST_URI'],'/colunistas/')){
     
      //pegando termo da pagina e mudando o title da pagina
      $tidTermo = ucfirst(arg(2));
      $objTermo = taxonomy_term_load($tidTermo);
      $termoNome = $objTermo->name;
      $termoCaderno =  ucfirst($objTermo->vocabulary_machine_name);
      
      // Setando o titulo da página
      drupal_set_title(t('@caderno - @title', array('@title' => $termoNome, '@caderno' => $termoCaderno)));
     
     $vars['theme_hook_suggestions'][] = 'page__caderno_colunistas';
   }else if(arg(0) == 'taxonomy' && arg(1) == 'term' && isSubcaderno() && !strstr($_SERVER['REQUEST_URI'],'/blogs/') && !strstr($_SERVER['REQUEST_URI'],'/colunistas/')){
     // Verifica se é algum subcaderno;
      
      //pegando termo da pagina e mudando o title da pagina
      $tidTermo = ucfirst(arg(2));
      $objTermo = taxonomy_term_load($tidTermo);
      $termoNome = $objTermo->name;
      $termoCaderno =  ucfirst($objTermo->vocabulary_machine_name);
       
       
       drupal_set_title($termoCaderno.' - '.$termoNome);

     $vars['theme_hook_suggestions'][] = 'page__noticias__sub';
   } elseif (strstr($_SERVER['REQUEST_URI'],'/blogs/') and $vars['node']->type !== 'page'){
       
       //nova tematização para os arquivos de blogs
       $termUri = $_SERVER['REQUEST_URI'];
       $arrayBlogs = array('cultura', 'carreiras', 'esportes');
       $vTid = ($vars['node']->field_catblog['pt-br'][0]['tid']);
       
       if(empty($vTid)){
             foreach ($arrayBlogs as $value) {
                 if(strstr($termUri,'/blogs/'.$value)){
                     $vars['tipoBlog'] = 'blog_'.$value;
                     break;
                 }
             }
       }else{
            switch ($vTid) {
                 case '4642':
                   $vars['tipoBlog'] = 'blog_esportes';
                   break;
                 case '4643':
                   $vars['tipoBlog'] = 'blog_cultura';
                   break;
                 case '4644':
                   $vars['tipoBlog'] = 'blog_carreiras';
                   break;
           }
       }

       //verificar quais variáveis estão sendo realmente usadas

       $vars['theme_hook_suggestions'][] = 'page__blogs_redacao';
       $vUrl    = drupal_lookup_path('alias', arg(0).'/'.arg(1).'/'.$vTid);
       $pParams = array('pQtdPagina' => 5, 'tags' => true);
       $pParams['limit'] = '5';

         if(!empty($_GET['page'])){
           $pParams['limit'] = ' 5 OFFSET '. ($_GET['page'])*5;
         }
         if(!empty($_GET['mes'])){
           $pParams['pMes'] = $_GET['mes'];
           $vUrl .= '&mes='.$_GET['mes'];
         }
         if(!empty($_GET['ano'])){
           $pParams['pAno'] = $_GET['ano'];
           $vUrl .= '&ano='.$_GET['ano'];
         }
         if(!empty($vTid)){
             $vars['vPaginacao'] = paginacao(getNodeCountByTerm($vTid, $pParams),$vUrl, $pParams);
         }
   }else if(arg(0) == 'taxonomy' && arg(1) == 'term' && is_numeric(arg(2))){
     
      //pegando termo da pagina e mudando o title da pagina
      $tidTermo = ucfirst(arg(2));
      $objTermo = taxonomy_term_load($tidTermo);
      $termoNome = $objTermo->name;
      $termoCaderno =  ucfirst($objTermo->vocabulary_machine_name);
      
      // Setando o titulo da página
      drupal_set_title(t('@caderno - @title', array('@title' => $termoNome, '@caderno' => $termoCaderno)));
     
      //Página de listagems das tags.
      $vars['theme_hook_suggestions'][0] = 'page__taxonomy__term';
   }
   
   // Verifica se é exibição de um Node e carrega bradcrumb.
   if(!empty($vars['node']->nid)){     
      // Criando o menu crumb do leiaja
      $vars['vCrumb'] = getCrumb($vars['node']->nid);
   }
   
   if(arg(0) === 'taxonomy'){
       
        //pegando termo da pagina e mudando o title da pagina
        $tidTermo = arg(2);
        $objTermo = taxonomy_term_load($tidTermo);
        $termoNome = $objTermo->name;
        
        $vidCaderno = $objTermo->vid;
        $objCaderno = taxonomy_vocabulary_load($vidCaderno);
        $nomeCaderno = $objCaderno->name;
        $urlCaderno = '/'.$objCaderno->machine_name;
        $vars['vTermoNome'] = $termoNome;
        $vars['vCadernoNome'] = $nomeCaderno;
        $vars['vCadernoUrl'] = $urlCaderno;
        
         // Carregando bloco de cobertura
         if($nomeCaderno !== "Multimidia")
            verificaBloco($vars, arg(0));
         
         $vars['is_caderno']   = true;
         init_menu($vars);
   }  
     
   // Regra para página de esportes
   if(arg(0) == 'futebol' && arg(1) == 'campeonatos'){
      $vars['theme_hook_suggestions'][0] = 'page__futebol__modulo'; 
   }
   
   // Regra para pagina imagens do dia ou node imagem do dia
   $caderno    = "";
   $subCaderno = "";
   $objNode    = "";
  if(!empty($vars['page']['content']['system_main']['nodes'])):
    $objNode = $vars['page']['content']['system_main']['nodes'];
    foreach($objNode as $key =>$value):
      if($objNode[$key]['field_tags']):
        $caderno = $objNode[$key]['field_tags']["#object"]->type;
        $subCaderno = (empty($objNode[$key]['field_tags']["#object"]->field_catradiotv["pt-br"][0]["tid"])) ? '' : $objNode[$key]['field_tags']["#object"]->field_catradiotv["pt-br"][0]["tid"];  
        break;
      endif;
    endforeach;
  endif;
  
   $pagina = arg(0);
   if($pagina =='imagens' ||  ($caderno == 'caderno_multimidia' && $subCaderno == "56743")){
     /* variavel contendo o valor para remover a coluna direita do page.tpl 
      * pois o mesmo será adicionado no node.tpl e na pagina da view.*/
      $vars['sem_colunadireita'] = true;
   }
   
  //INICIO -- pagina de tags; refeita com views; taxonomy_term_rewrite
  if(arg(0)=='taxonomy' && arg(1) == 'term' && strstr($_SERVER['REQUEST_URI'],'/tags')){
    $tid = arg(2);
    $taxonomia = taxonomy_term_load($tid);
    $vars['is_caderno'] = true;
    $vars['vCadernoNome'] = "Tags";
    $vars['tag'] = $taxonomia->name;

    //ocultando o paginador e a node que estava sendo carregada no template;
    unset($vars['page']["content"]["system_main"]['nodes']);
    unset($vars['page']["content"]["system_main"]["pager"]);
  }
  
  // Customização para página de resultado de busca.
  if(arg(0) == 'search' && arg(1) == 'site'){
      $query = apachesolr_current_query(apachesolr_default_environment());

      $search = apachesolr_static_response_cache($query->getSearcher());

      $vars['ocorrencias']      = $search->response->numFound;
      $vars['ocorrenciasCount'] = $search->response->start;
 }
} //FIM PREPROCESS PAGE

/**
 * Implementação do Hook processado antes da exibição do NODE.
 *
 * Aqui é realizada a consulta de sugestões de conteúdo baseado nas tags do node.
 *
 * @param Array $vars Váriaveis de escopo.
 */
function leiaja_preprocess_node(&$vars)
{
    if(in_array($vars['title'], array('Blogs', 'Colunistas')) and $vars['type'] == 'page'){
        $vars['theme_hook_suggestions'] = array('node__colunistas_blogs');
    }
    
  $vars['AdsenseTexto'] = '';
  $vars['jornalista'] = false;
  if(!empty($vars['node']->field_fonte[$vars['node']->language][0]['value']) && !empty($vars['node']->uid)){
    $vars['jornalista'] = (semAcentos($vars['node']->field_fonte[$vars['node']->language][0]['value']) == 'leiaja' && getUserImprensa($vars['node']->uid))? 'true': 'false';
  }
  $arrTipos = array('caderno_noticias','caderno_carreiras','caderno_esportes','caderno_cultura','caderno_tecnologia','caderno_multimidia');

  if(strstr($_SERVER['REQUEST_URI'],'preview=true')){
    $vars['theme_hook_suggestions'] = array('node__preview');
    $vars['vBlockBannerPreview']    = getBlocos(array('32'));
  }

    $subCadernosBanner[] = 'Educação';
    $subCadernosBanner[] = 'Cursos';
    $subCadernosBanner[] = 'Vestibular 2012';
    $subCadernosBanner[] = 'Empregos';
    
  //   56743
  // para noticias
  if($vars['type'] == "caderno_multimidia"){
      $tidImgDia = '56743';
      $language = key($vars['node']->field_catradiotv);
      if($vars['field_catradiotv'][$language][0]["tid"] == $tidImgDia):
        $vars['theme_hook_suggestions'][] = 'views_view__imagem_do_dia__page';
        $vars['sem_colunadireita'] = true;
      endif;
  };
}

/**
 * Retornar a string com a cor da seção de acrodo com o caderno.
 *
 * @param String $key
 * @return string
 */
function getCores($key)
{
  $corCategoria = array('noticias' => 'vermelho',
                        'carreiras' => 'roxo',
                        'esportes' => 'verde',
                        'politica' => 'azulEscuro',
                        'tecnologia' => 'azulClaro',
                        'cultura' => 'laranja',
                        'carnaval_2012' => 'laranja',
                        'multimidia' => 'cinza',
                        'multimidia' => 'cinza',
                        'blog_social' => 'laranja');
  return $corCategoria[$key];
}

/**
 *  Função que retorna a data da última revisão válida.
 *
 * @param int $pNid     Node Id.
 * @return type
 */
function getRevisao($pNid = null)
{
  $vData = getUltimaRevisao($pNid);

  if(empty($vData))
   $vRetorno = false;
  else
   $vRetorno = format_date($vData[0]->timestamp, 'medium');

  return $vRetorno;
}

/**
 * Método que irá retornar a ordenação de um array especifico
 * 
 * @param Variavel  $a
 * @param Variavel $b
 * @return Array 
 */
function sortByNodeColunaCreated($a, $b) {
  return strcmp($b["node_created"], $a["node_created"]);
}