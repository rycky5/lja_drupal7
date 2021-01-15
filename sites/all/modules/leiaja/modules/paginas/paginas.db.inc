<?php

/**
 *
 * Listagem dos Blogs Parceiros.
 * @param $pQtde
 * @param $Params[
 * pFavorito  -  Lista só os Blogs Parceiros favoritos do Usuário logado.
 * ]
 */
function db_getBlogsParceiros($pQtde = 0, $pParams = array()) {
    $vCacheId = "$pQtde" . md5(serialize($pParams));
    $vCache = cache_get($vCacheId, 'cache');
    $vRetorno = '';

    if (!$vCache) {
        $pFavoritos = (empty($pParams['pFavoritos'])) ? '' : "INNER JOIN tbmeuleiaja AS mj ON mj.nid = ttd.tid AND mj.uid = {$GLOBALS['user']->uid} AND mj.type = 2";
        (empty($pParams['tipoBlog'])) ? $pParams['tipoBlog'] = 11 : '';

        $vQuery = "SELECT ttd.tid, ttd.name, ttd.description, ua.alias
				FROM taxonomy_term_data AS ttd
				INNER JOIN url_alias AS ua
				ON CONCAT('taxonomy/term/',ttd.tid) = ua.source
				$pFavoritos
				WHERE ttd.vid = {$pParams['tipoBlog']}
				" . (($pQtde == 0) ? 'ORDER BY ttd.name' : "ORDER BY RAND() LIMIT " . $pQtde) . ";";


        $result = db_query($vQuery);
        $vRetorno = $result->fetchAll();

        cache_set($vCacheId, $vRetorno, 'cache', time() + 60 * 30);
    } else {
        $vRetorno = $vCache->data;
    }

    return $vRetorno;
}

/**
 *
 * Consulta que carrega ultimos posts de cada coluna.
 * @param $pQtd= 4
 * @param $pParams[pCaderno, pNotIn, pFavorito, pType]
 */
function db_getColunistaUltimas($pQtd = 4, $pParams = array()) {
    $vCacheId = "$pQtd" . md5(serialize($pParams));
    $vCache = cache_get($vCacheId, 'cache');
    $vRetorno = '';

    if (!$vCache) {
        $pFavoritos = (empty($pParams['pFavoritos'])) ? '' : "INNER JOIN tbmeuleiaja AS mj ON mj.nid = td.tid AND mj.uid = {$GLOBALS['user']->uid} AND mj.type = " . $pParams['pFavoritos'];
        $pType = (empty($pParams['pType'])) ? "caderno_colunistas" : $pParams['pType'];

        $vQuery = "SELECT n.created,n.nid,n.title,tv.name as categoria,td.name as subcategoria,tv.machine_name,td.tid,td.style,td.parent, ua.alias, fc.field_coluna_value AS coluna, fp.field_perfil_value AS perfil
               FROM `node` as n
               INNER JOIN (SELECT max(n2.nid) as nid,max(n2.created) as data
                           FROM `node` as n2
                           INNER JOIN taxonomy_index as tid2 ON tid2.nid = n2.nid
                           INNER JOIN taxonomy_term_data as td2 ON tid2.tid = td2.tid AND td2.vid <> 1
                           WHERE n2.type in ('$pType')
                           AND n2.status = 1
                           group by td2.name) AS sub ON sub.nid = n.nid
               INNER JOIN taxonomy_index as tid ON tid.nid = n.nid
               INNER JOIN taxonomy_term_data as td ON tid.tid = td.tid AND td.vid <> 1
               INNER JOIN taxonomy_vocabulary as tv ON tv.vid = td.vid
               INNER JOIN url_alias AS ua ON CONCAT('taxonomy/term/',td.tid) = ua.source
               LEFT JOIN field_revision_field_perfil AS fp ON fp.entity_id = td.tid
               LEFT JOIN field_revision_field_coluna AS fc ON fc.entity_id = td.tid
               $pFavoritos
               WHERE n.type in ('$pType')
               AND n.status = 1";

        ## Cláusulas Where.
        $vQuery .= (!empty($pParams['pCaderno'])) ? " AND td.parent = '{$pParams['pCaderno']}'" : '';
        $vQuery .= (!empty($pParams['pNotIn'])) ? " AND td.tid NOT IN ({$pParams['pNotIn']})" : '';

        $vQuery .= " GROUP BY subcategoria ORDER BY n.created DESC";

        $vQuery .= (!empty($pQtd)) ? " LIMIT $pQtd" : '';

        $result = db_query($vQuery);

        $vRetorno = $result->fetchAll();
        cache_set($vCacheId, $vRetorno, 'cache', time() + 60 * 60);
    } else {
        $vRetorno = $vCache->data;
    }

    return $vRetorno;
}

/**
 * Consulta que carrega os nids das dos termos do vocabulário especial
 */
function db_getTidsEspecial() {

    $query = new EntityFieldQuery;

    $tids = $query
            ->entityCondition('entity_type', 'taxonomy_term')
            ->propertyCondition('vid', 13)
            ->fieldCondition('field_espexibir', 'value', '1', '=')
            ->propertyOrderBy('weight')
            ->execute();

    return $tids;
}

function db_getCountTerm() {
    $vCacheId = 'getCountTerm';
    $vCache = cache_get($vCacheId, 'cache');
    $vRetorno = 0;

    if (!$vCache) {
        $vQuery = "SELECT count(n.nid) as total
				 FROM `node` as n
				 INNER JOIN (SELECT max(n2.nid) as nid,max(n2.created) as data
							 FROM `node` as n2
							 INNER JOIN taxonomy_index as tid2 ON tid2.nid = n2.nid
							 INNER JOIN taxonomy_term_data as td2 ON tid2.tid = td2.tid AND td2.vid <> 1
							 WHERE n2.type in ('caderno_colunistas')
							 AND n2.status = 1
							 group by td2.name) AS sub ON sub.nid = n.nid
				 INNER JOIN taxonomy_index as tid ON tid.nid = n.nid
				 INNER JOIN taxonomy_term_data as td ON tid.tid = td.tid AND td.vid <> 1
				 INNER JOIN taxonomy_vocabulary as tv ON tv.vid = td.vid
			     WHERE n.type in ('caderno_colunistas')
				 AND n.status = 1";

        $result = db_query($vQuery);

        $vTemp = $result->fetchAll();
        $vRetorno = $vTemp[0]->total;

        cache_set($vCacheId, $vRetorno, 'cache', time() + 60 * 60);
    } else {
        $vRetorno = $vCache->data;
    }

    return $vRetorno;
}
