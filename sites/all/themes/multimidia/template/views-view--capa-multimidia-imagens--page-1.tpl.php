<?php
//Template da capa de imagens para o caderno de multimidia

drupal_add_js(drupal_get_path('module', 'capa') . '/js/abas.js');
module_load_include('inc', 'capa', 'capa');
$pathTema = path_to_theme('multimidia');


//Chamada das views
$nodesImagens = get_nodes_views('capa_multimidia_imagens', 'page_1'); //resultado da views de imagens em cache
//-------------------------------------------------------------------
/**
 * Blocos de IMAGENS da capa
 */
//função que retorna um array com o html do tpl do tema setado e o array de resultados da views em cahce restante
$imagensVII = getTemaBloco($nodesImagens,'block-multi-img-VII',4);
$arrImagens = $imagensVII['array'];

//obsevar a ordem desse
$slideshowImgVertical = getTemaBloco($arrImagens,'block-multi-img-vertical',12);
$arrImagens = $slideshowImgVertical['array'];

$imagensVIII = getTemaBloco($arrImagens, 'block-multi-img-grande', 1);
$arrImagens = $imagensVIII['array'];

//-------------------------------------------------------------------

?>
  <!-- containergrande containerLinha -->
	<div class="divContainerGrande">
      <div class="cnt12">
        <div class="centroContainer">
           <!--box-->
            <?php print $imagensVII['html'];?>
           <!--/box-->      
           <!--box-->
           <?php print $imagensVIII['html'];?>
           <!--/box--> 
        </div>
      </div>
    </div>
    <!-- /containergrande containerLinha -->
    
    <!-- containergrande containerLinha -->
    <div class="divContainerGrande containerLinha">
    <div class="cnt12">
      <div class="centroContainer">
         <!-- box -->
        <!-- slide img verticais -->
         <?php print $slideshowImgVertical['html'];?>
        <!-- /slide img verticais-->
        <!-- /box -->
        </div>
      </div>
    </div>
   <!-- /containergrande containerLinha -->