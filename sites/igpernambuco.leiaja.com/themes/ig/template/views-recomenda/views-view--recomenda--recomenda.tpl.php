<?php
/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */

// Recuperando o resultado da view
$arrObjNode = $view->result;
?>

<style>
  .relacionadas {width:/*672px;*/100%;float:left;padding:10px 0;border-top:2px solid #000;}
  .relacionadasData, .relacionadasTitulo, .relacionadasLegenda, .relacionadasTituloBox  {width:100%;float:left}
  .relacionadasBox {width:470px;float:left;} 
  .relacionadas ul li {padding:20px 0;border-top:1px dotted #dcdcdc;width:100%;float:left;}
  .relacionadas ul li img {margin:10px;width:100px;height:100px;float:left;}
  .relacionadasTituloBox {font-size:18px;font-weight:bold;margin:0 0 10px 0;}
  .relacionadasBox .relacionadasData {font-size:12px;margin:10px 0 5px 0;font-weight:bold;}
  .relacionadasBox .relacionadasTitulo {}
  .relacionadasBox .relacionadasTitulo a {text-decoration:none;font-size:16px;font-weight: bold;color:#324e69;}
  .relacionadasBox .relacionadasTitulo a:hover {text-decoration:underline;}
  .relacionadasBox span.relacionadasLegenda a {text-decoration: none;font-size:12px;color:#666666!important;margin:5px 0 0 0; cursor: pointer;}
  .relacionadasBox span.relacionadasLegenda a:hover {text-decoration: underline;}
</style>
<!-- BLOCO RELACIONADAS -->
<div class="relacionadas">
   <span class="relacionadasTituloBox">Notícias Relacionadas</span>
   <ul>
     <?php
      foreach($arrObjNode as $objNodeView){

        // Recuperando a notícia
        $objNode = $objNodeView->_field_data["nid"]["entity"];
        
        // Recuperando a url da notícia
        $strLink = "http://pernambuco.ig.com.br".url(drupal_lookup_path('alias',"node/".$objNode->nid));

        $strImagem = "";

        if(!empty ($objNode->field_image[key($objNode->field_image)])){
          // Recuperando a imagem
          $strImagem = image_static_url("thumbnail", $objNode->field_image[key($objNode->field_image)][0]["uri"]);
        }elseif($objNode->field_image[key($objNode->field_image)]){
          // Recuperando a imagem
          $strImagem = image_static_url("thumbnail", $objNode->field_capa[key($objNode->field_image)][0]["uri"]);
        }
        
     ?>
        <li>
         <?php if($strImagem != ""){ ?>
            <img src="<?= $strImagem ?>" title="<?= $objNode->title ?>" alt="<?= $objNode->title ?>"/>
         <? }?>
         <div class="relacionadasBox">
           <span class="relacionadasData"><?= date("H:i d/m/Y", $objNode->created) ?></span>
           <span class="relacionadasTitulo"><a href="<?= $strLink ?>"><?= $objNode->title ?></a></span>
           <span class="relacionadasLegenda">
             <a href="<?= $strLink ?>">
               <?= (!empty ($objNode->body[key($objNode->body)][0]["summary"])) ? $objNode->body[key($objNode->body)][0]["summary"] : truncate_utf8(strip_tags($objNode->body[key($objNode->body)][0]["value"]), 150) ?>
             </a>
           </span>
         </div>
        </li>
     <?php
      }
     ?>
  </ul>
</div>
<!-- /BLOCO RELACIONADAS -->