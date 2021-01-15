<?php
/**
 * Arquivo que conterá o bloco de colunistas
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */
// Includes necessários
module_load_include('inc', 'widgetig', 'widgetig.db');

// Carregando as ultimas de cultura 
$arrObjNode = getColunistasPagIG(16);

// Pegando o caminho do thema do leiaja
$pathTema = "http://static1.leiaja.com/sites/igpernambuco.leiaja.com/themes/ig";

?>
 <!-- linha -->
 <div class="linha igd_12"></div><!-- /linha -->
 <!-- coluna -->
 <div class="coluna col igd_12">
   <div class="chapeu chapeuDestaque igd_12">
     <h1>COLUNISTAS</h1>
     <div class="passadorSlider1">
       <ul>
         <li><a id="ant" href="javascript:void(0)" class="ant"></a></li>
         <?php
            for($intContador = 1; $intContador <= (count($arrObjNode) / 4); $intContador++){
         ?>
                <li><a href="javascript:void(0)" class="<?= ($intContador == 1) ? 'ativo' : '' ?> passador_<?= $intContador ?> botoes_bolunistas" rel="<?= $intContador ?>"></a></li>
         <?php
            }
         ?>
         <li><a id="prox" href="javascript:void(0)" class="prox"></a></li>
       </ul>
      </div>
   </div> 
   <div class="boxSlide1 col igd_12" style="width: 672px">
     <ul class="boxSlide1 col igd_12" id="carrocelColunistas">
         <?php
              // Contador para o efeito de carrocel
              $intContador = 1;
              $intContadorQuatro = 0;
              // Contador de laço
              foreach($arrObjNode as $intChave => $objNode){
                
                if($intContadorQuatro == 4){
                  $intContadorQuatro = 0;
                  $intContador++;
                }
                // Incrementando o contador
                $intContadorQuatro++;
                
                if($intContadorQuatro%2!=0){
                  echo "<li class='col igd_6 passador_{$intContador}'" . (($intContador > 1) ? "style='display: none'" : "") .">";
                }
         ?>
                 <!-- box -->
                   <div class="box <?= ($intContadorQuatro%2!=0) ? "linha" : "";?> igd_6">
                     <a href="http://www.leiaja.com/<?= drupal_lookup_path('alias', 'taxonomy/term/'.$objNode->tid) ?>"><img  src="<?= $pathTema.'/img/foto-coluna-'.$objNode->tid.'.jpg'?>" /></a>
                     <h2><a href="http://www.leiaja.com/<?= drupal_lookup_path('alias', 'taxonomy/term/'.$objNode->tid) ?>"><?= $objNode->name ?></a></h2>
                     <p><a href="http://www.leiaja.com/<?= drupal_lookup_path('alias', 'node/'.$objNode->nid) ?>"><?=  limitaTexto($objNode->title, 50) ?></a></p>
                   </div>
                   <!-- /box -->
         <?php
              if($intContadorQuatro%2==0)
                echo '</li>';
              }
         ?>
     </ul>
   </div>
 </div>
 <!-- /coluna -->
 
 <script type="text/javascript">
    (function ($) {
        // Iniciando as variáveis 
        var intContador = 1;
        var intQtdContador = <?= (count($arrObjNode) / 4) ?>;
        
        // Inicialização no evento document load.
        $(document).ready(function(){
          
          $("#prox").click(function(){
            passaColunistar('prox');
          });
          
          $("#ant").click(function(){
            passaColunistar('ant');
          });
          
        });
        
        /**
         * Método que irá passar os colunistas
         */
        function passaColunistar(strEvento){
          // Verificando se estou na ultima posição ou na primeira
          if(strEvento == 'ant' && intContador == 1)
            return false
          else if(strEvento == 'prox' && intContador == intQtdContador)
            return false;
          
          // Voltando o passador
          if(strEvento == 'ant')
            intContador--;
          else // Passando o passador
            intContador++;
          
          // Removando a classe de selecionado
          $(".passadorSlider1").find("ul").find(".botoes_bolunistas").removeClass("ativo");
          
          // Setando a classe de ativo
          $(".passadorSlider1").find(".passador_"+intContador).addClass("ativo");
          
          // Escondendo todos os colunistas
          $("#carrocelColunistas").find("li").hide();
          $("#carrocelColunistas").find(".passador_"+intContador).show();
        }
        
        
    })(jQuery);
  </script>