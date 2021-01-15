<?php
/**
 * Arquivo que conterá os pages call back do módulo comentario
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */

// Includes necessários
module_load_include('inc', 'comentario', 'comentario.api');

/**
 * Método que irá salvar o comentário na base
 * 
 * @return Json
 */
function salvar_comentario(){
  // Parametros de retorno
  $strMensagem = "Salvo com sucesso!!!";
  $bolRetorno = false;
  
  try {
    // Chamando a função que irá salvar o post na base
    api_salvar_comentario($_POST);
    $bolRetorno = true;
  } catch (Exception $exc) {
    $strMensagem = $exc->getMessage();
  }

  // Criando o array de retorno
  $arrDados = array();
  $arrDados["strMensagem"] = $strMensagem;
  $arrDados["bolRetorno"] = $bolRetorno;
  
  // Retornando via Json
  echo json_encode($arrDados);die;
}