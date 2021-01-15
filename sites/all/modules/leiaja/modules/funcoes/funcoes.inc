<?php

//Incluindo o arquivo funcoes.api
module_load_include('inc', 'funcoes', 'funcoes.api');

//Função que vai retornar a revisão formatada
function get_revisao($nid) {
    
    //Recuperando o resultado
    $result = api_getRevisao($nid);
    
    return $result;
    
}
