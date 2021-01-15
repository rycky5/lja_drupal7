<?php
/**
 * Arquivo que conterá os hooks do meu módulo
 * 
 * @author Thiago Galvão <galvao@sereducacional.com>
 */

function page_galeriaEmbed() {
  $vNid = base64_decode(urldecode(arg(1)));
  $vNode = null;

  if (is_numeric($vNid)) {
    $vNode = node_load($vNid);

    if (!empty($vNode)) {
      db_query("UPDATE node_counter SET totalcount=totalcount+1 WHERE nid = $vNid")->execute();
      node_build_content($vNode, 'full', null);
    }
  }

  $vParams = Array('node' => $vNode);
  $output = theme('galeria-embed', $vParams);

  echo $output;
}


function page_multimidiaEmbed() 
{
  $vNid = base64_decode(urldecode(arg(1)));
  $vNode = null;

  if (is_numeric($vNid)) {
    $vNode = node_load($vNid);

    if (!empty($vNode)) {
      db_query("UPDATE node_counter SET totalcount=totalcount+1 WHERE nid = $vNid")->execute();
      node_build_content($vNode, 'full', null);
    }
  }


  $vParams = Array('node' => $vNode);
  $output = theme('multimidia-embed', $vParams);

  echo $output;
}

/**
 * Cria permlink para conteudo sem o permlink.
 */
function page_manutencaoPermlink() 
{
  $vQuery = "SELECT *
               FROM `node` as n
               LEFT JOIN field_data_field_permlink as per ON per.entity_id = n.nid
               WHERE field_permlink_value is null";

  $result = db_query($vQuery);
  global $base_url;

  foreach ($result as $res) {
    $vLink = $base_url . '/' . utf8_decode(drupal_lookup_path('alias', 'node/' . $res->nid));
    $vLinkPerm = file_get_contents('http://leiaja.me/ws/?url=' . $vLink);

    db_insert('field_data_field_permlink')->fields(array(
        'entity_type' => 'node',
        'bundle' => $res->type,
        'deleted' => 0,
        'entity_id' => $res->nid,
        'revision_id' => $res->nid,
        'language' => 'pt-br',
        'delta' => 0,
        'field_permlink_value' => trim($vLinkPerm)
    ))->execute();

    echo "nid: {$res->nid} $vLink => $vLinkPerm<hr/>";
  }
}

/**
 * Exibe versão de impressão
 *
 */
function page_utilImprimir() 
{
  if (!empty($_GET['l'])) {
    $vLink = 'http://' . $_SERVER['HTTP_HOST'] . base_path() . base64_decode(urldecode($_GET['l']));

    $vTxt = implode('', file($vLink));

    $vInicio = strpos($vTxt, '<!-- PRINT -->');
    $vFim = strpos($vTxt, '<!-- /PRINT -->');

    $vImprimir = substr($vTxt, $vInicio, $vFim - $vInicio);
  }

  echo $vImprimir;
}