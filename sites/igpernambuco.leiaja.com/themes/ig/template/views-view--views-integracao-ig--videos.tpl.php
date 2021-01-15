<?php
/**
 * Arquivo que conterá o bloco de vídeos do portal
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */

// Includes necessários
module_load_include('inc', 'montarcapa', 'montarcapa.api');

// Recuperando os ids que estão montado a parte superior
$strNidIgnode = getIgnoreCapa();

// Carregando as ultimas de vídeos do portal 
$arrObjNode = views_get_view_result("views_integracao_ig", "videos", $strNidIgnode);

?>
<!-- coluna -->
<div class="coluna col igd_6">
   <div class="chapeu igd_6"><h1>Vídeos</h1></div>
   <?php
        foreach($arrObjNode as $intChave => $objNode){
          
          // Recuperando o titulo para saber se irá usar chamada de capa ou titulo
          $strTitle = (!empty ($objNode->field_field_chamada_capa[0]["rendered"]["#markup"])) ?
                        $objNode->field_field_chamada_capa[0]["rendered"]["#markup"] :
                        $objNode->node_title;
          
          // Criando o array de notícias
          $img = array();
          $img['style']   = "thumb_capa_ig";
          $img['uri']     = api_getImageCapa($objNode->_field_data["nid"]["entity"]);
          $img['alt']     = $strTitle;
          $img['title']   = $strTitle;
          $img['width']   = 112;
          $img['height']  = 82;
    ?>
            <!-- box -->
             <div class="boxMiniTitImg <?= ($intChave < 2) ? "linha" : "";?> igd_6">
               <a href="<?=   'http://www.leiaja.com'. url(drupal_lookup_path('alias',"node/".$objNode->nid)) ?>" class="video">
                 <?php 
                    // Exibindo a imagem
                    image_static_lazy($img);
                 ?>
                 <span class="iconPlay"></span>
               </a>
               <h2><a  href="<?= 'http://www.leiaja.com' . url(drupal_lookup_path('alias',"node/".$objNode->nid)) ?>"><?= format_date($objNode->node_created,'data_ig') ?></a></h2>
               <p><a href="<?=  'http://www.leiaja.com' . url(drupal_lookup_path('alias',"node/".$objNode->nid))  ?>"><?= $strTitle ?></a></p>
             </div>
             <!-- /box -->
   
   <?php
        }
   ?>
   <a href="http://www.leiaja.com/multimidia/videos" class="lermais igd_6">Todos os vídeos</a>
 </div>
 <!-- /coluna --> 