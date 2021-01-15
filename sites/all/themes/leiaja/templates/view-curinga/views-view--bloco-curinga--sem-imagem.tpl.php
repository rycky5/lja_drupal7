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

//Inclui o módulo de capa
module_load_include('inc', 'capa', 'capa.api');

//Obtendo os nids setados na capa
$nidPass = api_getNidIgnore();

echo "<pre>";
var_dump($nidPass);
die;

$arrNodeSemImagem = views_get_view_result("bloco_curinga", "sem_imagem", $nidPass);
$nidPass = getNidsByViews($arrNodeSemImagem);

$arrNodeImagem = views_get_view_result("bloco_curinga", "com_imagem", $nidPass);
$nidPass = $nidPass .','. getNidsByViews($arrNodeImagem);

//atualizando cache dos nids já usada da home
api_IgnoreBlocoGeral($nidPass);

?>

<!-- div container -->
<div style="display: block;clear:both">
    <!-- div colunas2_1 -->
    <div class="colunas2_1">
        <?php
        $arrObjSemImagem = $arrNodeSemImagem[0]->_field_data["nid"]["entity"];

        $strCategoria = api_getCategoriaNode($arrObjSemImagem->type);
        //Carrega objeto de taxonomy
        $arrObjTax = taxonomy_term_load($arrObjSemImagem->{$strCategoria}[key($arrObjSemImagem->{$strCategoria})][0]["tid"]);
        //Carrega a cor
        $strCor = getCores(str_replace("caderno_", "", $arrObjSemImagem->type));
        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
        //Url da categoria
        $strUrlCat = url(drupal_lookup_path('alias',"node/".$arrObjTax->tid));        
        ?>
        <div class="contentCol bordaBottom padding-bottom7 margin-top15">
            <strong>
                <a href="<?= $strUrlCat; ?>" class="linksStrong <?= $strCor; ?>"><?= $arrObjTax->name; ?></a>
            </strong>
            <h2 class="noticiaH2"><a class="links cinza" href="<?= $strUrlNode; ?>" title=""><span class="geo-chamada1-titulo"><?= truncate_utf8($arrObjSemImagem->title, 48); ?></span>
                </a>
            </h2>
        </div>

        <?php
        $arrObjSemImagem = $arrNodeSemImagem[1]->_field_data["nid"]["entity"];

        $strCategoria = api_getCategoriaNode($arrObjSemImagem->type);
        //Carrega objeto de taxonomy
        $arrObjTax = taxonomy_term_load($arrObjSemImagem->{$strCategoria}[key($arrObjSemImagem->{$strCategoria})][0]["tid"]);
        //Carrega a cor
        $strCor = getCores(str_replace("caderno_", "", $arrObjSemImagem->type));
        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
        //Url da categoria
        $strUrlCat = url(drupal_lookup_path('alias',"node/".$arrObjTax->tid));  
        ?>
        <div class="contentCol bordaBottom padding-bottom7 margin-top15">
            <strong>
                <a href="<?= $strUrlCat ?>" class="linksStrong <?= $strCor; ?>"><?= $arrObjTax->name; ?></a>
            </strong>
            <h3 class="noticiaH3"><a class="links cinza" href="<?= $strUrlNode ?>" title=""><span class="geo-chamada1-titulo"><?= truncate_utf8($arrObjSemImagem->title, 48); ?></span>
                </a>
            </h3>
            <?php 
            $arrObjSemImagem = $arrNodeSemImagem[2]->_field_data["nid"]["entity"]; 
            $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
            ?>
            <a href="<?= $strUrlNode; ?>" class="links cinza bullet"><span>&bull;</span> <?= truncate_utf8($arrObjSemImagem->title, 48); ?></a>
            <?php 
            $arrObjSemImagem = $arrNodeSemImagem[3]->_field_data["nid"]["entity"]; 
            $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
            ?>
            <a href="<?= $strUrlNode; ?>" class="links cinza bullet"><span>&bull;</span> <?= truncate_utf8($arrObjSemImagem->title, 48); ?></a>
        </div>
        <?php
        $arrObjImagem = $arrNodeImagem[0]->_field_data["nid"]["entity"];
        //Recupera o tipo da categoria
        $strCategoria = api_getCategoriaNode($arrObjImagem->type);
        //Carrega objeto taxonomy
        $arrObjTax = taxonomy_term_load($arrObjImagem->{$strCategoria}[key($arrObjImagem->{$strCategoria})][0]["tid"]);
        //Recupera cor
        $strCor =  getCores(str_replace("caderno_", "", $arrObjImagem->type));

        $imagem = $arrObjImagem->field_image[key($arrObjImagem->field_image)][0]["uri"];
        $imgCapa = $arrObjImagem->field_capa[key($arrObjImagem->field_capa)][0]["uri"];

        $img = (!empty($imgCapa)?$imgCapa:$imagem);
        
        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
        //Url da categoria
        $strUrlCat = url(drupal_lookup_path('alias',"node/".$arrObjTax->tid)); 
        ?>
        <div class="contentCol bordaBottom margin-top15">
            <a href="<?= $strUrlCat; ?>"><img src="<?= image_static_url('home_thumb', $img); ?>" width="148" height="111" title="" class="imgH4"></a>
            <div class="containerImgH4" style="width:135px;">
                <strong><a href="<?= $strUrlNode; ?>" class="linksStrong <?= $strCor ?>"><?= $arrObjTax->name; ?></a></strong>
                <h4 class="noticiaH4"><a href="#" class="links cinza"><?= truncate_utf8($arrObjImagem->title, 48); ?></a></h4>
            </div>
        </div>
        <?php
        $arrObjSemImagem = $arrNodeSemImagem[4]->_field_data["nid"]["entity"];

        $strCategoria = api_getCategoriaNode($arrObjSemImagem->type);
        //Carrega objeto de taxonomy
        $arrObjTax = taxonomy_term_load($arrObjSemImagem->{$strCategoria}[key($arrObjSemImagem->{$strCategoria})][0]["tid"]);
        //Carrega a cor
        $strCor = getCores(str_replace("caderno_", "", $arrObjSemImagem->type));
        
        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
        //Url da categoria
        $strUrlCat = url(drupal_lookup_path('alias',"node/".$arrObjTax->tid)); 
        ?>
        <div class="contentCol bordaBottom padding-bottom7 margin-top15">
            <strong>
                <a href="<?= $strUrlCat; ?>" class="linksStrong <?= $strCor; ?>"><?= $arrObjTax->name; ?></a>
            </strong>
            <h3 class="noticiaH3"><a class="links cinza" href="<?= $strUrlNode; ?>" title=""><span class="geo-chamada1-titulo"><?= truncate_utf8($arrObjSemImagem->title, 48); ?></span>
                </a>
            </h3>
            <?php 
            $arrObjSemImagem = $arrNodeSemImagem[5]->_field_data["nid"]["entity"]; 
            //Url do node
            $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
            ?>
            <a href="<?= $strUrlNode ?>" class="links cinza bullet"><span>&bull;</span> <?= truncate_utf8($arrObjSemImagem->title, 48); ?></a>
        </div>

    </div><!-- FIM colunas2_1 -->
    
    <!-- colunas2_1 -->
    <div class="colunas2_1 margin-left25">
        <?php
        $arrObjSemImagem = $arrNodeSemImagem[6]->_field_data["nid"]["entity"];

        $strCategoria = api_getCategoriaNode($arrObjSemImagem->type);
        //Carrega objeto de taxonomy
        $arrObjTax = taxonomy_term_load($arrObjSemImagem->{$strCategoria}[key($arrObjSemImagem->{$strCategoria})][0]["tid"]);
        //Carrega a cor
        $strCor = getCores(str_replace("caderno_", "", $arrObjSemImagem->type));
        
        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
        //Url da categoria
        $strUrlCat = url(drupal_lookup_path('alias',"node/".$arrObjTax->tid));
        ?>
        <div class="contentCol bordaBottom padding-bottom7 margin-top15">
            <strong>
                <a href="<?= $strUrlCat; ?>" class="linksStrong <?= $strCor; ?>"><?= $arrObjTax->name; ?></a>
            </strong>
            <h3 class="noticiaH3"><a class="links cinza" href="<?= $strUrlNode; ?>" title=""><span class="geo-chamada1-titulo"><?= truncate_utf8($arrObjSemImagem->title, 48); ?></span>
                </a>
            </h3>
            <?php 
            $arrObjSemImagem = $arrNodeSemImagem[7]->_field_data["nid"]["entity"]; 
            //Url do node
            $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
            ?>
            <a href="<?= $strUrlNode; ?>" class="links cinza bullet"><span>&bull;</span> <?= truncate_utf8($arrObjSemImagem->title, 48); ?></a>
            <?php 
            $arrObjSemImagem = $arrNodeSemImagem[8]->_field_data["nid"]["entity"]; 
            //Url do node
            $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
            ?>
            <a href="<?= $strUrlNode; ?>" class="links cinza bullet"><span>&bull;</span> <?= truncate_utf8($arrObjSemImagem->title, 48); ?></a>
            <?php 
            $arrObjSemImagem = $arrNodeSemImagem[9]->_field_data["nid"]["entity"]; 
            //Url do node
            $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
            ?>
            <a href="<?= $strUrlNode; ?>" class="links cinza bullet"><span>&bull;</span> <?= truncate_utf8($arrObjSemImagem->title, 48); ?></a>
        </div>
        <?php
        $arrObjSemImagem = $arrNodeSemImagem[10]->_field_data["nid"]["entity"];

        $strCategoria = api_getCategoriaNode($arrObjSemImagem->type);
        //Carrega objeto de taxonomy
        $arrObjTax = taxonomy_term_load($arrObjSemImagem->{$strCategoria}[key($arrObjSemImagem->{$strCategoria})][0]["tid"]);
        //Carrega a cor
        $strCor = getCores(str_replace("caderno_", "", $arrObjSemImagem->type));
        
        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
        //Url da categoria
        $strUrlCat = url(drupal_lookup_path('alias',"node/".$arrObjTax->tid));
        ?>
        <div class="contentCol bordaBottom padding-bottom7 margin-top15">
            <strong>
                <a href="<?= $strUrlCat; ?>" class="linksStrong <?= $strCor; ?>"><?= $arrObjTax->name; ?></a>
            </strong>
            <h3 class="noticiaH3"><a class="links cinza" href="<?= $strUrlNode; ?>" title=""><span class="geo-chamada1-titulo"><?= truncate_utf8($arrObjSemImagem->title, 48); ?></span>
                </a>
            </h3>
            <?php 
            $arrObjSemImagem = $arrNodeSemImagem[11]->_field_data["nid"]["entity"]; 
            //Url do node
            $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
            ?>
            <a href="<?= $strUrlNode; ?>" class="links cinza bullet"><span>&bull;</span> <?= truncate_utf8($arrObjSemImagem->title, 48); ?></a>
        </div>
    </div> <!-- FIM colunas2_1 -->
    
    <!-- colunas2_2 -->
    <div class="colunas2_2 margin-left25">
        <?php
        $arrObjImagem = $arrNodeImagem[1]->_field_data["nid"]["entity"];
        //Recupera o tipo da categoria
        $strCategoria = api_getCategoriaNode($arrObjImagem->type);
        //Carrega objeto taxonomy
        $arrObjTax = taxonomy_term_load($arrObjImagem->{$strCategoria}[key($arrObjImagem->{$strCategoria})][0]["tid"]);
        //Recupera cor
        $strCor =  getCores(str_replace("caderno_", "", $arrObjImagem->type));

        $imagem  = (isset($arrObjImagem->field_image[key($arrObjImagem->field_image)][0]["uri"])) ? $arrObjImagem->field_image[key($arrObjImagem->field_image)][0]["uri"] : '';
        $imgCapa = (isset($arrObjImagem->field_capa[key($arrObjImagem->field_capa)][0]["uri"]))   ? $arrObjImagem->field_capa[key($arrObjImagem->field_capa)][0]["uri"]   : '';

        $img = (!empty($imgCapa)?$imgCapa:$imagem);
        
        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
        //Url da categoria
        $strUrlCat = url(drupal_lookup_path('alias',"node/".$arrObjTax->tid));
        ?>
        <div class="contentCol bordaBottom padding-bottom15 margin-top15">
            <a href="<?= $strUrlCat; ?>"><img src="<?= image_static_url('home_thumb', $img); ?>" width="148" height="111" title="" class="imgH6Pequena"></a>
            <div class="containerImgH4" style="width:135px;">
                <strong><a href="<?= $strUrlNode; ?>" class="linksStrong <?= $strCor; ?>"><?= $arrObjTax->name; ?></a></strong>
                <h3 class="noticiaH3"><a href="#" class="links cinza"><?= truncate_utf8($arrObjImagem->title, 48); ?></a></h3>
            </div>
        </div>
        <?php
        $arrObjImagem = $arrNodeImagem[2]->_field_data["nid"]["entity"];
        //Recupera o tipo da categoria
        $strCategoria = api_getCategoriaNode($arrObjImagem->type);
        //Carrega objeto taxonomy
        $arrObjTax = taxonomy_term_load($arrObjImagem->{$strCategoria}[key($arrObjImagem->{$strCategoria})][0]["tid"]);
        //Recupera cor
        $strCor =  getCores(str_replace("caderno_", "", $arrObjImagem->type));

        $imagem = $arrObjImagem->field_image[key($arrObjImagem->field_image)][0]["uri"];
        $imgCapa = $arrObjImagem->field_capa[key($arrObjImagem->field_capa)][0]["uri"];

        $img = (!empty($imgCapa)?$imgCapa:$imagem);
        
        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias',"node/".$arrObjSemImagem->nid));
        //Url da categoria
        $strUrlCat = url(drupal_lookup_path('alias',"node/".$arrObjTax->tid));
        ?>
        <div class="contentCol bordaBottom padding-bottom15 margin-top15 margin-left25">
            <a href="<?= $strUrlCat; ?>"><img src="<?= image_static_url('home_thumb', $img); ?>" width="148" height="111" title="" class="imgH6Pequena"></a>
            <div class="containerImgH4" style="width:135px;">
                <strong><a href="<?= $strUrlNode; ?>" class="linksStrong <?= $strCor; ?>"><?= $arrObjTax->name; ?></a></strong>
                <h3 class="noticiaH3"><a href="#" class="links cinza"><?= truncate_utf8($arrObjImagem->title, 48); ?></a></h3>
            </div>
        </div>
  </div> <!-- FIM colunas2_2 -->

</div><!-- FIM de div container -->