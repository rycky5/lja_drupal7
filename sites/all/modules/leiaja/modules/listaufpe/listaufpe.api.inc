<?php

/**
 * Arquivo resposável por conter as regras de negócio do módulo vídeo sambatech
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */

// incluindo os arquivos necessários
module_load_include('inc', 'listaufpe', 'listaufpe.bd');

function api_buscar_candidato_por_filtro(array $arrDadosCandidato){
    
    if(empty ($arrDadosCandidato["INSC-DET"]) && empty ($arrDadosCandidato["CAND-DET"]) && empty ($arrDadosCandidato["IDNR-DET"]))
        throw new Exception("Favor Preencher um dos campos de busca");
    
    
    return bd_buscar_candidato_por_filtro($arrDadosCandidato);
}


?>
