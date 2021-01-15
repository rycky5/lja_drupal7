<?php
/** 
 * Arquivo que conterá a funcionabilidade de montagem de capa
 * 
 * @author Alberto Medeiros
 */
?>
<link rel="stylesheet" type="text/css" href="<?= base_path().drupal_get_path('theme', 'leiaja'); ?>/css/estilo.css"/> 
<link rel="stylesheet" type="text/css" href="<?= base_path().drupal_get_path('theme', 'multimidia'); ?>/css/multimedia.css"/> 
<link rel="stylesheet" type="text/css" href="<?= base_path().drupal_get_path('theme', 'multimidia'); ?>/css/estilo.css"/> 
<link rel="stylesheet" type="text/css" href="<?= base_path().drupal_get_path('theme', 'multimidia'); ?>/css/grid.css"/> 

  <script src="/misc/ui/jquery.ui.core.min.js"></script>
  <script src="/misc/ui/jquery.ui.widget.min.js"></script>
  <script src="/misc/ui/jquery.ui.mouse.min.js"></script>
  <script src="/misc/ui/jquery.ui.sortable.min.js"></script>
  <script src="/misc/ui/jquery.ui.draggable.min.js"></script>
  
<style>
/*    #sortable { list-style-type: none; margin: 0; padding: 0; }*/
    #sortCapa li { margin: 3px 3px 3px 0; padding: 1px; float: left; }
/*    #sortCapa .noticiaAutomatica{ border: solid 1px; }*/
  </style>
<div class="messages warning" style="display:none;"><span class="warning tabledrag-changed">*</span> As alterações nesses blocos não vão ser salvas enquanto o botão <em>Salvar e Publicar</em> não for clicado.</div>    
<div class="menuTemplates">
  <h4>Selecione uma capa</h4>
  <select id="strIdCapa" name="strIdCapa">
      <option value="">--- Favor Selecionar uma Capa ---</option>
     <?php
          foreach($arrObjCapa as $objCapa){
     ?>
          <option value="<?= $objCapa->capa_id ?>"><?= $objCapa->nome_capa ?></option>
    <?php
          }
     ?>
  </select>
</div>    
<div class="addNoticias" style="float: left; margin-left: 20px;  width: 100px;  margin-left: -20px;">
  <div class="menuTemplates">
  <h4 class="titulo" style=" width: 200px; font: bold 15px;">Selecione Modulo</h4>
  </div>
  <select id="strIdModulo" name="strIdModulo" style="margin-bottom: 10px;">
      <option value="">--- Filtre Por Módulo ---</option>
     <?php
          $strModulo = "";
          foreach($arrObjBloco as $objBloco){
            // Se o bloco já foi listado continuo o laço
            if($objBloco->module == $strModulo)
              continue;
            else// se não seto o valor pra não ser mais mostrado
              $strModulo = $objBloco->module;

     ?>
      <option value="<?= $objBloco->module ?>"><?= strtoupper($objBloco->module) ?></option>
    <?php
          }
     ?>
  </select>
  <div class="divUlNoticiasTemplate" style="width: 230px; height: 600px; ">
    <ul class="ulUltimasNoticias connectedSortable" id="sortBlocos" style="width: 250px; height: 600px; border: 1 groove; overflow: auto" >
        <?php 
            foreach($arrObjBloco as $objBloco){
        ?>
             <li class="noticiaAutomatica cinza noticiaTodos montagemCapa <?= $objBloco->module ?>" rel_delta="<?= $objBloco->delta ?>" rel_module="<?= $objBloco->module ?>" style="width: 200px; font-size: 12px; font: none; border: solid 1px;"><?=  (!empty ($objBloco->title)) ? $objBloco->title : $objBloco->delta  ?></li>
        <?php
            }
         ?>
    </ul>
  </div>
</div>
<div class="divContainer bgBranco"  style="margin-left: 180px;width: 960px; float: left;">
  <!-- /slide cromo -->
  <div class="cnt12">
    <ul id="sortCapa" class="ui-sortable connectedSortable" style="width: 100%; min-height: 600px; border: 1px solid; float: left;">
    </ul>
  </div>
</div>
<div class="divSalvarTemplates" style="margin-left: 240px;">
    <button id="btnSalvarPublicar">
      <span>Salvar e Publicar</span>
    </button>
    <div id="divSalvarAguarde" style="display:none;"><img src="http://static1.leiaja.com/sites/all/themes/leiaja/images/loaderTemplate.gif">Aguarde...</div>
</div>
<script type="text/javascript">
  var atualizaNoticias = null;
  var initDrag = null;
  (function ($) {
          // Inicialização no evento document load.
      $(document).ready(function(){
          $('#ulTemplate input').eq(<?php print variable_get('capa_multimidia')-1;?>).attr('checked','checked')
          $(".noticiaAutomatica").dblclick(function(){
            alert("oi");
          });
          
          $("#strIdCapa").change(function(){
              if($("#strIdCapa").val() != ""){
                divCarregando($("#sortCapa"));
                // Lendo a capa montada anteriormente
                $("#sortCapa").load("/admin/carregarcapa", {
                  "intIdCapa" : $("#strIdCapa").val()
                }, function(){
                  
                });
              }else{
                $("#sortCapa").html("");
              }
          });
          
          $("#btnSalvarPublicar").click(function(){
              if($("#strIdCapa").val() != ""){
                
                // Criando o array que conterá os dados
                var arrDadosCapa = [];
                var intContador = 0;
                // Percorrendo a capa montada para pegar o delta do bloco e o modulo qual o memso faz parte
                $("#sortCapa").find(".montagemCapa").each(function(){
                    // Criando o array que conterá os dados da linha
                    var arrDadosLinhaCapa = [];
                    arrDadosLinhaCapa[0] = $(this).attr("rel_module");
                    arrDadosLinhaCapa[1] = $(this).attr("rel_delta");
                    
                    // Setando os dados no array principal
                    arrDadosCapa[intContador] = arrDadosLinhaCapa;
                    // Incrementando o contador
                    intContador++;
                 });
                 
                 // Validado se a capa foi selecionada e se há algum bloco selecionado para a capa
                 if(arrDadosCapa.length > 0 && $("#strIdCapa").val() != ""){
                   $.post("/admin/salvarcapa", 
                    {
                      "arrDadosCapa"  : arrDadosCapa,
                      "intIdCapa"     : $("#strIdCapa").val()
                    },function(arrRetorno){
                      alert(arrRetorno.strMensagem);
                    },"json");
                 }else
                   alert("Nenhum bloco foi selecionado pra essa capa!");
              }else{
                alert("Favor Selecionar uma capa!");
              }
          });
          
          $("#strIdModulo").change(function(){
            if($(this).val() == ""){
              $("#sortBlocos li").show(200);
            }else{
              $("#sortBlocos li").hide(200);
              $("."+$(this).val()).show(200);
            }
          });

           $(".connectedSortable").sortable({
                cancel: 'button',
                receive: function(event, ui) {
                    var objArratado = $(this).data().sortable.currentItem;
                    divCarregando($(objArratado));
                    $(objArratado).attr("style", "");
                    $(objArratado).load("/admin/carregabloco", 
                        {"strDelta":$(ui.item).attr("rel_delta"), "strModulo": $(ui.item).attr("rel_module")}, 
                        function(){

                        }
                    );
                },over: function(e, ui) { sortableIn = 1; },
                  out: function(e, ui) { sortableIn = 0; },
                  beforeStop: function(e, ui) {
                     if (sortableIn == 0) { 
                        ui.item.remove(); 
                     } 
                  }
           });
           $("#sortBlocos li").draggable({
              connectToSortable: "#sortCapa",
              helper: "clone",
              revert: "invalid"
           });
           $( "ul, li" ).disableSelection();
       });           



      var divCarregando = function(pElement){
        vHtml = "<div><img src=\"http://static1.leiaja.com/sites/all/themes/leiaja/images/loader.gif\">Carregando...</div>";
        $(pElement).html(vHtml);
      }
  })(jQuery);
</script>