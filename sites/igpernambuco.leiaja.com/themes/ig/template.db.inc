<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



/**
 * Retorna o número de visualizações de um Node.
 *
 * @param Int $pNid     ID do node.
 */
function getNodeViewsIg($pNid = null)
{
  $pNid = (int) $pNid;
  $query = "SELECT totalcount
            FROM `node_counter`
            WHERE nid = $pNid";

  $result = db_query($query);

  $vCount = $result->fetchAll();

  $intTotal = (!empty ($vCount[0]->totalcount)) ? $vCount[0]->totalcount : 0;
  return $intTotal;
}

function getUserImprensa($uid){

  $vQuery = "SELECT true FROM `users_roles` WHERE rid in(4,6,7) AND uid = $uid;";

  $result = db_query($vQuery);

  $result = $result->fetchAll();

  return $result;
}