<?php

//Função que vai consultar no banco a revisão de uma node
function db_getRevisao($nid) {
    
    $query = "SELECT n.timestamp
            FROM node_revision as n
            WHERE nid = $nid
            AND n.log <> ''
            ORDER BY vid DESC
            LIMIT 1";

    $result = db_query($query);

    return $result->fetchAll();
    
}
