<?php
/**
 * Arquivo que conterá o bloco de ultimas de cultura ou diversão
 * 
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */

//node_save($node);
// Includes necessários
module_load_include('inc', 'montarcapa', 'montarcapa.api');

// Recuperando os ids que estão montado a parte superior
$strNidIgnode = getIgnoreCapa();

// Carregando as ultimas de cultura 
$arrObjNodeFoto = views_get_view_result("views_integracao_ig", "bloco_ultimas_esporte ", $strNidIgnode);
$arrObjNodeSemFoto = views_get_view_result("views_integracao_ig", "ultima_esporte", $strNidIgnode);


// Verificando se a node irá abrir no modal
$strLink = getLinkNode($arrObjNodeSemFoto[0]);

// Recuperando o titulo para saber se irá usar chamada de capa ou titulo
$strTitle = (!empty ($arrObjNodeSemFoto[0]->field_field_chamada_capa[0]["rendered"]["#markup"])) ?
              $arrObjNodeSemFoto[0]->field_field_chamada_capa[0]["rendered"]["#markup"] :
              $arrObjNodeSemFoto[0]->node_title;
?>

<!-- coluna -->
 <div class="coluna col igd_6">
   <div class="chapeu igd_6"><h1>ESPORTES</h1></div>
   <!-- box -->
   <div class="boxMiniTitImg semimagem linha igd_6">
     <h2><a <?= $strLink ?>><?= format_date($arrObjNodeSemFoto[0]->node_created,'data_ig') ?></a></h2>
     <p><a <?= $strLink ?>><?= $strTitle ?></a></p>
   </div>
   <!-- /box -->
   <?php 
      $strLink = "";
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
        <!-- box -->
         <div class="boxMiniTitImg <?= ($intChave < 1) ? "linha" : "";?> igd_6">
           <a <?= $strLink ?> >
             <?php 
//                // Exibindo a imagem
//                api_geraImagem($objNodeFormatado, 'thumb_capa_ig', 112, 82); 
                // Exibindo a imagem
                image_static_lazy($img);
             ?>
           </a>
           <h2>
             <a <?= $strLink ?> >
                <?= format_date($objNode->node_created,'data_ig') ?>
             </a>
           </h2>
           <p>
             <a <?= $strLink ?> >
                     <?= $strTitle ?>
             </a>
           </p>
         </div>
        <!-- /box -->
   <?php
      }
   ?>
   <a href="http://www.leiaja.com/esportes" class="lermais igd_6">Todas as notícias</a>
 </div>
 <!-- /coluna -->
 <!-- coluna -->
 <div class="coluna col igd_6">
   <div class="box torcida">
     <iframe scrolling="no" src="http://torcidas.esporte.ig.com.br//paginaRankingEstado.wn?estado=PE" width="320" height="380" frameborder="0"></iframe> 
   </div>
 </div>
 <!-- /coluna --> 