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

//echo "<pre>";
//var_dump($nidPass);
//die;

$arrNodeSemImagem = views_get_view_result("bloco_coringa_home", "sem_imagem", $nidPass);
$nidPass = getNidsByViews($arrNodeSemImagem);

$arrNodeImagem = views_get_view_result("bloco_coringa_home", "com_imagem", $nidPass);
$nidPass = $nidPass . ',' . getNidsByViews($arrNodeImagem);

//atualizando cache dos nids já usada da home
api_IgnoreBlocoGeral($nidPass);
?>

<!-- div container -->
<div style="display: block;clear:both">
    <h2 class="tituloH2"><a href="/noticias" class="vermelho" title="Cultura">Notícias</a></h2>
    <!-- div colunas2_1 -->
    <div class="colunas2_1">
        <?php
        $arrObjSemImagem = $arrNodeSemImagem[0]->_field_data["nid"]["entity"];

        //Carrega a cor
        $strCor = getCores(str_replace("caderno_", "", $arrObjSemImagem->type));
        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjSemImagem->nid));
        //Recupera o titulo da noticia
        $strTitle = (empty($arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"])) ? $arrObjSemImagem->title : $arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"];
        ?>
        <div class="contentCol bordaBottom padding-bottom7 margin-top15">
            <strong>
                <a href="<?= url(drupal_lookup_path('alias', $arrNodeSemImagem[0]->field_field_catnoticia[0]["rendered"]["#href"])); ?>" class="linksStrong <?= $strCor; ?>"><?= $arrNodeSemImagem[0]->field_field_catnoticia[0]["rendered"]["#title"]; ?></a>
            </strong>
            <h2 class="noticiaH2"><a class="links cinza" href="<?= $strUrlNode; ?>" title=""><span class="geo-chamada1-titulo"><?= $strTitle; ?></span>
                </a>
            </h2>
        </div>

        <?php
        $arrObjSemImagem = $arrNodeSemImagem[1]->_field_data["nid"]["entity"];

        //Carrega a cor
        $strCor = getCores(str_replace("caderno_", "", $arrObjSemImagem->type));
        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjSemImagem->nid));
        //Recupera o titulo da noticia
        $strTitle = (empty($arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"])) ? $arrObjSemImagem->title : $arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"];
        ?>
        <div class="contentCol bordaBottom padding-bottom7 margin-top15">
            <strong>
                <a href="<?= url(drupal_lookup_path('alias', $arrNodeSemImagem[1]->field_field_catnoticia[0]["rendered"]["#href"])); ?>" class="linksStrong <?= $strCor; ?>"><?= $arrNodeSemImagem[1]->field_field_catnoticia[0]["rendered"]["#title"]; ?></a>
            </strong>
            <h3 class="noticiaH3"><a class="links cinza" href="<?= $strUrlNode ?>" title=""><span class="geo-chamada1-titulo"><?= $strTitle; ?></span>
                </a>
            </h3>
            <?php
            $arrObjSemImagem = $arrNodeSemImagem[2]->_field_data["nid"]["entity"];
            $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjSemImagem->nid));
            //Recupera o titulo da noticia
            $strTitle = (empty($arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"])) ? $arrObjSemImagem->title : $arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"];
            ?>
            <a style="display: block; min-width: 300px;" href="<?= $strUrlNode; ?>" class="links cinza bullet"><span>&bull;</span> <?= $strTitle; ?></a>
            <?php
            $arrObjSemImagem = $arrNodeSemImagem[3]->_field_data["nid"]["entity"];
            $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjSemImagem->nid));
            //Recupera o titulo da noticia
            $strTitle = (empty($arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"])) ? $arrObjSemImagem->title : $arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"];
            ?>
            <a style="display: block; min-width: 300px;" href="<?= $strUrlNode; ?>" class="links cinza bullet"><span>&bull;</span> <?= $strTitle; ?></a>
        </div>
        <?php
        $arrObjImagem = $arrNodeImagem[0]->_field_data["nid"]["entity"];
        //Recupera cor
        $strCor = getCores(str_replace("caderno_", "", $arrObjImagem->type));

        $imagem = $arrObjImagem->field_image[key($arrObjImagem->field_image)][0]["uri"];
        $imgCapa = $arrObjImagem->field_capa[key($arrObjImagem->field_capa)][0]["uri"];

        $img = (!empty($imgCapa) ? $imgCapa : $imagem);

        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjImagem->nid));
        //Recupera o titulo da noticia
        $strTitle = (empty($arrObjImagem->field_chamada_capa[key($arrObjImagem->field_chamada_capa)][0]["value"])) ? $arrObjImagem->title : $arrObjImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"];
        ?>
        <div class="contentCol bordaBottom margin-top15">
            <a href="<?= $strUrlNode; ?>"><img src="<?= image_static_url('home_thumb', $img); ?>" width="148" height="111" title="" class="imgH4"></a>
            <div class="containerImgH4" style="width:135px;">
                <strong><a href="<?= url(drupal_lookup_path('alias', $arrNodeImagem[0]->field_field_catnoticia[0]["rendered"]["#href"])); ?>" class="linksStrong <?= $strCor ?>"><?= $arrNodeImagem[0]->field_field_catnoticia[0]["rendered"]["#title"]; ?></a></strong>
                <h4 class="noticiaH4"><a href="<?= $strUrlNode; ?>" class="links cinza"><?= $strTitle; ?></a></h4>
            </div>
        </div>
        <?php
        $arrObjSemImagem = $arrNodeSemImagem[4]->_field_data["nid"]["entity"];

        //Carrega a cor
        $strCor = getCores(str_replace("caderno_", "", $arrObjSemImagem->type));

        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjSemImagem->nid));
        //Recupera o titulo da noticia
        $strTitle = (empty($arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"])) ? $arrObjSemImagem->title : $arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"];
        ?>
        <div class="contentCol bordaBottom padding-bottom7 margin-top15">
            <strong>
                <a href="<?= url(drupal_lookup_path('alias', $arrNodeSemImagem[4]->field_field_catnoticia[0]["rendered"]["#href"])); ?>" class="linksStrong <?= $strCor; ?>"><?= $arrNodeSemImagem[4]->field_field_catnoticia[0]["rendered"]["#title"]; ?></a>
            </strong>
            <h3 class="noticiaH3"><a class="links cinza" href="<?= $strUrlNode; ?>" title=""><span class="geo-chamada1-titulo"><?= $strTitle; ?></span>
                </a>
            </h3>
            <?php
            $arrObjSemImagem = $arrNodeSemImagem[5]->_field_data["nid"]["entity"];
            //Url do node
            $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjSemImagem->nid));
            //Recupera o titulo da noticia
            $strTitle = (empty($arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"])) ? $arrObjSemImagem->title : $arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"];
            ?>
            <a style="display: block; min-width: 300px;" href="<?= $strUrlNode ?>" class="links cinza bullet"><span>&bull;</span> <?= $strTitle; ?></a>
        </div>

    </div><!-- FIM colunas2_1 -->

    <!-- colunas2_1 -->
    <div class="colunas2_1 margin-left25">
        <?php
        $arrObjSemImagem = $arrNodeSemImagem[6]->_field_data["nid"]["entity"];

        //Carrega a cor
        $strCor = getCores(str_replace("caderno_", "", $arrObjSemImagem->type));

        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjSemImagem->nid));
        //Recupera o titulo da noticia
        $strTitle = (empty($arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"])) ? $arrObjSemImagem->title : $arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"];
        ?>
        <div class="contentCol bordaBottom padding-bottom7 margin-top15">
            <strong>
                <a href="<?= url(drupal_lookup_path('alias', $arrNodeSemImagem[6]->field_field_catnoticia[0]["rendered"]["#href"])); ?>" class="linksStrong <?= $strCor; ?>"><?= $arrNodeSemImagem[6]->field_field_catnoticia[0]["rendered"]["#title"]; ?></a>
            </strong>
            <h3 class="noticiaH3"><a class="links cinza" href="<?= $strUrlNode; ?>" title=""><span class="geo-chamada1-titulo"><?= $strTitle; ?></span>
                </a>
            </h3>
            <?php
            $arrObjSemImagem = $arrNodeSemImagem[7]->_field_data["nid"]["entity"];
            //Url do node
            $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjSemImagem->nid));
            //Recupera o titulo da noticia
            $strTitle = (empty($arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"])) ? $arrObjSemImagem->title : $arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"];
            ?>
            <a style="display: block; min-width: 300px;" href="<?= $strUrlNode; ?>" class="links cinza bullet"><span>&bull;</span> <?= $strTitle; ?></a>
            <?php
            $arrObjSemImagem = $arrNodeSemImagem[8]->_field_data["nid"]["entity"];
            //Url do node
            $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjSemImagem->nid));
            //Recupera o titulo da noticia
            $strTitle = (empty($arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"])) ? $arrObjSemImagem->title : $arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"];
            ?>
            <a style="display: block; min-width: 300px;" href="<?= $strUrlNode; ?>" class="links cinza bullet"><span>&bull;</span> <?= $strTitle; ?></a>
            <?php
            $arrObjSemImagem = $arrNodeSemImagem[9]->_field_data["nid"]["entity"];
            //Url do node
            $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjSemImagem->nid));
            //Recupera o titulo da noticia
            $strTitle = (empty($arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"])) ? $arrObjSemImagem->title : $arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"];
            ?>
            <a style="display: block; min-width: 300px;" href="<?= $strUrlNode; ?>" class="links cinza bullet"><span>&bull;</span> <?= $strTitle; ?></a>
        </div>
        <?php
        $arrObjSemImagem = $arrNodeSemImagem[10]->_field_data["nid"]["entity"];

        //Carrega a cor
        $strCor = getCores(str_replace("caderno_", "", $arrObjSemImagem->type));

        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjSemImagem->nid));
        //Recupera o titulo da noticia
        $strTitle = (empty($arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"])) ? $arrObjSemImagem->title : $arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"];
        ?>
        <div class="contentCol bordaBottom padding-bottom7 margin-top15">
            <strong>
                <a href="<?= url(drupal_lookup_path('alias', $arrNodeSemImagem[10]->field_field_catnoticia[0]["rendered"]["#href"])); ?>" class="linksStrong <?= $strCor; ?>"><?= $arrNodeSemImagem[10]->field_field_catnoticia[0]["rendered"]["#title"]; ?></a>
            </strong>
            <h3 class="noticiaH3"><a class="links cinza" href="<?= $strUrlNode; ?>" title=""><span class="geo-chamada1-titulo"><?= $strTitle; ?></span>
                </a>
            </h3>
            <?php
            $arrObjSemImagem = $arrNodeSemImagem[11]->_field_data["nid"]["entity"];
            //Url do node
            $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjSemImagem->nid));
            //Recupera o titulo da noticia
            $strTitle = (empty($arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"])) ? $arrObjSemImagem->title : $arrObjSemImagem->field_chamada_capa[key($arrObjSemImagem->field_chamada_capa)][0]["value"];
            ?>
            <a href="<?= $strUrlNode; ?>" class="links cinza bullet"><span>&bull;</span> <?= $strTitle; ?></a>
        </div>
    </div> <!-- FIM colunas2_1 -->

    <!-- colunas2_2 -->
    <div class="colunas2_2 margin-left25">
        <?php
        $arrObjImagem = $arrNodeImagem[1]->_field_data["nid"]["entity"];
        //Recupera cor
        $strCor = getCores(str_replace("caderno_", "", $arrObjImagem->type));

        $imagem = $arrObjImagem->field_image[key($arrObjImagem->field_image)][0]["uri"];
        $imgCapa = $arrObjImagem->field_capa[key($arrObjImagem->field_capa)][0]["uri"];

        $img = (!empty($imgCapa) ? $imgCapa : $imagem);

        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjImagem->nid));
        //Recupera o titulo da noticia
        $strTitle = (empty($arrObjImagem->field_chamada_capa[key($arrObjImagem->field_chamada_capa)][0]["value"])) ? $arrObjImagem->title : $arrObjImagem->field_chamada_capa[key($arrObjImagem->field_chamada_capa)][0]["value"];
        ?>
        <div class="contentCol bordaBottom padding-bottom15 margin-top15">
            <a href="<?= $strUrlNode; ?>"><img src="<?= image_static_url('home_thumb', $img); ?>" width="148" height="111" title="" class="imgH6Pequena"></a>
            <div class="containerImgH4" style="width:135px;">
                <strong><a href="<?= url(drupal_lookup_path('alias', $arrNodeImagem[1]->field_field_catnoticia[0]["rendered"]["#href"])); ?>" class="linksStrong <?= $strCor; ?>"><?= $arrNodeImagem[1]->field_field_catnoticia[0]["rendered"]["#title"]; ?></a></strong>
                <h3 class="noticiaH3"><a href="<?= $strUrlNode; ?>" class="links cinza"><?= $strTitle; ?></a></h3>
            </div>
        </div>
        <?php
        $arrObjImagem = $arrNodeImagem[2]->_field_data["nid"]["entity"];
        //Recupera cor
        $strCor = getCores(str_replace("caderno_", "", $arrObjImagem->type));

        $imagem = (isset($arrObjImagem->field_image[key($arrObjImagem->field_image)][0]["uri"])) ? $arrObjImagem->field_image[key($arrObjImagem->field_image)][0]["uri"] : '';
        $imgCapa = (isset($arrObjImagem->field_capa[key($arrObjImagem->field_capa)][0]["uri"])) ? $arrObjImagem->field_capa[key($arrObjImagem->field_capa)][0]["uri"] : '';

        $img = (!empty($imgCapa) ? $imgCapa : $imagem);

        //Url do node
        $strUrlNode = url(drupal_lookup_path('alias', "node/" . $arrObjImagem->nid));
        //Recupera o titulo da noticia
        $strTitle = (empty($arrObjImagem->field_chamada_capa[key($arrObjImagem->field_chamada_capa)][0]["value"])) ? $arrObjImagem->title : $arrObjImagem->field_chamada_capa[key($arrObjImagem->field_chamada_capa)][0]["value"];
        
        ?>
        <div class="contentCol bordaBottom padding-bottom15 margin-top15 margin-left25">
            <a href="<?= $strUrlNode; ?>"><img src="<?= image_static_url('home_thumb', $img); ?>" width="148" height="111" title="" class="imgH6Pequena"></a>
            <div class="containerImgH4" style="width:135px;">
                <strong><a href="<?= url(drupal_lookup_path('alias', $arrNodeImagem[2]->field_field_catnoticia[0]["rendered"]["#href"])); ?>" class="linksStrong <?= $strCor; ?>"><?= $arrNodeImagem[2]->field_field_catnoticia[0]["rendered"]["#title"]; ?></a></strong>
                <h3 class="noticiaH3"><a href="<?= $strUrlNode; ?>" class="links cinza"><?= $strTitle; ?></a></h3>
            </div>
        </div>
    </div> <!-- FIM colunas2_2 -->

</div><!-- FIM de div container -->