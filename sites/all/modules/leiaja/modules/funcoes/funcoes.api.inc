<?php

//Incluindo o arquivo funcoes.db
module_load_include('inc', 'funcoes', 'funcoes.db');

//Função que vai recuperar o timestamp enviado pelo banco e vai retonar o valor formatado
function api_getRevisao($nid){
    
    $vData = db_getRevisao($nid);
    
    if(empty($nid)){
        return FALSE;
    }else if(empty ($vData)){
        return FALSE;
    }else{
        $vRetorno = format_date($vData[0]->timestamp, 'medium');
        return $vRetorno;
    }    
    
}

