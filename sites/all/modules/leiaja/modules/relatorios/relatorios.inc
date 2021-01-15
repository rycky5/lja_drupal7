<?
// includes
module_load_include('inc','relatorios','relatorios.api');

## relatorios de publicacoes ##
## cadernos
// filtro e relatorio
/**
 * @param   [int $mes], [int $ano] 
 * @author  Inaldo Nogueira <inaldo.nogueira@leiaja.com.br>
 * @return  theme form HTML, theme table HTML
 * @link    admin/reports/relatorios_de_publicacoes/cadernos/[:mes]/[:ano]
 */
function relatorios_de_publicacoes_cadernos($mes = false,$ano = false){
  return relatorios_de_publicacoes_api_cadernos($mes,$ano);
}
/**
 * @param   [int $mes], [int $ano] 
 * @author  Inaldo Nogueira <inaldo.nogueira@leiaja.com.br>
 * @return  theme form HTML, theme table HTML
 * @link    admin/reports/relatorios_de_publicacoes/cadernos_detalhe/[:mes]/[:ano]
 */
function relatorios_de_publicacoes_cadernos_detalhe($mes = false,$ano = false){
  return relatorios_de_publicacoes_api_cadernos_detalhe($mes,$ano);
}
## blogs da redacao
// filtro e relatorio
/**
 * @param   [int $mes], [int $ano] 
 * @author  Inaldo Nogueira <inaldo.nogueira@leiaja.com.br>
 * @return  theme form HTML, theme table HTML
 * @link    admin/reports/relatorios_de_publicacoes/blogs_da_redacao/[:mes]/[:ano]
 */
function relatorios_de_publicacoes_blogs_da_redacao($mes = false,$ano = false){
  return relatorios_de_publicacoes_api_blogs_da_redacao($mes,$ano);
}
## especiais
// filtro e relatorio
/**
 * @param   void
 * @author  Inaldo Nogueira <inaldo.nogueira@leiaja.com.br>
 * @return  theme form HTML, theme table HTML
 * @link    admin/reports/relatorios_de_publicacoes/especiais/[:mes]/[:ano]
 */
function relatorios_de_publicacoes_especiais(){
  return relatorios_de_publicacoes_api_especiais();
}
