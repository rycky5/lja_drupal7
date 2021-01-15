<?php
/**
 * Carrega Conteúdo
 *
 * @param String $pCaderno  Nome dos caderos separados por virgula.
 * @param Array $pParams{
 * @param pFotos, Com ou sem fotos
 * @param pDestaque, Bool destaque.
 * @param pPromovido,
 * @param pQtd, Limit de notícias
 * @param pFavoritos, Notícias Favoritas por usuário logado
 * @param pVideo,
 * @param pNodeId,
 * @param pPromovido,
 * @param pDestaque,
 * @param pSemDestaque,
 * @param pSemFoto,
 * @param pIgnore,
 * @param pSubcategoria}
 *
 */
function getConteudoMulher($pCaderno = '', $pParams = array())
{
  $pQtd       = (empty($pParams['pQtd'])) ? 0 : $pParams['pQtd'];
  $pFavoritos = (!isset($pParams['pFavoritos'])) ? '' : "INNER JOIN tbmeuleiaja AS mj ON mj.nid = n.nid AND mj.uid = {$GLOBALS['user']->uid} AND mj.type = ".$pParams['pFavoritos'];
  $pCaderno   = (empty($pCaderno)) ? "'carnaval-2012'" : $pCaderno;
  $pIdNode    = "";

  // se  array de nodes não estiver vazio
  if(!empty ($pParams["pIdNode"])){
    // Iniciando a clausula de not in dos nodes
    $pIdNode = " AND n.nid NOT IN (";

    // Realizando a interação para pegar os ids dos nodes que não serão utilizados
    foreach($pParams["pIdNode"] as $intIdNode)
      $pIdNode .= " {$intIdNode},";

    // Retirando o ultimo caractere
    $pIdNode = substr($pIdNode, 0, -1) . ")";

  }

  $vQuery = "SELECT n.nid,
                    n.title,
                    f.filename,
                    if(fm.uri IS NULL,f.uri,fm.uri) as uri,
                    tv.name as categoria,
                    td.name as subcategoria,
                    tv.machine_name,
                    n.created,
                    date_format(FROM_UNIXTIME(n.created),'%d/%m') AS data,
                    date_format(FROM_UNIXTIME(n.created),'%H:%i') AS hora,
                    bo.body_summary,
                    bo.body_value,
                    if(ch.field_chapeu_value IS NULL, td2.name, ch.field_chapeu_value) as tag,
                    td2.tid as tid2,
                    td.tid,
                    fo.field_fonte_value as fonte,
                    u.name,
                    co.comment_count,
                    fm.uri as urithumbvideo
                    FROM `node` as n
                    INNER JOIN users AS u                       ON u.uid = n.uid
                    LEFT JOIN field_data_field_fonte AS fo      ON fo.entity_id = n.nid and fo.bundle = n.type
                    LEFT JOIN field_data_body AS bo             ON bo.entity_id = n.nid and bo.bundle = n.type
                    LEFT JOIN field_revision_field_chapeu AS ch      ON ch.entity_id = n.nid and ch.bundle = n.type
                    LEFT JOIN field_data_field_capa as fc       ON fc.entity_id = n.nid
                    LEFT JOIN file_managed as fm                ON fm.fid = fc.field_capa_fid
                    LEFT JOIN field_data_field_image as img  ON n.nid = img.entity_id
                    LEFT JOIN file_managed as f              ON f.fid = img.field_image_fid
                    $pFavoritos
                    INNER JOIN taxonomy_index as tid            ON tid.nid = n.nid
                    INNER JOIN taxonomy_term_data as td         ON tid.tid = td.tid AND td.vid <> 1
                    INNER JOIN taxonomy_vocabulary as tv        ON tv.vid = td.vid
                    INNER JOIN taxonomy_index as tid2           ON tid2.nid = n.nid
                    INNER JOIN taxonomy_term_data as td2        ON tid2.tid = td2.tid AND td2.vid = 1
                    LEFT JOIN node_comment_statistics AS co     ON co.nid = n.nid
                    WHERE n.type in ($pCaderno) AND n.status = 1 ";

## Cláusulas where.
//  $vQuery .= ((empty($pParams['pFavoritosMidia'])) ? "" : " td.vid = {$pParams['pFavoritosMidia']}");
  $vQuery .= ((!empty($pParams['pNodeId'])) ? " n.nid = {$pParams['pNodeId']}" : "");
  $vQuery .= ((!empty($pParams['pPromovido'])) ? " AND n.promote = 1 " : "");
  $vQuery .= ((!empty($pParams['pNoPage'])) ? " AND n.comment <> 1 " : "");
  $vQuery .= (!empty($pParams['pFotos'])) ? ' AND (f.uri is not null OR fm.uri is not null) ' : '';
  $vQuery .= ((!empty($pParams['pDestaque'])) ? " AND n.sticky = 1 " : "");
  $vQuery .= ((!empty($pParams['pSemDestaque'])) ? " AND n.sticky <> 1 " : "");
  $vQuery .= ((!empty($pParams['pSemFoto'])) ? " AND f.uri is null AND fm.uri IS NULL " : "");
  $vQuery .= ((!empty($pParams['pIgnore'])) ? " AND n.nid not in ({$pParams['pIgnore']}) " : "");
  $vQuery .= ((!empty($pParams['pSubcategoria'])) ? " AND td.name = '{$pParams['pSubcategoria']}' " : "");
  $vQuery .= (!empty($pParams['pDias'])) ? " AND DATE_FORMAT(FROM_UNIXTIME(n.created),'%Y-%m-%d') BETWEEN DATE_SUB(CURRENT_DATE,interval {$pParams['pDias']} day) AND CURRENT_DATE" : '';
  $vQuery .= (!empty($pParams['pIgnoreCapa'])) ? " AND n.nid NOT IN(SELECT nid FROM tbcapa WHERE status = 1 AND nid is not null)" : '';
  $vQuery .= (!empty ($pIdNode)) ? $pIdNode : "";
  ## Agrupando o resultado.
  $vQuery .= " GROUP BY n.nid ";

  ## Ordenando a query.
  $vQuery .= "ORDER BY n.created DESC";

  ## Finalizando a montagem da query.
  $vQuery .= ($pQtd > 0) ? " LIMIT $pQtd " : "";
   //echo (!empty($pParams['echo']))? $vQuery: '';
  //watchdog(WATCHDOG_DEBUG, $vQuery);
  $result = db_query($vQuery);
  $result = $result->fetchAll();

  return $result;
}

$vIgnore = '';
/**
 * Consulta que retorna os nós na ordem definida no Backoffice.
 * tem como parametro a região definida (ex.: 'capa').
 *
 * @param $pArea
 */
function getConteudoCapaMulher($pArea = 'capa', &$vars, $template = true)
{
  $vQuery = "SELECT cp.posicao,cp.params,cp.area,cp.template,n.nid,n.title,fm.uri as uri ,tax.categoria,tax.subcategoria,tax.machine_name
             FROM `tbcapa` AS cp
	     LEFT JOIN node AS n ON n.nid = cp.nid
	     LEFT JOIN field_data_field_fonte AS fo ON fo.entity_id = n.nid and fo.bundle = n.type
	     LEFT JOIN field_data_body AS bo ON bo.entity_id = n.nid and bo.bundle = n.type
	     LEFT JOIN field_data_field_image as img ON n.nid = img.entity_id
	     LEFT JOIN file_managed as f ON f.fid = img.field_image_fid
             LEFT JOIN field_data_field_capa as fc ON fc.entity_id = n.nid
             LEFT JOIN file_managed as fm ON fm.fid = fc.field_capa_fid
             LEFT JOIN (SELECT ti.nid,tv.name as categoria,td.name as subcategoria,tv.machine_name
                        FROM taxonomy_index as ti
                        INNER JOIN taxonomy_term_data as td ON td.tid = ti.tid AND td.vid <> 1
                        INNER JOIN taxonomy_vocabulary as tv ON tv.vid = td.vid) as tax ON tax.nid = n.nid
	     WHERE cp.status = 1
             AND cp.area = '$pArea'
  	     GROUP BY cp.id
	     ORDER BY cp.posicao ASC";

  $result = db_query($vQuery);

  $vCapa = $result->fetchAll();

  ## Verifica das noticas da capa se existem randomicas e prepara uma array com os cadernos e quantidades a serem preenchidas.
  $vCarrega  = Array();
  $vTemplate = null;
  foreach($vCapa as $key => $vNot){
    $vTemplate = $vNot->template;
    if(empty($vNot->nid)){
      @$vCarrega[$vNot->params]['total']++;
      @$vCarrega[$vNot->params]['posicao'][] = $vNot->posicao;
    }else{
      @$vIgnore[] = $vNot->nid;
    }
  }

  ## Carrega as noticias randomicas para tantos cadernos e posições definidas.
  ## Caso não existam randomicas não entra no laço.
  foreach($vCarrega as $vCaderno => $vRand){

    $vNotIn = implode(',',$vIgnore);

    $vCaderno = ($vCaderno == 'geral') ? "'caderno_noticias','caderno_esportes','caderno_cultura','caderno_carreiras','caderno_tecnologia'" : "'$vCaderno'";

    $vNoticiaRand = getConteudoMulher($vCaderno, array('pQtd' => $vRand['total'], 'pDestaque' => true, 'pFotos' => true, 'pIgnore' => $vNotIn));

    ## Popula a primeira consulta da capa preenchendo com as noticias randomicas.
    foreach($vRand['posicao'] as $key => $vPos){
      $vNoticiaRand[$key]->posicao = $vPos;
      $vCapa[($vPos-1)] = $vNoticiaRand[$key];
      $vIgnore[]        = $vNoticiaRand[$key]->nid;
    }

  }
  if($template){

    $vArea            = strtolower($pArea);
    $vCaminho         = $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('module', 'leiaja').'/template/';
    $vArquivoTemplate = "{$vCaminho}{$vArea}.template{$vTemplate}.tpl.php";
    $vars['vArquivoTemplateCapa'] = $vArquivoTemplate;
    $vars['vUltimas']              = $vCapa;

    return $vArquivoTemplate;

  }else{
    return $vCapa;
  }

}