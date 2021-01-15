<?php
if(filter_input(INPUT_GET, 'c', FILTER_SANITIZE_STRING) || filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING)):
//Recuperando o valor da view passando o caderno como parametro
$promovDestac1 = views_get_view_result('ultimas_noticias', 'promov_destac_1', (!empty($_GET['c'])) ? $_GET['c'] : 'all', $_GET['t']);

//Carregando o objeto da node
$objNode = node_load($promovDestac1[0]->nid);
//Recuperando o campo da categoria
$cadernoSettings = getCadernoNode($objNode->type);
$cadernoField = $cadernoSettings['field'];
$objCadernoCategoria = $objNode->$cadernoField;
//Recuperando o objeto taxonomy
$objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0][tid]);
?>
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/estilo.css">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/grid.css">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/novacapa.css">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/font-awesome.css">
        <script type="text/javascript" src="/sites/all/themes/leiaja2/css/boxes/jquerycapa.min.js"></script>
        <script type="text/javascript" src="/sites/all/themes/leiaja2/js/script.js"></script>
        <script type="text/javascript" src="/sites/all/themes/leiaja2/css/boxes/boxes.js"></script>

    <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0026_12x8_1_iframe/css/box.css" />

    <div class="wgd12 hgd8 box0026 <?= $cadernoField ?>" style="margin:0px;">
        <style type="text/css"> .zbox { padding:10px 0px;margin:0px }</style>
        <div class="wgdcol wgd4 iframeinterna" style="margin-left:0px">
            <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0024_4x4_1_texto/css/box.css" />
            <div class="zbox wgd4 hgd4 box0024" style="padding-top:0px;">
                <div class="wgd4 hgd4 node">
                    <div class="wgd4 hgd1">
                        <h1><a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>"><?= $objTaxonomia->name ?></a></h1>
                    </div>
                    <div class="wgd4 hgd3"><a target="_parent" href="<?= url('node/' . $objNode->nid) ?>" class="titulo undefined"><?= $objNode->title ?></a>
                    </div>
                </div>
            </div>
            <?php
            //Recuperando o valor da view passando o caderno como parametro
            $promovDestac4 = views_get_view_result('ultimas_noticias', 'promov_destac_4', (!empty($_GET['c'])) ? $_GET['c'] : 'all', $_GET['t']);
            //Recuperando apenas os nids
            $nids = array();
            foreach ($promovDestac4 as $value) {
                $nids[] = $value->nid;
            }
            //Carregando os objetos das nodes
            $objNodes = node_load_multiple($nids);                                
            ?>
            <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0003_4x2_1_normal/css/box.css" />
            <?php
            //Recuperando o campo da categoria
            $cadernoSettings = getCadernoNode($objNodes[$nids[0]]->type);
            $cadernoField = $cadernoSettings['field'];
            $objCadernoCategoria = $objNodes[$nids[0]]->$cadernoField;
            //Recuperando o objeto taxonomy
            $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0][tid]);

            $urlNode = url('node/' . $objNodes[$nids[0]]->nid);

            //recuperando as imagens
            $image = (!empty($objNodes[$nids[0]]->field_capa)) ? $objNodes[$nids[0]]->field_capa[key($objNodes[$nids[0]]->field_capa)][0]['uri'] : $objNodes[$nids[0]]->field_image[key($objNodes[$nids[0]]->field_image)][0]['uri'];
            ?>
            <div class="zbox wgd4 hgd2 box0003 boxNotList1 <?= $cadernoField ?>">
                <ul>
                    <li class="wgd4 hgd2 node">
                        <a target="_parent" class="img" href="<?= $urlNode ?>">
                            <img src="<?= image_style_url('73x55', $image) ?>" width="73" height="55" style="width: 73px; height: 55px;">
                        </a>
                        <h1><a target="_parent" class="titulo undefined" href="<?= $urlNode ?>"><?= $objNodes[$nids[0]]->title ?></a></h1>
                        <span><a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>"><?= $objTaxonomia->name ?></a></span>
                    </li>
                </ul>
            </div>
            <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0003_4x2_1_normal/css/box.css" />
            <?php
            //Recuperando o campo da categoria
            $cadernoSettings = getCadernoNode($objNodes[$nids[1]]->type);
            $cadernoField = $cadernoSettings['field'];
            $objCadernoCategoria = $objNodes[$nids[1]]->$cadernoField;
            //Recuperando o objeto taxonomy
            $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0][tid]);

            $urlNode = url('node/' . $objNodes[$nids[1]]->nid);

            //recuperando as imagens
            $image = (!empty($objNodes[$nids[1]]->field_capa)) ? $objNodes[$nids[1]]->field_capa[key($objNodes[$nids[1]]->field_capa)][0]['uri'] : $objNodes[$nids[1]]->field_image[key($objNodes[$nids[1]]->field_image)][0]['uri'];
            ?>
            <div class="zbox wgd4 hgd2 box0003 boxNotList1 <?= $cadernoField ?>">
                <ul>
                    <li class="wgd4 hgd2 node">
                        <a target="_parent" class="img" href="<?= $urlNode ?>">
                            <img src="<?= image_style_url('73x55', $image) ?>" width="73" height="55" style="width: 73px; height: 55px;">
                        </a>
                        <h1><a target="_parent" class="titulo undefined" href="<?= $urlNode ?>"><?= $objNodes[$nids[1]]->title ?></a></h1>
                        <span><a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>"><?= $objTaxonomia->name ?></a></span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="wgdcol wgd4">
            <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0002_4x8_1_normal/css/box.css" />
            <?php
            //Recuperando o campo da categoria
            $cadernoSettings = getCadernoNode($objNodes[$nids[2]]->type);
            $cadernoField = $cadernoSettings['field'];
            $objCadernoCategoria = $objNodes[$nids[2]]->$cadernoField;
            //Recuperando o objeto taxonomy
            $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0][tid]);

            $urlNode = url('node/' . $objNodes[$nids[2]]->nid);

            //recuperando as imagens
            $image = (!empty($objNodes[$nids[2]]->field_capa)) ? $objNodes[$nids[2]]->field_capa[key($objNodes[$nids[2]]->field_capa)][0]['uri'] : $objNodes[$nids[2]]->field_image[key($objNodes[$nids[2]]->field_image)][0]['uri'];
            ?>
            <div class="zbox wgd4 hgd8 box0002 <?= $cadernoField ?>"  style="padding-top:0px;">
                <ul>
                    <li class="wgd4 hgd8 node">
                        <div class="wgd4 hgd1">
                            <h1 class="chapeu">
                                <a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>"><?= $objTaxonomia->name ?></a>
                            </h1>
                        </div>
                        <div class="wgd4 hgd6">
                            <a target="_parent" class="img" href="<?= $urlNode ?>">
                                <img src="<?= image_style_url('medium', $image) ?>" width="300" height="220" style="width: 300px; height: 220px;">
                            </a>
                        </div>
                        <div class="wgd4 hgd2">
                            <p>
                                <a target="_parent" class="titulo undefined" href="<?= $urlNode ?>"><?= $objNodes[$nids[2]]->title ?></a>
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="wgdcol wgd4" style="margin-right:0px">
            <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0002_4x8_1_normal/css/box.css" />
            <?php
            //Recuperando o campo da categoria
            $cadernoSettings = getCadernoNode($objNodes[$nids[3]]->type);
            $cadernoField = $cadernoSettings['field'];
            $objCadernoCategoria = $objNodes[$nids[3]]->$cadernoField;
            //Recuperando o objeto taxonomy
            $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0][tid]);

            $urlNode = url('node/' . $objNodes[$nids[3]]->nid);

            //recuperando as imagens
            $image = (!empty($objNodes[$nids[3]]->field_capa)) ? $objNodes[$nids[3]]->field_capa[key($objNodes[$nids[3]]->field_capa)][0]['uri'] : $objNodes[$nids[3]]->field_image[key($objNodes[$nids[3]]->field_image)][0]['uri'];
            ?>
            <div class="zbox wgd4 hgd8 box0002 <?= $cadernoField ?>" style="padding-top:0px;">
                <ul>
                    <li class="wgd4 hgd8 node">
                        <div class="wgd4 hgd1">
                            <h1 class="chapeu">
                                <a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>"><?= $objTaxonomia->name ?></a>
                            </h1>
                        </div>
                        <div class="wgd4 hgd6">
                            <a target="_parent" class="img" href="<?= $urlNode ?>">
                                <img src="<?= image_style_url('medium', $image) ?>" width="300" height="220" style="width: 300px; height: 220px;">
                            </a>
                        </div>
                        <div class="wgd4 hgd2">
                            <p>
                                <a target="_parent" class="titulo undefined" href="<?= $urlNode ?>"><?= $objNodes[$nids[3]]->title ?></a>
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

<?php
endif;