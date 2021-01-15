<?php

/**
 * Arquivo resposável por conter todo acesso ao banco do módulo vídeo sambatech
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */


/**
 * Função Responsável por arualizar os views dos vídeos na base
 *
 * @param array $arrDadosVideo 
 */
function bd_buscar_candidato_por_filtro(array $arrDadosCandidato){
    try{
        
        if(!empty ($arrDadosCandidato["INSC-DET"])){
            $strCampoBusca = "INSCDET";
            $strCondicao = $arrDadosCandidato["INSC-DET"];
            $strCondicaoBusca = "=";
        }else  if(!empty ($arrDadosCandidato["CAND-DET"])){
            $strCampoBusca = "CANDDET";
            $strCondicao = $arrDadosCandidato["CAND-DET"] ."%";
            $strCondicaoBusca = "like";
        }else {
            $strCampoBusca = "IDNRDET";
            $strCondicao = $arrDadosCandidato["IDNR-DET"];
            $strCondicaoBusca = "=";
        }
        
        // atualizando os views dos vídeos da sambatech na base
        $registro = db_select("tb_listao_ufpe_2014", "lu")
                    ->fields("lu")
                    ->condition($strCampoBusca,$strCondicao,$strCondicaoBusca)
                    ->range(0,50)
                    ->execute();
        
        return $registro->fetchAll();
    }  catch (Exception $objEx){
        // Lançando a excessão 
        throw new Exception($objEx->getMessage());
    }
}

?>