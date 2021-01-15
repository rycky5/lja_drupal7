<?php
/**
 * Arquivo que conterá o bloco de vídeos do portal
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */

// Includes necessários
module_load_include('inc', 'montarcapa', 'montarcapa.api');

// Recuperando as ultimas notícas do portal
$arrObjNodeFoto = views_get_view_result("views_integracao_ig", "ultimas_noticias");

// Carregando as ultimas galerias 
$arrObjNode = views_get_view_result("views_integracao_ig", "galeria_portal", api_getNidIgnore());

// Recuperando a notícia galeria
$objNode = $arrObjNode[0]->_field_data["nid_1"]["entity"];

// Tamanho do modal
$strModal = "?TB_iframe=true&width=906&height=585&modal=true";

// Método que recebe a node e ira retornar a categoria
$strCategoria = api_getFieldCategoriaPorCaderno($objNode);

// Lendo o subcaderno da notícia
$objSubCaderno = api_getSubCaderno($objNode->{$strCategoria}["pt-br"][0]["tid"]);

// Formatando a node
  $objNodeFormatado = api_formataNodeCapa($objNode);
?>
<!-- linha --><div class="linha igd_12"></div><!-- /linha -->
<!-- coluna -->
 <div class="coluna col igd_6">
   <div class="chapeu igd_6"><h1><?= $objSubCaderno->name ?></h1></div>
   <!-- box -->
   <div class="box boxImg igd_6">
     <a href="http://www.leiaja.com<?= url(drupal_lookup_path('alias',"node/".$objNode->nid))  ?>">
       <?php 
          // Exibindo a imagem
          api_geraImagem($objNodeFormatado, 'home_destaque_ig', 322, 243); 
       ?>
     </a>
     <h2>
       <a href="http://www.leiaja.com<?= url(drupal_lookup_path('alias',"node/".$objNode->nid))  ?>">
           <?= $objNode->title ?>
       </a>
     </h2>
   </div>
   <!-- /box -->
 </div>
 <!-- /coluna -->
 <?php
 // Executando apenas uma vez
?>

<!-- coluna -->
 <div class="coluna col igd_6">
   <div  class="chapeu igd_6"><h1>ULTIMAS NOTÍCIAS</h1></div>
   
<?php   
    foreach($arrObjNodeFoto as $intChave => $objNode){
      // Verificando se a node irá abrir no modal
      $strLink = getLinkNode($objNode->_field_data["nid"]["entity"], $bolDebug);

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
       <div class="boxMiniTitImg <?= ($intChave < 2) ? "linha" : "";?> igd_6">
         <a <?= $strLink ?>>
           <?php 
               // Exibindo a imagem
                image_static_lazy($img);
           ?>
         </a>
         <h2>
           <a <?= $strLink ?>>
             <?= format_date($objNode->node_created,'data_ig') ?>
           </a>
         </h2>
         <p>
           <a <?= $strLink ?>>
             <?= $strTitle ?>
           </a>
         </p>
       </div>
<?php
   }
?>
  <a href="http://www.leiaja.com/ultimas" class="lermais igd_6">Todas as notícias</a>
 </div>
 <!-- /coluna -->


<!-- linha --><div class="linha igd_12"></div><!-- /linha -->