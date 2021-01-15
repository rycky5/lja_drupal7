<?php

module_load_include('inc', 'widget', 'widget.db');

function getParentByTid($tid = NULL) {

    $parent = '';

    if (!empty($tid)) {
        $tid = (int) $tid;

        $cid = 'parent_' . $tid;
        $cache_parent = cache_get($cid);

        if (empty($cache_parent->data)) {
            $parent = bd_getParentByTid($tid);
            cache_set('parent_' . $tid, $parent, 'cache', time() + 30 * 60);
        } else {
            $parent = $cache_parent->data;
        }
    } else {
        $parent = NULL;
    }
    return $parent;
}

function conteudoHallSocialV2() {

    $cacheHallSocial = cache_get('cache_hall_social');
    if (empty($cacheHallSocial) || $cacheHallSocial->data == NULL) {
        try {

            // Lendo as livrarias
            $arrLibraries = libraries_get_libraries();

            // Incluindo o arquivo necessário
            require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $arrLibraries["curl"] . "/cURL.php";

            $vUrl = 'http://hallsocial.leiaja.com/rss.xml';

            // Criando o objeto curl
            $objCurl = new cURL(300);

            // Realizando o get para a notícia no ig pernambuco
            $strRetornoXml = $objCurl->get($vUrl);

            // Imprimir a saída
            $hallSocialGetRss = new SimpleXmlElement($strRetornoXml);
            cache_set('cache_hall_social', $hallSocialRss, 'cache', time() + 30 * 60);
            $hallSocialRss = $hallSocialGetRss;
        } catch (Exception $exc) {
            // echo $exc->getTraceAsString();
            watchdog('WATCHDOG_INFO', 'ERRO ao acessar o xml hallsocial');
            $hallSocialRss = NULL;
        }
    } else {
        $hallSocialRss = $cacheHallSocial->data;
    }

    return $hallSocialRss;
}

function api_getUltimasDinamico($arrParam) {

    $filters = array(
        'c' => array(
            'filter' => FILTER_SANITIZE_STRING
        ),
        'p' => array(
            'filter' => FILTER_VALIDATE_BOOLEAN
        ),
        'd' => array(
            'filter' => FILTER_VALIDATE_BOOLEAN
        ),
        'qnt' => array(
            'filter' => FILTER_VALIDATE_INT,
            'options' => array(
                'min_range' => 1,
                'max_range' => 10
            )
        ),
    );

    $vCacheId = 'blUltimas_' . md5(serialize($arrParam));

    $cacheUltimas = cache_get($vCacheId, 'cache');

    //Verificando se é um cache válido
    if (empty($cacheUltimas) || $cacheUltimas->data == NULL) {
        $filterResult = filter_var_array($arrParam, $filters);
        //Recuperando o resultado do banco
        $resultDb = db_getUltimasDinamico($filterResult);

        $nids = array();
        //Formanto os nids para o node_load()
        foreach ($resultDb as $value) {
            $nids[] = $value->nid;
        }

        $objNodes = node_load_multiple($nids);

        cache_set($vCacheId, $objNodes, 'cache', time() + 60 * 30);
    } else {
        $objNodes = $cacheUltimas->data;
    }

    return $objNodes;
}

//Função que vai ler o xml do carnaval para
function api_getUltimasCarnaval() {

    $vCacheId = 'blCarnaval_' . md5(serialize('carnaval'));

    $cacheUltimas = cache_get($vCacheId, 'cache');

    //Verificando se é um cache válido
    if (empty($cacheUltimas) || $cacheUltimas->data == NULL) {
        
        $feed = 'http://carnaval.leiaja.com/rss.xml';
        $rss = simplexml_load_file($feed);

        $data = array();

        foreach ($rss->channel->item as $item) {

            $data[] = array(
                'title' => (array) $item->title,
                'link' => (array) $item->link,
                'pubDate' => (array) strtotime($item->pubDate)
            );
        }
        
        cache_set($vCacheId, $data, 'cache', time() + 60 * 30);
    }else{
        $data = $cacheUltimas->data;
    }

    return $data;
}

//Funcção que vai ler todos os rss dos blogs
function api_getRssBlogs() {

    //Recuperando o objeto vocabulario "blogs_parceiros"
    $vocabulary = taxonomy_vocabulary_machine_name_load('blogs_parceiros');
    //Carregando todas os termos relacionados ao vocabulario
    $terms = entity_load('taxonomy_term', FALSE, array('vid' => $vocabulary->vid));

    foreach ($terms as $key => $term) {

        //Verificando se existe uma url para o rss do blog
        if (!empty($term->field_rss[key($term->field_rss)][0]['value']) && !empty($term->field_imagem[key($term->field_imagem)][0]['uri'])) {

            try {

                // Lendo as livrarias
                $arrLibraries = libraries_get_libraries();

                // Incluindo o arquivo necessário
                require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $arrLibraries["curl"] . "/cURL.php";

                $rssUrl = $term->field_rss[key($term->field_rss)][0]['value'];

                // Criando o objeto curl
                $objCurl = new cURL(300);

                // Realizando o get para a notícia no ig pernambuco
                $retornoXml = $objCurl->get($rssUrl);

                // Imprimir a saída
                $objXml = new SimpleXmlElement($retornoXml);
            } catch (Exception $exc) {
                watchdog('WATCHDOG_INFO', 'ERRO ao acessar o xml - ' . $term->name);
            }

            try {

                //Transformando a data para timestamp
                $dateTime = strtotime($objXml->channel->item[0]->pubDate);
                //Formatando a data para o banco
                $dateTime = date('Y-m-d H:i:s', $dateTime);

                $arrDados = array(
                    'id' => $key,
                    'titulo' => ($term->name == "HallSocial") ? (string) strip_tags($objXml->channel->item[0]->description) : (string) strip_tags($objXml->channel->item[0]->title),
                    'url' => (string) $objXml->channel->item[0]->link,
                    'uri_image' => $term->field_imagem[key($term->field_imagem)][0]['uri'],
                    'data_publicacao' => $dateTime,
                );

                //Verificando se o blog já tem registro no banco
                $blogExiste = db_blogExiste($key);

                //Se o blog blog n existir no banco
                if (!$blogExiste) {
                    //Adiciona a notícia
                    db_addNoticiaRss($arrDados);
                } else {
                    if ($blogExiste->titulo != $arrDados['titulo']) {
                        db_atualizarNoticiasRss($arrDados);
                    }
                }
            } catch (Exception $exc) {
                watchdog('WATCHDOG_INFO', 'ERRO tentar incluir no banco - ' . $term->name);
            }
        }
    }
}

function api_getUltimasBlogs() {
    //Recuperando o cache setado
    $cacheBlogs = cache_get('cache_blogs_parceiros');

    //Verificando se é um cache válido
    if (empty($cacheBlogs) || $cacheBlogs->data == NULL) {
        //ultimas noticias
        $ultimasBlogs = db_getUltimasBlogs();
        //Retornando a tpl
        $output = theme('blogs-parceiros', array('ultimasBlogs' => $ultimasBlogs));

        cache_set('cache_blogs_parceiros', $output, 'cache', time() + 30 * 60);
    } else {

        $output = $cacheBlogs->data;
    }

    return $output;
}

function api_getUltimasBlogsHorizontal() {

    //Recuperando o cache setado
    $cacheBlogs = cache_get('cache_blogs_parceiros_horizontal');
    //Verificando se é um cache válido
    if (empty($cacheBlogs) || $cacheBlogs->data == NULL) {
        //ultimas noticias
        $ultimasBlogs = db_getUltimasBlogs(6);
        //Retornando a tpl
        $output = theme('blogs-parceiros-horizontal', array('ultimasBlogs' => $ultimasBlogs));

        cache_set('cache_blogs_parceiros_horizontal', $output, 'cache', time() + 30 * 60);
    } else {
        $output = $cacheBlogs->data;
    }

    return $output;
}
