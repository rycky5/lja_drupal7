<?php
//Carregando as nodes para exibir
$nodesLoadeds = node_load_multiple($nids);
if (!empty($nodesLoadeds)):
    ?>
    <link rel="stylesheet" type="text/css" href="http://www.leiaja.com/sites/all/themes/leiaja2/css/boxes/box0011_4x7_1_normal/css/box.css?1501852371941">
            <style>
            section .inner_content .wgdlinha { margin:20px 0px; }
            section .inner_content .zbox h1 {
                width:auto !important;
                text-align:left !important;
                margin-bottom:0px !important;
                letter-spacing:normal !important;
            }

            </style>
    <div id="Linha0" class="wgdlinha">
        <div class="wgd12">
            <link rel="stylesheet" type="text/css" href="http://www.leiaja.com/sites/all/themes/leiaja2/css/boxes/box0_0x1_1_titulo/css/box.css?1503497124173">
            <div class="zbox abreBox divisorBoxTop wgd12 hgd1">
                <!-- abre o box -->
                <div class="wgd12 node" style="width:100%">
                    <h1><a class="titulo ">LEIAJÁ TAMB&Eacute;M</a></h1>
                </div><!-- /abre o box -->
            </div>
        </div>
        <?php
        foreach ($nodesLoadeds as $noticia) :
            //Carregando o objeto da node
            $objNode = $noticia;
            //Recuperando o campo da categoria
            $cadernoSettings = getCadernoNode($objNode->type);
            $cadernoField = $cadernoSettings['field'];
            $objCadernoCategoria = $objNode->$cadernoField;
            //Recuperando o objeto taxonomy
            $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0][tid]);
            $image = (!empty($objNode->field_capa)) ? $objNode->field_capa[key($objNode->field_capa)][0]['uri'] : $objNode->field_image[key($objNode->field_image)][0]['uri'];
            ?>

            <div class="wgdcol wgd4 <?= $cadernoField ?>">
                <div class="zbox wgd4 hgd7 box0011">
                    <ul>
                        <li class="wgd4 hgd7 node">
                            <div class="wgd4 hgd1">
                                <h1 class="chapeu">
                                    <a class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>"><?= $objTaxonomia->name ?></a>
                                </h1>
                            </div>
                            <div class="wgd4 hgd5">
                                <a class="img" href="<?= url('node/' . $objNode->nid) ?>">
                                    <img src="<?php print image_style_url('medium', $image); ?>" width="300" height="180" style="width: 300px; height: 180px;">
                                </a>
                            </div>
                            <div class="wgd4 hgd2">
                                <p>
                                    <a class="titulo undefined" href="<?= url('node/' . $objNode->nid) ?>"><?= $objNode->title ?></a>
                                </p>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
endif;