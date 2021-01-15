<?php

// Incluindo arqivos necessários
module_load_include('inc', 'leiaja', 'capa');

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
 * @return ArrayObject Node
 */
function getConteudo($pCaderno = '', $pParams = array())
{
  $vCacheId = md5(serialize($pCaderno)).md5(serialize($pParams));
  $vCache   = cache_get($vCacheId, 'cache'); 
  
  if(!$vCache){
    $strCondicaoIMG = (empty($pParams['pFotos'])) ? '' : 'AND (f.uri is not null OR fm.uri is not null)';
    $pQtd           = (empty($pParams['pQtd'])) ? 2 : $pParams['pQtd'];
    $pCaderno       = (empty($pCaderno)) ? "'caderno_noticias','caderno_politica','caderno_cultura','caderno_esportes','caderno_carreiras','caderno_tecnologia'" : $pCaderno;
    $strCondicao    = "";
    $strContagemImg = "";

    /*************************************************************************
     ******** UTILIZADO PARA VERIFICAR NOTÍCIAS DE OUTROS CADERNOS ***********
     *************************************************************************/
    if(!empty($pParams["pSubcategoria"]) && $pParams["pSubcategoria"] == "Fotos"){
      $strCondicao = " OR field_image_fid IS NOT NULL ";

      // Seleciona nodes com pelo menos mais de uma imagem pra ser considerado galeria
      $strContagemImg = " AND (SELECT
                                  count(img.field_image_fid) as qtd
                          FROM field_data_field_image as img
                          WHERE  n.nid = img.entity_id
                          group by
                                  img.entity_id) > 1";
    }else  if(!empty($pParams["pSubcategoria"]) && $pParams["pSubcategoria"] == "Vídeos")
      $strCondicao = " OR (vst.field_videost_value IS NOT NULL AND td.name <> 'TV Leia Já')";
    else  if(!empty($pParams["pSubcategoria"]) && $pParams["pSubcategoria"] == "Podcasts"){
      $strCondicao = " OR (pdc.entity_id IS NOT NULL OR ast.entity_id IS NOT NULL)";
    }else if($pCaderno == "'caderno_multimidia'" && !(!empty($pParams["pSubcategoria"]) && $pParams["pSubcategoria"] != "Fotos"
                                                    || !empty($pParams["pSubcategoria"]) && $pParams["pSubcategoria"] != "Vídeos"
                                                    || !empty($pParams["pSubcategoria"]) && $pParams["pSubcategoria"] != "Podcasts"
                                                    || !empty($pParams["pSubcategoria"]) && $pParams["pSubcategoria"] != 'TV Leia Já')){ // Caso o caderno seja multímidia
      // Condições para buscar nodes que possual alguma multímidia
      $strCondicao = " OR field_image_fid IS NOT NULL OR  ast.field_audiost_value IS NOT NULL OR vst.field_videost_value IS NOT NULL OR v.entity_id IS NOT NULL OR pdc.entity_id IS NOT NULL ";
      // Seleciona nodes com pelo menos mais de uma imagem pra ser considerado galeria
      $strContagemImg = " AND (SELECT count(img.field_image_fid) as qtd
                               FROM field_data_field_image as img
                               WHERE  n.nid = img.entity_id
                               group by img.entity_id) > 1";
    }
    /* Contruindo a query */
    $vQuery = "SELECT
                      n.nid,
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
                      tbTag.name as tag,tbTag.tid as tid2,
                      td.tid,
                      fo.field_fonte_value as fonte,
                      u.name,
                      co.comment_count,
                      if(fm.uri IS NULL,f.uri,fm.uri) as uriThumbVideo
                      FROM `node` as n

                      INNER JOIN users AS u                       ON u.uid = n.uid
                      LEFT JOIN field_data_field_fonte AS fo      ON fo.entity_id = n.nid and fo.bundle = n.type
                      LEFT JOIN field_data_body AS bo             ON bo.entity_id = n.nid and bo.bundle = n.type
                      LEFT JOIN field_data_field_videost as vst   ON vst.entity_id = n.nid
                      LEFT JOIN field_data_field_audiost as ast   ON ast.entity_id = n.nid
                      LEFT JOIN field_data_field_audio as pdc     ON pdc.entity_id = n.nid
                      LEFT JOIN field_data_field_capa as fc       ON fc.entity_id = n.nid
                      LEFT JOIN file_managed as fm                ON fm.fid = fc.field_capa_fid
                      LEFT JOIN field_data_field_image as img  ON n.nid = img.entity_id $strContagemImg
                      LEFT JOIN file_managed as f              ON f.fid = img.field_image_fid
                      INNER JOIN taxonomy_index as tid            ON tid.nid = n.nid
                      INNER JOIN taxonomy_term_data as td         ON tid.tid = td.tid AND td.vid <> 1
                      INNER JOIN taxonomy_vocabulary as tv        ON tv.vid = td.vid

                      INNER JOIN taxonomy_chapeu as tbTag ON tbTag.nid = n.nid

                      LEFT JOIN node_comment_statistics AS co     ON co.nid = n.nid

                      WHERE (n.type in ($pCaderno) $strCondicao {$strCondicaoIMG}) AND n.status = 1 ";

    ## Cláusulas where.
    $vQuery .= ((!empty($pParams['pNodeId'])) ? " n.nid = {$pParams['pNodeId']}" : "");
    $vQuery .= ((!empty($pParams['pPromovido'])) ? " AND n.promote = 1 " : "");
    $vQuery .= ((!empty($pParams['pNoPage'])) ? " AND n.comment <> 1 " : "");
    $vQuery .= ((!empty($pParams['pDestaque'])) ? " AND n.sticky = 1 " : "");
    $vQuery .= ((!empty($pParams['pSemDestaque'])) ? " AND n.sticky <> 1 " : "");
    $vQuery .= ((!empty($pParams['pSemFoto'])) ? " AND f.uri is null AND fm.uri is null" : "");
    $vQuery .= ((!empty($pParams['pIgnore']) && !strstr($pParams['pIgnore'],',,')) ? " AND n.nid not in ({$pParams['pIgnore']}) " : "");
    $vQuery .= ((!empty($pParams['pSubcategoria']) && $pParams["pSubcategoria"] != "Podcasts") ? " AND (td.name = '{$pParams['pSubcategoria']}' $strCondicao)" : "");
    $vQuery .= (!empty($pParams['pDias'])) ? " AND DATE_FORMAT(FROM_UNIXTIME(n.created),'%Y-%m-%d') BETWEEN DATE_SUB(CURRENT_DATE,interval {$pParams['pDias']} day) AND CURRENT_DATE" : '';
    $vQuery .= (!empty($pParams['pIgnoreCapa'])) ? " AND n.nid NOT IN(SELECT nid FROM tbcapa WHERE status = 1 AND nid is not null)" : '';

    ## Agrupando o resultado.
    $vQuery .= " GROUP BY n.nid ";

    ## Ordenando a query.
    $vQuery .= "ORDER BY n.created DESC";

    ## Finalizando a montagem da query.
    $vQuery .= (!empty($pQtd)) ? " LIMIT $pQtd " : "";

    $result = null;

    try {
      // Setando o banc default
       db_set_active("default");

      // Execultando a query
      $result = db_query($vQuery)->fetchAll();
    } catch (Exception $exc) {  }

    cache_set($vCacheId, $result, 'cache', time() + 60*30);
    
    // Retornando o resultado
    return $result;
  }else{
      return $vCache->data;
  }
}

/**
 * Método que irá montar o menu
 *
 * @param type $strCaderno
 * @param array $arrFiltro
 */
function getConteudoMenu($strCaderno = "", array $arrFiltro)
{
  // iniciando as variáveis
  $vCacheId       = $strCaderno."_".$arrFiltro['pQtd'];
  $intQTD         = $arrFiltro['pQtd'];
  $strCondicao    = "";
  $strContagemImg = "";
  $resultCache    = cache_get($vCacheId, 'cache');
  
  if(empty($resultCache)){
    // Caso o caderno seja multímidia
    if($strCaderno == "caderno_multimidia"){
      // Condições para buscar nodes que possual alguma multímidia
      $strCondicao = " OR field_image_fid IS NOT NULL OR  ast.field_audiost_value IS NOT NULL OR vst.field_videost_value IS NOT NULL OR v.entity_id IS NOT NULL OR pdc.entity_id IS NOT NULL ";
      // Seleciona nodes com pelo menos mais de uma imagem pra ser considerado galeria
      $strContagemImg = " AND (SELECT count(img.field_image_fid) as qtd
                               FROM field_data_field_image as img
                               WHERE  n.nid = img.entity_id
                               group by img.entity_id) > 1";
    }

    try {
      $strQuery = "SELECT                  
                    n.nid,
                    n.title,
                    td.name as subcategoria,
                    tv.machine_name,
                    date_format(FROM_UNIXTIME(n.created),'%d/%m') AS data,
                    date_format(FROM_UNIXTIME(n.created),'%H:%i') AS hora,
                    if(fm.uri IS NULL,f.uri,fm.uri) as uri,
                    if(ast.field_audiost_value IS NULL,0,1) as podcast,
                    fm.uri as uriThumbVideo
                    FROM node as n

                    LEFT JOIN field_data_field_image as img ON n.nid = img.entity_id $strContagemImg
                    LEFT JOIN file_managed as f ON f.fid = img.field_image_fid

                    LEFT JOIN field_data_field_videost as vst   ON vst.entity_id = n.nid
                    LEFT JOIN field_data_field_audiost as ast ON ast.entity_id = n.nid
                    LEFT JOIN field_data_field_audio as pdc     ON pdc.entity_id = n.nid

                    LEFT JOIN field_data_field_capa as fc       ON fc.entity_id = n.nid
                    LEFT JOIN file_managed as fm                ON fm.fid = fc.field_capa_fid

                    INNER JOIN taxonomy_index as tid ON tid.nid = n.nid
                    INNER JOIN taxonomy_term_data as td ON tid.tid = td.tid AND td.vid <> 1
                    INNER JOIN taxonomy_vocabulary as tv ON tv.vid = td.vid

                    WHERE (n.type in ('$strCaderno') $strCondicao) AND n.status = 1
                    GROUP BY n.nid
                    ORDER BY n.created DESC
                    LIMIT $intQTD ";

       // Setando o banc default
       db_set_active("default");

       // Execultando a query
       $result = db_query($strQuery)->fetchAll();

       cache_set($vCacheId, $result, 'cache', 60*30);

      } catch (Exception $exc) {
         //    echo $exc->getMessage();
         //    echo $strQuery;die;
      }
    }else{
        $result = $resultCache->data;
    }
    
    // Retornando o resultado
    return $result;
}

/*
 * Metodo que retorna as mais lidas de multimidia 
 */
function getSubmenuMultimidia(){  
  try{
    //string com a query responsável por informar se é um carrossel de imagens ou não.
  $strContagemImg="AND (SELECT count(img.field_image_fid) as qtd
                         FROM field_data_field_image as img
                         WHERE  n.nid = img.entity_id
                         group by img.entity_id) > 1";
  $intQTD=4;
     /*
     * Select retornará todos os nodes que 
     * possuem conteúdo multimidia(audio, video,imagem), independente do caderno,
     * com o objetivo de popular o submenu com a quantidade setada;
     * a informação mais lida também será listada
     */
    $strQuery="SELECT
                n.nid,                
                n.title,
                td.name as subcategoria,
                tv.machine_name,
                date_format(FROM_UNIXTIME(n.created),'%d/%m') AS data,
                date_format(FROM_UNIXTIME(n.created),'%H:%i') AS hora,
                if(fm.uri IS NULL,f.uri,fm.uri) as uri,
                fm.uri as uriThumbVideo
                FROM node as n

                LEFT JOIN field_data_field_image as img ON n.nid = img.entity_id $strContagemImg
                LEFT JOIN file_managed as f ON f.fid = img.field_image_fid

                LEFT JOIN field_data_field_videost as vst   ON vst.entity_id = n.nid
                LEFT JOIN field_data_field_audiost as ast   ON ast.entity_id = n.nid
                LEFT JOIN field_data_field_audio as pdc     ON pdc.entity_id = n.nid

                LEFT JOIN field_data_field_capa as fc       ON fc.entity_id = n.nid
                LEFT JOIN file_managed as fm                ON fm.fid = fc.field_capa_fid

                INNER JOIN taxonomy_index as tid ON tid.nid = n.nid
                INNER JOIN taxonomy_term_data as td ON tid.tid = td.tid AND td.vid <> 1
                INNER JOIN taxonomy_vocabulary as tv ON tv.vid = td.vid

                WHERE field_image_fid IS NOT NULL OR ast.field_audiost_value IS NOT NULL OR vst.field_videost_value IS NOT NULL OR v.entity_id IS NOT NULL OR pdc.entity_id IS NOT NULL AND n.status = 1
                GROUP BY n.nid
                ORDER BY n.created DESC
                LIMIT $intQTD";
     // Setando o banc default
     db_set_active("default");

    // Execultando a query
    $result = db_query($strQuery)->fetchAll();
  }catch (Exception $exc){
//    echo $exc->getMessage();
//    echo $strQuery; die;
  }
    return $result;
}

/**
 * Método que ira buscar as notícias mais lidas de todos ou de um caderno especifico
 *
 * @param Strind $strCaderno
 * @return ArrayObject Node
 */
function getMaisLidasCadernos($strCaderno = "",$intDias = 2){

  // Inicializando as váriaveis
  $vSubMaisLidas = "";

  $strCaderno = (!empty ($strCaderno)) ? " AND n.type in ('$strCaderno')" : "";

  // Query que ira retornar as ultimas de cada caderno
  $strQuery = "SELECT MAX(totalcount), n.nid, n.title, tv.name as categoria,td.name as subcategoria,tv.machine_name,bo.body_summary,bo.body_value,
                    if(fm.uri is null,f.uri,fm.uri) as uri, if(ast.field_audiost_value IS NULL,0,1)as podcast

                    FROM node as n
                    LEFT JOIN field_data_body AS bo ON bo.entity_id = n.nid and bo.bundle = n.type

                    LEFT JOIN field_data_field_image as img ON n.nid = img.entity_id
                    LEFT JOIN file_managed as f ON f.fid = img.field_image_fid

                    LEFT JOIN field_data_field_videost as vst   ON vst.entity_id = n.nid
                    LEFT JOIN field_data_field_audiost as ast   ON ast.entity_id = n.nid

                    LEFT JOIN field_data_field_capa as fc       ON fc.entity_id = n.nid
                    LEFT JOIN file_managed as fm                ON fm.fid = fc.field_capa_fid

                    INNER JOIN taxonomy_index as tid ON tid.nid = n.nid
                    INNER JOIN taxonomy_term_data as td ON tid.tid = td.tid AND td.vid <> 1
                    INNER JOIN taxonomy_vocabulary as tv ON tv.vid = td.vid
                    INNER JOIN node_counter AS co ON co.nid = n.nid
                    WHERE n.status = 1
                    $strCaderno
                    AND (f.uri IS NOT NULL OR fm.uri IS NOT NULL OR ast.field_audiost_value IS NOT NULL OR vst.field_videost_value IS NOT NULL)
                    AND (DATE_FORMAT(FROM_UNIXTIME(n.created),'%Y-%m-%d') BETWEEN DATE_SUB(CURRENT_DATE,interval {$intDias} day) AND CURRENT_DATE)
                    GROUP BY n.type
                    ORDER BY n.created ";
   try{
     // Seleciona as mais lidas do dia de cada categoria para exibição no submenu.
     $result = db_query($strQuery);

     $vSubMaisLidas = $result->fetchAll();
   }catch(Exception $e){ }

   return $vSubMaisLidas;
}



$vIgnore = '';
/**
 * Consulta que retorna os nós na ordem definida no Backoffice.
 * tem como parametro a região definida (ex.: 'capa').
 *
 * @param $pArea
 */
function getConteudoCapa($pArea = 'capa', &$vars, $template = true)
{
  $vQuery = "SELECT cp.posicao,cp.params,cp.area,cp.template,cp.origem,cp.nid as idoriginal,n.nid,n.title,if(fm.uri IS NULL,f.uri,fm.uri) as uri, max(tv.name) as categoria,max(td.name) as subcategoria,max(tv.machine_name) as machine_name
             FROM `tbcapa` AS cp
	     LEFT JOIN node AS n ON n.nid = cp.nid
	     LEFT JOIN field_data_field_fonte AS fo ON fo.entity_id = n.nid and fo.bundle = n.type
	     LEFT JOIN field_data_body AS bo ON bo.entity_id = n.nid and bo.bundle = n.type
	     LEFT JOIN field_data_field_image as img ON n.nid = img.entity_id
	     LEFT JOIN file_managed as f ON f.fid = img.field_image_fid
             LEFT JOIN field_data_field_capa as fc ON fc.entity_id = n.nid
             LEFT JOIN file_managed as fm ON fm.fid = fc.field_capa_fid
             LEFT JOIN taxonomy_index as ti ON ti.nid = cp.nid
             LEFT JOIN taxonomy_term_data as td ON td.tid = ti.tid AND td.vid <> 1
             LEFT JOIN taxonomy_vocabulary as tv ON tv.vid = td.vid

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
      if($vNot->origem != "default" && $template){
        // Carregando a notícia de outro servidor
        $vNot = carregaNodeServidor($vNot->origem, $vNot->idoriginal);
        // Setando a notícia no array de retorno
        $vCapa[$key]  = $vNot[0];
        @$vIgnore[]   = $vNot[0]->nid;
      }elseif($vNot->origem == "default"){
        @$vCarrega[$vNot->params]['total']++;
        @$vCarrega[$vNot->params]['posicao'][] = $vNot->posicao;
      }
    }else{
      @$vIgnore[] = $vNot->nid;
    }
  }

  ## Carrega as noticias randomicas para tantos cadernos e posições definidas.
  ## Caso não existam randomicas não entra no laço.
  foreach($vCarrega as $vCaderno => $vRand){

    $vNotIn = implode(',',$vIgnore);

    $vCaderno = ($vCaderno == 'geral') ? "'caderno_noticias','caderno_politica','caderno_esportes','caderno_cultura','caderno_carreiras','caderno_tecnologia'" : "'$vCaderno'";

    $vNoticiaRand = getConteudo($vCaderno, array('pQtd' => $vRand['total'], 'pDestaque' => true, 'pFotos' => true, 'pIgnore' => $vNotIn));

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

function getNidsConteudoCapa()
{
  return $vIgnore;
}

/**
 * Retorna os nodes mais lidos.
 *
 * @param type $pDias
 * @param type $pQtd
 * @return type
 */
function getConteudoMaisLido($pDias = 7, $pQtd = 4, $strCaderno = "")
{  
  $vCacheId = "maisLida_{$pDias}_{$pQtd}_{$strCaderno}";
  $strCaderno=(!empty ($strCaderno)) ? " AND n.type = '$strCaderno'" : "";
  // Verifica cache.
  $vCache = cache_get($vCacheId, 'cache');
  if(empty($vCache)){
    $vQuery = "SELECT n.nid,n.title,tv.name as categoria,td.name as subcategoria,tv.machine_name,nc.totalcount
               FROM `node` as n
               INNER JOIN taxonomy_index as tid ON tid.nid = n.nid
               INNER JOIN taxonomy_term_data as td ON tid.tid = td.tid AND td.vid <> 1
               INNER JOIN taxonomy_vocabulary as tv ON tv.vid = td.vid
               INNER JOIN node_counter as nc on n.nid = nc.nid
               WHERE n.nid is not null $strCaderno
               AND n.status = 1
               AND DATE_FORMAT(FROM_UNIXTIME(n.created),'%Y-%m-%d') BETWEEN DATE_SUB(CURRENT_DATE,interval $pDias day) AND CURRENT_DATE               
               GROUP BY n.nid ORDER BY totalcount DESC LIMIT $pQtd";

    $result = db_query($vQuery);
    
    $vNodes = $result->fetchAll();
    
    cache_set($vCacheId, $vNodes, 'cache', (time()+900));
    return $vNodes;    
  }else
    return $vCache->data;

}

/**
 *
 * Listagem dos Blogs Parceiros.
 * @param $pQtde
 * @param $Params[
 * pFavorito  -  Lista só os Blogs Parceiros favoritos do Usuário logado.
 * ]
 */
function getBlogsParceiros($pQtde = 0, $pParams = array())
{
    $vCacheId = "$pQtde".md5(serialize($pParams));
    $vCache   = cache_get($vCacheId, 'cache');
    $vRetorno = '';
    
    if(!$vCache){
	$pFavoritos = (empty($pParams['pFavoritos'])) ? '' : "INNER JOIN tbmeuleiaja AS mj ON mj.nid = ttd.tid AND mj.uid = {$GLOBALS['user']->uid} AND mj.type = 2";
	(empty($pParams['tipoBlog'])) ? $pParams['tipoBlog'] = 11 : '';

	$vQuery = "SELECT ttd.tid, ttd.name, ttd.description, ua.alias
				FROM taxonomy_term_data AS ttd
				INNER JOIN url_alias AS ua
				ON CONCAT('taxonomy/term/',ttd.tid) = ua.source
				$pFavoritos
				WHERE ttd.vid = {$pParams['tipoBlog']}
				".(($pQtde == 0)? 'ORDER BY ttd.name' : "ORDER BY RAND() LIMIT ".$pQtde).";";

  
        $result = db_query($vQuery);
        $vRetorno = $result->fetchAll();   
        
        cache_set($vCacheId, $vRetorno, 'cache', time() + 60*30);
    }else{
      $vRetorno = $vCache->data;
    }

    return $vRetorno;
}

function getConteudoMaisComentado($pDias = 30, $pQtd = 4)
{
	$vQuery = "SELECT n.nid,n.title,tv.name as categoria,td.name as subcategoria,tv.machine_name,nc.comment_count
               FROM `node` as n
               INNER JOIN taxonomy_index as tid ON tid.nid = n.nid
               INNER JOIN taxonomy_term_data as td ON tid.tid = td.tid AND td.vid <> 1
               INNER JOIN taxonomy_vocabulary as tv ON tv.vid = td.vid
               INNER JOIN node_comment_statistics as nc on n.nid = nc.nid
               AND n.status = 1
               AND nc.comment_count <> 0
               AND DATE_FORMAT(FROM_UNIXTIME(n.created),'%Y-%m-%d') BETWEEN DATE_SUB(CURRENT_DATE,interval $pDias day) AND CURRENT_DATE
               GROUP BY n.nid
               ORDER BY comment_count DESC LIMIT $pQtd";

    $result = db_query($vQuery);

    return $result->fetchAll();
}

/**
 * 
 * @param type $pArrTags
 * @param type $pNodeIgnore
 * @param type $pQtd
 * @return type
 */
function getRecomendacao($pArrTags, $pNodeIgnore = '', $pQtd = '')
{
	$vQuery = "SELECT n.nid,n.title,n.type AS caderno,td.name as subcategoria,date_format(FROM_UNIXTIME(n.created),'%d/%m') AS data,date_format(FROM_UNIXTIME(n.created),'%H:%i') AS hora
		FROM `node` as n
               INNER JOIN taxonomy_index as tid ON tid.nid = n.nid
               INNER JOIN taxonomy_term_data as td ON tid.tid = td.tid AND td.vid = 1
               WHERE n.status = 1
               AND tid.tid in (".implode(',',$pArrTags).")"
               .((empty($pNodeIgnore)) ? '' : " AND n.nid <> $pNodeIgnore ").
               "GROUP BY n.nid
               ORDER BY n.created DESC";

    (empty($pQtd)) ? '' : $vQuery .= " LIMIT $pQtd";

    $result = db_query($vQuery);

    return $result->fetchAll();
}

function getColunistaInfo($pTid)
{
  $result = db_query("SELECT td.tid,td.vid,td.name,td.description,td.style, fp.field_perfil_value AS perfil, fc.field_coluna_value AS coluna FROM `taxonomy_term_data` AS td
                            LEFT JOIN field_revision_field_perfil AS fp ON fp.entity_id = td.tid
                            LEFT JOIN field_revision_field_coluna AS fc ON fc.entity_id = td.tid
                            WHERE td.tid = $pTid");

  $vTemp = $result->fetchAll();
  return $vTemp[0];
}

function getColunistaConteudo($pTid)
{
    
    $vCacheId = 'getColunistaConteudo'.$pTid;
    $vCache   = cache_get($vCacheId, 'cache');
    $vRetorno = '';
    
    if(!$vCache){
	$vQuery = "SELECT DISTINCT n.nid,n.title,f.filename,f.uri,tv.name as categoria,td.name as subcategoria,tv.machine_name,
               date_format(FROM_UNIXTIME(n.created),'%d/%m') AS data,date_format(FROM_UNIXTIME(n.created),'%H:%i') AS hora,bo.body_summary,
               bo.body_value,n.created,fo.field_fonte_value as fonte,co.comment_count
               FROM `node` as n
               LEFT JOIN field_data_field_fonte AS fo ON fo.entity_id = n.nid and fo.bundle = n.type
               INNER JOIN field_data_body AS bo ON bo.entity_id = n.nid and bo.bundle = n.type
               LEFT JOIN field_data_field_image as img ON n.nid = img.entity_id
               LEFT JOIN file_managed as f ON f.fid = img.field_image_fid
               INNER JOIN taxonomy_index as tid ON tid.nid = n.nid
               INNER JOIN taxonomy_term_data as td ON tid.tid = td.tid AND td.vid <> 1
               INNER JOIN taxonomy_vocabulary as tv ON tv.vid = td.vid
               LEFT JOIN node_comment_statistics AS co ON co.nid = n.nid
               WHERE n.type = 'caderno_colunistas'
               AND n.status = 1
               AND td.tid = $pTid
               ORDER BY n.created DESC";

      $result   = db_query($vQuery);
      $vRetorno = $result->fetchAll();
      
      cache_set($vCacheId, $vRetorno, 'cache', time() + 60*60);
    }else{
      $vRetorno = $vCache->data;
    }
    
    return $vRetorno;
}

function getNoticiaByTag($pTid, $pParams)
{
  $vCacheId = $pTid.md5(serialize($pParams));
  $vCache   = cache_get($vCacheId, 'cache');
  
  if(!$vCache){
    $pFotos = (empty($pParams['pFotos'])) ? 'LEFT' : 'INNER';

    $vQuery = "SELECT n.nid, n.title, bo.body_summary, fo.field_fonte_value, u.name,f.filename,f.uri
                  FROM node AS n
                  LEFT JOIN users AS u ON u.uid = n.uid
                  INNER JOIN taxonomy_index AS ti
                  ON ti.nid = n.nid
                  INNER JOIN taxonomy_term_data AS td
                  ON td.tid = ti.tid
                  INNER JOIN field_data_body AS bo
                  ON bo.entity_id = n.nid and bo.bundle = n.type
                  LEFT JOIN field_data_field_fonte AS fo
                  ON fo.entity_id = n.nid and fo.bundle = n.type
                  $pFotos JOIN field_data_field_image as img ON n.nid = img.entity_id
                  $pFotos JOIN file_managed as f ON f.fid = img.field_image_fid
                  WHERE td.tid = $pTid
                  ".((!empty($pParams['pSemFoto'])) ? " AND f.uri IS NULL " : "")."
                  ".((!empty($pParams['pIgnore'])) ? " AND n.nid not in ({$pParams['pIgnore']}) " : "")."
                  GROUP BY n.nid
                  ORDER BY n.created DESC
                  ".((!empty($pParams['limit'])) ? " LIMIT {$pParams['limit']} " : "");

      $result = db_query($vQuery);

      $result = $result->fetchAll();
          if(!empty($pParams['tags']) && @$pParams['tags'] == true){
            $result = getTagsFromObject($result, $pTid, $pParams['limit']);
      }
      
      cache_set($vCacheId, $result, cache, time() + 60*30);
  }else{
      $result = $vCache->data;
  }
    

    return $result;
}
/**
 *
 * Função que retorna os registros por termo.
 * @param $pTid
 * @param $pParams[tags(bool),limit, pNotIn]
 */
function getConteudobyTerm($pTid, $pParams = array())
{
    $vCacheId = $pTid.md5(serialize($pParams));
    $vCache   = cache_get($vCacheId, 'cache');
    
    if(!$vCache){
        $pFotos = (empty($pParams['pFotos'])) ? 'LEFT' : 'INNER';

        $vQuery = "SELECT DISTINCT n.nid,n.title,if(fm.filename IS NULL,f.filename,fm.filename) as filename,if(fm.uri IS NULL,f.uri,fm.uri) as uri,tv.name as categoria,td.name as subcategoria,tv.machine_name,
               date_format(FROM_UNIXTIME(n.created),'%d/%m') AS data,date_format(FROM_UNIXTIME(n.created),'%H:%i') AS hora,bo.body_summary,
               bo.body_value,n.created,fo.field_fonte_value as fonte,co.comment_count, u.name,pe.field_permlink_value as permlink
               FROM `node` as n
               LEFT JOIN users AS u ON u.uid = n.uid
               LEFT JOIN field_data_field_fonte AS fo ON fo.entity_id = n.nid and fo.bundle = n.type
               LEFT JOIN field_data_field_permlink AS pe ON pe.entity_id = n.nid and pe.bundle = n.type
               INNER JOIN field_data_body AS bo ON bo.entity_id = n.nid and bo.bundle = n.type
               $pFotos JOIN field_data_field_image as img ON n.nid = img.entity_id
               $pFotos JOIN file_managed as f ON f.fid = img.field_image_fid
               LEFT JOIN field_data_field_capa as fc       ON fc.entity_id = n.nid
               LEFT JOIN file_managed as fm                ON fm.fid = fc.field_capa_fid
               INNER JOIN taxonomy_index as tid ON tid.nid = n.nid
               INNER JOIN taxonomy_term_data as td ON tid.tid = td.tid ".((!empty($pParams['pApenasSubcaderno']) && $pParams['pApenasSubcaderno'] === true ) ? "AND td.vid <> 1 " : "").
               "INNER JOIN taxonomy_vocabulary as tv ON tv.vid = td.vid
               LEFT JOIN node_comment_statistics AS co ON co.nid = n.nid           
               WHERE td.tid = $pTid
               ".((!empty($pParams['pNotIn']) && is_array($pParams['pNotIn'])) ? "AND n.nid NOT IN (".implode(",", $pParams['pNotIn']).")" : '')."
               ".((!empty($pParams['pMes'])) ? "AND date_format(FROM_UNIXTIME(n.created),'%m') = {$pParams['pMes']} " : "")."
               ".((!empty($pParams['pAno'])) ? "AND date_format(FROM_UNIXTIME(n.created),'%Y') = {$pParams['pAno']} " : "")."
               GROUP BY n.nid
               ORDER BY n.created DESC
               ".((!empty($pParams['limit'])) ? " LIMIT {$pParams['limit']} " : "");


        $result = db_query($vQuery);
        $vResult = $result->fetchAll();

        //Se $pParams[tags] for true o objeto retornado virá com um atributo do tipo tags populado.
        if(!empty($pParams['tags']) && @$pParams['tags'] == true){
          $vResult = getTagsFromObject($vResult, $pTid, $pParams);
        }
        
        cache_set($vCacheId, $vResult, 'cache', time() + 60*30);
    }else{
      $vResult = $vCache->data;
    }
    
    return $vResult;
}

/**
 *
 * Função que retorna as datas que um colunista postou
 * @param $pTid
 * @param $pParams[tags(bool),limit[string = '20,40']]
 */
function getDataPosts($pTid)
{
    $vCacheId = 'getDataPost'.$pTid;
    $vCache   = cache_get($vCacheId, 'cache');
    
    if(!$vCache){
        $vQuery = "SELECT DISTINCT
                                    date_format(FROM_UNIXTIME(n.created),'%m') AS mes,
                                    date_format(FROM_UNIXTIME(n.created),'%Y') AS ano
                   FROM `node` as n
                   INNER JOIN taxonomy_index as tid ON tid.nid = n.nid
                   INNER JOIN taxonomy_term_data as td ON tid.tid = td.tid AND td.vid <> 1
                   WHERE n.status = 1
                   AND td.tid = $pTid
                   ORDER BY ano DESC, mes";

        $result = db_query($vQuery);

        $vResult = $result->fetchAll();
        
        cache_set($vCacheId, $vResult, 'cache', time() + 60*60);
    }else{
        $vResult = $vCache->data;
    }

    return $vResult;
}

/**
 *
 * Enter description here ...
 * @param $pObject
 * @param $pTid
 * @param $pParams['limit']
 */
function getTagsFromObject($pObject, $pTid, $pParams)
{
  $vCacheId = md5(serialize($pObject))."$pTid".md5(serialize($pParams));
  $vCache   = cache_get($vCacheId, 'cache');
  $vRetorno = '';
  
  if(!$vCache){
    $pFotos    = (empty($pParams['pFotos'])) ? 'LEFT' : 'INNER';

    $vQueryTag = "SELECT n.nid, td.name AS tag, td.tid
                  FROM taxonomy_term_data AS ttd
                  INNER JOIN taxonomy_index AS tin ON tin.tid = ttd.tid
                  INNER JOIN (
                      SELECT n.nid, n.title
                      FROM node AS n
                      INNER JOIN taxonomy_index AS ti ON ti.nid = n.nid
                      INNER JOIN taxonomy_term_data AS td ON td.tid = ti.tid
                      $pFotos JOIN field_data_field_image as img ON n.nid = img.entity_id
                      $pFotos JOIN file_managed as f ON f.fid = img.field_image_fid
                      WHERE td.tid = $pTid
                      ".((!empty($pParams['pNotIn']) && is_array($pParams['pNotIn'])) ? "AND n.nid NOT IN (".implode(",", $pParams['pNotIn']).")" : '')."
                      GROUP BY n.nid
                      ORDER BY n.created DESC
                      ".((!empty($pParams['limit'])) ? " LIMIT {$pParams['limit']} " : "")."
                   ) AS n ON n.nid = tin.nid
                  INNER JOIN taxonomy_index AS ti ON ti.nid = n.nid
                  INNER JOIN taxonomy_term_data AS td ON td.tid = ti.tid
                  WHERE ttd.tid = $pTid AND td.vid = 1";

      $resultTag  = db_query($vQueryTag);

      $vResultTag = $resultTag->fetchAll();

      foreach ($pObject as $nKey => $nValue) {
        foreach ($vResultTag AS $tKey => $tValue){
          if($nValue->nid == $tValue->nid){
            $pObject[$nKey]->tags[] = $tValue;
          }
        }
      }   
      
      $vRetorno =  $pObject;
      cache_set($vCacheId, $vRetorno, 'cache', time() + 60*60);
  }else{
      $vRetorno = $vCache->data;
  }
    
   return $vRetorno;
}

function getTagsOfGetConteudo($pObject, $pCaderno, $pParams)
{
    
  $vCacheId = md5(serialize($pObject)).$pCaderno.md5(serialize($pParams));
  $vCache   = cache_get($vCacheId, 'cache');
  $vRetorno = '';
  
  if(!$vCache){
    $pFotos    = (empty($pParams['pFotos'])) ? 'LEFT' : 'INNER';

    $vQueryTag = "SELECT n.nid, td.name AS tag, td.tid
                  FROM taxonomy_term_data AS ttd
                  INNER JOIN taxonomy_index AS tin ON tin.tid = ttd.tid
                  INNER JOIN (
                      SELECT n.nid, n.title
                      FROM node AS n
                      INNER JOIN taxonomy_index AS ti ON ti.nid = n.nid
                      INNER JOIN taxonomy_term_data AS td ON td.tid = ti.tid
                      $pFotos JOIN field_data_field_image as img ON n.nid = img.entity_id
                      $pFotos JOIN file_managed as f ON f.fid = img.field_image_fid
                      WHERE td.tid = $pTid
                      ".((!empty($pParams['pNotIn']) && is_array($pParams['pNotIn'])) ? "AND n.nid NOT IN (".implode(",", $pParams['pNotIn']).")" : '')."
                      ORDER BY n.created DESC
                      ".((!empty($pParams['limit'])) ? " LIMIT {$pParams['limit']} " : "")."
                   ) AS n ON n.nid = tin.nid
                  INNER JOIN taxonomy_index AS ti ON ti.nid = n.nid
                  INNER JOIN taxonomy_term_data AS td ON td.tid = ti.tid
                  WHERE WHERE n.type in ($pCaderno) AND td.vid = 1";

    $resultTag  = db_query($vQueryTag);

    $vResultTag = $resultTag->fetchAll();

    foreach ($pObject as $nKey => $nValue) {
      foreach ($vResultTag AS $tKey => $tValue){
        if($nValue->nid == $tValue->nid){
          $pObject[$nKey]->tags[] = $tValue;
        }
      }
    }
 
    $vRetorno = $pObject;
    
    cache_set($vCacheId, $vRetorno, 'cache', time() + 60*60);
  }else{
    $vRetorno = $vCache->data;
  } 

  return $vRetorno;
}

/**
 *
 * Conta o total de nós pelo termo.
 * @param $pTid
 * @param $pParams['noTag']
 */
function getNodeCountByTerm($pTid = '', $pParams = null)
{
  $vCacheId = $pTid.md5(serialize($pParams));
  $vCache   = cache_get($vCacheId, 'cache');
  
  if(!$vCache){
    (!empty($pParams['noTag']) && $pParams['noTag']) ? $noTag = 'AND td.vid = 1' : $noTag = 'AND td.vid <> 1';
    (!empty($pParams['caderno'])) ? $caderno = " AND n.type IN ({$pParams['caderno']})" : $caderno = '';
    (!empty($pTid)) ? $pTid = "AND td.tid =  $pTid" : $pTid = '';

    $vQuery = "SELECT count(n.nid) as total
               FROM `node` as n
               INNER JOIN taxonomy_index as tid ON tid.nid = n.nid
               INNER JOIN taxonomy_term_data as td ON tid.tid = td.tid $noTag
               WHERE n.status = 1
               $caderno
               ".((!empty($pParams['pMes'])) ? "AND date_format(FROM_UNIXTIME(n.created),'%m') = {$pParams['pMes']} " : "")."
               ".((!empty($pParams['pAno'])) ? "AND date_format(FROM_UNIXTIME(n.created),'%Y') = {$pParams['pAno']} " : "")."
               $pTid;";

    $result = db_query($vQuery);

    $vTemp = $result->fetchAll();

    cache_set($vCacheId, $vTemp[0]->total, 'cache', time() + 60*30);
    
    return $vTemp[0]->total;      
  }else{
    return $vCache->data;
  }
}

function getCrumb($pNid)
{
    $vCacheId = 'getCrumb'.$pNid;
    $vCache   = cache_get($vCacheId, 'cache');
    $vRetorno = null;
    
    if(!$vCache){
	$vQuery = "SELECT DISTINCT n.nid,n.title,tv.name as categoria,td.name as subcategoria,tv.machine_name,td.tid
               FROM `node` as n
               INNER JOIN taxonomy_index as tid ON tid.nid = n.nid
               INNER JOIN taxonomy_term_data as td ON tid.tid = td.tid AND td.vid <> 1
               INNER JOIN taxonomy_vocabulary as tv ON tv.vid = td.vid
               WHERE n.nid = $pNid";

        $result = db_query($vQuery);

        $vTemp = $result->fetchAll();
        
        $vRetorno = $vTemp[0];
        
        cache_set($vCacheId, $vRetorno, 'cache', time() + 60*60);
    }else{
        $vRetorno = $vCache->data;
    }
    
    return $vRetorno;
}

function getPromosParticipando(){

     $result = db_select('tb_participante_promo', 'pp')
    ->fields('pp', array('tid'))
    ->condition('uid', $GLOBALS['user']->uid,'=');
    $result->join('field_data_field_data_exibicao', 'fe', 'fe.entity_id = pp.tid');
    $result->condition('fe.field_data_exibicao_value', 'NOW()','<=');
    $result = $result->execute()
    ->fetchCol();

   return $result;
}

function getUserImprensa($uid){

  $vQuery = "SELECT true FROM `users_roles` WHERE rid in(4,6,7) AND uid = $uid;";

  $result = db_query($vQuery);

  $result = $result->fetchAll();

  return $result;
}


/**
 * Consulta pra trazer a última revisão.
 *
 * @param type $caderno
 * @param type $qtd
 * @return type
 */
function getUltimaRevisao($pNid = null)
{
  $query = "SELECT n.timestamp
            FROM node_revision as n
            WHERE nid = $pNid
            AND n.log <> ''
            ORDER BY vid DESC
            LIMIT 1";

  $result = db_query($query);

  return $result->fetchAll();
}

function getUser($uid){

  $result = db_select('users', 'u')
    ->fields('u')
    ->condition('uid', $uid,'=')
    ->condition('status', 1,'=')
    ->execute()
    ->fetchAssoc();

    if($result){
      return $result;
    }

    return false;

}

/**
 * Método que irá buscar no servidor de blogs as ultimas notícias
 * 
 * @return ArrayObject 
 */
function db_getNodeBlogs(){
  // Setando o banco de blogs
  db_set_active("blog_social");  
  
  //executando a query
  $query = db_query("SELECT s1.* FROM (SELECT n.*, fc.field_chamada_capa_value as chamada_capa
                     FROM node n
                     LEFT JOIN field_data_field_chamada_capa fc on fc.entity_id = n.nid
                     WHERE n.status = 1
                     ORDER BY created DESC) AS s1
                     GROUP BY s1.type;");

  // mudando para o banco default
  db_set_active("default");   
  
  $query=$query->fetchAll();
  
  return $query; 
}

function db_widget_promocoes()
{
  //executando a query
  $query = db_query("SELECT td.tid, td.name as titulo, td.description as descricao, DATE_FORMAT(dts.field_data_sorteio_value,GET_FORMAT(DATE,'EUR')) as data_sorteio,DATE_FORMAT(dts.field_data_sorteio_value,GET_FORMAT(TIME,'ISO')) as hora_sorteio
                    FROM `taxonomy_term_data` as td
                    LEFT JOIN `field_data_field_data_exibicao` AS dte on dte.entity_id = td.tid
                    LEFT JOIN `field_data_field_data_sorteio` AS dts on dts.entity_id = td.tid
                    LEFT JOIN `field_data_field_imagecrop` AS ic on ic.entity_id = td.tid
                    WHERE td.vid = 18 AND dts.field_data_sorteio_value > now()
                    ORDER BY rand()");
  
    return $query->fetchAll(); 
}

/*
 * 
 * Função que retorna o id da taxonomia colunista; id do colunista
 */
function getColunistaNode($nodeColuna){
  //setando a query a uma variavel
  $query="SELECT ttd.tid
          FROM node as n
          LEFT JOIN taxonomy_index as ti on ti.nid=n.nid
          LEFT JOIN taxonomy_term_data as ttd on ttd.tid=ti.tid
          LEFT JOIN taxonomy_vocabulary as tv on tv.vid=ttd.vid
          WHERE tv.machine_name='colunistas' and n.nid={$nodeColuna}";
  
  
  $result=db_query($query);
  
  return $result->fetchAll();
  
}

/*
 * 
 * Função que retorna o id da taxonomia colunista; id do colunista
 */
function getColunistabyNodebyField($nodeColuna){
  //setando a query a uma variavel
  $query="SELECT ttd.tid
          FROM node as n
          LEFT JOIN field_data_field_catcolunista as fcc on fcc.entity_id = n.nid
          LEFT JOIN taxonomy_term_data as ttd on ttd.tid = fcc.field_catcolunista_tid
          LEFT JOIN taxonomy_vocabulary as tv on tv.vid=ttd.vid
          WHERE tv.machine_name='colunistas' and n.nid={$nodeColuna}";
  
  
  $result=db_query($query);
  
  return $result->fetchAll();
  
}