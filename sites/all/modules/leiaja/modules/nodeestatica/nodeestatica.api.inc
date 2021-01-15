<?php
/**
  * @author Thiago Galvão <galvao@sereducacional.com
  * @version 2.0
  */

  // Includes necessarios
  module_load_include('inc', 'nodeestatica', 'nodeestatica.db');
  define("PATHA_ESTATICO", $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR);

/**
 * Metodo que ira gerar/atualizar os as quivos de conteúdo.
 * 
 * @param stdClass $node
 * @param boolean $bolAtualizar 
 */
function api_gerarEstatico($node, $bolAtualizar = false, $pCron = false)
{
  module_load_include('inc', 'pathauto');
  $vFalhaGeracao = true;

  try {
    
    // Se o node não estiver sendo publicado retorna false.
    if ($node->status == 0 && $node->publish_on == 0){
      return false;
    }
    // Se o tipo de conteúdo for colunistas gera o XML e retorna false.
    if($node->type == 'caderno_colunistas'){
        _salvarXmlNode($node);
        return false;
    }    
    // Se o tipo de conteúdo não pertencer a algum cadernos definido retorna false.
    if(!in_array($node->type, array_flip(_getTiposConteudos()))){
        return false;
    }
    
      
    // Se o node estiver sendo atualizado exclui arquivos estáticos antigos.
    if ($bolAtualizar) {
       _invalidaEstatico($node);
    }


    // Atualizar o alias no banco.
    pathauto_node_update_alias($node, "insert");
    $urlAlias = $node->path['alias'] = drupal_lookup_path('alias', "node/" . $node->nid);

    // Se houve falha na criação do Alias não permite que o node seja publicado.
    if (!isset($urlAlias) || empty($urlAlias)) {
      $node->status = 0;
      field_attach_update('node', $node);
      drupal_set_message(t("ERRO Url Alias, Verifique se está ativo a 'Generate automatic URL alias'. Nid = " . $node->nid), 'error');
      return false;
    }

    // pasta onde ficam os arquivos gerados
    $pathPasta = PATHA_ESTATICO . $urlAlias . DIRECTORY_SEPARATOR;
    
    if (!is_dir($pathPasta)){
      $vEstruturaPasta = mkdir($pathPasta, 0777, true);
      if(!$vEstruturaPasta){
        watchdog('Node Est�tica', '[api_gerarEstatico] Erro ao criar estrutura diret�rio.', null, WATCHDOG_ERROR);
        
        return false;
      }
    }

    // Verificando se h� uso do 'field_redireciona' para criar index.php espec�fico.
    if (!empty($node->field_redireciona[key($node->field_redireciona)][0]["value"])) {

      $strRedireciona = '<?php header("Location: ' . $node->field_redireciona["und"][0]["value"] . '"); die; ?>';
      
      $strRedireciona = str_replace('sgc.leiaja.com', 'www.leiaja.com', $strRedireciona);
      $vFalhaGeracao    = file_put_contents($pathPasta . "index.php", $strRedireciona);
    } else {
      //FIXME: Verificar necessidade de mexer nos campos de imagens do conteúdo.
      if (!empty($node->field_image)) {
        foreach ($node->field_image[key($node->field_image)] as $intChave => $arrFile) {
          $objFile = file_load($arrFile["fid"]);
          // Setando o titulo da imagem
          $objFile->title = $node->field_image[key($node->field_image)][$intChave]["title"];
          // Setando o alt da imagem
          $objFile->alt = $node->field_image[key($node->field_image)][$intChave]["alt"];
          // Setando o objeto imagem
          $node->field_image[key($node->field_image)][$intChave] = (array) $objFile;
        }
      }

      //For�ar commit para a transaction ativa.
      db_query('COMMIT')->execute();
      
      // Gera HTML est�tico.
      $vFalhaGeracao = _salvaHtmlNode($node, $pathPasta);
      
      // Salvar XML do node. Caso vier de um cron n�o salvar o XML.
      $vFazerIntegracao = ($pCron) ? false : true;
      _salvarXmlNode($node, $pathPasta . "index", $vFazerIntegracao);
      
      if(!$vFalhaGeracao){
        // Caso tenha erro retorno no retorno do file_get_contents
        $vFalhaGeracao = false;
        watchdog('Node Estática', '[api_gerarEstatico] Falha ao gerar nid => ' . $node->nid, null, WATCHDOG_ERROR);
      }else{          
        watchdog('Node Estática', "Node gerado: " . $node->title . " - " . $node->nid, null, WATCHDOG_INFO);
      }
    }


    if (!$vFalhaGeracao || !file_exists($pathPasta . "index.php")) {
      // atualizar o banco o status para 0
      $node->status = 0;

      drupal_set_message(t('Não foi possível publicar o conteúdo, tente novamente. Falha ao gerar arquivos estáticos. Nid = ' . $node->nid), 'error');
    }

    // atualizacao no banco
    field_attach_update('node', $node);

    return true;
  } catch (Exception $exc) {
    $node->status = 0;
    field_attach_update('node', $node);
    // Setando mensagem no log de erro do drupal
    watchdog('Node Estática', $exc->getMessage() . $exc->getTraceAsString(), null, WATCHDOG_ERROR);
    drupal_set_message(t('Exception: Não foi possível publicar o conteúdo, tente novamente. Falha ao gerar arquivos estáticos. Nid = ' . $node->nid), 'error');
    return false;
  }
}

/**
 * Função para contabilizar PageViews com informações do GetClicky.
 * 
 */
function api_contabilizaGetClick() 
{
  $arrayFiltros = array(1 => 'today', 2 => 'this-week', 3 => 'this-month');
  
  ## limpar os valores antigos para nao gerar lixo na tabela
  db_clearGetClicky();
  
  foreach ($arrayFiltros as $k => $value) {
    $urlApi = "http://api.getclicky.com/api/stats/4?site_id=66504528&sitekey=dc304fb62ab3a783&type=pages&date={$value}&limit=20&output=json";

    $json      = file_get_contents($urlApi);
    $objResult = json_decode($json, true);

    foreach ($objResult[0]['dates'][0]['items'] as $item) {
      // remover sgc e www1 
      $link = str_replace('www1', 'www', str_replace('sgc.', 'www.', $item['url']));

      if (_GetClickyUrlBlacklist($link) || _GetClickyTitleBlacklist($item['title']))
        continue;

      // remover query string da url
      $tempUrl = explode('?', $link);
      $urlLink = $tempUrl[0];

      $urlTitulo = str_replace('| LeiaJá', '', $item['title']);

      db_addGetClicky($urlTitulo, $urlLink, $item['value'], $k);
    }
  }

  watchdog('Node Estática', "Atualizada 'As mais lidas' via API GetClicky" , null, WATCHDOG_INFO);
}

/**
 * metodo para gerar topo e rodape dos cadernos
 * 
 */
function api_gerarEstruturaNode() 
{
  $arrCadernos = _getTiposConteudos();

  try {

      $strUrl = "http://" . $_SERVER["SERVER_NAME"] . "/nodeestatica/htmlestrutura";

      // TODO: Versão para tema leiajá 2.0
      //$strUrl = "http://" . $_SERVER["SERVER_NAME"] . "/admin-capa/ajax/capa-base";

      // Recuperando a URL com um timeout de 60 segundos
      $objRetorno = drupal_http_request($strUrl, array("timeout" => 60));

      // validandoo retorno
      if ($objRetorno->code == 200 || $objRetorno->code == 201 || $objRetorno->code == 202) {

        // Removendo os escapes do php para realizar o include
        $strHtmlRetorno = str_replace("\\<\\?php", "<?php", str_replace("\\?\\>", " ?>", $objRetorno->data));

        // Explodindo o resultado
        $arrResultado = explode("##@content@##", $strHtmlRetorno);

        // Caso tenha retorno
        if ($strHtmlRetorno != null) {
          // gerar as capas para cada caderno
          foreach ($arrCadernos as $strChave => $strValor) {
              
            // Removendo a string de caderno_
            $strResultado = str_replace("caderno_", "", $strChave);
            
            // Verificando os diretorios
            if (!is_dir(DRUPAL_ROOT . DIRECTORY_SEPARATOR . $strResultado))
                mkdir(DRUPAL_ROOT . DIRECTORY_SEPARATOR . $strResultado);

            // Criando o arquivo com a noticia
            file_put_contents(DRUPAL_ROOT . DIRECTORY_SEPARATOR . $strResultado . DIRECTORY_SEPARATOR . "index_topo.php", trim(str_replace("{css_cor}", "vermelho",$arrResultado[0])));
            file_put_contents(DRUPAL_ROOT . DIRECTORY_SEPARATOR . $strResultado . DIRECTORY_SEPARATOR . "index_baixo.php", trim($arrResultado[1]));
          }
        }
      }
    } catch (Exception $exc) {
       watchdog('Node Estática', "[api_gerarEstruturaNode] ".$exc->getMessage() . $exc->getTraceAsString(), null, WATCHDOG_ERROR);
    }
}

/**
 * Cron para gerar arquivos estáticos.
 *  
 */
function api_executaCron() 
{
    $arrNids = db_getCron();
    $vCont   = 0;
    
    foreach ($arrNids as $nid) {
        $vNode   = node_load($nid->Nid);
        api_gerarEstatico($vNode, true, true);
        
        db_deleteCron($nid->Nid);
    }
    
    watchdog('Node Estática', "Cron executada. $vCont nodes atualizados." , null, WATCHDOG_INFO);
}

################################################################################
##
## Funções "Privadas" para uso apenas pelas funções de API.
## Não devem ser invocadas por funções de outros arquivos.
##
################################################################################

/**
 * Retorna array com os tipos de conteúdos.
 *
 * @return Array
 */
function _getTiposConteudos()
{
    $vCadernos['caderno_noticias']   = 'Notícias';
    $vCadernos['caderno_politica']   = 'Política';
    $vCadernos['caderno_carreiras']  = 'Carreiras';
    $vCadernos['caderno_esportes']   = 'Esportes';
    $vCadernos['caderno_cultura']    = 'Cultura';
    $vCadernos['caderno_tecnologia'] = 'Tecnologia';
    $vCadernos['caderno_multimidia'] = 'Multimídia';

    return $vCadernos;
}

/**
 * Salva HTML com o conteúdo do node no diretório de acordo com o URL Alias.
 * 
 * @return boolean
 */
function _salvaHtmlNode($pNode, $vPath)
{
    // Renderizando node com tema específico do módulo para trazer apenas o conteúdo (miolo).
    $strUrlNode = "http://" . $_SERVER["SERVER_NAME"] . "/nodeestatica/htmlnode?idNode=" . $pNode->nid . "&v=" . rand();
    $strHtmlRetorno = file_get_contents($strUrlNode);

    if ($strHtmlRetorno && $strHtmlRetorno != null) {

      // Removendo os escapes do php para realizar o include
      $strHtmlRetorno = str_replace("\\<\\?php", "<?php", str_replace("\\?\\>", " ?>", $strHtmlRetorno));
      // Setando os includes na noticia
      $strHtmlRetorno = _getIncludesNodeEstatica($strHtmlRetorno, $pNode->type);
      // Data de atualizacao da node  
      $strHtmlRetorno .= " \r\n <!-- Gerado em: " . date("d-m-Y H:i:s") . " -->";

      $strHtmlRetorno = str_replace('sgc.leiaja.com', 'www.leiaja.com', $strHtmlRetorno);
      $erroGeracao = file_put_contents($vPath . "index.php", $strHtmlRetorno);

      // Removendo os escapes do php para realizar o include
      $strVariaveis = str_replace("\\<\\?php", "<?php", str_replace("\\?\\>", " ?>", _getVariaveis($pNode)));
      $erroGeracao = file_put_contents($vPath . "variaveis.php", $strVariaveis);  
    }else
      $erroGeracao = false;
    
    return $erroGeracao;
}

/**
 * Retorna STRING com código PHP para ser inserido no arquivo estático.
 * 
 * @param String $strResultadoNode
 * @return string 
 */
function _getIncludesNodeEstatica($vHtmlNode, $strCaderno = '') 
{
  $urlCaderno = str_replace('caderno_', '', $strCaderno);

  // Incluindo do topo.
  $strResultadoNode = "<?php 
                        define('DRUPAL_ROOT', '" . getcwd() . "');

                        // carregando os arquivo de variaveis
                        if(file_exists('variaveis.php')){
                          // Include no arquivo de variaveis
                          include_once('variaveis.php');
                        }
                        
                        // Include no arquivo de topo
                        include_once(DRUPAL_ROOT. DIRECTORY_SEPARATOR . '" . $urlCaderno . "' . DIRECTORY_SEPARATOR . 'index_topo.php'); ?>" . $vHtmlNode;

  // Include do Footer.
  $strResultadoNode = $strResultadoNode .
          "<?php 
                // Include no arquivo baixo
                include_once(DRUPAL_ROOT. DIRECTORY_SEPARATOR . '" . $urlCaderno . "' . DIRECTORY_SEPARATOR . 'index_baixo.php');
          ?>";

  // Retornando o arquivo de topo
  return $strResultadoNode;
}

/**
 * Método que irá salvar o xml que representa a estrutura de um Node.
 * 
 * @param stdClass  $node
 * @param string    $strPathNode
 * @param bool      $update 
 */
function _salvarXmlNode($node, $strPathNode = null, $pIntegracao = true) 
{
    
  try {
    # Instancia do objeto XMLWriter
    $xml = new XMLWriter;

    # Cria memoria para armazenar a saida
    $xml->openMemory();

    # Inicia o cabeçalho do documento XML
    $xml->startDocument('1.0', 'iso-8859-1');

    # Adiciona/Inicia um Elemento / Nó Pai <item>
    $xml->startElement("materia");

    #  Adiciona um NÃ³ Filho <quantidade> e valor 8
    $xml->writeElement("nid", $node->nid);
    $xml->writeElement("data", $node->created);
    $xml->writeElement("titulo", $node->title);
    $xml->writeElement("caderno", $node->type);
    $xml->writeElement("linguagem", $node->language);
    $xml->writeElement("status", $node->status);
    $xml->writeElement("promote", $node->promote);
    $xml->writeElement("sticky", $node->sticky);
    $xml->writeElement("comment", $node->comment);

    if(!empty($node->field_catnegocios[$node->language][0]['tid'])){
        $vTermoCategoria = taxonomy_term_load($node->field_catnegocios[$node->language][0]['tid']);
        $xml->writeElement("categoria", $vTermoCategoria->name);
    }elseif(!empty($node->field_catnoticia[$node->language][0]['tid'])){
        $vTermoCategoria = taxonomy_term_load($node->field_catnoticia[$node->language][0]['tid']);
        $xml->writeElement("categoria", $vTermoCategoria->name);
    }elseif(!empty($node->field_catcultura[$node->language][0]['tid'])){
        $vTermoCategoria = taxonomy_term_load($node->field_catcultura[$node->language][0]['tid']);
        $xml->writeElement("categoria", $vTermoCategoria->name);
    }elseif(!empty($node->field_catesporte[$node->language][0]['tid'])){
        $vTermoCategoria = taxonomy_term_load($node->field_catesporte[$node->language][0]['tid']);
        $xml->writeElement("categoria", $vTermoCategoria->name);
    }elseif(!empty($node->field_catpolitica['und'][0]['tid'])){
        $vTermoCategoria = taxonomy_term_load($node->field_catpolitica['und'][0]['tid']);
        $xml->writeElement("categoria", $vTermoCategoria->name);
    }elseif(!empty($node->field_catradiotv[$node->language][0]['tid'])){
        $vTermoCategoria = taxonomy_term_load($node->field_catradiotv[$node->language][0]['tid']);
        $xml->writeElement("categoria", $vTermoCategoria->name);
    }elseif(!empty($node->field_cattecnologia[$node->language][0]['tid'])){
        $vTermoCategoria = taxonomy_term_load($node->field_cattecnologia[$node->language][0]['tid']);
        $xml->writeElement("categoria", $vTermoCategoria->name);
    }elseif(!empty($node->field_catcolunista[$node->language][0]['tid'])){
        $vTermoCategoria = taxonomy_term_load($node->field_catcolunista[$node->language][0]['tid']);
        $xml->writeElement("categoria", $vTermoCategoria->name);
    }
  
    $xml->writeElement('ig', @$node->field_ig['und'][0]['value']);
    $xml->writeElement("body", @$node->body[$node->language][0]["value"]);
    $xml->writeElement("summary", @$node->body[$node->language][0]["summary"]);
    $xml->writeElement("fonte", @$node->field_fonte[$node->language][0]["value"]);
    $xml->writeElement("videost", @$node->field_videost[key($node->field_videost)][0]["value"]);
    $xml->writeElement("audiost", @$node->field_audiost[key($node->field_audiost)][0]["value"]);

    $xml->startElement('tags');
    foreach ($node->field_tags[$node->language] AS $value) {
        if(!empty($value["name"]))
          $xml->writeElement("tag", $value["name"]);
    }
    $xml->endElement();

    // Salvando o caminho das imagens de topo
    $xml->startElement('images');

    // Salvando o caminho das imagens de capa
    if(!empty($node->field_image[key($node->field_image)])){
        foreach ($node->field_image[key($node->field_image)] AS $value) {
          $xml->startElement('image');
          // Recuperando os dados da imagem pelo seu FID
          $objFileImage = file_load($value["fid"]);
          $xml->writeElement("uri", str_replace("sgc", "www", file_create_url($objFileImage->uri)));
          $xml->writeElement("title", $value["title"]);
          $xml->writeElement("alt", $value["alt"]);
          $xml->endElement();
        }
    }
    $xml->endElement();

    // Salvando o caminho da imagem de capa
    $xml->startElement('imagecapa');
    
    if(!empty($node->field_capa[key($node->field_capa)])){
        foreach ($node->field_capa[key($node->field_capa)] AS $value) {
          // Recuperando os dados da imagem pelo seu FID
          $objFileImage = file_load($value["fid"]);

          $xml->writeElement("uri", str_replace("sgc", "www", file_create_url($objFileImage->uri)));
          $xml->writeElement("title", $value["title"]);
          $xml->writeElement("alt", $value["alt"]);
        }
    }

    // Finalizando o elemento XML
    $xml->endElement();

    $xml->startElement('imagemTopo');
    
    if(!empty($node->field_imagem_topo[key($node->field_imagem_topo)])){
        foreach ($node->field_imagem_topo[key($node->field_imagem_topo)] AS $value) {
          // Recuperando os dados da imagem pelo seu FID
          $objFileImage = file_load($value["fid"]);
          
          $xml->writeElement("uri", str_replace("sgc", "www", file_create_url($objFileImage->uri)));
          $xml->writeElement("title", $value["title"]);
          $xml->writeElement("alt", $value["alt"]);
        }
    }
    
//    if(!empty($node->field_imagem_topo)){
//        $objImgTopo = $node->field_imagem_topo[key($node->field_imagem_topo)][0];
//        //Recuperando os dados da imagem pelo seu FID
//        $objFileImage = file_load($objImgTopo['fid']);
//        
//        $xml->writeElement("uri", str_replace("sgc", "www", file_create_url($objFileImage->uri)));
//        $xml->writeElement("title", $objImgTopo['title']);
//        $xml->writeElement("alt", $objImgTopo['alt']);
//    }
    
    //Finalizando o elemento XML
    $xml->endElement();
    
    $xml->writeElement("path", str_replace("sgc", "www", "http://" . $_SERVER["SERVER_NAME"]) . "/" . $node->path["alias"]);
    $xml->writeElement("alias", drupal_lookup_path('alias', 'node/' . $node->nid));

    #  Finaliza o Nó Pai / Elemento <Item>
    $xml->endElement();

    # Salvando o arquivo em disco
    # retorna erro se o header foi definido.
    # retorna erro se o método outputMemory já foi executado.
    
    $vConteudoXML = $xml->outputMemory(true);
    
    if(!empty($strPathNode)){
        $file = fopen($strPathNode . ".xml", 'w+');
        fwrite($file, $vConteudoXML);
        fclose($file);        
    }
    
    ##Salva XML em pasta para integração com outros sistemas.
    if($pIntegracao){
        $file = fopen(PATH_XML.'/leiaja/'.mktime(). ".xml", 'w+');
        fwrite($file, $vConteudoXML);
        fclose($file);        
    }
    
    $arquivo = fopen(PATH_XML . DIRECTORY_SEPARATOR . 'leiaja' . DIRECTORY_SEPARATOR . 'debug' . DIRECTORY_SEPARATOR . $node->nid . ".txt", 'w+');
    fwrite($arquivo, serialize($node));
    fclose($arquivo);
    
    if(!empty($node->field_imagem_topo[key($node->field_imagem_topo)])){
        foreach ($node->field_imagem_topo[key($node->field_imagem_topo)] AS $value) {
          // Recuperando os dados da imagem pelo seu FID
          $objFileImage = file_load($value["fid"]);
          
          $objImage = fopen(PATH_XML . DIRECTORY_SEPARATOR . 'leiaja' . DIRECTORY_SEPARATOR . 'debug' . DIRECTORY_SEPARATOR . $node->nid . "_objImg.txt", 'w');
          fwrite($objImage, serialize($objFileImage));
          fclose($objImage);
        }
    }
  } catch (Exception $exc) {
    // Setando mensagem no log de erro do drupal
    watchdog('Node Estática', "[_salvarXmlNode] ".$exc->getMessage() . $exc->getTraceAsString(), null, WATCHDOG_ERROR);
  }
}

/**
  * Metodo para criar as variaveis.php
  * 
  * @param stdClass $objNode  
  * @return string 
  */
function _getVariaveis($objNode) 
{
    //imagem do facebook
    $strImagem = "";

    if(!empty($objNode->field_capa[key($objNode->field_capa)][0]["fid"])){
        //Recuperando a uri da imagem de capa
        $imagemUri = file_load($objNode->field_capa[key($objNode->field_capa)][0]["fid"])->uri;
        $strImagem = image_style_url('large', $imagemUri);
    }elseif(!empty ($objNode->field_imagem_topo[key($objNode->field_imagem_topo)][0]['fid'])){
        //Recuperando a uri da imagem de topo
        $imagemUri = file_load($objNode->field_imagem_topo[key($objNode->field_imagem_topo)][0]['fid'])->uri;
        $strImagem = image_style_url('large', $imagemUri);
    }elseif(!empty($objNode->field_image[key($objNode->field_image)][0]["fid"])){
        //Recuperando a uri da imagem
        $imagemUri = file_load($objNode->field_image[key($objNode->field_image)][0]["fid"])->uri;
        $strImagem = image_style_url('large', $imagemUri);
    }else{
        $strImagem = "http://www.leiaja.com/images/leiaja_social.png";
    }
    //Recuperando as tags da node
    $strTags = '';
    $arrTags = $objNode->field_tags[key($objNode->field_tags)];
    if(!empty($arrTags)){
        foreach ($arrTags as $key => $tag) {
            if($key < (count($objNode->field_tags[key($objNode->field_tags)]) - 1)){
                $strTags .= $tag['name'] . ', ';
            }else{
                $strTags .= $tag['name'];
            }
        }
    }    
    
  return '\<\?php 
                $strTitulo = "' . addslashes($objNode->title) . '";
                $strDescricao = "' . addslashes($objNode->body[$objNode->language][0]['summary']) . '";
                $strImagem = "' . $strImagem . '";
                $strTags ="'. $strTags .'";    
        \?\>';
}

/**
 * Retorna o link permanente via integração API leiaja.me
 */
function _getPermlink($pNid)
{
  $vUrlBase  = (str_replace('sgc.', 'www.', $_SERVER ['SERVER_NAME']));
  $vLinkFull = $vUrlBase . '/' . drupal_lookup_path('alias', "node/" . $pNid);
  $vLinkPerm = file_get_contents('http://leiaja.me/ws/?url=' . $vLinkFull);
  
  return $vLinkPerm;
}

/**
  * 
  * Exclui arquivos estáticos baseado no URL Alias do Nid.
  * 
  */
function _invalidaEstatico($node)
{
    $arrayUrlAlias = db_loadUrlAlias($node->nid);

    // eliminando todo o conteudo antigo dos alias
    foreach ($arrayUrlAlias as $objAlias) {
      $pathUrlAntiga = PATHA_ESTATICO . $objAlias->alias;
      if (is_dir($pathUrlAntiga))
          _deleteDir($pathUrlAntiga);
    }
    
    if(in_array($node->type, array_flip(_getTiposConteudos()))){
        // removendo os registros dos alias antigos
        db_excluirAlias($node->nid);
    }
    
}

/**
  * Função para remover pastas e todos arquivos contidos.
  * 
  * @param string $dirPath
  * @return void 
  */
function _deleteDir($dirPath) 
{
  if (!is_dir($dirPath)) {
    return;
  }
  if (substr($dirPath, strlen($dirPath) - 1, 1) != DIRECTORY_SEPARATOR) {
    $dirPath .= DIRECTORY_SEPARATOR;
  }
  $files = glob($dirPath . '*', GLOB_MARK);

  foreach ($files as $file) {
    if (is_dir($file)) {
      _deleteDir($file);
    } else {
      unlink($file);
    }
  }
  rmdir($dirPath);
}

/**
 * Retira acentos e espaços de uma String
 * 
 * @return String
 */
function _sanitizaAcentos($string)
{
	$a = 'À�?ÂÃÄÅÆÇÈÉÊËÌ�?Î�?�?ÑÒÓÔÕÖØÙÚÛÜ�?ÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
	$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	$string = utf8_decode($string);
	$string = strtr($string, utf8_decode($a), $b); //substitui letras acentuadas por &quot;normais&quot;
	$string = str_replace(' ', '', $string); // retira espaco
	$string = strtolower($string); // passa tudo para minusculo
	return utf8_encode($string); //finaliza, gerando uma saída para a funcao
}

/**
 * Função para validar se a url não pode ser contabilizada para as mais lidas.
 */
function _GetClickyTitleBlacklist($pTitle)
{
    $vValida    = false;
    $vBlacklist = array();
    
    $vBlacklist[] = 'A página não foi encontrada';
    $vBlacklist[] = 'Tudo que você precisa saber.';
    $vBlacklist[] = 'Página de Tags';
    $vBlacklist[] = 'Carreiras - Concursos';
    $vBlacklist[] = 'Caderno';
            
    // Valida se a string existe dentro do link.
    foreach($vBlacklist as $reject){
        if(strstr(strtolower(trim($pTitle)), strtolower(trim($reject)))){
            $vValida = true;
            break;
        }
    }
 
    return $vValida;
}
/**
 * Função para validar se a url não pode ser contabilizada para as mais lidas.
 */
function _GetClickyUrlBlacklist($pLink)
{
    $vValida    = false;
    $vBlacklist = array();
    
    $vBlacklist[] = '/tags';
    $vBlacklist[] = '/user';
    $vBlacklist[] = '/admin';
    $vBlacklist[] = '/nodeestatica';
    $vBlacklist[] = '//www3';
    $vBlacklist[] = '//www4';
    $vBlacklist[] = '/as-mais-clean';
    $vBlacklist[] = '/colunistas-clean';
    $vBlacklist[] = '/block-promov-destac-caderno';
    $vBlacklist[] = '/ultimas-noticias-clean';
    $vBlacklist[] = '/blogs-redacao-clean';
    $vBlacklist[] = '/colunistas-clean';
    $vBlacklist[] = '/ultimas-noticias-caderno-clean';
    $vBlacklist[] = '/block_concursos_clean';
    $vBlacklist[] = 'igpernambuco.leiaja.com';
    $vBlacklist[] = 'pernambuco.ig.com.br';
    
    ### criar um array com as url que nao preciso salvar em banco ###
    $arrayObjCadernos = _getTiposConteudos();
  
    foreach ($arrayObjCadernos as $key => $objCaderno) {
      $arrayUrlIgnoradas[] = trim('http://www.leiaja.com/' . strtolower(str_replace('caderno_', '', $key)) . '/');
    }
    
    $arrayUrlIgnoradas[] = 'http://www.leiaja.com/';
    $arrayUrlIgnoradas[] = 'http://retrospectiva.leiaja.com/';
    $arrayUrlIgnoradas[] = 'http://carnaval.leiaja.com/';
    $arrayUrlIgnoradas[] = 'http://saojoao.leiaja.com/';
       

    // Valida links completos.
    if(in_array($pLink, $arrayUrlIgnoradas)){
        return true;
    }
            
    // Valida se a string existe dentro do link.
    foreach($vBlacklist as $reject){
        if(strstr(strtolower($pLink), strtolower($reject))){
            $vValida = true;
            break;
        }
    }
 
    return $vValida;
}