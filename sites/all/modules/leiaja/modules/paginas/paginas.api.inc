<?php

module_load_include('inc', 'paginas', 'paginas.db');

//Função que vai retonar a página de colunistas
function api_getColunistas() {

    //Variavel global com o nome do tema
    global $theme_key;
    //Variavel que vai conter o valor de saida
    $output = '';
    //Id do cache
    $cacheId = 'cadernoColunistas' . $theme_key;
    //Recuperando o cache
    $cache = cache_get($cacheId, 'cache');

    if (!$cache) {

        //Atribuindo o tema
        $output = views_embed_view('colunistas_taxonomy', 'colunista');
        //Setando o cache
        cache_set($cacheId, $output, 'cache', time() + 60 * 60);
    } else {

        //Atribuindo o valor do cache
        $output = $cache->data;
    }

    return $output;
}

//Função que vai retornar a pagina de especiais
function api_getEspeciais() {

    global $theme_key;

    $output = '';
    $cacheId = 'especiais' . $theme_key;

    $vars['corCategoria'] = array('noticias' => 'vermelho',
        'carreiras' => 'roxo',
        'esportes' => 'verde',
        'tecnologia' => 'azulClaro',
        'cultura' => 'laranja',
        'multimidia' => 'azulClaro');

    $cache = cache_get($cacheId, 'cache');

    if (!$cache) {

        ## CAPA - Caderno COLUNISTAS/Blogs.
//        $vars['vBlogsParceiros'] = db_getBlogsParceiros();
        $vars['vColunistas'] = db_getColunistaUltimas(100);
//        $vars['vBlogsRedacao'] = db_getColunistaUltimas(100, array('pType' => 'blogs_da_redacao'));

        $tids = db_getTidsEspecial();
        $vars['vEspeciais'] = taxonomy_term_load_multiple(array_keys($tids["taxonomy_term"]));
        $vars['vTotalCol'] = db_getCountTerm();

        $output = theme('especiais', $vars);

        cache_set($cacheId, $output, 'cache', time() + 60 * 60);
        
    } else {
        
        $output = $cache->data;
        
    }

    return $output;
}

//Função que vai retornar e cachear a pagina dos feeds
function api_getAssine(){
    
    return theme('assine');
    
}
