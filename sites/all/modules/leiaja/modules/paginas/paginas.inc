<?php

module_load_include('inc', 'paginas', 'paginas.api');

/**
 * Callback para a capa do caderno de Colunistas.
 *
 * @link /colunistas
 * @return type
 */
function page_colunistas(){
  
    return api_getColunistas();
    
}

/**
 * Callback para a pagina de especiais
 * 
 * @link /especiais
 * @return type
 */
function page_especiais(){
    
    return api_getEspeciais();
    
}

/**
 * Callback para a pagina de Assine(feeds)
 * 
 * @link /assine
 * @return type
 */
function page_assine(){
    
    return api_getAssine();
    
}

