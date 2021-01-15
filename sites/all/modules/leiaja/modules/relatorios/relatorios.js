(function ($){
$(document).ready(function(){

  // form
  var form_filtro_relatorios_de_publicacoes_api_cadernos          = $("#relatorios-de-publicacoes-api-cadernos-form-filtro");
  var form_filtro_relatorios_de_publicacoes_api_cadernos_detalhe  = $("#relatorios-de-publicacoes-api-cadernos-detalhe-form-filtro");
  var form_filtro_relatorios_de_publicacoes_api_blogs_da_redacao  = $("#relatorios-de-publicacoes-api-blogs-da-redacao-form-filtro");

  // Filtro location cadernos
  $(form_filtro_relatorios_de_publicacoes_api_cadernos).submit(function(){
    
    var action  = $(form_filtro_relatorios_de_publicacoes_api_cadernos).attr('action');
    var mes     = $(form_filtro_relatorios_de_publicacoes_api_cadernos).find('[name="mes"]').val();
    var ano     = $(form_filtro_relatorios_de_publicacoes_api_cadernos).find('[name="ano"]').val();
        
    window.location = action+'/'+mes+'/'+ano;
        
    return false;
  });
  
  // Filtro location cadernos detale
  $(form_filtro_relatorios_de_publicacoes_api_cadernos_detalhe).submit(function(){
    
    var action  = $(form_filtro_relatorios_de_publicacoes_api_cadernos_detalhe).attr('action');
    var mes     = $(form_filtro_relatorios_de_publicacoes_api_cadernos_detalhe).find('[name="mes"]').val();
    var ano     = $(form_filtro_relatorios_de_publicacoes_api_cadernos_detalhe).find('[name="ano"]').val();
        
    window.location = action+'/'+mes+'/'+ano;
        
    return false;
  });
    
  // Filtro location blogs da redacao
  $(form_filtro_relatorios_de_publicacoes_api_blogs_da_redacao).submit(function(){
    
    var action  = $(form_filtro_relatorios_de_publicacoes_api_blogs_da_redacao).attr('action');
    var mes     = $(form_filtro_relatorios_de_publicacoes_api_blogs_da_redacao).find('[name="mes"]').val();
    var ano     = $(form_filtro_relatorios_de_publicacoes_api_blogs_da_redacao).find('[name="ano"]').val();
        
    window.location = action+'/'+mes+'/'+ano;
        
    return false;
  });
});
})(jQuery);