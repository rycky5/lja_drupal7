<?php

require_once $pathTema.'/template/includes/monta_capa_multimidia.api.inc';

function api_montagem_capa(){
    
    $varTplSetado = variable_get('capa_multimidia');
    
    switch ($varTplSetado) {
        case 1:
            require_once $pathTema.'include_page_multi_01.inc';
            break;
        
        case 2:
            require_once $pathTema.'include_page_multi_02.inc';
            break;
        
        case 3:
            require_once $pathTema.'include_page_multi_03.inc';
            break;

        default:
            require_once $pathTema.'include_page_multi_01.inc';
            break;
    }
    
}

?>