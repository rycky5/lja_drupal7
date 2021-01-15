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
$objResult = $view->result;

$strTexto = "Shop LeiaJá";
//Verificando se a variavel existe
if(variable_get("bloco_shop") != NULL || variable_get("bloco_shop") != ""){
    $strTexto = variable_get("bloco_shop");
}

?>

<!-- BLOCO SHOPPING PATROCINADO -->
<style>
.divShoppingPatrocinado { width:300px;height:600px;float:left; }
.divShoppingPatrocinado .divShoppingHeader { background-color:#ee1616;display:block;padding:7px 10px 3px 10px;text-align:right;height:20px;overflow:hidden; }
.divShoppingPatrocinado .divShoppingHeader  h2 { font:bold 18px arial;color:#fff;float:left;margin-top:-2px }
.divShoppingPatrocinado .divShoppingHeader em { color:#ffcccc;font:bold 16px arial; }
.divShoppingPatrocinado .divShoppingConteudo { border:1px solid #aaa;border-top:0px;display:block;height:569px;overflow:hidden; }
.divShoppingPatrocinado .liShopProduto { width:140px;height:181px;float:left;margin:7px 0px 0px 6px; }
.divShoppingPatrocinado .liShopProduto img { width:140px;height:85px;border-radius:3px;display:block;clear:both; }
.divShoppingPatrocinado .liShopProduto a { text-align:center;text-decoration:none;display:block; }
.divShoppingPatrocinado .liShopProduto a:hover { background-color:#f9f9ef }
.divShoppingPatrocinado .liShopProduto .shopTxt { color:#585b5e;display:block;padding:6px 0px;overflow:hidden;clear:both;width:100%;font:14px arial; }
.divShoppingPatrocinado .liShopProduto .shopTxt b { color:#000;font: bold 14px arial;padding-bottom:6px;display:block;}
.divShoppingPatrocinado .liShopProduto .shopBtn { background-color:#f1f1f1;display:block;border-bottom:2px solid #ccc;padding:3px 5px;border-top:1px solid #f4f4f4;border-radius:3px;clear:both;width:130px;color:#000;font-weight:bold;}

</style>

<div class="divShoppingPatrocinado">
  <div class="divShoppingHeader">
  <h2>Shopping</h2>
    <em><?= $strTexto ?></em>
  </div>
  <div class="divShoppingConteudo">
    <ul>
      <!-- Exebindo os produtos -->
      <?php
          foreach($objResult as $intChave => $objProduto){
      ?>
            <li class="liShopProduto">
              <a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$objProduto->tid)); ?>">
                  <img src="<?= image_static_url("medium", $objProduto->field_field_imagem_produto[0]["rendered"]["#item"]["uri"]) ?>" />
                <span class="shopTxt">
                  <b><?= $objProduto->taxonomy_term_data_name ?></b>
                  <?= limitaTextoTags(strip_tags($objProduto->taxonomy_term_data_description), 28, " ", "")  ?>
                </span>
                <span class="shopBtn">
                  <?= $objProduto->field_field_valor[0]["rendered"]["#markup"] ?>
                </span>
              </a>
            </li>
      <?php
          }
      ?>
    </ul>
  </div>
</div>
<!-- FIM DE BLOCO SHOPPING PATROCINADO -->  