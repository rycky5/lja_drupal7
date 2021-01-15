<?php

/**
 * Arquivo resposável por conter as requisições de callback referente a listaufpe
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */

/**
 * Inclui os arquivos necessários da biblioteca.
 */
module_load_include('inc', 'listaufpe', 'listaufpe.api');

/**
 * Método de callback responsável por receber a requisição para Visualização da pagina de resultado
 * 
 */
function resultado_ufpe(){
    $strMsgErro = "";
    $arrDadosUsuario = array();
    if($_POST){
       
        try {
            // criando o array com os campos de busca
            $arrDados = array("INSC-DET"=>"","CAND-DET" =>"", "IDNR-DET"=>"");
            
            if($_POST["intTipoFiltro"] == 1)
                $arrDados["INSC-DET"] = $_POST["keys"];
            else 
            if($_POST["intTipoFiltro"] == 2)
                $arrDados["CAND-DET"] = $_POST["keys"];
            else
                $arrDados["IDNR-DET"] = $_POST["keys"];
            
            $arrDadosUsuario =  api_buscar_candidato_por_filtro($arrDados);
            
        } catch (Exception $exc) {
            $strMsgErro = "Desculpe-nos, ocorreu um erro favor testar novamente!";
        }
       
        // criando a Mensagem de retorno
        $strMsgErro = (count($arrDadosUsuario) == 0) ? "Nenhum Resultado Encontrado para a busca por: <em>" . $_POST["keys"] . "<em>": " Resultado para a busca por: <em>" . $_POST["keys"] . "<em>";
        if($GLOBALS['user']->uid == '40'){
         echo $strMsgErro;  
        }
    }
    
    // Criando o array com o resultado da busca
    $vars = array("arrDadosUsuario" => $arrDadosUsuario, "strMensagem" => $strMsgErro);
    
    return theme("listaufpe-2011", $vars);
    
}


?>
