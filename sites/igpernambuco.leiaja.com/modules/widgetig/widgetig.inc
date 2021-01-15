<?php
/**
 * Arquivo que conterá os métodos comuns aos blocos e os widgets do portal
 * 
 * @author Alberto Medeiros
 */

// incluindo os arquivos necessários
module_load_include('inc', 'widget', 'widget.api');

/**
 * Um array de variáveis para o thema do bloco.
 *
 * @param $type
 *   O nome do tema do bloco
 * @param $name
 *   A quantidade de elementos para busca de colunistas.
 *
 * @return
 *   Um array de variáveis para o thema do bloco.
 */
function api_bloco_renderiza_bloco($strTema){
  // Retornando o tema
  return theme($strTema);
}
