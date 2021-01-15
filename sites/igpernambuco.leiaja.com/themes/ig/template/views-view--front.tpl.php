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
  
// Includes necessários
module_load_include('inc', 'montarcapa', 'montarcapa.api');

// Carregando as nodes da capa
$arrObjNode = api_getCapaAtiva();

// Tamanho do modal
$strModal = "?TB_iframe=true&width=906&height=585&modal=true";

?>
<!-- coluna -->
<div class="coluna col igd_12">
 <!-- box -->
 <div class="boxTit  box igd_12">
   <h2><a <?= $arrObjNode[0]->link ?>><?= $arrObjNode[0]->title ?></a></h2>
   <p><a <?= $arrObjNode[0]->link ?>><?= $arrObjNode[0]->summary ?></a></p>
 </div>
 <!-- /box -->
</div>
<!-- /coluna -->
<!-- linha --><div class="linha igd_12"></div><!-- /linha -->

<!-- coluna -->
<div class="coluna col igd_6">
 <!-- box -->
  <div class="box boxImg igd_6">
   <?php
    $strLink = $arrObjNode[1]->link;
    $linkSubCategoria = $arrObjNode[1]->linkSubCaderno;
   ?>
    <a <?= $strLink ?> >
      <?php 
        // Se a notícia for do leiaja
        if($arrObjNode[1]->origem == "default"){
          // Exibindo a imagem
          api_geraImagem($arrObjNode[1], 'home_destaque_ig', 321, 243);
        }else{
      ?>    <img width="321" height="243" src="<?= $arrObjNode[1]->imagem ?>" title="<?= addslashes($arrObjNode[1]->title) ?>" alt="<?= addslashes($arrObjNode[1]->title) ?>" />
      <?php } ?>
    </a>
   <h2><a href="<?= $linkSubCategoria ?>" ><?= $arrObjNode[1]->subcategoria ?></a></h2>
   <p><a <?= $strLink ?> ><?= $arrObjNode[1]->title ?></a></p>
  </div>
 <!-- /box -->
</div>
<!-- /coluna -->

<!-- coluna -->
<div class="coluna col igd_6">
  <?php
        for($intContador = 2; $intContador < 6; $intContador++){
          // Pegando os links
          $strLink = $arrObjNode[$intContador]->link;
          $linkChapeu = $arrObjNode[$intContador]->linkChapeu;
  ?>
          <!-- box -->
           <div class="box boxMiniTex igd_6">
             <h2><a href="<?= $linkChapeu ?>"><?= $arrObjNode[$intContador]->chapeu ?></a></h2>
             <p>
               <a <?= $strLink ?>>
                  <?= $arrObjNode[$intContador]->title ?>
               </a>
             </p>
           </div>
         <!-- /box -->
  <?php
        }
  ?>
 
</div>
<!-- /coluna -->
<!-- linha --><div class="linha igd_12"></div><!-- /linha -->

<?php
    // Pagando a node
  $objNodeMultimidia = "";
    $objNode = "";
    for($intContador = 6; $intContador < 9; $intContador++){
      $strLink = $arrObjNode[$intContador]->link;
      $linkSubCategoria = $arrObjNode[$intContador]->linkSubCaderno;
      $linkChapeu = $arrObjNode[$intContador]->linkChapeu;
?>
          <!-- coluna -->
          <div class="coluna col igd_4">  
           <div class="chapeu igd_4">
             <h1 class="chapeu ">
                   <?= $arrObjNode[$intContador]->subcategoria ?>
             </h1>
           </div>
           <!-- box -->
           <div class="box boxMiniImg igd_4">
             <a <?= $strLink ?>>
               <?php
                  // Se a notícia for do leiaja
                  if($arrObjNode[$intContador]->origem == "default"){
                    // Exibindo a imagem
                     api_geraImagem($arrObjNode[$intContador], 'home_ig_medio', 204, 153);
                  }else{
               ?>   
                    <img width="204" height="153" src="<?= $arrObjNode[$intContador]->imagem ?>" title="<?= addslashes($arrObjNode[$intContador]->title) ?>" alt="<?= addslashes($arrObjNode[$intContador]->title) ?>" />
                 <?php } ?>
             </a>
             <h2>
               <a href="<?= $linkChapeu ?>">
                       <?= $arrObjNode[$intContador]->chapeu?>
               </a>
             </h2>
             <p>
               <a <?= $strLink  ?>>
                 <?= $arrObjNode[$intContador]->title?>
               </a>
             </p>
           </div>
           <!-- /box -->
          </div>
          <!-- /coluna -->
<?php
    }
?>
