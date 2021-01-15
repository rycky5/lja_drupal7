<?php

//Incluindo o arquivo integracao_novaa_capa.db.inc
module_load_include('inc', 'integracao_nova_capa', 'integracao_nova_capa.db');

//Funcao que recupera os nids e montas a listagem de noticias
function api_getNoticias($numeroDeItens, $caderno) {
    //Variavel q vai conter o obj de nodes
    $arrObjNode = array();
    //Variavel com o json q vai ser retornado
    $jsonRetorno = array();

    //Recuperando os nids dos nodes
    $arrNids = db_getNoticias($numeroDeItens, $caderno);

    //Percorrendo os nids e carregando as nodes
    foreach ($arrNids as $value) {
        $arrObjNode[] = node_load($value->nid);
    }
    //Percorrendo as node
    foreach ($arrObjNode as $node) {

        $strNid = $node->nid;
        $strTitulo = $node->title;
        $strCreated = date('Y/m/d H:i', $node->created);
        $strTimestamp = $node->created;
        $strVideo = (!empty($node->field_videost)) ? 1 : 0;
        $strAudio = (!empty($node->field_audiost)) ? 1 : 0;
        $strCaderno = $node->type;
        $strImagemCapa = (!empty($node->field_capa)) ? $node->field_capa[key($node->field_capa)][0]['uri'] : "";
        $strGaleria = (!empty($node->field_image)) ? $node->field_image[key($node->field_image)][0]['uri'] : "";
        $strImagemTopo = (!empty($node->field_imagem_topo)) ? $node->field_imagem_topo[key($node->field_imagem_topo)][0]['uri'] : "";
        $strNodeUri = url('node/' . $node->nid, array('absolute' => FALSE));

        $strImgUri = "";
        //Criando a url caso ela exista
        if (!empty($strImagemCapa)) {
            $strImgUri = file_create_url($strImagemCapa);
        } elseif (!empty($strGaleria)) {
            $strImgUri = file_create_url($strGaleria);
        } elseif (!empty($strImagemTopo)) {
            $strImgUri = $strImagemTopo;
        } else {
            $strImgUri = NULL;
        }
        //Verificando se existe alguma url
        $strImage = ($strImgUri !== NULL) ? 1 : 0;

        //Variavel q vai ter o tid da taxonomia para carregar o objeto
        $tid = "";

        switch ($node->type) {
            case "caderno_esportes":
                $tid = $node->field_catesporte[key($node->field_catesporte)][0]['tid'];
                break;
            case "caderno_carreiras":
                $tid = $node->field_catnegocios[key($node->field_catnegocios)][0]['tid'];
                break;
            case "caderno_cultura":
                $tid = $node->field_catcultura[key($node->field_catcultura)][0]['tid'];
                break;
            case "caderno_tecnologia":
                $tid = $node->field_cattecnologia[key($node->field_cattecnologia)][0]['tid'];
                break;
            case "caderno_noticias":
                $tid = $node->field_catnoticia[key($node->field_catnoticia)][0]['tid'];
                break;
            case "caderno_multimidia":
                $tid = $node->field_catradiotv[key($node->field_catradiotv)][0]['tid'];
                break;
            case "caderno_colunistas":
                $tid = $node->field_catcolunista[key($node->field_catcolunista)][0]['tid'];
                break;
            case "caderno_politica":
                $tid = $node->field_catpolitica[key($node->field_catpolitica)][0]['tid'];
                break;
            case "blogs_da_redacao":
                $tid = $node->field_catblog[key($node->field_catblog)][0]['tid'];
                break;
        }

        $objTaxonomy = taxonomy_term_load($tid);

        $jsonRetorno[] = array(
            'nid' => $strNid,
            'titulo' => $strTitulo,
            'created' => $strCreated,
            'timestamp' => $strTimestamp,
            'caderno' => $strCaderno,
            'subCategoria' => $objTaxonomy->name,
            'video' => $strVideo,
            'audio' => $strAudio,
            'image' => $strImage,
            'imageUrl' => $strImgUri,
            'nodeUrl' => $strNodeUri
        );
    }

    return json_encode($jsonRetorno);
}

//Funcao que recupera os nids e monta os jsons para o mobile
function api_gerarJson() {

    //Array com todos os cadernos
    $arrCadernos = array('all', 'caderno_noticias', 'caderno_politica', 'caderno_carreiras', 'caderno_esportes', 'caderno_cultura', 'caderno_tecnologia', 'caderno_colunistas');

    //Variavel que vai retornar o json formatado
    $jsonRetorno = array();

    //Gerando os jsons
    foreach ($arrCadernos as $caderno) {

        //Variavel q vai conter o obj de nodes
        $arrObjNode = array();

        //Recuperando os nids dos nodes
        $arrNids = db_getNoticias(100, $caderno);


        //Percorrendo os nids e carregando as nodes
        foreach ($arrNids as $value) {
            $arrObjNode[] = node_load($value->nid);
        }

        if ($caderno == 'all') {
            //Array para as nodes do nodequeue
            $arrObjNodeQueue = '';
            $nidNodeQueue = views_get_view_result('nodequeue_6', 'page');

            foreach ($nidNodeQueue as $objQueue) {
                $arrObjNodeQueue[] = node_load($objQueue->nid);
            }

            $jsonRetornoTemp = __api_formatarJson($arrObjNode);
            $jsonQueue = __api_formatarJson($arrObjNodeQueue);
            $maxQueue = count($jsonQueue);
            
            
            for ($i = 0; $i < $maxQueue; $i++) {
                $jsonRetorno[] = $jsonRetornoTemp[$i];
                $jsonRetorno[] = $jsonQueue[$i];
            }
            
            for($b = $maxQueue; $b <= 99; $b++){
                $jsonRetorno[] = $jsonRetornoTemp[$b];
            }
            
        }else{
            $jsonRetorno = __api_formatarJson($arrObjNode);
        }
        echo "<pre>";
        print_r($jsonRetorno);
        die();
        $pastaCaderno = ($caderno == 'all') ? '' : $caderno;
        $pathCadernoJson = PATH_JSON . DIRECTORY_SEPARATOR . $pastaCaderno;

        if (!is_dir($pathCadernoJson)) {
            mkdir($pathCadernoJson);
        }

        header("Content-Type: application/json");

        $file = fopen($pathCadernoJson . DIRECTORY_SEPARATOR . "mobile.json", 'w+');
        fwrite($file, json_encode($jsonRetorno));
        fclose($file);
    }
}

//Funcao q vai retornar o objeto noticia formatdo
function api_montarNoticia($nid) {

    //Verificando se a variavel $_POST esta setado e vazia
    if (empty($nid)) {
        die('Nenhum id foi encontrado.');
    }

    $objNode = node_load($nid);

    $strNid = $objNode->nid;
    $strTitulo = $objNode->title;
    $strCreated = date('Y/m/d H:i', $objNode->created);
    $strCaderno = $objNode->type;
    $strChamadaCapa = (!empty($objNode->field_chamada_capa)) ? $objNode->field_chamada_capa[key($objNode->field_chamada_capa)][0]['value'] : $objNode->body[key($objNode->body)][0]['summary'];
    $strVideo = (!empty($objNode->field_videost)) ? 1 : 0;
    $strAudio = (!empty($objNode->field_audiost)) ? 1 : 0;
    $strImagemCapa = (!empty($objNode->field_capa)) ? $objNode->field_capa[key($objNode->field_capa)][0]['uri'] : "";
    $strImagemTopo = (!empty($objNode->field_imagem_topo)) ? $objNode->field_imagem_topo[key($objNode->field_imagem_topo)][0]['uri'] : "";
    $strGaleria = (!empty($objNode->field_image)) ? $objNode->field_image[key($objNode->field_image)][0]['uri'] : "";
    $strNodeUri = url('node/' . $objNode->nid, array('absolute' => FALSE));

    $strImgUri = "";
    if (!empty($strImagemCapa)) {
        $strImgUri = file_create_url($strImagemCapa);
        $strImgUri = parse_url($strImgUri);
        $strImgUri = LEIAJAURL . $strImgUri['path'];
    } elseif (!empty($strGaleria)) {
        $strImgUri = file_create_url($strGaleria);
        $strImgUri = parse_url($strImgUri);
        $strImgUri = LEIAJAURL . $strImgUri['path'];
    } elseif (!empty($strImagemTopo)) {
        $strImgUri = file_create_url($strImagemTopo);
        //$strImgUri = str_replace(LEIAJAURL, '', $strImgUri);
//        $strImgUri = parse_url($strImagemTopo);
//        $strImgUri = $strImgUri['path'];
    } else {
        $strImgUri = NULL;
    }

    $strImage = ($strImgUri !== NULL) ? 1 : 0;

    //Variavel q vai ter o tid da taxonomia para carregar o objeto
    $tid = "";

    switch ($objNode->type) {
        case "caderno_esportes":
            $tid = $objNode->field_catesporte[key($objNode->field_catesporte)][0]['tid'];
            break;
        case "caderno_carreiras":
            $tid = $objNode->field_catnegocios[key($objNode->field_catnegocios)][0]['tid'];
            break;
        case "caderno_cultura":
            $tid = $objNode->field_catcultura[key($objNode->field_catcultura)][0]['tid'];
            break;
        case "caderno_tecnologia":
            $tid = $objNode->field_cattecnologia[key($objNode->field_cattecnologia)][0]['tid'];
            break;
        case "caderno_noticias":
            $tid = $objNode->field_catnoticia[key($objNode->field_catnoticia)][0]['tid'];
            break;
        case "caderno_multimidia":
            $tid = $objNode->field_catradiotv[key($objNode->field_catradiotv)][0]['tid'];
            break;
        case "caderno_colunistas":
            $tid = $objNode->field_catcolunista[key($objNode->field_catcolunista)][0]['tid'];
            break;
        case "caderno_politica":
            $tid = $objNode->field_catpolitica[key($objNode->field_catpolitica)][0]['tid'];
            break;
        case "blogs_da_redacao":
            $tid = $objNode->field_catblog[key($objNode->field_catblog)][0]['tid'];
            break;
    }

    $objTaxonomy = taxonomy_term_load($tid);


    $jsonRetorno = array(
        'nid' => $strNid,
        'titulo' => $strTitulo,
        'url' => LEIAJAURL . $strNodeUri,
        'created' => $strCreated,
        'caderno' => $strCaderno,
        'subCategoria' => $objTaxonomy->name,
        'chamadaCapa' => $strChamadaCapa,
        'video' => $strVideo,
        'audio' => $strAudio,
        'image' => $strImage,
        'imageUrl' => $strImgUri
    );

    return json_encode($jsonRetorno);
}

//Função que vai croppar e salvar a imagem em um diretorio
function api_imageCrop($arrCrop) {

    $hash = mktime();
    $vDir = NOVACAPAIMGDIR . DIRECTORY_SEPARATOR . date('Y', time()) . DIRECTORY_SEPARATOR . date('m', time()) . DIRECTORY_SEPARATOR . date('d', time());
    $imgDirName = $vDir . DIRECTORY_SEPARATOR . str_replace(' ', '_', strtolower(transliteration_get($arrCrop['titulo']))) . $hash . '.jpg';
    $imgUri = LEIAJAURL . '/sites/default/files/capa/';
    //Verificando se o diretorio existe
    if (!is_dir($vDir)) {
        //Criando o diretorio
        if (mkdir($vDir, 0777, TRUE)) {

            $targ_w = $arrCrop['imageW'];
            $targ_h = $arrCrop['imageH'];
            $jpeg_quality = 70;

            $src = $arrCrop['imgUrl'];
            $img_r = imagecreatefromjpeg($src);
            $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

            imagecopyresampled($dst_r, $img_r, 0, 0, $arrCrop['c']['x'], $arrCrop['c']['y'], $targ_w, $targ_h, $arrCrop['c']['w'], $arrCrop['c']['h']);

            header('Content-type: image/jpeg');
            imagejpeg($dst_r, $imgDirName, $jpeg_quality);
            //Retornando a url completa da imagem
            return $imgUri . date('Y', time()) . '/' . date('m', time()) . '/' . date('d', time()) . '/' . str_replace(' ', '_', strtolower(transliteration_get($arrCrop['titulo']))) . $hash . '.jpg';
        }
    } else {

        $targ_w = $arrCrop['imageW'];
        $targ_h = $arrCrop['imageH'];
        $jpeg_quality = 70;

        $src = $arrCrop['imgUrl'];
        $img_r = imagecreatefromjpeg($src);
        $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

        imagecopyresampled($dst_r, $img_r, 0, 0, $arrCrop['c']['x'], $arrCrop['c']['y'], $targ_w, $targ_h, $arrCrop['c']['w'], $arrCrop['c']['h']);

        header('Content-type: image/jpeg');
        imagejpeg($dst_r, $imgDirName, $jpeg_quality);
        //Retornando a url completa da imagem
        return $imgUri . date('Y', time()) . '/' . date('m', time()) . '/' . date('d', time()) . '/' . str_replace(' ', '_', strtolower(transliteration_get($arrCrop['titulo']))) . $hash . '.jpg';
    }
}

//Função que vai salvar uma nova imagem no diretorio
function api_novaImagem($file) {

    $vDir = NOVACAPAIMGDIR . DIRECTORY_SEPARATOR . date('Y', time()) . DIRECTORY_SEPARATOR . date('m', time()) . DIRECTORY_SEPARATOR . date('d', time());
    $imgDirName = $vDir . DIRECTORY_SEPARATOR . str_replace(' ', '_', strtolower(transliteration_get($arrCrop['titulo']))) . '.jpg';
    $imgUri = LEIAJAURL . '/sites/default/files/capa/';

    $arrExtensoes = array('image/jpeg', 'image/png', 'image/gif');

    if ($file['erro'] == 0 && in_array($file['type'], $arrExtensoes)) {
        if (!is_dir($vDir)) {
            //Criando o diretorio
            if (mkdir($vDir, 0777, TRUE)) {
                move_uploaded_file($file['tmp_name'], $vDir . DIRECTORY_SEPARATOR . str_replace(' ', '_', strtolower(transliteration_get($file['name']))));
                return $imgUri . date('Y', time()) . '/' . date('m', time()) . '/' . date('d', time()) . '/' . str_replace(' ', '_', strtolower(transliteration_get($file['name'])));
            }
        } else {
            move_uploaded_file($file['tmp_name'], $vDir . DIRECTORY_SEPARATOR . str_replace(' ', '_', strtolower(transliteration_get($file['name']))));
            return $imgUri . date('Y', time()) . '/' . date('m', time()) . '/' . date('d', time()) . '/' . str_replace(' ', '_', strtolower(transliteration_get($file['name'])));
        }
    }
}

//Função que vai deletar uma imagem do diretorio
function api_destroiImagem($url) {

    $objUrl = pathinfo(parse_url($url, PHP_URL_PATH));

    if (is_file(NOVACAPAIMGDIRBASE . DIRECTORY_SEPARATOR . $objUrl['dirname'] . DIRECTORY_SEPARATOR . $objUrl['basename'])) {
        return unlink(NOVACAPAIMGDIRBASE . DIRECTORY_SEPARATOR . $objUrl['dirname'] . DIRECTORY_SEPARATOR . $objUrl['basename']);
    } else {
        return 'o arquivo n existe';
    }
}

//Funç]ao que vai salvar o historico de capa
function api_salvarCapa($dadosCapa) {

    if (!isset($dadosCapa['html']) || !isset($dadosCapa['matriz']) || !isset($dadosCapa['nome']) || !isset($dadosCapa['tipo']) ||
            !isset($dadosCapa['status']) || !isset($dadosCapa['usuario'])) {
        return 'Os dados não podem ser recuperados';
        die;
    } else {

        //Verificando qual o ambiente da aplicação
        if (strstr($_SERVER['SERVER_NAME'], 'www4')) {
            $dadosCapa['html'] = str_replace('../..//', 'http://www4.leiaja.com/sites/all/themes/leiaja2/css/', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('../../', 'http://www4.leiaja.com/sites/all/themes/leiaja2/css/', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('<pre class="titulo">', '', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('</pre>', '', $dadosCapa['html']);
        } else if (strstr($_SERVER['SERVER_NAME'], 'www3')) {
            $dadosCapa['html'] = str_replace('../..//', 'http://www3.leiaja.com/sites/all/themes/leiaja2/css/', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('../../', 'http://www3.leiaja.com/sites/all/themes/leiaja2/css/', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('<pre class="titulo">', '', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('</pre>', '', $dadosCapa['html']);
        } else {
            $dadosCapa['html'] = str_replace('../..//', 'http://www.leiaja.com/sites/all/themes/leiaja2/css/', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('../../', 'http://www.leiaja.com/sites/all/themes/leiaja2/css/', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('<pre class="titulo">', '', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('</pre>', '', $dadosCapa['html']);
        }

        //Formatando o tipo da capa
        $dadosCapa['tipo'] = api_getCaderno($dadosCapa['tipo']);

        //Verificando se o usuário quer salvar a capa atual como ativa
        if ($dadosCapa['status']) {
            //Desativando a capa antiga caso exista o tipo na tabela
            api_destivarCapa($dadosCapa["tipo"]);
        }

        //Verificando o tipo da capa
        if ($dadosCapa['tipo'] == 'home') {
            //Salvando os dados no banco
            $sinal = db_salvarCapa($dadosCapa);

            if ($sinal) {
                //Verificando se a capa não está ativa
                if (!$dadosCapa['status']) {
                    return 1;
                } else {
                    //Recuperando o conteudo da capa-base
                    $vPagBase = file_get_contents(LEIAJAURL . '/admin-capa/ajax/capa-base');
                    $vHtmlOutput = str_replace('[##@title@##]', '<title>Tudo que você precisa saber. Notícias, Carreiras, Esportes, Cultura, Tecnologia, Vídeos e muito mais... | LeiaJá</title>', $vPagBase);
                    $vHtmlOutput = str_replace('##@content@##', html_entity_decode(stripslashes($dadosCapa['html'])), $vHtmlOutput);
                    file_put_contents(NOVACAPAIMGDIRBASE . DIRECTORY_SEPARATOR . 'index.html', $vHtmlOutput);
                    return LEIAJAURL . '/index.html';
                }
            } else {
                return 0;
            }
        } else {
            //Salvando os dados no bando
            $sinal = db_salvarCapa($dadosCapa);

            if ($sinal) {
                if (!$dadosCapa['status']) {
                    return 1;
                } else {
                    if (mkdir(NOVACAPAIMGDIRBASE . DIRECTORY_SEPARATOR . $dadosCapa['tipo']) || is_dir(NOVACAPAIMGDIRBASE . DIRECTORY_SEPARATOR . $dadosCapa['tipo'])) {
                        $arrCadernos = getCadernos();
                        $cadernoTipo = $dadosCapa['tipo'];

                        //Recuperando o conteudo da capa-base
                        $vPagBase = file_get_contents(LEIAJAURL . '/admin-capa/ajax/capa-base');
                        $vHtmlOutput = str_replace('[##@title@##]', '<title>' . $arrCadernos['caderno_' . $cadernoTipo] . ' | LeiaJá</title>', $vPagBase);
                        $vHtmlOutput = str_replace('##@content@##', html_entity_decode(stripslashes($dadosCapa['html'])), $vHtmlOutput);
                        file_put_contents(NOVACAPAIMGDIRBASE . DIRECTORY_SEPARATOR . $dadosCapa['tipo'] . DIRECTORY_SEPARATOR . 'index.html', $vHtmlOutput);
                        return LEIAJAURL . '/' . $dadosCapa['tipo'] . '/index.html';
                    } else {
                        return 0;
                    }
                }
            } else {
                return 0;
            }
        }
    }
}

//Funç]ao que vai atualizar o historico de capa
function api_atualizarCapa($dadosCapa) {

    if (!isset($dadosCapa['html']) || !isset($dadosCapa['matriz']) || !isset($dadosCapa['nome']) || !isset($dadosCapa['tipo']) ||
            !isset($dadosCapa['status']) || !isset($dadosCapa['usuario']) || !isset($dadosCapa['cid'])) {
        return 'Os dados não podem ser recuperados';
        die;
    } else {

        //Verificando qual o ambiente da aplicação
        if (strstr($_SERVER['SERVER_NAME'], 'www4')) {
            $dadosCapa['html'] = str_replace('../..//', 'http://www4.leiaja.com/sites/all/themes/leiaja2/css/', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('../../', 'http://www4.leiaja.com/sites/all/themes/leiaja2/css/', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('<pre class="titulo">', '', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('</pre>', '', $dadosCapa['html']);
        } else if (strstr($_SERVER['SERVER_NAME'], 'www3')) {
            $dadosCapa['html'] = str_replace('../..//', 'http://www3.leiaja.com/sites/all/themes/leiaja2/css/', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('../../', 'http://www3.leiaja.com/sites/all/themes/leiaja2/css/', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('<pre class="titulo">', '', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('</pre>', '', $dadosCapa['html']);
        } else {
            $dadosCapa['html'] = str_replace('../..//', 'http://www.leiaja.com/sites/all/themes/leiaja2/css/', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('../../', 'http://www.leiaja.com/sites/all/themes/leiaja2/css/', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('<pre class="titulo">', '', $dadosCapa['html']);
            $dadosCapa['html'] = str_replace('</pre>', '', $dadosCapa['html']);
        }

        //Formatando o tipo da capa
        $dadosCapa['tipo'] = api_getCaderno($dadosCapa['tipo']);

        //Verificando se o usuário quer salvar a capa atual como ativa
        if ($dadosCapa['status']) {
            //Desativando a capa antiga caso exista o tipo na tabela
            api_destivarCapa($dadosCapa["tipo"]);
        }

        //Verificando o tipo da capa
        if ($dadosCapa['tipo'] == 'home') {
            //Atualizando os dados no banco
            $sinal = db_atualizarCapa($dadosCapa);

            if ($sinal) {
                if (!$dadosCapa['status']) {
                    return 1;
                } else {
                    //Recuperando o conteudo da capa-base
                    $vPagBase = file_get_contents(LEIAJAURL . '/admin-capa/ajax/capa-base');

                    $vHtmlOutput = str_replace('[##@title@##]', '<title>Tudo que você precisa saber. Notícias, Carreiras, Esportes, Cultura, Tecnologia, Vídeos e muito mais... | LeiaJá</title>', $vPagBase);
                    $vHtmlOutput = str_replace('##@content@##', html_entity_decode(stripslashes($dadosCapa['html'])), $vHtmlOutput);
                    file_put_contents(NOVACAPAIMGDIRBASE . DIRECTORY_SEPARATOR . 'index.html', $vHtmlOutput);
                    return LEIAJAURL . '/index.html';
                }
            } else {
                return 0;
            }
        } else {

            $sinal = db_atualizarCapa($dadosCapa);

            if ($sinal) {
                if (!$dadosCapa['status']) {
                    return 1;
                } else {
                    if (mkdir(NOVACAPAIMGDIRBASE . DIRECTORY_SEPARATOR . $dadosCapa['tipo']) || is_dir(NOVACAPAIMGDIRBASE . DIRECTORY_SEPARATOR . $dadosCapa['tipo'])) {
                        $arrCadernos = getCadernos();
                        $cadernoTipo = $dadosCapa['tipo'];

                        //Recuperando o conteudo da capa-base
                        $vPagBase = file_get_contents(LEIAJAURL . '/admin-capa/ajax/capa-base');

                        $vHtmlOutput = str_replace('[##@title@##]', '<title>' . $arrCadernos['caderno_' . $cadernoTipo] . ' | LeiaJá</title>', $vPagBase);
                        $vHtmlOutput = str_replace('##@content@##', html_entity_decode(stripslashes($dadosCapa['html'])), $vHtmlOutput);
                        file_put_contents(NOVACAPAIMGDIRBASE . DIRECTORY_SEPARATOR . $dadosCapa['tipo'] . DIRECTORY_SEPARATOR . 'index.html', $vHtmlOutput);
                        return LEIAJAURL . '/' . $dadosCapa['tipo'] . '/index.html';
                    }
                }
            } else {
                return 0;
            }
        }
    }
}

//Função que vai deletar a capa
function api_deletarCapa($cid) {
    //Verificando se a variavel foi setada e se não está vazia
    if (isset($_POST['cid']) && !empty($_POST['cid'])) {

        $cid = $_POST['cid'];
        $output = db_deletarCapa($cid);

        return $output;
    }
}

//Função que vai listar as capas
function api_listarCapa() {

    $objRetorno = db_listarCapa();

    foreach ($objRetorno as $key => $value) {

        if (!empty($objRetorno[$key]->html)) {
            $objRetorno[$key]->html = stripslashes($objRetorno[$key]->html);
        }
        if (!empty($objRetorno[$key]->matriz)) {
            $objRetorno[$key]->matriz = unserialize($objRetorno[$key]->matriz);
        }
    }

    return $objRetorno;
}

//Função que vai criar o arquivo para preview da capa
function api_previewCapa($html) {

    //Diretorio temporario
    $diretorioTemp = NOVACAPAIMGDIR . 'temp';

    //Verificando qual o ambiente da aplicação
    if (strstr($_SERVER['SERVER_NAME'], 'www4')) {
        $html = str_replace('../..//', 'http://www4.leiaja.com/sites/all/themes/leiaja2/css/', $html);
        $html = str_replace('../../', 'http://www4.leiaja.com/sites/all/themes/leiaja2/css/', $html);
        $html = str_replace('<pre class="titulo">', '', $html);
        $html = str_replace('</pre>', '', $html);
    } else if (strstr($_SERVER['SERVER_NAME'], 'www3')) {
        $html = str_replace('../..//', 'http://www3.leiaja.com/sites/all/themes/leiaja2/css/', $html);
        $html = str_replace('../../', 'http://www3.leiaja.com/sites/all/themes/leiaja2/css/', $html);
        $html = str_replace('<pre class="titulo">', '', $html);
        $html = str_replace('</pre>', '', $html);
    } else {
        $html = str_replace('../..//', 'http://www.leiaja.com/sites/all/themes/leiaja2/css/', $html);
        $html = str_replace('../../', 'http://www.leiaja.com/sites/all/themes/leiaja2/css/', $html);
        $html = str_replace('<pre class="titulo">', '', $html);
        $html = str_replace('</pre>', '', $html);
    }

    if (!is_dir($diretorioTemp)) {
        if (mkdir($diretorioTemp)) {
            //Recuperando a pagina base da capa
            $vPagBase = file_get_contents(LEIAJAURL . '/admin-capa/ajax/capa-base');
            $vHtmlOutput = str_replace('##@content@##', $html, $vPagBase);

            if (file_put_contents($diretorioTemp . DIRECTORY_SEPARATOR . 'preview.html', $vHtmlOutput)) {
                //Retornando a url do arquivo do preview
                return LEIAJAURL . '/sites/default/files/capa/temp/preview.html?' . time();
            } else {
                return 'o arquivo n pode ser criado';
            }
        }
    } else {
        //Recuperando a pagina base da capa
        $vPagBase = file_get_contents(LEIAJAURL . '/admin-capa/ajax/capa-base');
        $vHtmlOutput = str_replace('##@content@##', $html, $vPagBase);

        if (file_put_contents($diretorioTemp . DIRECTORY_SEPARATOR . 'preview.html', $vHtmlOutput)) {
            //Retornando a url do arquivo do preview
            return LEIAJAURL . '/sites/default/files/capa/temp/preview.html?' . time();
        } else {
            return 'o arquivo n pode ser criado';
        }
    }
}

//Função q vai retornar a matriz da capa ativa
function api_getMatriz($cid) {

    $output = db_getMatriz($cid);

    $output->matriz = unserialize($output->matriz);
    $output->matriz_background = unserialize($output->matriz_background);

    return $output;
}

//Função que vai verificar o tipo e retornar o caderno
function api_getCaderno($caderno) {

    $output = "";

    switch ($caderno) {
        case "caderno_esportes":
            $output = "esportes";
            break;
        case "caderno_carreiras":
            $output = "carreiras";
            break;
        case "caderno_cultura":
            $output = "cultura";
            break;
        case "caderno_tecnologia":
            $output = "tecnologia";
            break;
        case "caderno_noticias":
            $output = "noticias";
            break;
        case "caderno_multimidia":
            $output = "multimidia";
            break;
        case "caderno_politica":
            $output = "politica";
            break;
        case "caderno_copa_america":
            $output = "copaamerica";
            break;
        case "caderno_rio2016":
            $output = "rio2016";
            break;
        case "caderno_pa":
            $output = "pa";
            break;
        case "caderno_sp":
            $output = "sp";
            break;
        case "caderno_pe":
            $output = "pe";
            break;
        case "caderno_ce":
            $output = "ce";
            break;
        case "caderno_ba":
            $output = "ba";
            break;
        case "caderno_cl":
            $output = "cl";
            break;
        case "caderno_pb":
            $output = "pb";
            break;
        case "caderno_rj":
            $output = "rj";
            break;
        case "caderno_nasocial":
            $output = "nasocial";
            break;
        case "caderno_multimidia":
            $output = "multimidia";
            break;
        case "caderno_ce":
            $output = "ce";
            break;
        case "caderno_ba":
            $output = "ba";
            break;
        case "caderno_cl":
            $output = "cl";
            break;
        case "caderno_nasocial":
            $output = "nasocial";
            break;
        case "caderno_enem":
            $output = "enem";
            break;
        case "caderno_oab":
            $output = "oab";
            break;
        default :
            $output = "home";
            break;
    }

    return $output;
}

//Função que vai desativar uma capa
function api_destivarCapa($tipoCapa) {

    $output = db_desativarCapa($tipoCapa);
    return $output;
}

//Função que vai duplicar uma capa
function api_duplicarCapa($cid) {

    if (isset($cid['cid']) && !empty($cid['cid'])) {
        $capaAtual = db_getCapa($cid['cid']);

        $arrCapa = array(
            'nome' => "CÓPIA DE " . $capaAtual->nome,
            'html' => $capaAtual->html,
            'matriz' => unserialize($capaAtual->matriz),
            'atualizado_por' => $cid['user'],
            'status' => 0,
            'tipo' => $capaAtual->tipo
        );

        $output = db_salvarCapa($arrCapa);
        return $output;
    } else {
        return 'cid não encontrado';
    }
}

//Função que formata o json exibido no mobile
function __api_formatarJson($arrObjNode) {

    //Variavel com o json q vai ser retornado
    $ObjJsonRetorno = array();

    //Percorrendo as node
    foreach ($arrObjNode as $node) {

        $strNid = $node->nid;
        $strTitulo = $node->title;
        $strCreated = date('Y/m/d H:i', $node->created);
        $strTimestamp = $node->created;
        $strVideo = (!empty($node->field_videost)) ? 1 : 0;
        $strAudio = (!empty($node->field_audiost)) ? 1 : 0;
        $strCaderno = $node->type;
        $strImagemCapa = (!empty($node->field_capa)) ? $node->field_capa[key($node->field_capa)][0]['uri'] : "";
        $strGaleria = (!empty($node->field_image)) ? $node->field_image[key($node->field_image)][0]['uri'] : "";
        $strImagemTopo = (!empty($node->field_imagem_topo)) ? $node->field_imagem_topo[key($node->field_imagem_topo)][0]['uri'] : "";
        $strNodeUri = url('node/' . $node->nid, array('absolute' => FALSE));

        $strImgUri = "";
        //Criando a url caso ela exista
        if (!empty($strImagemCapa)) {
            $strImgUri = file_create_url($strImagemCapa);
        } elseif (!empty($strGaleria)) {
            $strImgUri = file_create_url($strGaleria);
        } elseif (!empty($strImagemTopo)) {
            $strImgUri = file_create_url($strImagemTopo);
        } else {
            $strImgUri = NULL;
        }
        //Verificando se existe alguma url
        $strImage = ($strImgUri !== NULL) ? 1 : 0;

        //Variavel q vai ter o tid da taxonomia para carregar o objeto
        $tid = "";

        switch ($node->type) {
            case "caderno_esportes":
                $tid = $node->field_catesporte[key($node->field_catesporte)][0]['tid'];
                break;
            case "caderno_carreiras":
                $tid = $node->field_catnegocios[key($node->field_catnegocios)][0]['tid'];
                break;
            case "caderno_cultura":
                $tid = $node->field_catcultura[key($node->field_catcultura)][0]['tid'];
                break;
            case "caderno_tecnologia":
                $tid = $node->field_cattecnologia[key($node->field_cattecnologia)][0]['tid'];
                break;
            case "caderno_noticias":
                $tid = $node->field_catnoticia[key($node->field_catnoticia)][0]['tid'];
                break;
            case "caderno_multimidia":
                $tid = $node->field_catradiotv[key($node->field_catradiotv)][0]['tid'];
                break;
            case "caderno_colunistas":
                $tid = $node->field_catcolunista[key($node->field_catcolunista)][0]['tid'];
                break;
            case "caderno_politica":
                $tid = $node->field_catpolitica[key($node->field_catpolitica)][0]['tid'];
                break;
            case "blogs_da_redacao":
                $tid = $node->field_catblog[key($node->field_catblog)][0]['tid'];
                break;
        }

        $objTaxonomy = taxonomy_term_load($tid);

        $ObjJsonRetorno[] = array(
            'nid' => $strNid,
            'titulo' => $strTitulo,
            'created' => $strCreated,
            'timestamp' => $strTimestamp,
            'caderno' => $strCaderno,
            'subCategoria' => $objTaxonomy->name,
            'video' => $strVideo,
            'audio' => $strAudio,
            'image' => $strImage,
            'imageUrl' => $strImgUri,
            'nodeUrl' => $strNodeUri
        );
    }

    return $ObjJsonRetorno;
}
