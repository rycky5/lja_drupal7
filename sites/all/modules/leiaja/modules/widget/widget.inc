<?php
/**
 * Arquivo que conterá os métodos comuns aos blocos e os widgets do portal
 * 
 * @author Alberto Medeiros
 */

// incluindo os arquivos necessários
module_load_include('inc', 'leiaja', 'leiaja.db');
module_load_include('inc', 'widget', 'widget.db');
module_load_include('inc', 'widget', 'widget.api');
module_load_include('inc', 'leiaja', 'capa');


function api_widget_medalhas(){
  incluiArquivos();
  // Pegando o quadro e medalha
  $objQuadroMedalha = db_getQuadroMedalhas();
 
  // Criando o array que será passado para a tpl
  $arrVars = array();
  $arrVars["objQuadroMedalha"] = $objQuadroMedalha;
  
  // Retornando o tema
  return theme("widget-medalhas", $arrVars);
  
}

function api_bloco_noticia(){
  incluiArquivos();
  // Recuperando as notícias de esporte
  $vHomeNoticia = getNoticiasBlocos("'caderno_noticias'");
  
  // Criando o array que será passado para a tpl
  $arrVars = array();
  $arrVars["vHomeNoticia"] = $vHomeNoticia;
  
  // Retornando o tema
  return theme("bloco-noticia", $arrVars);
  
}

// Nova abordagem para a consulta dos colunista no bloco pagiado - PROJETO MELHORIAS
/**
 * Um array de variáveis para o thema do bloco.
 *
 * @param $type
 *   O nome do tema do bloco
 * @param $name
 *   A quantidade de elementos para busca de colunistas.
 *
 * @return
 *   Um array de variáveis para o thema do bloco.
 */
function api_bloco_colunista_v2($nomeThema, $qtdeLimite){

    $arrVars = array();
    $cacheCols = cache_get($nomeThema);
    
    if(empty($cacheCols) || !$cacheCols){
        $resultColunista = getColunistasPag($qtdeLimite);
        cache_set('bloco_colunista', $resultColunista);
    }else{$resultColunista=$cacheCols->data;}
    
    $numCols = count($resultColunista);
    $arrVars["resultCols"] = $resultColunista;
    $arrVars["numCols"]=$numCols;
       
     // Retornando o tema
  return theme($nomeThema, $arrVars);
}



function incluiArquivos(){
  require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja') .'/template.db.inc';
  require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja') .'/template.api.inc';
}
/*
 * Método utilizado para auxiliar na ordenação do array.
 * @return -1 ou 1 de acordo com a data de criação do objeto view.
 */
function sortByNodeCreated($a, $b)
{
  if ($a->node_created == $b->node_created) {
    return 0;
  }
  return ($a->node_created < $b->node_created) ? 1 : -1;
}
// Obtem via views as nóticias recentes para consudo no menu - PROJETO MELHORIAS
function initContentMenuRecentes()
{
    $vCacheId = 'initContentMenuRecentes_';    
    $vCache   = cache_get($vCacheId, 'cache_block');   

    $vUltimasNoticias = $vCache->data;
    
    if(empty($vUltimasNoticias)){
        $vUltimasNoticias = array();
        $vUltimasNoticias['noticias']   = views_get_view_result('menu_conteudo_recentes_v2','menu_noticias');
        $vUltimasNoticias['politica']   = views_get_view_result('menu_conteudo_recentes_v2','menu_politica');
        $vUltimasNoticias['carreiras']  = views_get_view_result('menu_conteudo_recentes_v2','menu_carreiras');
        $vUltimasNoticias['esportes']   = views_get_view_result('menu_conteudo_recentes_v2','menu_esportes');
        $vUltimasNoticias['cultura']    = views_get_view_result('menu_conteudo_recentes_v2','menu_cultura');
        $vUltimasNoticias['tecnologia'] = views_get_view_result('menu_conteudo_recentes_v2','menu_tecnologia');

        cache_set($vCacheId, $vUltimasNoticias, 'cache_block', CACHE_TEMPORARY);
    }
      
    return $vUltimasNoticias;
}

// Obtem via views as nóticias mais lidas para consudo no menu - PROJETO MELHORIAS
function initContentMenuMaisLida()
{
    $vCacheId = 'initContentMenuMaisLida_';    
    $vCache   = cache_get($vCacheId, 'cache_block');   
    
    $retorno = $vCache->data;

    if(empty($result)){
        $result = array();
        $result['noticias']   = views_get_view_result('menu_conteudo_mais_lidas','menu_maislida_noticias');
        $result['politica']   = views_get_view_result('menu_conteudo_mais_lidas','menu_maislida_politica');
        $result['carreiras']  = views_get_view_result('menu_conteudo_mais_lidas','menu_maislida_carreiras');
        $result['esportes']   = views_get_view_result('menu_conteudo_mais_lidas','menu_maislida_esportes');
        $result['cultura']    = views_get_view_result('menu_conteudo_mais_lidas','menu_maislida_cultura');
        $result['tecnologia'] = views_get_view_result('menu_conteudo_mais_lidas','menu_maislida_tecnologia');
        $result['multimidia'] = views_get_view_result('menu_conteudo_mais_lidas','menu_maislida_multimidia');

        foreach ($result as $key => $value){

            $nid = $value[0]->nid;
            $retorno[$key]['titulo'] = $value[0]->node_title;
            $retorno[$key]['link_node'] = drupal_lookup_path('alias',"node/".$nid);
            $retorno[$key]['resumo'] = truncate_utf8(strip_tags($value[0]->field_body[0]['raw']['value']), '80', TRUE, TRUE);
            $retorno[$key]['resumo'] = retiraHashII($retorno[$key]['resumo']);

            if(!empty($value[0]->field_field_capa)){
                $uri = $value[0]->field_field_capa[0]['rendered']['#item']['uri'];
            }else{
                $uri = $value[0]->field_field_image[0]['rendered']['#item']['uri'];
            }

            $retorno[$key]['imagem'] = image_style_url('medium', $uri);
        }
        
        cache_set($vCacheId, $retorno, 'cache_block', CACHE_TEMPORARY);
    }
    
    return $retorno;
}

function conteudoArqsBlogs(){
 
    $arrVars['views'] = views_embed_view('arquivos', 'blogs');
    
    return theme('bloco-arquivos-blogs', $arrVars);
}

//função que retornas os dados dos blocos e locais que usam os Blogs da Redação
function conteudoBlogsRedacao()
{   
    $resultDbBlogs = getBlogsRedacao();
    
    $retornoBlogs = array();
    
    foreach($resultDbBlogs as $key => $blog){
                
            //declaração das variáveis
            $retornoBlogs[$key]['nid']=$nid        = $blog->nid;
            $retornoBlogs[$key]['tid']=$tid        = $blog->tid;
            $retornoBlogs[$key]['urlImg']          = "http://static1.leiaja.com/sites/all/themes/leiaja/images/blogs-redacao-".$tid.".jpg";
            $termTaxy                           = taxonomy_term_load($tid);
            $retornoBlogs[$key]['parent']=$parent  = strtolower($termTaxy->name);
            $retornoBlogs[$key]['subcategoria']    = $parent;
            $retornoBlogs[$key]['title']           = $blog->title;
            $retornoBlogs[$key]['urlNode']         = $urlNode = url(drupal_lookup_path('alias',"node/".$nid),array('absolute' => true));
            $retornoBlogs[$key]['urlTax']=$urlTax  = $urlTax =url(drupal_lookup_path('alias',"taxonomy/term/".$tid),array('absolute' => true));
            $retornoBlogs[$key]['urlChapeu']       = url(drupal_lookup_path('alias',$urlTax),array('absolute' => true));
        
      }
      
      return $retornoBlogs;
}

//Função que vai retornar a pagina com o bloco das mais lidas
function getPageMaisLidas(){
    
    //Definindo o tema que serah retornado
    return theme('bloco-as-mais-lidas');   
    
}

//Função que vai retornar a pagina com o bloco das mais lidas
function getPageMaisLidasClean(){
    
    //Definindo o tema que serah retornado
    return theme('bloco-as-mais-lidas-clean');   
    
}

//Função que vai retornar a pagina com o bloco das ultimas noticias
function getPageUltimasNoticias(){
    
    //Carregando o display da view
    $block = module_invoke('views', 'block_view', 'ultimas_noticias-block_1');
    //printando e renderizando o bloco
    print render($block['content']);
    
}

//Função que vai retornar a pagina com o bloco das ultimas noticias
function getPageUltimasNoticiasClean(){
    
    //Carregando o display da view
    $block = module_invoke('views', 'block_view', 'ultimas_noticias-block_clean');
    //printando e renderizando o bloco
    print render($block['content']);
    
}

//Função que vai retornar a pagina com a listagem dos blogs da redação
function getPageBlogsRedacao(){
    
    //Carregando o display da view
    $block = module_invoke('views', 'block_view', 'blog_da_reda_o-block_2');
    //printando e renderizando o bloco
    print render($block['content']);
    
}

//Função que vai retornar a pagina com a listagem dos blogs da redação
function getPageBlogsRedacaoClean(){
    
    //Carregando o display da view
    $block = module_invoke('views', 'block_view', 'blog_da_reda_o-bloco_clean');
    //printando e renderizando o bloco
    print render($block['content']);
    
}

//Função que vai retornar os colunistas e sua ultima materia
function getPageColunistas(){
    
    //Carregando o display da view
    $block = module_invoke('views', 'block_view', 'colunistas_taxonomy-colunista');
    //printando e renderizando o bloco
    print render($block['content']);
    
}

//Função que vai retornar os colunistas e sua ultima materia
function getPageColunistasClean(){
    
    //Carregando o display da view
    $block = module_invoke('views', 'block_view', 'colunistas_taxonomy-block_clean');
    //printando e renderizando o bloco
    print render($block['content']);
    
}

//Função que vai retornar as ultimas notícias por caderno
function getUltimasPorCaderno(){
    
    return theme('block-ultimas-noticias-caderno');
    
}

//Bloco de notícias promovidas e destacadas por caderno
function getPromovDestac(){
    
    return theme('block-promov-destac-caderno');
    
}

//Bloco de notícias promovidas e destacadas por caderno 10
function getPromovDestac10(){
    
    return theme('block-promov-destac-caderno-10');
    
}

//Bloco de notícias promovidas e destacadas por caderno
function getConcursosClean(){
    
    //Carregando o display da view
    $block = module_invoke('views', 'block_view', 'concursos-block');
    //printando e renderizando o bloco
    print render($block['content']);
    
}

//Bloco de ultimas notícias dinamico
function getUltimasDinamicoBloco(){
    
    $arrParam = $_GET;
    $result = api_getUltimasDinamico($arrParam);
    
    return theme('bloco_ultimas_dinamico', array('objNodes' => $result));
    
}

//Bloco de ultimas notícias dinamico
function getUltimasCarnavalBloco(){
    
    $result = api_getUltimasCarnaval();
    
    return theme('bloco_ultimas_carnaval', array('arrXML' => $result));
    
}
//Iframe de ultimas notícias dinamico
function getUltimasDinamicoIframe(){
    
    $arrParam = $_GET;
    $result = api_getUltimasDinamico($arrParam);
    
    return theme('iframe_ultimas_dinamico', array('objNodes' => $result));
    
}

//Função de callback para ler os rss dos blogs da redação
function getRssBlogs(){
    
    return api_getRssBlogs();
    
}

function blogsParceiros(){
    
    return api_getUltimasBlogs();
    
}

function blogsParceirosHorizontal(){
    
    return api_getUltimasBlogsHorizontal();
    
}