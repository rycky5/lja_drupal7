<?php

/**
 * Arquivo resposável por conter as regras de negócio do módulo vídeo sambatech
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */

// incluindo os arquivos necessários
module_load_include('inc', 'especiais', 'promocoes.bd');


/**
 * 
 */
function getTermos(){
  return getTermosdb(array('abertas' => true));
}

function participando_promo_api(){
  return listar_participante();
}


function participar_promo_api($tid){
  return participar_promo_db($tid);
}

/**
 * Método que ira realizar validação da listagem de telefones 
 * 
 */
function api_listagem_promo(array $arrFiltro){
  // Realizando a consulta
  $arrObjUsuario = db_listagem_participantes($arrFiltro);
  
  // Nome do arquivo e path onde ele se encontra
  $strNomeArquivo = "lista_participantes_" . date("Ymd_His") . ".csv";
  
  // Path do arquivo
  $strPath = "/var/tmp/";
  
  // Abrindo o arquivo
  $strArquivo = fopen($strPath . $strNomeArquivo, "a+");
  
  // Criando o cabeçalho do arquivo
  fwrite($strArquivo, "Nome;Email;Telefone;Promocao \r\n");
  
  // Escrevendo no arquivo
  foreach($arrObjUsuario as $objUsuario){
    fwrite($strArquivo, $objUsuario->name . ";" . $objUsuario->mail . ";" . $objUsuario->cel . ";" . $objUsuario->promo . "  \r\n");
  }
  
  // Fechando o arquivo
  fclose($strArquivo);
  
  /***************************************************
   ******* REALIZANDO O DONWLOAD DO ARQUIVO     ****** 
   ***************************************************/
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename='.basename($strNomeArquivo));
  header('Content-Transfer-Encoding: binary');
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($strPath . $strNomeArquivo));
  readfile($strPath . $strNomeArquivo);
  unlink($strPath . $strNomeArquivo);
  exit;
  
}
function api_widget_promocoes(){
// incluindo os arquivos necessários
  $vars["vPromocoes"]=getTermos();
  $promocoes=theme('block_promocoes',$vars);
  return $promocoes;
}



?>
