<?php

/*
 *  Arquivo onde estão localizadas funções de apoio ao negócio (helpers)
 *
 *  @package    Integracao
 *  @subpackage Integracao
 *  @author     Thiago Galvão Soares (galvao@sereducacional.com)
 */

module_load_include('inc', 'integracao', 'integracao.db');

/**
 * Integração com XML da Agência Estado
 *
 * Notícias importadas a partir dos arquivos XML no servidor de FTP da
 * agência estado.
 *
 */
function api_integra_aestado() {
    set_time_limit(0);
    $GLOBALS['conf']['cache'] = FALSE;
    $vPath = PATH_CAHCE_XML . '/aestado/';

    $vFtp = _conectaFtp('ftp.ae.com.br', 21, 'aeftp362', '@&f7p263') or die("erro");
    $vPastas = $vFtp->ls();
    $vCont = 1;


    foreach ($vPastas as $dir) {
        if ($vCont == 51)
            break;

        if ($dir['is_dir'] != 'd') {
            $vCont++;
            $vArquivoLocal = $vPath . $dir['name'];

            $vDownload = $vFtp->get($dir['name'], $vArquivoLocal, true);

            if (!$vDownload) {
                watchdog('Integracao', "Erro ao realizar download => {$dir['name']}", null, WATCHDOG_WARNING);
                continue;
            }

            $vXml = simplexml_load_file($vArquivoLocal);

            if ($vXml !== false) {
                $node = new stdClass();
                $vQuando = convert_datetime($vXml->DATA . ' ' . $vXml->HORA);

                if ($vQuando === false) {
                    watchdog('Integracao', "Erro ao converter data => $vArquivoLocal", null, WATCHDOG_WARNING);
                    echo "<br/>Erro ao converter data => $vArquivoLocal";
                    continue;
                }

                setCategoria($vXml->EDITORIA, $node);

                $node->status = '0';
                $node->uid = 1031;
                $node->title = $vXml->TITULO;
                $node->promote = 0;
                $node->created = $vQuando;
                $node->timestamp = $vQuando;
                $node->sticky = 0;
                $node->comment = 2;
                $node->language = 'pt-br';
                $node->hash = $vXml->ID;
                $node->revision = 0;
                $node->body['pt-br'][0]['format'] = 'full_html';
                $node->body['pt-br'][0]['summary'] = '';
                $node->body['pt-br'][0]['value'] = _filter_autop($vXml->INTEGRA);
                $node->field_fonte['pt-br'][0]['value'] = 'Estadao Conteudo';

                $vTags = explode(';', $vXml->KEYWORDS);

                foreach ($vTags as $key => $tag) {
                    $node->field_tags['pt-br'][$key]['tid'] = getTags($tag);
                }

                $node = node_submit($node);
                node_save($node);

                atualizaNodeOrigem($node->nid, $vXml->ID);
                $vFtp->rm($dir['name']);

                watchdog('Integracao', "Incluida noticia do XML => $vArquivoLocal", null, WATCHDOG_INFO);
                echo '<br/>Salvo: ' . $vXml->ID;
            } else {
                watchdog('Integracao', "Erro: XML vazio => $vArquivoLocal", null, WATCHDOG_WARNING);
                echo "<br/>Erro: XML vazio => $vArquivoLocal";
            }

            echo "<hr/>";
        }
    }
}

/**
 * Método que irá cadstrar as notícias de especial
 * Irá realizar o donwload do arquivo e cadastrar localmente
 *
 *
 */
//function api_integra_especiais() {
//
//    // Iniciando a mensagem de erro
//    $strErro = "";
//    $arrNodeErro = array();
//    $arrIntegrado = array();
//    $arrArquivo = "";
//    $strDirTemp = file_directory_temp();
//
//    // Verificando qual barra usar
//    $bolSO = (PHP_OS == 'WINNT' || PHP_OS == 'Darwin') ? true : false;
//
//    // Pegando o diretorio dos xmls
//    $strDirXml = (PHP_OS == 'WINNT' || PHP_OS == 'Darwin') ? 'D:/_HTTP/WWW/projetosEspecial/branches/carnaval/sites/default/files/xml' : PATH_XML;
//    $bolLido = true;
//    try {
//        $arrArquivo = glob($strDirXml . "/*") or $bolLido = false;
//        if (!$bolLido)
//            throw new Exception("Não Existe Xmls");
//    } catch (Exception $exc) {
//        // Array com os dados do erro
//        $arrErro = array();
//        $arrErro["strErro"] = $exc->getMessage();
//        $arrErro["intNid"] = addslashes($objXml->nid);
//        $arrErro["strTituloNode"] = addslashes($objXml->titulo);
//        $arrErro["strDataHora"] = date("d-m-Y H:s:m");
//
//        $arrNodeErro[] = $arrErro;
//    }
//
//    // Iniciando o objeto node
//    $objXml = null;
//    //permorre a lista
//    foreach ($arrArquivo as $strArquivo) {
//        try {
//            if (!is_dir($strArquivo)) {
//                if (strstr($strArquivo, ".xml")) {
//                    // Lendo o xml
//                    $objXml = simplexml_load_file($strArquivo);
//
//                    // Caso o xml esteja ok
//                    if ($objXml !== false) {
//                        //Iniciando o objeto
//                        $objSincronizacao = false;
//                        // Verificando se a notícia já esta sincronizada
//                        $objSincronizacao = db_existe_leiaja($objXml->nid);
//
//                        // Caso esteja soncronizado leio a notícia já cadastrada no leiaja
//                        if ($objSincronizacao)
//                            $node = node_load($objSincronizacao->nid_lj);
//                        else // se não crio um objeto
//                            $node = new stdClass();
//
//                        $vQuando = addslashes($objXml->data);
//
//                        if ($vQuando === false) {
//                            watchdog('Integracao', "Erro ao converter data => $vArquivoLocal", null, WATCHDOG_WARNING);
//                            echo "<br/>Erro ao converter data => $vArquivoLocal";
//                            continue;
//                        }
//
//                        // Setando o caderno e a categoria da notícia
//                        setCategoria($objXml->caderno, $node);
//
//                        // Se a notícia já foi sincronizada
//                        if (!$objSincronizacao) {
//                            $node->status = (string) (!empty($objXml->status)) ? addslashes($objXml->status) : '0';
//                            $node->sticky = (string) (!empty($objXml->sticky)) ? addslashes($objXml->sticky) : '0';
//                            ;
//                            $node->promote = (string) (!empty($objXml->promote)) ? addslashes($objXml->promote) : '0';
//                            ;
//                            $node->created = $vQuando;
//                            $node->timestamp = $vQuando;
//                        } else {
//                            // Caso a notícia esteja sincronizada atualizo apenas a data de atualização
//                            $node->changed = mktime();
//                        }
//
//
//                        // Setando os demais campos da notícia
//                        $node->uid = 722;
//                        $node->title = addslashes($objXml->titulo);
//                        $node->comment = 2;
//                        $node->language = 'pt-br';
//                        $node->revision = 0;
//                        $node->body['pt-br'][0]['format'] = 'full_html';
//                        $node->body['pt-br'][0]['summary'] = addslashes($objXml->summary);
//                        $node->body['pt-br'][0]['value'] = _filter_autop($objXml->body);
//                        $node->field_fonte['pt-br'][0]['value'] = addslashes($objXml->fonte);
//                        $node->field_tags['pt-br'][0]['tid'] = getTags(addslashes($objXml->chapeu));
//
//                        // validando se a chamada de capa foi alterada
//                        if (isset($objXml->chamada_capa) && !empty($objXml->chamada_capa))
//                            $node->field_chamada_capa['und'][0]['value'] = addslashes($objXml->chamada_capa);
//
//                        // Destruindo a posição do vídeo
//                        unset($node->field_videost["und"]);
//                        unset($node->field_videost['pt-br']);
//                        $strVideoST = (String) html_entity_decode($objXml->videost);
//                        // Veiricando se tem video para ser salvo
//                        if (!empty($strVideoST)) {
//                            $node->field_videost["und"][0]['value'] = $strVideoST;
//                        }
//
//                        // Contador
//                        $intCont = 1;
//                        // Percorrendo as tags e salvando na base
//                        foreach ($objXml->tags as $key => $tag) {
//                            $node->field_tags['pt-br'][$intCont]['tid'] = getTags(addslashes(@$tag->tag));
//                            $intCont++;
//                        }
//
//                        // se a node foi sincronizada e se existe o nid
//                        if ($objSincronizacao) {
//                            $nodeVelha = node_load($node->nid);
//                            if (!empty($nodeVelha->field_image['pt-br'])) {
//                                // Percorro todas as imagens pra apagar
//                                foreach ($nodeVelha->field_image['pt-br'] as $key => $arrImage) {
//                                    if (!empty($arrImage['fid'])) {
//                                        $vTmpFile = file_load($arrImage['fid']);
//                                        if ($vTmpFile)// Veficiando o arquivo
//                                            file_delete($vTmpFile, 1);
//                                    }else {
//                                        unset($nodeVelha->field_image['pt-br'][$key]);
//                                    }
//                                }
//                            }
//                        }
//
//                        // Contador das posições
//                        $intCont = 0;
//                        // Percorrendo as tags e salvando na base
//                        foreach ($objXml->images->image as $key => $objImagem) {
//                            // Pegando a uri da imagem
//                            $strImagem = (string) strip_tags(addslashes($objImagem->uri));
//
//                            // Se não houver url
//                            if (empty($strImagem))
//                                continue;
//
//                            // Formatando o caminho do arquivo
//                            $pUrl = str_replace("\\\\", "/", addslashes($objImagem->uri));
//
//                            // Se o SO for windows
//                            if ($bolSO)
//                                $pUrl = str_replace("/", '\\', $pUrl);
//
//                            // Obtem extensão do arquivo a partir da URL.
//                            $vInfoFile = pathinfo(parse_url($pUrl, PHP_URL_PATH));
//
//                            // verificando a extensão do arquivo
//                            if (empty($vInfoFile['extension']))
//                                throw new Exception("Arquivo sem extensão Galeria");
//
//                            $vNomeArquivo = $vInfoFile['filename'] . '.' . $vInfoFile['extension'];
//
//                            // Cria nome para o arquivo temporário.
//                            $vTempFile = $strDirTemp . '/' . $vNomeArquivo;
//
//                            // Download do arquivo para o diretorio temporário.
//                            $vCopiado = copy($pUrl, $vTempFile);
//
//                            // Se o arquivo foi realmente copiado
//                            if ($vCopiado) {
//                                $file_path = drupal_realpath($vTempFile);
//                                // Cria o file object do Drupal.
//                                $file = (object) array(
//                                            'uid' => 722, // "dono" do arquivo
//                                            'uri' => $file_path, // caminho para o arquivo
//                                            'filemime' => file_get_mimetype($file_path), // pega o mimetype do arquivo
//                                            'display' => 1,
//                                            'status' => 1,
//                                );
//
//                                // Salva o arquivo na raiz da sua pasta files
//                                $file = file_copy($file, "public://");
//
//                                $node->field_image['pt-br'][$intCont] = (array) $file;
//                                $intCont++;
//                                // Excluindo o arquivo tempororario
//                                unlink($vTempFile);
//                            }
//                        }
//                        // Apagando as imagens que estão vasias
//                        foreach ($node->field_image['pt-br'] as $intChave => $objImagem) {
//                            // verifico se a imagem de capa está setada se não apago a posição
//                            if (empty($node->field_image['pt-br'][$intChave])) {
//                                unset($node->field_image['pt-br'][$intChave]);
//                            }
//                        }
//
//                        // se a node foi sincronizada e se existe o nid
//                        if ($objSincronizacao) {
//                            $nodeVelha = node_load($node->nid);
//                            // Percorro verifico a imagem de capa pra apagar
//                            if (!empty($nodeVelha->field_capa['pt-br'][0]['fid'])) {
//                                $vTmpFile = file_load($nodeVelha->field_capa['pt-br'][0]['fid']);
//                                if ($vTmpFile)// Veficiando o arquivo
//                                    file_delete($vTmpFile, 1);
//                            }else {
//                                unset($nodeVelha->field_capa['pt-br']);
//                            }
//                        }
//
//                        // Salvando as imagens na node
//                        $objImageCapa = $objXml->imagecapa;
//                        $strUriCapa = (string) strip_tags(addslashes($objImageCapa->uri));
//
//                        // Se houver uma imagem de capa
//                        if (!empty($strUriCapa)) {
//                            // Formatando o caminho do arquivo
//                            $pUrlCapa = str_replace("\\\\", "/", addslashes($objImageCapa->uri));
//
//                            // Se o SO for windows
//                            if ($bolSO)
//                                $pUrlCapa = str_replace("/", '\\', $pUrlCapa);
//
//                            // Obtem extensão do arquivo a partir da URL.
//                            $vInfoFileCapa = pathinfo(parse_url($pUrlCapa, PHP_URL_PATH));
//
//                            // verificando a extensão do arquivo
//                            if (empty($vInfoFileCapa['extension']))
//                                throw new Exception("Arquivo sem extensão Capa");
//
//                            // Imagem de capa
//                            $vNomeArquivoCapa = $vInfoFileCapa['filename'] . '.' . $vInfoFileCapa['extension'];
//
//                            // Cria nome para o arquivo temporário.
//                            $vTempFileCapa = $strDirTemp . '/' . $vNomeArquivoCapa;
//
//                            // Download do arquivo para o diretorio temporário.
//                            $vCopiado = copy($pUrlCapa, $vTempFileCapa);
//
//                            // Se o arquivo foi realmente copiado
//                            if ($vCopiado) {
//                                $file_path = drupal_realpath($vTempFileCapa);
//                                // Cria o file object do Drupal.
//                                $file = (object) array(
//                                            'uid' => 722, // "dono" do arquivo
//                                            'uri' => $file_path, // caminho para o arquivo
//                                            'filemime' => file_get_mimetype($file_path), // pega o mimetype do arquivo
//                                            'display' => 1,
//                                            'status' => 1,
//                                );
//
//                                // Salva o arquivo na raiz da sua pasta files
//                                $file = file_copy($file, "public://");
//
//                                // Setando a imagem na node
//                                $node->field_capa['pt-br'][0] = (array) $file;
//
//                                // Excluindo o arquivo tempororari;o
//                                unlink($vTempFileCapa);
//                            }
//                        }
//
//
//                        // verifico se a imagem de capa está setada se não apago a posição
//                        if (empty($node->field_capa['pt-br'][0])) {
//                            unset($node->field_capa['pt-br']);
//                        }
//
//                        /*                         * **********************************************************
//                         * * Criando o redirecionamento da notícia para o especial
//                         * ********************************************************** */
//                        $vLinkPerm = file_get_contents('http://leiaja.me/ws/?url=' . getDominio($objXml->caderno) . addslashes($objXml->alias));
//
//                        // Salvando o dominio do redirecionamento da notícia
//                        $node->field_redireciona["und"][0]['value'] = trim($vLinkPerm);
//
//                        // se a node foi sincronizada e se existe o nid
//                        if (!$objSincronizacao) {
//                            // Submetendo e salvando a node
//                            $node = node_submit($node);
//                        }
//
//                        // Salvando a node
//                        node_save($node);
//
//                        // se a notícia já foi cincronizada
//                        if (!$objSincronizacao)
//                            db_inserirRelaciaoEspecial($node->nid, $objXml->nid);
//
//                        // Pegando o caminho do arquivo
//                        $vPath = getcwd() . '/' . drupal_get_path('module', 'integracao') . '/cachexml/especiais/';
//
//                        // Download do arquivo para o diretorio temporário.
//                        copy($strArquivo, $vPath);
//
//                        // Excluindo o aruivo
//                        unlink($strArquivo);
//
//                        watchdog('Integracao Especial', "Incluida noticia do XML => $strArquivo", null, WATCHDOG_INFO);
//                        echo '<br/>Salvo Titulo: ' . addslashes($objXml->titulo) . ' NID: ' . addslashes($objXml->nid);
//
//                        // Criando o array com os dados do acerto
//                        $arrCerto = array();
//                        $arrCerto["intNid"] = addslashes($objXml->nid);
//                        $arrCerto["strTituloNode"] = addslashes($objXml->titulo);
//                        $arrCerto["strDataHora"] = date("d-m-Y H:s:m");
//
//                        // Setando a variavel
//                        $arrIntegrado[] = $arrCerto;
//                    }else {
//                        watchdog('Integracao Especial', "Erro: XML vazio => $vArquivoLocal", null, WATCHDOG_WARNING);
//                        echo "<br/>Erro: XML vazio => $vArquivoLocal";
//                    }
//                    echo "<hr/>";
//                }
//            }
//        } catch (Exception $exc) {
//            // Array com os dados do erro
//            $arrErro = array();
//            $arrErro["strErro"] = $exc->getMessage();
//            $arrErro["intNid"] = addslashes($objXml->nid);
//            $arrErro["strTituloNode"] = addslashes($objXml->titulo);
//            $arrErro["strDataHora"] = date("d-m-Y H:s:m");
//
//            $arrNodeErro[] = $arrErro;
//        }
//    }
//
//    // Criando o array que contera a msg de envio
//    $arrDados = array();
//    $arrDados["arrIntegrado"] = $arrIntegrado;
//    $arrDados["arrNodeErro"] = $arrNodeErro;
//
//    // Enviando emails com resultado da integração
//    drupal_mail('leiaja', 'integracao', "albertomedeiros214@gmail.com", 'pt-br', $arrDados);
//    drupal_mail('leiaja', 'integracao', "redacao@leiaja.com.br", 'pt-br', $arrDados);
//}

/**
 * Integração com XML da NowDigital
 *
 * Notícias importadas a partir dos arquivos XML da Nowdigital enviados para
 * pasta '/nowgitial' na raiz do servidor de arquivos.
 *
 */
function api_integra_nowdigital() {
    set_time_limit(0);
    $GLOBALS['conf']['cache'] = FALSE;

    $vPathXml = (PHP_OS == 'WINNT' || PHP_OS == 'Darwin') ? 'D:/_HTTP/WWW/nowdigital/' : '/JJPart_NAS/Sites/nowdigital/';
    $vPathCache = PATH_CAHCE_XML . '/nowdigital/';


    // Percorre o diretório listando os arquivos XML.
    if (is_dir($vPathXml)) {
        if ($dh = opendir($vPathXml)) {
            while (($file = readdir($dh)) !== false) {
                if (filetype($vPathXml . $file) == 'file') {

                    $vArquivoLocal = $vPathXml . $file;

                    ## Carrega Objeto XML para inserir no banco.
                    $vXml = simplexml_load_file($vArquivoLocal);

                    if ($vXml !== false) {
                        $node = new stdClass();
                        $vQuando = convert_datetime($vXml->DATA . ' ' . $vXml->HORA);

                        if ($vQuando === false) {
                            watchdog('NOWDIGITAL Integracao', "Erro ao converter data => $vArquivoLocal", null, WATCHDOG_WARNING);
                            echo "<br/>Erro ao converter data => $vArquivoLocal";
                            continue;
                        }

                        $vEditoriaFonte = explode('/', $vXml->EDITORIA);

                        setCategoriaNowDigital($vEditoriaFonte[1], $node);

                        $node->status = '0';
                        $node->uid = 182;
                        $node->title = $vXml->TITULO;
                        $node->promote = 0;
                        $node->created = $vQuando;
                        $node->timestamp = $vQuando;
                        $node->sticky = 0;
                        $node->comment = 2;
                        $node->language = 'pt-br';
                        $node->hash = $vXml->ID;
                        $node->revision = 0;

                        $node->body['pt-br'][0]['format'] = 'full_html';
                        $node->body['pt-br'][0]['summary'] = '';
                        $node->body['pt-br'][0]['value'] = _filter_autop($vXml->INTEGRA);
                        $node->field_fonte['pt-br'][0]['value'] = $vEditoriaFonte[0];

                        $vTags = explode(';', $vXml->KEYWORDS);

                        foreach ($vTags as $key => $tag) {
                            $node->field_tags['pt-br'][$key]['tid'] = getTags($tag);
                        }

                        $node = node_submit($node);
                        node_save($node);

                        atualizaNodeOrigem($node->nid, $vXml->ID);

                        watchdog('Integracao', "NOWDIGITAL Incluida noticia do XML => $vArquivoLocal", null, WATCHDOG_INFO);
                        echo '<br/>Salvo: ' . $vXml->ID;
                    } else {
                        watchdog('Integracao', "NOWDIGITAL Erro: XML vazio => $vArquivoLocal", null, WATCHDOG_WARNING);
                        echo "<br/>Erro: XML vazio => $vArquivoLocal";
                    }
                    echo "<hr/>";
                    echo "filename: $file<br>";

                    rename($vArquivoLocal, $vPathCache . $file);
                }
            }
            closedir($dh);
        }
    }
}

/**
 * Função que retorna tid para termos e vocabulario especificado nos parametros.
 *
 * @param $pTermo         String	Texto com o termo a ser pesquisado.
 * @param $pVocabulario   Integer   ID do vocabulario a ser pesquisado o termo.
 */
function getTags($pTermo, $pVocabulario = 1) {
    $vTid = null;

    $vTermos = taxonomy_term_load_multiple(array(), array('name' => trim($pTermo), 'vid' => $pVocabulario));

    if (empty($vTermos)) {
        $new_term = array('vid' => $pVocabulario, 'name' => $pTermo);
        $new_term = (object) $new_term;
        taxonomy_term_save($new_term);
        $vTid = $new_term->tid;
    } else {
        $vTid = key($vTermos);
    }

    return $vTid;
}

/**
 * Método que irá retornar o dominio a qual a notícia de especial pertence
 *
 * @param String $strTipoConteudo
 * @return String $strDominio
 */
function getDominio($strTipoConteudo) {
    // Dominio default
    $strDominio = 'www6.leiaja.com/';

    switch ($strTipoConteudo) {
        case 'saojoao' :
            // Verificando qual barra usar
            $strInicio = (PHP_OS == 'WINNT' || PHP_OS == 'Darwin') ? "www4." : "";
            $strDominio = 'http://' . $strInicio . 'saojoao.leiaja.com/';
            break;
        case 'campus_party' :
            // Verificando qual barra usar
            $strInicio = (PHP_OS == 'WINNT' || PHP_OS == 'Darwin') ? "www4." : "";
            $strDominio = 'http://' . $strInicio . 'campusparty2012.leiaja.com/';
            break;
        case 'agenda_recife' :
            // Verificando qual barra usar
            $strInicio = (PHP_OS == 'WINNT' || PHP_OS == 'Darwin') ? "www4." : "";
            $strDominio = 'http://' . $strInicio . 'agendarecife.leiaja.com/';
            break;
        case 'carnaval' :
            // Verificando qual barra usar
            $strInicio = (PHP_OS == 'WINNT' || PHP_OS == 'Darwin') ? "www4." : "";
            $strDominio = 'http://' . $strInicio . 'carnaval.leiaja.com/';
            break;
        case 'copa' :
            // Verificando qual barra usar
            $strInicio = (PHP_OS == 'WINNT' || PHP_OS == 'Darwin') ? "www4." : "";
            $strDominio = 'http://' . $strInicio . 'copa.leiaja.com/';
            break;
        case 'vestibular' :
            // Verificando qual barra usar
            $strInicio = (PHP_OS == 'WINNT' || PHP_OS == 'Darwin') ? "www4." : "";
            $strDominio = 'http://' . $strInicio . 'vestibular.leiaja.com/';
            break;
        case 'retrospectiva_2013' :
            // Verificando qual barra usar
            $strInicio = (PHP_OS == 'WINNT' || PHP_OS == 'Darwin') ? "www4." : "";
            $strDominio = 'http://' . $strInicio . 'retrospectiva.leiaja.com/';
            break;
    };


    return $strDominio;
}

/**
 * Função para tratamento e tipagem do conteúdo.
 *
 * @param String $pCategoria	Nome da categoria a ser pesquisada.
 */
function setCategoria($pCategoria, &$pNode) {
    $pNovaCategoria = 'caderno_noticias';

    switch ($pCategoria) {
        case 'ESPORTES':
            $pNovaCategoria = 'caderno_esportes';
            $pNode->field_catesporte['pt-br'][0]['tid'] = 10643;
            break;
        case 'POLÍTICA':
            $pNovaCategoria = 'caderno_politica';
            $pNode->field_catpolitica['pt-br'][0]['tid'] = 13;
            break;
        case 'GERAL':
            $pNovaCategoria = 'caderno_noticias';
            $pNode->field_catnoticia['pt-br'][0]['tid'] = 11;
            break;
        case 'INTERNACIONAL':
            $pNovaCategoria = 'caderno_noticias';
            $pNode->field_catnoticia['pt-br'][0]['tid'] = 12;
            break;
        case 'FINANÇAS' :
            $pNovaCategoria = 'caderno_noticias';
            $pNode->field_catnoticia['pt-br'][0]['tid'] = 14;
            break;
        case 'ECONOMIA' :
            $pNovaCategoria = 'caderno_noticias';
            $pNode->field_catnoticia['pt-br'][0]['tid'] = 14;
            break;
        case 'saojoao' :
            $intIdTaxonomia = (PHP_OS == 'WINNT' || PHP_OS == 'Darwin') ? 25910 : 31626;
            $pNovaCategoria = 'caderno_cultura';
            $pNode->field_catcultura['pt-br'][0]['tid'] = $intIdTaxonomia;
            break;
        case 'campus_party' :
            $intIdTaxonomia = (PHP_OS == 'WINNT' || PHP_OS == 'Darwin') ? 25962 : 37089;
            $pNovaCategoria = 'caderno_tecnologia';
            $pNode->field_cattecnologia['pt-br'][0]['tid'] = $intIdTaxonomia;
            break;
        case 'agenda_recife' :
            $intIdTaxonomia = 17;
            $pNovaCategoria = 'caderno_noticias';
            $pNode->field_catnoticia['pt-br'][0]['tid'] = $intIdTaxonomia;
            break;
        case 'carnaval' :
            $intIdTaxonomia = 22417;
            $pNovaCategoria = 'caderno_cultura';
            $pNode->field_catcultura['pt-br'][0]['tid'] = $intIdTaxonomia;
            break;
        case 'copa':
            $pNovaCategoria = 'caderno_esportes';
            $pNode->field_catesporte['pt-br'][0]['tid'] = 20872;
            break;
        case 'vestibular':
            $pNovaCategoria = 'caderno_carreiras';
            $pNode->field_catnegocios['pt-br'][0]['tid'] = 12665;
            break;
    };

    $pNode->type = $pNovaCategoria;

    return $pNovaCategoria;
}

/**
 * Função para tratamento e tipagem do conteúdo.
 *
 * @param String $pCategoria	Nome da categoria a ser pesquisada.
 */
function setCategoriaNowDigital($pCategoria, &$pNode) {
    $pNode->type = 'caderno_tecnologia';

    switch ($pCategoria) {
        case 'noticias':
            $pNode->field_cattecnologia['pt-br'][0]['tid'] = 2323;
            break;
        case 'mercado':
            $pNode->field_cattecnologia['pt-br'][0]['tid'] = 2323;
            break;
        case 'internet':
            $pNode->field_cattecnologia['pt-br'][0]['tid'] = 25;
            break;
        case 'seguranca':
            $pNode->field_cattecnologia['pt-br'][0]['tid'] = 2326;
            break;
        case 'telecom' :
            $pNode->field_cattecnologia['pt-br'][0]['tid'] = 2325;
            break;
        case 'negocios':
            $pNode->field_cattecnologia['pt-br'][0]['tid'] = 2323;
            break;
        case 'dicas':
            $pNode->field_cattecnologia['pt-br'][0]['tid'] = 18;
            break;
        case 'games':
            $pNode->field_cattecnologia['pt-br'][0]['tid'] = 18;
            break;
        case 'reviews':
            $pNode->field_cattecnologia['pt-br'][0]['tid'] = 2324;
            break;
        default:
            $pNode->field_cattecnologia['pt-br'][0]['tid'] = 2323;
            break;
    };

    return true;
}

/**
 * Conecta-se a um servidor FTP.
 * Faz uso do Pacote pear::Net.
 *
 * @param type $pHost
 * @param type $pPorta
 * @param type $pUsuario
 * @param type $pSenha
 * @return Connection resource
 */
function _conectaFtp($pHost, $pPorta = 21, $pUsuario = '', $pSenha = '') {
    require_once 'Net/FTP.php';

    try {
        $vConexao = new Net_FTP($pHost, $pPorta) or die("erro");
        $vConexao->login($pUsuario, $pSenha);
        $vConexao->setPassive(true);
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }

    return $vConexao;
}

/**
 * Função para converter data e hora para timestamp.
 *
 * @param type $str
 * @return boolean
 */
function convert_datetime($str) {

    if (empty($str))
        return false;

    list($date, $time) = explode(' ', $str);
    list($day, $month, $year) = explode('/', $date);
    list($hour, $minute) = explode(':', $time);
    $timestamp = mktime($hour, $minute, 0, $month, $day, $year);

    return $timestamp;
}

//Integração coma a agência AFP - by Weydson Fraga
function api_integra_afp() {

    $arrayDests = array();
    $origem = PATH_XML_AFP;
    $arrayDirs = scandir($origem) or $bolErro = false;

    foreach ($arrayDirs as $value) {
        $arrayDests[] .= $origem . BAR_SO . $value;
    }

    //retirando as diretorios nulos
    $arrayDests = array_slice($arrayDests, 2);

    // lendo os xmls
    $vetorXmls = lerXmlsDir($arrayDests);

    if ($vetorXmls != FALSE) {
        salvaNodes($vetorXmls);
    } else {
        drupal_set_message('Erro: Pasta sem Xml', "error");
    }
}

function copiarArqs($arqOrigem, $arqDest) {

    if (copy($arqOrigem, $arqDest)) {
        unlink($arqOrigem);
    } else {
        drupal_set_message("O arquivo: " . $arqDest . " Não foi copiado!");
    }
}

function copiar_diretorio($diretorio, $destino, $ver_acao = false) {
    if ($destino{strlen($destino) - 1} == '/') {
        $destino = substr($destino, 0, -1);
    }
    if (!is_dir($destino)) {
        if ($ver_acao) {
            echo "Criando diretorio {$destino}\n";
        }
        mkdir($destino, 0755);
    }

    $folder = opendir($diretorio);

    while ($item = readdir($folder)) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (is_dir("{$diretorio}/{$item}")) {
            copy_dir("{$diretorio}/{$item}", "{$destino}/{$item}", $ver_acao);
        } else {
            if ($ver_acao) {
                echo "<pre>Copiando {$item} para {$destino}" . "<br>";
            }
            copy("{$diretorio}/{$item}", "{$destino}/{$item}");
        }
    }
}

function lerXmlsDir($diretorios) {

    $vetorXml = array();
    $i = 0;

    foreach ($diretorios as $key => $diretorio) {
        if (is_dir($diretorio)) {
            if ($dir = opendir($diretorio)) {
                while (($arq = readdir($dir)) !== FALSE) {
                    $extensao = pathinfo($arq);
                    if ($extensao['extension'] == "xml" && $arq != 'index.xml') {
                        $vXml = simplexml_load_file($diretorio . BAR_SO . $arq);
                        $vetorXml[$i]['dados'] = $vXml;
                        $vetorXml[$i]['diretorio'] = $diretorio;
                        $vetorXml[$i]['nomeXml'] = $arq;
                        $i++;
                    }
                }
            }
        }
    }

    if (!empty($vetorXml)) {
        $retorno = $vetorXml;
    } else {
        $retorno = FALSE;
    }

    return $retorno;
}

function salvaNodes($arrayXmls) {

    $dest = PATH_XML_AFP_CAHCE;
    $cont = 0;

    foreach ($arrayXmls as $key => $value) {
        $node = new stdClass();
        try {

            $ttHeadLine = $value['dados']->NewsItem->NewsComponent->NewsLines->HeadLine;

            $corpo = "";
            foreach ($value['dados']->NewsItem->NewsComponent->NewsComponent->ContentItem->DataContent->p as $strP) {
                $corpo .= "<p>" . $strP . "</p>";
            }
//        $corpo = _filter_autop($value['dados']->NewsItem->NewsComponent->NewsComponent->ContentItem->DataContent);
            $nomeImg = $value['dados']->NewsItem->NewsComponent->NewsComponent[1]->NewsComponent[1]->ContentItem['Href'];
            $dataTemp = $value['dados']->NewsItem->NewsManagement->FirstCreated;
            $dataCreate = substr($dataTemp, 0, -8);
            $dataStamp = strtotime($dataCreate);
            $pathImg = $value['diretorio'];
            $pathXml = $value['diretorio'] . BAR_SO . $value['nomeXml'];
            $destXml = $dest . BAR_SO . $value['nomeXml'];

            $node->type = 'caderno_cultura';
            $node->status = '0';
            $node->uid = 1024;
            $node->title = $ttHeadLine;
            $node->promote = 0;
            $node->created = $dataStamp;
            $node->timestamp = $dataStamp;
            $node->comment = 2;
            $node->sticky = 0;
            $node->language = 'pt-br';
            //$node->hash      = $vXml->ID;
            $node->revision = 0;
            $node->body['pt-br'][0]['format'] = 'full_html';
            $node->body['pt-br'][0]['summary'] = '';
            $node->body['pt-br'][0]['value'] = _filter_autop($corpo);
            $node->field_fonte['pt-br'][0]['value'] = 'AFP';

            // Pegando o diretório temporário
            $strDirTemp = file_directory_temp();

            // Download do arquivo para o diretorio temporário.
            $vCopiado = copy($pathImg . BAR_SO . $nomeImg, $strDirTemp . BAR_SO . $nomeImg);
            // Se o arquivo foi realmente copiado
            if ($vCopiado) {
                $file_path = drupal_realpath($strDirTemp . BAR_SO . $nomeImg);
                // Cria o file object do Drupal.
                $file = (object) array(
                            'uid' => 722, // "dono" do arquivo
                            'uri' => $file_path, // caminho para o arquivo
                            'filemime' => file_get_mimetype($file_path), // pega o mimetype do arquivo
                            'display' => 1,
                            'status' => 1,
                            'title' => $value['dados']->NewsItem->NewsComponent->NewsComponent[1]->NewsLines->HeadLine,
                            'alt' => $value['dados']->NewsItem->NewsComponent->NewsComponent[1]->NewsLines->ByLine,
                );

                // Salva o arquivo na raiz da sua pasta files 
                $file = file_copy($file, "public://");

                // Setando a imagens na node
                $node->field_image['pt-br'][0] = (array) $file;
                $node->field_capa['pt-br'][0] = (array) $file;

                // Excluindo o arquivo tempororario
                unlink($strDirTemp . BAR_SO . $nomeImg);
            } else {
                throw new Exception("Imagem não uplodiada: " . $ttHeadLine);
            }

            if ($node = node_submit($node)) {
                node_save($node);
                $cont++;
                copy($pathXml, $destXml);
            } else {
                drupal_set_message('Houve um erro ao salvar o node'); //die('nao add');}
            }



            // Salvando no log do drupal
            watchdog('Integracao', $ttHeadLine, null, WATCHDOG_INFO);
        } catch (Exception $exc) {
            watchdog('Integracao', $exc->getMessage() . $exc->getTraceAsString(), null, WATCHDOG_WARNING);
        }
    }
//    watchdog('Integracao', $exc->getMessage() . $exc->getTraceAsString(), null, );

    drupal_set_message('Foram adcionados e copiados ' . $cont . ' notícios da AFP');
}

/**
 * Método que irá cadstrar as notícias de especial
 * Irá realizar ler o rss e cadastrar localmente
 *
 *
 */
function api_integra_especiais() {

    //Variável com todos os path a serem inseridos no banco
    $rssPath = unserialize(RSSPATH);
    $strDirTemp = file_directory_temp();

    foreach ($rssPath as $feedPath) {
        try {

            //Carregando o RSS
            $rss = simplexml_load_file($feedPath);
            
            if (!$rss) {
                throw new Exception('[api_integra_rss] Não foi possível ler a url do feed. <br /> Path="' . $feedPath . '"');
            }

            foreach ($rss as $noticia) {
                //Iniciando o objeto
                $objSincronizacao = FALSE;
                // Verificando se a notícia já esta sincronizada
                $objSincronizacao = db_existe_leiaja($noticia->nid);

                // Caso esteja soncronizado leio a notícia já cadastrada no leiaja
                if ($objSincronizacao) {
                    continue;
                    $node = node_load($objSincronizacao->nid_lj);
                } else {// se não crio um objeto
                    $node = new stdClass();
                }

                $vQuando = $noticia->data;

                // Setando o caderno e a categoria da notícia
                setCategoria($noticia->caderno, $node);

                // Se a notícia já foi sincronizada
//                if (!$objSincronizacao) {
//                    $node->status = 0;
//                    $node->sticky = 0;
//                    $node->promote = 0;
//
//                    $node->created = (string) $vQuando;
//                    $node->timestamp = (string) $vQuando;
//                } else {
//                    // Caso a notícia esteja sincronizada atualizo apenas a data de atualização
//                    $node->changed = time();
//                }

                // Setando os demais campos da notícia
                $node->uid = 722;
                $node->title = (string) $noticia->titulo;
                $node->comment = 2;
                $node->language = 'pt-br';
                $node->revision = 0;
                $node->body['pt-br'][0]['format'] = 'full_html';
                $node->body['pt-br'][0]['summary'] = (string) $noticia->summary;
                $node->body['pt-br'][0]['value'] = (string) _filter_autop($noticia->body);
                $node->field_fonte['pt-br'][0]['value'] = (string) $noticia->fonte;
                $node->status = $noticia->publicado;
                $node->sticky = $noticia->promovido;
                $node->promote = $noticia->destacado;

                $node->created = (string) $vQuando;
                $node->timestamp = (string) $vQuando;

                //Adicionando as tags ao banco
                foreach ((array)$noticia->tags->tag as $keyTag => $tag) {
                    
                    //Verifica se a tag existe
                    $originalTag = taxonomy_get_term_by_name((string)$tag, 'tags');
                    $originalTag = reset($originalTag);
                    
                    if (!empty($originalTag)) {

                        $node->field_tags['pt-br'][$keyTag] = array('tid' => $originalTag->tid);
                    } else {
                        $newTag = new stdClass();
                        $newTag->name = (string)$tag;
                        $newTag->vid = 1;
                        taxonomy_term_save($newTag);

                        $node->field_tags['pt-br'][$keyTag] = array('tid' => $newTag->tid);
                    }
                }

                // Verificando se a node foi sincronizada e se tem imagem de capa
                if ($objSincronizacao) {
                    if (!empty($node->field_capa['pt-br'][0]['fid'])) {
                        $vTmpFile = file_load($node->field_capa['pt-br'][0]['fid']);
                        if ($vTmpFile)// Veficiando o arquivo
                            file_delete($vTmpFile, 1);
                    }else {
                        unset($node->field_capa['pt-br']);
                    }
                }

                // Salvando as imagens na node
                $strUriCapa = (string) $noticia->imagem->path;

                // Se houver uma imagem de capa
                if (!empty($strUriCapa)) {
                    
                    // Obtem extensão do arquivo a partir da URL.
                    $vInfoFileCapa = pathinfo(parse_url($strUriCapa, PHP_URL_PATH));
                    
                    // verificando a extensão do arquivo
                    if (empty($vInfoFileCapa['extension'])){
                        throw new Exception("Arquivo sem extensão Capa");
                    }

                    // Imagem de capa
                    $vNomeArquivoCapa = $vInfoFileCapa['filename'] . '.' . $vInfoFileCapa['extension'];

                    // Cria nome para o arquivo temporário.
                    $vTempFileCapa = $strDirTemp . '/' . $vNomeArquivoCapa;

                    // Download do arquivo para o diretorio temporário.
                    $vCopiado = copy($strUriCapa, $vTempFileCapa);
                    
                    // Se o arquivo foi realmente copiado
                    if ($vCopiado) {
                        $file_path = drupal_realpath($vTempFileCapa);
                        // Cria o file object do Drupal.
                        $file = (object) array(
                                    'uid' => 722, // "dono" do arquivo
                                    'uri' => $file_path, // caminho para o arquivo
                                    'filemime' => file_get_mimetype($file_path), // pega o mimetype do arquivo
                                    'display' => 1,
                                    'status' => 1,
                                    'alt' => $noticia->imagem->alt,
                                    'title' => $noticia->imagem->title
                        );

                        // Salva o arquivo na raiz da sua pasta files
                        $file = file_copy($file, "public://");

                        // Setando a imagem na node
                        $node->field_capa['pt-br'][0] = (array) $file;

                        // Excluindo o arquivo tempororari;o
                        unlink($vTempFileCapa);
                    }
                }
                
                // Salvando o dominio do redirecionamento da notícia
                $node->field_redireciona["und"][0]['value'] = (string) 'http://' . $noticia->path;

                // se a node foi sincronizada e se existe o nid
                if (!$objSincronizacao) {
                    // Submetendo e salvando a node
                    $node = node_submit($node);
                }

                // Salvando a node
                node_save($node);

                // se a notícia já foi cincronizada
                if (!$objSincronizacao)
                    db_inserirRelaciaoEspecial($node->nid, $noticia->nid);
            }
        } catch (Exception $exc) {
            watchdog('Integração RSS', $exc->getMessage(), null, WATCHDOG_ERROR);
        }
    }
}

function __addTags($arrTags, &$node, $vId = 1) {

    foreach ($arrTags as $keyTag => $tag) {

        //Verifica se a tag existe
        $originalTag = taxonomy_get_term_by_name($tag->name, 'tags');
        $originalTag = reset($originalTag);

        if (!empty($originalTag)) {

            $objNode->field_tags['pt-br'][$keyTag] = array('tid' => $originalTag->tid);
        } else {
            $newTag = new stdClass();
            $newTag->name = $tag->name;
            $newTag->vid = $objVocabTags->vid;
            taxonomy_term_save($newTag);

            $objNode->field_tags['pt-br'][$keyTag] = array('tid' => $newTag->tid);
        }
    }
}