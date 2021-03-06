<?php
/**
 * Arquivo que conterá os page callback do módulo
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */

// Includes necessários
module_load_include('inc', 'blocosespeciais', 'blocosespeciais.api');

/**
 * Método que irá retornar a page de montagem de capa
 */
function montarcapa(){
  // Add as livrarias
  drupal_add_library('system', 'ui.draggable');
  drupal_add_library('system', 'ui.droppable');
  drupal_add_library('system', 'ui.dialog');

  // Cadernos do LeiaJá
  $vCadernoLegenda['caderno_noticias']   = "Notícias";
  $vCadernoLegenda['caderno_politica']   = "Política";
  $vCadernoLegenda['caderno_esportes']   = "Esportes";
  $vCadernoLegenda['caderno_cultura']    = "Cultura";
  $vCadernoLegenda['caderno_tecnologia'] = "Tecnologia";
  $vCadernoLegenda['caderno_carreira']   = "Carreira";
  $vCadernoLegenda['caderno_multimidia'] = "Multimídia";
  $vCadernoLegenda['eleicoes_2012']      = "Eleições 2012";
  $vCadernoLegenda['Carnaval_2012']      = "Carnaval 2012";
  $vCadernoLegenda['especial']           = "Especial";
  $vCadernoLegenda['geral']              = "Todos Cadernos";
  $vCadernoLegenda['blog_social']        = "Blog HallSocial";


  $vParams['vCadernoLegendas'] = $vCadernoLegenda;

  return theme('montarcapa', $vParams);
  
}


function ajax_noticiasPorCaderno()
{
    // Recupernaod o caderno informado
    $vCaderno = (empty($_GET['caderno'])) ? 'caderno_noticias' : $_GET['caderno'];
    
    // Chamando a função que ira tratar os dados e retornar a listagem das notícias
    $vUltimas = api_noticiasPorCaderno($vCaderno);
    
    $objRetorno = array();
    
    foreach($vUltimas as $intKey => $arrDados){
      foreach($arrDados as $strChave => $strValor){
        $objRetorno[$intKey][$strChave] = utf8_encode($strValor);
      }
    }
    
    
    // Retornando o json
    echo json_encode($vUltimas);die;
}

function ajax_templateig()
{
    // Recupernaod o caderno informado
    $vCaderno = (empty($_GET['caderno'])) ? 'caderno_noticias' : $_GET['caderno'];
    
    // Chamando a função que ira tratar os dados e retornar a listagem das notícias
    $vUltimas = api_noticiasPorCaderno($vCaderno);
    
    // Retornando o json
    echo json_encode($vUltimas);die;
}

function ajax_carreganode(){
  
  $vNid     = (int) @$_GET['nid'];
  $vPosicao = (int) @$_GET['posicao'];
  $vOrigem  = @$_GET['origem'];
  
  // Array de parametros
  $arrDados = array("intNId"=> $vNid, "strPosicao"=>$vPosicao, "intUId"=> $GLOBALS['user']->uid, "strOrigem"=>$vOrigem);
  
  // Case o nid seja valido
  if(is_numeric($vNid)){
    // chamando a função
    $objNode = api_ajax_carreganode($arrDados);
    
    // Retornando via Json
    echo json_encode($objNode);
  }else{
    // Caso seja falso retorno erro
    echo json_encode(false);
  }
}


function ajax_salvarcapa(){
  // Parametros de retorno
  $strMensagem = "Salvo com sucesso!!!";
  $bolRetorno = false;
  
  // Iniciando a transação
  $objTransaction = db_transaction();
  try {
    // Passando o array do post para ser tratado e posteriomente salvo em banco
    api_salvar_capa_ig($_POST);
    $bolRetorno = true;
    
        // We are returning JSON, so tell the browser.
    drupal_add_http_header('Content-Type', 'application/json; charset=utf-8');
    
    // Imprimindo o retonor
    $content = drupal_json_encode(api_ajax_integracao_ig());
    
    // Criando o arquivo com a  para o ig pernambuco
    $erroGeracao = file_put_contents($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "integracaoig.js", $content);
  } catch (Exception $exc) {
    $objTransaction->rollback();
    $strMensagem = $exc->getMessage();
  }

  // Array de retorno
  $arrRetorno = array();
  $arrRetorno["strMensagem"] = $strMensagem;
  $arrRetorno["bolRetorno"] = $bolRetorno;
  
  // Retornando via json
  echo json_encode($arrRetorno);
}


function ajax_populartemplate(){
  // Parametros de retorno
  $strMensagem = "Salvo com sucesso!!!";
  $bolRetorno = false;
  
  // Iniciando a transação
  $objTransaction = db_transaction();
  try {
    // Pegando o identificador da capa
    $intIdCapa = @$_POST["capaid"];
    //Pegando o tipo do bloco
    $tipo_bloco = @$_POST["tipo_bloco"];
    
    // Passando o array do post para ser tratado e posteriomente salvo em banco
    $arrNodes = api_carregaNodesTemplate($intIdCapa, $tipo_bloco);
    $bolRetorno = true;
  } catch (Exception $exc) {
    $objTransaction->rollback();
    $strMensagem = $exc->getMessage();
  }
  // Array de retorno
  $arrRetorno = array();
  $arrRetorno["strMensagem"] = $strMensagem;
  $arrRetorno["bolRetorno"] = $bolRetorno;
  $arrRetorno["arrNodes"] = $arrNodes;
  
  // Retornando via json
  echo json_encode($arrRetorno);
  
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
function ajax_integracao_ig(){
  try {
    // We are returning JSON, so tell the browser.
    drupal_add_http_header('Content-Type', 'application/json; charset=utf-8');
    
    // Imprimindo o retonor
    echo drupal_json_encode(api_ajax_integracao_ig());
    
  } catch (Exception $exc) {  }
  
}

/**
 * Método que irá limpar o cache do site especifíco
 */
function limparCacheNode(){
  try {
      // Limpando todos os caches
      drupal_flush_all_caches();
      
      // Mostrando o log
      watchdog('Cache Integração', "Caches limpos em: " . date("d/m/Y H:i"), null, WATCHDOG_NOTICE);
            echo "tudo certo";
  } catch (Exception $exc) {  watchdog('Cache Integração', $exc->getMessage(), null, WATCHDOG_NOTICE);}
  
}

function getNodesInLeiajaBlock(){
  
  return api_getNodesInLeiajaBlock();
  
}

function getNodesInCarnavalBlock(){
  
  return api_getNodesInCarnavalBlock();
  
}

function getNodesInCopaBlock(){
  
  return api_getNodesInCopaBlock();
  
}

function getNodesInEleicoesBlock(){
  
  return api_getNodesInEleicoesBlock();
  
}

function getNodesInSaoJoaoBlock(){
  
  return api_getNodesInSaoJoaoBlock();
  
}