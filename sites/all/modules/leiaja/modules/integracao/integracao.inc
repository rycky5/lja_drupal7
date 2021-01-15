<?php
/*
 *  Arquivo onde estão localizadas funções de CALLBACK do hook_menu().
 *
 *  @package    Integracao
 *  @subpackage Integracao
 *  @author     Thiago Galvão Soares (galvao@sereducacional.com)
 *
 */

module_load_include('inc','integracao','integracao.api');

/**
 * Callback para importar notícias da agência estado.
 *
 * @link /integra/aestado
 */
function page_aestado()
{
  api_integra_aestado();
}

/**
 * Callback para importar notícias da Nowdigital.
 *
 * @link /integra/nowdigital
 */
function page_nowdigital()
{
  api_integra_nowdigital();
}

/**
 * Callback para importar notícias dos especiais.
 *
 * @link /integra/especiais
 */
//function page_especiais()
//{
//  api_integra_especiais();
//}

/**
 * Callback para importar notícias da agência AFP
 */

function integra_afp(){
    api_integra_afp();
}

/**
 * Callback para importar notícias dos rss
 */

function integra_especiais(){
    api_integra_especiais();
}