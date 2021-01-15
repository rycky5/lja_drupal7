<?php
/**
 * Arquivo que conterá o bloco de ultimas de cultura ou diversão
 * 
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */

//echo "<pre>";
//var_dump($view->result);
//die;

// Includes necessários
module_load_include('inc', 'montarcapa', 'montarcapa.api');

// Recuperando os ids que estão montado a parte superior
$strNidIgnode = getIgnoreCapa();

// Carregando as ultimas de cultura 
$arrObjNode = views_get_view_result("views_integracao_ig", "ultimas_cultura", $strNidIgnode);

// Tamanho do modal
$strModal = "?TB_iframe=true&width=906&height=585&modal=true";
?>
<!-- linha -->
  <div class="linha igd_12"></div>
<!-- /linha -->
<!-- coluna -->
 <div class="coluna col igd_6">
   <div  class="chapeu igd_6"><h1>diversão</h1></div>
   
<?php   
    foreach($arrObjNode as $intChave => $objNode){
      if($intChave == 3)
        break;
      // Verificando se a node irá abrir no modal
      $strLink = getLinkNode($objNode->_field_data["nid_1"]["entity"]);
      
      // Recuperando o titulo para saber se irá usar chamada de capa ou titulo
      $strTitle = (!empty ($objNode->field_field_chamada_capa[0]["rendered"]["#markup"])) ?
            $objNode->field_field_chamada_capa[0]["rendered"]["#markup"] :
            $objNode->node_title;
      
      // Formatando a node
//      $objNodeFormatado = api_formataNodeCapa($objNode->_field_data["nid"]["entity"]);
      
      // Criando o array de notícias
      $img = array();
      $img['style']   = "thumb_capa_ig";
      $img['uri']     = api_getImageCapa($objNode->_field_data["nid_1"]["entity"]);
      $img['alt']     = $strTitle;
      $img['title']   = $strTitle;
      $img['width']   = 112;
      $img['height']  = 82;
 ?>
       <!-- box -->
       <div class="boxMiniTitImg <?= ($intChave < 2) ? "linha" : "";?> igd_6">
         <a <?= $strLink ?> >
           <?php 
              // Exibindo a imagem
              image_static_lazy($img);
           ?>
         </a>
         <h2><a <?= $strLink ?>  ><?= format_date($objNode->node_created,'data_ig') ?></a></h2>
         <p><a <?= $strLink ?> ><?= $strTitle ?></a></p>
       </div>
<?php
   }
?>
  <a href="http://www.leiaja.com/cultura" class="lermais igd_6">Todas as notícias</a>
 </div>
 <!-- /coluna -->