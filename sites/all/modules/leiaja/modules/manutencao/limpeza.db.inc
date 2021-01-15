<?php
/*
 *  Arquivo onde estão localizadas funções de recuperação e persistência de dados
 *  na base de dados.
 *
 *  @package    Manutencao
 *  @subpackage Limpeza
 *  @author     Thiago Galvão Soares (galvao@sereducacional.com)
 *
 */

/**
 * Retorna os nodes antigos não publicados
 *
 * @param Array $pParams
 */
function db_getNodeAntigos($pParams = array())
{
   $vDias     = (empty($pParams['pDias']))     ? 60            : $pParams['pDias'];
   $vUsuarios = (empty($pParams['pUsuarios'])) ? array(55,182,1024) : $pParams['pUsuarios'];

   $vSelect = db_select('node','n')
              ->fields('n',array('nid'))
              ->condition('status', 0, '=')
              ->condition('uid', $vUsuarios, 'IN')
              ->where('FROM_UNIXTIME(created) < DATE_SUB(CURRENT_DATE,interval 3 MONTH)')
              ->orderBy('created')->execute();


   return $vSelect->fetchAll();
}