<?php

/**
 * Renderização do XML com o feed.
 */
function exibirFeed() {
    $arg1 = arg(1);
    $arg2 = arg(2);
    header('Content-Type: application/rss+xml; charset=utf-8');

    if (empty($arg1)) {
        $vCacheId = 'feed' . $arg1;
        $vCache = cache_get($vCacheId, 'cache');
        $vConteudo = '';

        if (!$vCache) {
            $nids = db_query("SELECT         ti.nid
                         FROM        taxonomy_vocabulary AS tv
                         INNER JOIN  taxonomy_term_data AS ttd
                         INNER JOIN  taxonomy_index AS ti

                         ON          tv.machine_name <> 'tags'
                         AND         tv.machine_name <> 'multimidia'
                         AND         tv.machine_name <> 'galerias'
                         AND         tv.machine_name <> 'politica'
                         AND         tv.machine_name <> 'blogs_parceiros'
                         AND         tv.machine_name <> 'agenda'
                         AND         tv.vid = ttd.vid
                         AND         ttd.tid = ti.tid
                         ORDER BY    ti.nid DESC
                         LIMIT       10")->fetchCol();

            $channel['link'] = url('assinar', array('absolute' => TRUE));
            $channel['title'] = variable_get('site_name', 'Drupal') . ' - Assinar';
            $channel['description'] = check_markup('Feed do site www.leiaja.com', '', '', TRUE);

            //Iniciando o output buffer e bloqueando qualquer saida para o navegador
            ob_start();

            //Padronizando e retornando o feed para o navegador
            node_feed($nids, $channel);

            //Recuperando os valores enviados para o navegador
            $strContent = ob_get_contents();

            ob_end_clean();

            //Expressão regular
            $regex = '/img src=&quot;/';

            $vConteudo = str_replace('##RECOMENDA##', '', $strContent);
            $vConteudo = preg_replace($regex, 'img src=&quot;http://' . $_SERVER['SERVER_NAME'], $vConteudo);

            cache_set($vCacheId, $vConteudo, 'cache', time() + 60 * 120);
        } else {
            $vConteudo = $vCache->data;
        }

        print $vConteudo;
        die;
    } else if (!empty($arg2)) {
        $vCacheId = 'feed2' . $arg2;
        $vCache = cache_get($vCacheId, 'cache');
        $vConteudo = '';

        if (!$vCache) {
            $result = db_query("SELECT      REPLACE(source, 'taxonomy/term/', '') AS tid 
                            FROM        url_alias 
                            WHERE       alias like '$arg1/$arg2'
                            ORDER BY    tid DESC")->fetchField();

            $term = taxonomy_term_load($result);

            $channel['link'] = url('taxonomy/term/' . $term->tid, array('absolute' => TRUE));
            $channel['title'] = variable_get('site_name', 'Drupal') . ' - ' . $term->name;
            $channel['description'] = check_markup($term->description, $term->format, '', TRUE);
            $nids = taxonomy_select_nodes($term->tid, FALSE, 10, $order = array('t.created' => 'DESC'));

            //Iniciando o output buffer e bloqueando qualquer saida para o navegador
            ob_start();

            //Padronizando e retornando o feed para o navegador
            node_feed($nids, $channel);


            //Recuperando os valores enviados para o navegador
            $strContent = ob_get_contents();

            ob_end_clean();

            //Expressão regular
            $regex = '/(src=&quot;)(.*?)(&quot;)/';

            //Função de callback para ser usado no preg_replace_callback
            function callback($matches) {
                //Verifica se exiete http na string
                if (!preg_match('/http://.*?/', $matches[2])) {
                    //Incluindo o http caso ele não exista
                    $matches[1] = 'src=&quot;http://' . $_SERVER['SERVER_NAME'];
                }
                //Retornando todos os subpattern
                return $matches[1] . $matches[2] . $matches[3];
            }

            //print preg_replace($regex, 'img src=&quot;http://' . $_SERVER['SERVER_NAME'], $strContent);
            $vConteudo = str_replace('##RECOMENDA##', '', $strContent);
            $vConteudo = preg_replace_callback($regex, 'callback', $vConteudo);

            cache_set($vCacheId, $vConteudo, 'cache', time() + 60 * 120);
        } else {
            $vConteudo = $vCache->data;
        }

        print $vConteudo;
        die;
    } else if (!empty($arg1)) {
        $vCacheId = 'feed3' . $arg1;
        $vCache = cache_get($vCacheId, 'cache');
        $vConteudo = '';

        if (!$vCache) {

            $nids = db_query("  SELECT      nid
                        FROM        taxonomy_vocabulary AS tv
                        INNER JOIN  taxonomy_term_data AS tta ON tv.machine_name like '%$arg1%' AND tv.vid = tta.vid
                        INNER JOIN  taxonomy_index AS ti ON ti.tid = tta.tid
                        ORDER BY    ti.created DESC
                        LIMIT 10")->fetchCol();

            $channel['link'] = url($arg1, array('absolute' => TRUE));
            $channel['title'] = variable_get('site_name', 'Drupal') . ' - ' . $arg1;
            $channel['description'] = check_markup('Feed do site www.leiaja.com', '', '', TRUE);

            //Iniciando o output buffer e bloqueando qualquer saida para o navegador
            ob_start();

            //Padronizando e retornando o feed para o navegador
            node_feed($nids, $channel);

            //Recuperando os valores enviados para o navegador
            $strContent = ob_get_contents();

            ob_end_clean();

            //Expressão regular
            $regex = '/img src=&quot;/';

            $vConteudo = str_replace('##RECOMENDA##', '', $strContent);
            $vConteudo = preg_replace($regex, 'img src=&quot;http://' . $_SERVER['SERVER_NAME'], $vConteudo);

            cache_set($vConteudo, $vConteudo, 'cache', time() + 60 * 120);
        } else {
            $vConteudo = $vCache->data;
        }

        print $vConteudo;
        die;
    }
}

/**
 * Página com links para os feeds.
 * 
 * @return type
 */
function page_assine() {
    $vCacheId = 'PaginaAssine';
    $vCache = cache_get($vCacheId, 'cache');
    $vRetorno = '';

    if (!$vCache) {
        $vRetorno = theme('assine');
        cache_set($vCacheId, $vRetorno, 'cache', time() + 60 * 120);
    } else {
        $vRetorno = $vCache->data;
    }

    return $vRetorno;
}

/**
 * Página 2 com links para os feeds.
 * 
 * @return type
 */
function page_feed2() {

    return theme('feed2');
}

function exibirFeed2() {
    //path para incluir os scripts do analytics nos xmls
    $pathScripts = drupal_get_path('theme', 'leiaja2') . "/templates/scripts.php";

    //Expressão regular para encontrar as larguras no corpo da node
    $patternWidth = 'width=[\'\"][0-9]+[\'\"]';

    //Recuperando os valores do argumento 2 e 3 da url
    $arg1 = arg(2);
    $arg2 = arg(3);
    header('Content-Type: application/rss+xml; charset=utf-8');
    //Iniciando o objeto SimpleXMLElement
    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss></rss>');
    //Definindo a versão do xml
    $xml->addAttribute('version', '2.0');
    $xml->addAttribute('xml:xml:base', 'http://www.leiaja.com');
    $xml->addAttribute('xmlns:xmlns:dc', 'http://purl.org/dc/elements/1.1/');
    $xml->addAttribute('xmlns:xmlns:media', 'http://search.yahoo.com/mrss/');

    if (empty($arg1)) {
        
        $vCacheId = 'feedV2-1' . $arg1;
        $vCache = cache_get($vCacheId, 'cache');
        $vConteudo = '';

        if (!$vCache) {
            $nids = db_query("SELECT         ti.nid
                         FROM        taxonomy_vocabulary AS tv
                         INNER JOIN  taxonomy_term_data AS ttd
                         INNER JOIN  taxonomy_index AS ti

                         ON          tv.machine_name <> 'tags'
                         AND         tv.machine_name <> 'multimidia'
                         AND         tv.machine_name <> 'galerias'
                         AND         tv.machine_name <> 'politica'
                         AND         tv.machine_name <> 'blogs_parceiros'
                         AND         tv.machine_name <> 'agenda'
                         AND         tv.vid = ttd.vid
                         AND         ttd.tid = ti.tid
                         ORDER BY    ti.nid DESC
                         LIMIT       20")->fetchCol();
            //Adicionando o canal ao xml
            $channel = $xml->addChild('channel');
            $channel->addChild('title', variable_get('site_name', 'Drupal') . ' - RSS');
            $channel->addChild('link', url('feed2/rss', array('absolute' => TRUE)));
            $channel->addChild('description', 'Feed do site www.leiaja.com');
            //Carregando as nodes pelo id
            $objNodes = node_load_multiple($nids);

            //Colocando a primeira node com imagem no inicio do array
            foreach ($objNodes as $key => $node) {

                //Recuperando a imagem
                $imgCapa = field_get_items('node', $node, 'field_capa');
                $imgGaleria = field_get_items('node', $node, 'field_image');
                $imgTopo = field_get_items('node', $node, 'field_imagem_topo');

                if (!empty($imgCapa)) {
                    $img = $imgCapa[0]['uri'];
                } elseif (!empty($imgTopo)) {
                    $img = $imgTopo[0]['uri'];
                } elseif (!empty($imgGaleria)) {
                    $img = $imgGaleria[0]['uri'];
                } else {
                    $img = "";
                }

                if ($key > 0 && !empty($img)) {
                    $objNode = $objNodes[$key];
                    unset($objNodes[$key]);
                    array_unshift($objNodes, $objNode);
                    break;
                }
            }

            foreach ($objNodes as $key => $node) {
                $vConteudo = $node->body[key($node->body)][0]['value'];
                //Tratando as hashs no conteudo
                //removendo o recomenda
                $vConteudo = str_replace('##RECOMENDA##', "", $vConteudo);
                //removendo a hash de video
                if (!empty($node->field_image[key($node->field_image)]) && count($node->field_image[key($node->field_image)]) > 1) {
                    ob_start();
                    getGaleriaFull($node);
                    $galeria = ob_get_contents();
                    ob_end_clean();
                    $vConteudo = str_replace('[@#galeria#@]', $galeria, render($vConteudo));
                }
                //Removendo a hash do video               
                if (!empty($node->field_videost)) {
                    $objVideo = field_get_items('node', $node, 'field_videost');
                    $vConteudo = str_replace('[@#video#@]', $objVideo[0]['value'], $vConteudo);
                }
                //Removendo a hass do podcast
                if (!empty($node->field_audiost)) {
                    $objAudio = field_get_items('node', $node, 'field_audiost');
                    $vConteudo = str_replace('[@#podcast#@]', $objAudio[0]['value'], $vConteudo);
                }

                //Recuperando a imagem
                $imgCapa = field_get_items('node', $node, 'field_capa');
                $imgGaleria = field_get_items('node', $node, 'field_image');
                $imgTopo = field_get_items('node', $node, 'field_imagem_topo');

                if (!empty($imgCapa)) {
                    $img = $imgCapa[0]['uri'];
                } elseif (!empty($imgTopo)) {
                    $img = $imgTopo[0]['uri'];
                } elseif (!empty($imgGaleria)) {
                    $img = $imgGaleria[0]['uri'];
                } else {
                    $img = "http://www.leiaja.com/images/leiaja_acento.jpg";
                }

                //Expressão regular
                $regex = '/img src=&quot;/';
                $vConteudo = preg_replace($regex, 'img src=&quot;http://' . $_SERVER['SERVER_NAME'], $vConteudo);

                //Replace na largura do video
                $vConteudo = ereg_replace($patternWidth, 'width="350"', $vConteudo);

                //Carregando o objeto usuario
                $objUser = user_load($node->uid);
                //Criando o elemento item
                $item = $channel->addChild('item');
                $item->addChild('title', $node->title);
                $item->addChild('link', url('node/' . $node->nid, array('absolute' => TRUE)));
                $item->addChild('description', htmlspecialchars($vConteudo));
                $item->addChild('pubDate', date('r', $node->created));
                $item->addChild('dc:dc:creator', $objUser->name);
                if ($img != "http://www.leiaja.com/images/leiaja_acento.jpg") {
                    $item->addChild('media:media:content', '')->addAttribute('url', image_style_url('600x450', $img));
                }
                $item->addChild('photo', file_create_url($img));
                $item->addChild('guid', $node->nid . ' at ' . $_SERVER['SERVER_NAME'])->addAttribute('isPermalink', 'false');
            }

            cache_set($vCacheId, $xml->asXML(), 'cache', time() + 60 * 120);
            $xml = $xml->asXML();
        } else {
            $xml = $vCache->data;
        }

        echo $xml;
        include_once $pathScripts;
        die;
    } else if (!empty($arg2)) {
        $vCacheId = 'feedV2-2' . $arg2;
        $vCache = cache_get($vCacheId, 'cache');
        $vConteudo = '';

        if (!$vCache) {
            $result = db_query("SELECT      REPLACE(source, 'taxonomy/term/', '') AS tid 
                            FROM        url_alias 
                            WHERE       alias like '$arg1/$arg2'
                            ORDER BY    tid DESC")->fetchField();

            $term = taxonomy_term_load($result);
            $nids = taxonomy_select_nodes($term->tid, FALSE, 20, $order = array('t.created' => 'DESC'));

            //Adicionando o canal ao xml
            $channel = $xml->addChild('channel');
            $channel->addChild('title', variable_get('site_name', 'Drupal') . ' - ' . $term->name);
            $channel->addChild('link', url('taxonomy/term/' . $term->tid, array('absolute' => TRUE)));
            $channel->addChild('description', htmlspecialchars($term->description));

            //Carregando as nodes pelo id
            $objNodes = node_load_multiple($nids);

            //Colocando a primeira node com imagem no inicio do array
            foreach ($objNodes as $key => $node) {

                //Recuperando a imagem
                $imgCapa = field_get_items('node', $node, 'field_capa');
                $imgGaleria = field_get_items('node', $node, 'field_image');
                $imgTopo = field_get_items('node', $node, 'field_imagem_topo');

                if (!empty($imgCapa)) {
                    $img = $imgCapa[0]['uri'];
                } elseif (!empty($imgTopo)) {
                    $img = $imgTopo[0]['uri'];
                } elseif (!empty($imgGaleria)) {
                    $img = $imgGaleria[0]['uri'];
                } else {
                    $img = "";
                }

                if ($key > 0 && !empty($img)) {
                    $objNode = $objNodes[$key];
                    unset($objNodes[$key]);
                    array_unshift($objNodes, $objNode);
                    break;
                }
            }

            $image = '';
            foreach ($objNodes as $node) {
                $vConteudo = $node->body[key($node->body)][0]['value'];
                //Tratando as hashs no conteudo
                //removendo o recomenda
                $vConteudo = str_replace('##RECOMENDA##', "", $vConteudo);
                //removendo a hash de video
                if (!empty($node->field_image[key($node->field_image)]) && count($node->field_image[key($node->field_image)]) > 1) {
                    ob_start();
                    getGaleriaFull($node);
                    $galeria = ob_get_contents();
                    ob_end_clean();
                    $vConteudo = str_replace('[@#galeria#@]', $galeria, render($vConteudo));
                }
                //Removendo a hash do video               
                if (!empty($node->field_videost)) {
                    $objVideo = field_get_items('node', $node, 'field_videost');
                    $vConteudo = str_replace('[@#video#@]', $objVideo[0]['value'], $vConteudo);
                }
                //Removendo a hass do podcast
                if (!empty($node->field_audiost)) {

                    $objAudio = field_get_items('node', $node, 'field_audiost');
                    $vConteudo = str_replace('[@#podcast#@]', $objAudio[0]['value'], $vConteudo);
                }

                //Recuperando a imagem
                $imgCapa = field_get_items('node', $node, 'field_capa');
                $imgGaleria = field_get_items('node', $node, 'field_image');
                $imgTopo = field_get_items('node', $node, 'field_imagem_topo');

                if (!empty($imgCapa)) {
                    $img = $imgCapa[0]['uri'];
                } elseif (!empty($imgTopo)) {
                    $img = $imgTopo[0]['uri'];
                } elseif (!empty($imgGaleria)) {
                    $img = $imgGaleria[0]['uri'];
                } else {
                    $img = "http://www.leiaja.com/images/leiaja_acento.jpg";
                }

                //Expressão regular
                $regex = '/(src=&quot;)(.*?)(&quot;)/';

                //print preg_replace($regex, 'img src=&quot;http://' . $_SERVER['SERVER_NAME'], $strContent);
                $vConteudo = preg_replace_callback($regex, 'callback2', $vConteudo);
                
                //Replace na largura do video
                $vConteudo = ereg_replace($patternWidth, 'width="350"', $vConteudo);

                //Carregando o objeto usuario
                $objUser = user_load($node->uid);
                //Criando o elemento item
                $item = $channel->addChild('item');
                $item->addChild('title', $node->title);
                $item->addChild('link', url('node/' . $node->nid, array('absolute' => TRUE)));
                $item->addChild('description', htmlspecialchars($vConteudo));
                $item->addChild('pubDate', date('r', $node->created));
                $item->addChild('dc:dc:creator', $objUser->name);
                if ($img != "http://www.leiaja.com/images/leiaja_acento.jpg") {
                    $item->addChild('media:media:content', '')->addAttribute('url', image_style_url('600x450', $img));
                }
                $item->addChild('photo', file_create_url($img));
                $item->addChild('guid', $node->nid . ' at ' . $_SERVER['SERVER_NAME'])->addAttribute('isPermalink', 'false');
            }

            cache_set($vCacheId, $xml->asXML(), 'cache', time() + 60 * 120);
            $xml = $xml->asXML();
        } else {
            $xml = $vCache->data;
        }

        echo $xml;
        include_once $pathScripts;
        die;
    } else if (!empty($arg1)) {
        $vCacheId = 'feedv2-3' . $arg1;
        $vCache = cache_get($vCacheId, 'cache');
        $vConteudo = '';

        if (!$vCache) {

            $nids = db_query("  SELECT      nid
                        FROM        taxonomy_vocabulary AS tv
                        INNER JOIN  taxonomy_term_data AS tta ON tv.machine_name like '%$arg1%' AND tv.vid = tta.vid
                        INNER JOIN  taxonomy_index AS ti ON ti.tid = tta.tid
                        ORDER BY    ti.created DESC
                        LIMIT 20")->fetchCol();

            //Adicionando o canal ao xml
            $channel = $xml->addChild('channel');
            $channel->addChild('title', variable_get('site_name', 'Drupal') . ' - ' . $arg1);
            $channel->addChild('link', url($arg1, array('absolute' => TRUE)));
            $channel->addChild('description', 'Feed do site www.leiaja.com');

            //Carregando as nodes pelo id
            $objNodes = node_load_multiple($nids);

            //Colocando a primeira node com imagem no inicio do array
            foreach ($objNodes as $key => $node) {

                //Recuperando a imagem
                $imgCapa = field_get_items('node', $node, 'field_capa');
                $imgGaleria = field_get_items('node', $node, 'field_image');
                $imgTopo = field_get_items('node', $node, 'field_imagem_topo');

                if (!empty($imgCapa)) {
                    $img = $imgCapa[0]['uri'];
                } elseif (!empty($imgTopo)) {
                    $img = $imgTopo[0]['uri'];
                } elseif (!empty($imgGaleria)) {
                    $img = $imgGaleria[0]['uri'];
                } else {
                    $img = "";
                }

                if ($key > 0 && !empty($img)) {
                    $objNode = $objNodes[$key];
                    unset($objNodes[$key]);
                    array_unshift($objNodes, $objNode);
                    break;
                }
            }

            foreach ($objNodes as $node) {
                $vConteudo = $node->body[key($node->body)][0]['value'];
                //Tratando as hashs no conteudo
                //removendo o recomenda
                $vConteudo = str_replace('##RECOMENDA##', "", $vConteudo);
                //removendo a hash de video
                if (!empty($node->field_image[key($node->field_image)]) && count($node->field_image[key($node->field_image)]) > 1) {
                    ob_start();
                    getGaleriaFull($node);
                    $galeria = ob_get_contents();
                    ob_end_clean();
                    $vConteudo = str_replace('[@#galeria#@]', $galeria, render($vConteudo));
                }
                //Removendo a hash do video               
                if (!empty($node->field_videost)) {
                    $objVideo = field_get_items('node', $node, 'field_videost');
                    $vConteudo = str_replace('[@#video#@]', $objVideo[0]['value'], $vConteudo);
                }
                //Removendo a hass do podcast
                if (!empty($node->field_audiost)) {

                    $objAudio = field_get_items('node', $node, 'field_audiost');
                    $vConteudo = str_replace('[@#podcast#@]', $objAudio[0]['value'], $vConteudo);
                }

                //Recuperando a imagem
                $imgCapa = field_get_items('node', $node, 'field_capa');
                $imgGaleria = field_get_items('node', $node, 'field_image');
                $imgTopo = field_get_items('node', $node, 'field_imagem_topo');

                if (!empty($imgCapa)) {
                    $img = $imgCapa[0]['uri'];
                } elseif (!empty($imgTopo)) {
                    $img = $imgTopo[0]['uri'];
                } elseif (!empty($imgGaleria)) {
                    $img = $imgGaleria[0]['uri'];
                } else {
                    $img = "http://www.leiaja.com/images/leiaja_acento.jpg";
                }

                //Expressão regular
                $regex = '/img src=&quot;/';
                $vConteudo = preg_replace($regex, 'img src=&quot;http://' . $_SERVER['SERVER_NAME'], $vConteudo);
                
                //Replace na largura do video
                $vConteudo = ereg_replace($patternWidth, 'width="350"', $vConteudo);

                //Carregando o objeto usuario
                $objUser = user_load($node->uid);
                //Criando o elemento item
                $item = $channel->addChild('item');
                $item->addChild('title', $node->title);
                $item->addChild('link', url('node/' . $node->nid, array('absolute' => TRUE)));
                $item->addChild('description', htmlspecialchars($vConteudo));
                $item->addChild('pubDate', date('r', $node->created));
                $item->addChild('dc:dc:creator', $objUser->name);
                if ($img != "http://www.leiaja.com/images/leiaja_acento.jpg") {
                    $item->addChild('media:media:content', '')->addAttribute('url', image_style_url('600x450', $img));
                }
                $item->addChild('photo', file_create_url($img));
                $item->addChild('guid', $node->nid . ' at ' . $_SERVER['SERVER_NAME'])->addAttribute('isPermalink', 'false');
            }

            cache_set($vCacheId, $xml->asXML(), 'cache', time() + 60 * 120);
            $xml = $xml->asXML();
        } else {
            $xml = $vCache->data;
        }

        echo $xml;
        include_once $pathScripts;
        die;
    }
}


/**
 * Página 3 com links para os feeds.
 * 
 * @return type
 */
function page_feed3() {

    return theme('feed3');
}

function exibirFeed3() {
    //path para incluir os scripts do analytics nos xmls
    //$pathScripts = drupal_get_path('theme', 'leiaja2') . "/templates/scripts.php";

    //Expressão regular para encontrar as larguras no corpo da node
    $patternWidth = 'width=[\'\"][0-9]+[\'\"]';

    //Recuperando os valores do argumento 2 e 3 da url
    $arg1 = arg(2);
    $arg2 = arg(3);
    header('Content-Type: application/rss+xml; charset=utf-8');
    //Iniciando o objeto SimpleXMLElement
    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss></rss>');
    //Definindo a versão do xml
    $xml->addAttribute('version', '2.0');
    $xml->addAttribute('xml:xml:base', 'http://www.leiaja.com');
    $xml->addAttribute('xmlns:xmlns:dc', 'http://purl.org/dc/elements/1.1/');
    $xml->addAttribute('xmlns:xmlns:media', 'http://search.yahoo.com/mrss/');

    if (empty($arg1)) {
        
        $vCacheId = 'feedV3-1' . $arg1;
        $vCache = cache_get($vCacheId, 'cache');
        $vConteudo = '';

        if (!$vCache) {
            $nids = db_query("SELECT ti.nid
                         FROM        taxonomy_vocabulary AS tv
                         INNER JOIN  taxonomy_term_data AS ttd
                         INNER JOIN  taxonomy_index AS ti

                         ON          tv.machine_name <> 'tags'
                         AND         tv.machine_name <> 'multimidia'
                         AND         tv.machine_name <> 'galerias'
                         AND         tv.machine_name <> 'politica'
                         AND         tv.machine_name <> 'blogs_parceiros'
                         AND         tv.machine_name <> 'agenda'
                         AND         tv.vid = ttd.vid
                         AND         ttd.tid = ti.tid
                         ORDER BY    ti.nid DESC
                         LIMIT       20")->fetchCol();
            //Adicionando o canal ao xml
            $channel = $xml->addChild('channel');
            $channel->addChild('title', variable_get('site_name', 'Drupal') . ' - RSS');
            $channel->addChild('link', url('feed3/rss', array('absolute' => TRUE)));
            $channel->addChild('description', 'Feed do site www.leiaja.com');
            //Carregando as nodes pelo id
            $objNodes = node_load_multiple($nids);

            //Colocando a primeira node com imagem no inicio do array
            foreach ($objNodes as $key => $node) {

                //Recuperando a imagem
                $imgCapa = field_get_items('node', $node, 'field_capa');
                $imgGaleria = field_get_items('node', $node, 'field_image');
                $imgTopo = field_get_items('node', $node, 'field_imagem_topo');

                if (!empty($imgCapa)) {
                    $img = $imgCapa[0]['uri'];
                } elseif (!empty($imgTopo)) {
                    $img = $imgTopo[0]['uri'];
                } elseif (!empty($imgGaleria)) {
                    $img = $imgGaleria[0]['uri'];
                } else {
                    $img = "";
                }

                if ($key > 0 && !empty($img)) {
                    $objNode = $objNodes[$key];
                    unset($objNodes[$key]);
                    array_unshift($objNodes, $objNode);
                    break;
                }
            }

            foreach ($objNodes as $key => $node) {

                $vConteudo = $node->body[key($node->body)][0]['summary'];
                //Tratando as hashs no conteudo
                //removendo o recomenda
                $vConteudo = str_replace('##RECOMENDA##', "", $vConteudo);
                //removendo a hash de video
                if (!empty($node->field_image[key($node->field_image)]) && count($node->field_image[key($node->field_image)]) > 1) {
                    ob_start();
                    getGaleriaFull($node);
                    $galeria = ob_get_contents();
                    ob_end_clean();
                    $vConteudo = str_replace('[@#galeria#@]', "", $vConteudo);
                }
                //Removendo a hash do video               
                if (!empty($node->field_videost)) {
                    $objVideo = field_get_items('node', $node, 'field_videost');
                    $vConteudo = str_replace('[@#video#@]', "", $vConteudo);
                }
                //Removendo a hass do podcast
                if (!empty($node->field_audiost)) {
                    $objAudio = field_get_items('node', $node, 'field_audiost');
                    $vConteudo = str_replace('[@#podcast#@]', "", $vConteudo);
                }

                //Recuperando a imagem
                $imgCapa = field_get_items('node', $node, 'field_capa');
                $imgGaleria = field_get_items('node', $node, 'field_image');
                $imgTopo = field_get_items('node', $node, 'field_imagem_topo');

                if (!empty($imgCapa)) {
                    $img = $imgCapa[0]['uri'];
                } elseif (!empty($imgTopo)) {
                    $img = $imgTopo[0]['uri'];
                } elseif (!empty($imgGaleria)) {
                    $img = $imgGaleria[0]['uri'];
                } else {
                    $img = "http://www.leiaja.com/images/LeiaJa_paineltvs.jpg";
                }

                //Expressão regular
                $regex = '/img src=&quot;/';
                $vConteudo = preg_replace($regex, 'img src=&quot;http://' . $_SERVER['SERVER_NAME'], $vConteudo);

                //Replace na largura do video
                $vConteudo = ereg_replace($patternWidth, 'width="350"', $vConteudo);

                //Carregando o objeto usuario
                $objUser = user_load($node->uid);
                //Criando o elemento item
                $item = $channel->addChild('item');
                $item->addChild('title', $node->title);
                $item->addChild('link', url('node/' . $node->nid, array('absolute' => TRUE)));
                $item->addChild('description', htmlspecialchars($vConteudo));
                $item->addChild('pubDate', date('r', $node->created));
                $item->addChild('dc:dc:creator', $objUser->name);
                if ($img != "http://www.leiaja.com/images/LeiaJa_paineltvs.jpg") {
                    $item->addChild('media:media:content', '')->addAttribute('url', image_style_url('600x450', $img));
                }
                $item->addChild('photo', file_create_url($img));
                $item->addChild('guid', $node->nid . ' at ' . $_SERVER['SERVER_NAME'])->addAttribute('isPermalink', 'false');
            }

            cache_set($vCacheId, $xml->asXML(), 'cache', time() + 60 * 120);
            $xml = $xml->asXML();
        } else {
            $xml = $vCache->data;
        }

        echo $xml;
        include_once $pathScripts;
        die;
    } else if (!empty($arg2)) {
        $vCacheId = 'feedV3-2' . $arg2;
        $vCache = cache_get($vCacheId, 'cache');
        $vConteudo = '';

        if (!$vCache) {
            $result = db_query("SELECT REPLACE(source, 'taxonomy/term/', '') AS tid 
                            FROM        url_alias 
                            WHERE       alias like '$arg1/$arg2'
                            ORDER BY    tid DESC")->fetchField();

            $term = taxonomy_term_load($result);
            $nids = taxonomy_select_nodes($term->tid, FALSE, 20, $order = array('t.created' => 'DESC'));

            //Adicionando o canal ao xml
            $channel = $xml->addChild('channel');
            $channel->addChild('title', variable_get('site_name', 'Drupal') . ' - ' . $term->name);
            $channel->addChild('link', url('taxonomy/term/' . $term->tid, array('absolute' => TRUE)));
            $channel->addChild('description', htmlspecialchars($term->description));

            //Carregando as nodes pelo id
            $objNodes = node_load_multiple($nids);

            //Colocando a primeira node com imagem no inicio do array
            foreach ($objNodes as $key => $node) {

                //Recuperando a imagem
                $imgCapa = field_get_items('node', $node, 'field_capa');
                $imgGaleria = field_get_items('node', $node, 'field_image');
                $imgTopo = field_get_items('node', $node, 'field_imagem_topo');

                if (!empty($imgCapa)) {
                    $img = $imgCapa[0]['uri'];
                } elseif (!empty($imgTopo)) {
                    $img = $imgTopo[0]['uri'];
                } elseif (!empty($imgGaleria)) {
                    $img = $imgGaleria[0]['uri'];
                } else {
                    $img = "";
                }

                if ($key > 0 && !empty($img)) {
                    $objNode = $objNodes[$key];
                    unset($objNodes[$key]);
                    array_unshift($objNodes, $objNode);
                    break;
                }
            }

            $image = '';
            foreach ($objNodes as $node) {
               
                $vConteudo = $node->body[key($node->body)][0]['summary'];
                //Tratando as hashs no conteudo
                //removendo o recomenda
                $vConteudo = str_replace('##RECOMENDA##', "", $vConteudo);
                //removendo a hash de video
                if (!empty($node->field_image[key($node->field_image)]) && count($node->field_image[key($node->field_image)]) > 1) {
                    ob_start();
                    getGaleriaFull($node);
                    $galeria = ob_get_contents();
                    ob_end_clean();
                    $vConteudo = str_replace('[@#galeria#@]', "", $vConteudo);
                }
                //Removendo a hash do video               
                if (!empty($node->field_videost)) {
                    $objVideo = field_get_items('node', $node, 'field_videost');
                    $vConteudo = str_replace('[@#video#@]', "", $vConteudo);
                }
                //Removendo a hass do podcast
                if (!empty($node->field_audiost)) {

                    $objAudio = field_get_items('node', $node, 'field_audiost');
                    $vConteudo = str_replace('[@#podcast#@]', "", $vConteudo);
                }

                //Recuperando a imagem
                $imgCapa = field_get_items('node', $node, 'field_capa');
                $imgGaleria = field_get_items('node', $node, 'field_image');
                $imgTopo = field_get_items('node', $node, 'field_imagem_topo');

                if (!empty($imgCapa)) {
                    $img = $imgCapa[0]['uri'];
                } elseif (!empty($imgTopo)) {
                    $img = $imgTopo[0]['uri'];
                } elseif (!empty($imgGaleria)) {
                    $img = $imgGaleria[0]['uri'];
                } else {
                    $img = "http://www.leiaja.com/images/LeiaJa_paineltvs.jpg";
                }

                //Expressão regular
                $regex = '/(src=&quot;)(.*?)(&quot;)/';

                //print preg_replace($regex, 'img src=&quot;http://' . $_SERVER['SERVER_NAME'], $strContent);
                $vConteudo = preg_replace_callback($regex, 'callback2', $vConteudo);
                
                //Replace na largura do video
                $vConteudo = ereg_replace($patternWidth, 'width="350"', $vConteudo);

                //Carregando o objeto usuario
                $objUser = user_load($node->uid);
                //Criando o elemento item
                $item = $channel->addChild('item');
                $item->addChild('title', $node->title);
                $item->addChild('link', url('node/' . $node->nid, array('absolute' => TRUE)));
                $item->addChild('description', htmlspecialchars($vConteudo));
                $item->addChild('pubDate', date('r', $node->created));
                $item->addChild('dc:dc:creator', $objUser->name);
                if ($img != "http://www.leiaja.com/images/LeiaJa_paineltvs.jpg") {
                    $item->addChild('media:media:content', '')->addAttribute('url', image_style_url('600x450', $img));
                }
                $item->addChild('photo', file_create_url($img));
                $item->addChild('guid', $node->nid . ' at ' . $_SERVER['SERVER_NAME'])->addAttribute('isPermalink', 'false');
            }

            cache_set($vCacheId, $xml->asXML(), 'cache', time() + 60 * 120);
            $xml = $xml->asXML();
        } else {
            $xml = $vCache->data;
        }

        echo $xml;
        include_once $pathScripts;
        die;
    } else if (!empty($arg1)) {
        $vCacheId = 'feedv3-3' . $arg1;
        $vCache = cache_get($vCacheId, 'cache');
        $vConteudo = '';

        if (!$vCache) {

            $nids = db_query("  SELECT      nid
                        FROM        taxonomy_vocabulary AS tv
                        INNER JOIN  taxonomy_term_data AS tta ON tv.machine_name like '%$arg1%' AND tv.vid = tta.vid
                        INNER JOIN  taxonomy_index AS ti ON ti.tid = tta.tid
                        ORDER BY    ti.created DESC
                        LIMIT 20")->fetchCol();

            //Adicionando o canal ao xml
            $channel = $xml->addChild('channel');
            $channel->addChild('title', variable_get('site_name', 'Drupal') . ' - ' . $arg1);
            $channel->addChild('link', url($arg1, array('absolute' => TRUE)));
            $channel->addChild('description', 'Feed do site www.leiaja.com');

            //Carregando as nodes pelo id
            $objNodes = node_load_multiple($nids);

            //Colocando a primeira node com imagem no inicio do array
            foreach ($objNodes as $key => $node) {

                //Recuperando a imagem
                $imgCapa = field_get_items('node', $node, 'field_capa');
                $imgGaleria = field_get_items('node', $node, 'field_image');
                $imgTopo = field_get_items('node', $node, 'field_imagem_topo');

                if (!empty($imgCapa)) {
                    $img = $imgCapa[0]['uri'];
                } elseif (!empty($imgTopo)) {
                    $img = $imgTopo[0]['uri'];
                } elseif (!empty($imgGaleria)) {
                    $img = $imgGaleria[0]['uri'];
                } else {
                    $img = "";
                }

                if ($key > 0 && !empty($img)) {
                    $objNode = $objNodes[$key];
                    unset($objNodes[$key]);
                    array_unshift($objNodes, $objNode);
                    break;
                }
            }

            foreach ($objNodes as $node) {
                $vConteudo = $node->body[key($node->body)][0]['summary'];
                //Tratando as hashs no conteudo
                //removendo o recomenda
                $vConteudo = str_replace('##RECOMENDA##', "", $vConteudo);
                //removendo a hash de video
                if (!empty($node->field_image[key($node->field_image)]) && count($node->field_image[key($node->field_image)]) > 1) {
                    ob_start();
                    getGaleriaFull($node);
                    $galeria = ob_get_contents();
                    ob_end_clean();
                    $vConteudo = str_replace('[@#galeria#@]', "", $vConteudo);
                }
                //Removendo a hash do video               
                if (!empty($node->field_videost)) {
                    $objVideo = field_get_items('node', $node, 'field_videost');
                    $vConteudo = str_replace('[@#video#@]', "", $vConteudo);
                }
                //Removendo a hass do podcast
                if (!empty($node->field_audiost)) {

                    $objAudio = field_get_items('node', $node, 'field_audiost');
                    $vConteudo = str_replace('[@#podcast#@]', "", $vConteudo);
                }

                //Recuperando a imagem
                $imgCapa = field_get_items('node', $node, 'field_capa');
                $imgGaleria = field_get_items('node', $node, 'field_image');
                $imgTopo = field_get_items('node', $node, 'field_imagem_topo');

                if (!empty($imgCapa)) {
                    $img = $imgCapa[0]['uri'];
                } elseif (!empty($imgTopo)) {
                    $img = $imgTopo[0]['uri'];
                } elseif (!empty($imgGaleria)) {
                    $img = $imgGaleria[0]['uri'];
                } else {
                    $img = "http://www.leiaja.com/images/LeiaJa_paineltvs.jpg";
                }

                //Expressão regular
                $regex = '/img src=&quot;/';
                $vConteudo = preg_replace($regex, 'img src=&quot;http://' . $_SERVER['SERVER_NAME'], $vConteudo);
                
                //Replace na largura do video
                $vConteudo = ereg_replace($patternWidth, 'width="350"', $vConteudo);

                //Carregando o objeto usuario
                $objUser = user_load($node->uid);
                //Criando o elemento item
                $item = $channel->addChild('item');
                $item->addChild('title', $node->title);
                $item->addChild('link', url('node/' . $node->nid, array('absolute' => TRUE)));
                $item->addChild('description', htmlspecialchars($vConteudo));
                $item->addChild('pubDate', date('r', $node->created));
                $item->addChild('dc:dc:creator', $objUser->name);
                if ($img != "http://www.leiaja.com/images/LeiaJa_paineltvs.jpg") {
                    $item->addChild('media:media:content', '')->addAttribute('url', image_style_url('600x450', $img));
                }
                $item->addChild('photo', file_create_url($img));
                $item->addChild('guid', $node->nid . ' at ' . $_SERVER['SERVER_NAME'])->addAttribute('isPermalink', 'false');
            }

            cache_set($vCacheId, $xml->asXML(), 'cache', time() + 60 * 120);
            $xml = $xml->asXML();
        } else {
            $xml = $vCache->data;
        }

        echo $xml;
        include_once $pathScripts;
        die;
    }
}


//Função de callback para ser usado no preg_replace_callback
function callback2($matches) {
    //Verifica se exiete http na string
    if (!preg_match('/http://.*?/', $matches[2])) {
        //Incluindo o http caso ele não exista
        $matches[1] = 'src=&quot;http://' . $_SERVER['SERVER_NAME'];
    }
    //Retornando todos os subpattern
    return $matches[1] . $matches[2] . $matches[3];
}
