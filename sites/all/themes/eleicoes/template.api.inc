<?php



/**
 * Função que recebe array de objetos Node e retorna string com NIDs.
 *
 * @param Array     $pArr
 * @return String
 */
function getIgnoreNidEleicoes($pArr = array(), $strIgnode = "")
{
    $vIgnore = null;

    foreach($pArr as $vNot)
      $vIgnore[] = $vNot->nid;

    return ((!empty($strIgnode)) ? $strIgnode . "," : "") . implode(',',$vIgnore) ;
}