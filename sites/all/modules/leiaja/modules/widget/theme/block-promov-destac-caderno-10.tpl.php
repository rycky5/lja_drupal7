<?php
if(filter_input(INPUT_GET, 'c', FILTER_SANITIZE_STRING) || filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING)):
    
    //Recuperando o valor da view passando o caderno como parametro
    $promovDestac4SemImg = views_get_view_result('ultimas_noticias', 'promov_destac_4_sem_img_caderno', (!empty($_GET['c'])) ? $_GET['c'] : 'all', $_GET['t']);
    
    $nids4SemImg = array();
    foreach ($promovDestac4SemImg as $value) {
        $nids4SemImg[] = $value->nid;
    }
    
    //Carregando os objetos das nodes
    $objNodesSemImg = node_load_multiple($nids4SemImg);
 
    //Recuperando o valor da view passando o caderno como parametro
    $promovDestac6ComImg = views_get_view_result('ultimas_noticias', 'promov_destac_6_com_img_caderno', (!empty($_GET['c'])) ? $_GET['c'] : 'all', $_GET['t']);
    $nids6ComImg = array();
    foreach ($promovDestac6ComImg as $value) {
        $nids6ComImg[] = $value->nid;
    }
   
    //Carregando os objetos das nodes
    $objNodesComImg = node_load_multiple($nids6ComImg);
    //Recuperando o campo da categoria
    $cadernoSettings = getCadernoNode($objNodesSemImg[key($objNodesSemImg)]->type);
    $cadernoField = $cadernoSettings['field'];

?>
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/estilo.css">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/grid.css">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/novacapa.css">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/font-awesome.css">
        <script type="text/javascript" src="/sites/all/themes/leiaja2/css/boxes/jquerycapa.min.js"></script>
        <script type="text/javascript" src="/sites/all/themes/leiaja2/js/script.js"></script>
        <script type="text/javascript" src="/sites/all/themes/leiaja2/css/boxes/boxes.js"></script>


<div class="wgdlinha" style="margin:0px;width:940px;overflow:hidden;">
<style type="text/css">
  .zbox {
    padding:10px 0px;
    margin:0px }
</style>

    <?php
    //Recuperando o campo da categoria
    $cadernoSettings = getCadernoNode($objNodesSemImg[$nids4SemImg[0]]->type);
    $cadernoField = $cadernoSettings['field'];
    $objCadernoCategoria = $objNodesSemImg[$nids4SemImg[0]]->$cadernoField;
    //Recuperando o objeto taxonomy
    $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0]['tid']);

    $urlNode = url('node/' . $objNodesSemImg[$nids4SemImg[0]]->nid);
    ?>
    <div class="wgdcol wgd12" style="margin:0px;overflow:hidden">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0023_12x2_1_texto/css/box.css?1415646571560">
        <div class="zbox wgd12 hgd2 box0023 <?= $cadernoField ?>" style="margin:0px;">
            <div class="wgd12 hgd2 node" style="margin:0px;">
                
                <div class="wgd12 hgd1">
                    <h1>
                    <a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>">
                    <?= $objTaxonomia->name ?> </a>
                    </h1>
                </div>
                <div class="wgd12 hgd1">
                    <a target="_parent" href="<?= $urlNode ?>" class="titulo">
                    <?= $objNodesSemImg[$nids4SemImg[0]]->title ?> </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wgdlinha" style="margin:0px;width:940px;overflow:hidden;">
    <?php
    //Recuperando o campo da categoria
    $cadernoSettings = getCadernoNode($objNodesSemImg[$nids4SemImg[1]]->type);
    $cadernoField = $cadernoSettings['field'];
    $objCadernoCategoria = $objNodesSemImg[$nids4SemImg[1]]->$cadernoField;
    //Recuperando o objeto taxonomy
    $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0]['tid']);

    $urlNode = url('node/' . $objNodesSemImg[$nids4SemImg[1]]->nid);
    ?>
    <div class="wgdcol wgd4" style="margin-left:0px">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0030_4x3_1_texto/css/box.css?1415646571562">
        <div class="zbox wgd4 hgd3 box0030 <?= $cadernoField ?>">
            <div class="wgd4 hgd3 node">
                <div class="wgd4 hgd1">
                    <h1>
                    <a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>">
                    <?= $objTaxonomia->name ?></a>
                    </h1>
                </div>
                <div class="wgd4 hgd2">
                    <a target="_parent" href="<?= $urlNode ?>" class="titulo">
                    <?= $objNodesSemImg[$nids4SemImg[1]]->title ?> </a>
                </div>
            </div>
        </div>
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0007_4x5_1_normal/css/box.css?1415646571563">
        <?php
        //Recuperando o campo da categoria
        $cadernoSettings = getCadernoNode($objNodesComImg[$nids6ComImg[0]]->type);
        $cadernoField = $cadernoSettings['field'];
        $objCadernoCategoria = $objNodesComImg[$nids6ComImg[0]]->$cadernoField;
        //Recuperando o objeto taxonomy
        $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0]['tid']);

        $urlNode = url('node/' . $objNodesComImg[$nids6ComImg[0]]->nid);

        //recuperando as imagens
        $image = (!empty($objNodesComImg[$nids6ComImg[0]]->field_capa)) ? $objNodesComImg[$nids6ComImg[0]]->field_capa[key($objNodesComImg[$nids6ComImg[0]]->field_capa)][0]['uri'] : $objNodesComImg[$nids6ComImg[0]]->field_image[key($objNodesComImg[$nids6ComImg[0]]->field_image)][0]['uri'];
        ?>
        <div class="zbox wgd4 hgd5 boxVerticalImagem box0007 <?= $cadernoField ?>">
            <div class="wgd4 hgd5 destaque node">
                <div class="wgd4 hgd1">
                    <h1>
                    <a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>">
                    <?= $objTaxonomia->name ?> </a>
                    </h1>
                </div>
                <div class="wgd4 hgd3">
                    <a target="_parent" class="img" href="<?= $urlNode ?>">
                        <img src="<?= image_style_url('300x100', $image) ?>" width="300" height="100">
                    </a>
                </div>
                <div class="wgd4 hgd2">
                    <p>
                        <a target="_parent" class="titulo" href="<?= $urlNode ?>">
                        <?= $objNodesComImg[$nids6ComImg[0]]->title ?> </a>
                    </p>
                </div>
            </div>
        </div>
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0010_4x3_1_normal/css/box.css?1415646571565">
        <?php
        //Recuperando o campo da categoria
        $cadernoSettings = getCadernoNode($objNodesComImg[$nids6ComImg[1]]->type);

        $cadernoField = $cadernoSettings['field'];
        $objCadernoCategoria = $objNodesComImg[$nids6ComImg[1]]->$cadernoField;
        //Recuperando o objeto taxonomy
        $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0]['tid']);

        $urlNode = url('node/' . $objNodesComImg[$nids6ComImg[1]]->nid);

        //recuperando as imagens
        $image = (!empty($objNodesComImg[$nids6ComImg[1]]->field_capa)) ? $objNodesComImg[$nids6ComImg[1]]->field_capa[key($objNodesComImg[$nids6ComImg[1]]->field_capa)][0]['uri'] : $objNodesComImg[$nids6ComImg[1]]->field_image[key($objNodesComImg[$nids6ComImg[1]]->field_image)][0]['uri'];
        ?>
        <div class="zbox wgd4 hgd3 boxNotListHor box0010 <?= $cadernoField ?>">
            <ul>
                <li class="wgd4 hgd3 node">
                <h1>
                <a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>">
                <?= $objTaxonomia->name ?> </a>
                </h1>
                <a target="_parent" class="img" href="<?= $urlNode ?>">
                <img src="<?= image_style_url('110x75', $image) ?>" width="110" height="75">
                </a>
                <p>
                    <a target="_parent" class="titulo" href="<?= $urlNode ?>">
                    <?= $objNodesComImg[$nids6ComImg[1]]->title ?> </a>
                </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="wgdcol wgd4">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0002_4x8_1_normal/css/box.css?1415646571566">
        <?php
        //Recuperando o campo da categoria
        $cadernoSettings = getCadernoNode($objNodesComImg[$nids6ComImg[2]]->type);
        $cadernoField = $cadernoSettings['field'];
        $objCadernoCategoria = $objNodesComImg[$nids6ComImg[2]]->$cadernoField;
        //Recuperando o objeto taxonomy
        $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0]['tid']);

        $urlNode = url('node/' . $objNodesComImg[$nids6ComImg[2]]->nid);

        //recuperando as imagens
        $image = (!empty($objNodesComImg[$nids6ComImg[2]]->field_capa)) ? $objNodesComImg[$nids6ComImg[2]]->field_capa[key($objNodesComImg[$nids6ComImg[2]]->field_capa)][0]['uri'] : $objNodesComImg[$nids6ComImg[2]]->field_image[key($objNodesComImg[$nids6ComImg[2]]->field_image)][0]['uri'];
        ?>
        <div class="zbox wgd4 hgd8 box0002 boxPimg1 <?= $cadernoField ?>">
            <ul>
                <li class="wgd4 hgd8 node">
                <div class="wgd4 hgd1">
                    <h1 class="chapeu">
                    <a class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>">
                    <?= $objTaxonomia->name ?> </a>
                    </h1>
                </div>
                <div class="wgd4 hgd6">
                    <a target="_parent" class="img" href="<?= $urlNode ?>">
                    <img src="<?= image_style_url('medium', $image) ?>" width="300" height="220">
                    </a>
                </div>
                <div class="wgd4 hgd2">
                    <p>
                        <a target="_parent" class="titulo" href="<?= $urlNode ?>">
                        <?= $objNodesComImg[$nids6ComImg[2]]->title ?> </a>
                    </p>
                </div>
                </li>
            </ul>
        </div>
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0010_4x3_1_normal/css/box.css?1415646571567">
        <?php
        //Recuperando o campo da categoria
        $cadernoSettings = getCadernoNode($objNodesComImg[$nids6ComImg[3]]->type);
        $cadernoField = $cadernoSettings['field'];
        $objCadernoCategoria = $objNodesComImg[$nids6ComImg[3]]->$cadernoField;
        //Recuperando o objeto taxonomy
        $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0]['tid']);

        $urlNode = url('node/' . $objNodesComImg[$nids6ComImg[3]]->nid);

        //recuperando as imagens
        $image = (!empty($objNodesComImg[$nids6ComImg[3]]->field_capa)) ? $objNodesComImg[$nids6ComImg[3]]->field_capa[key($objNodesComImg[$nids6ComImg[3]]->field_capa)][0]['uri'] : $objNodesComImg[$nids6ComImg[3]]->field_image[key($objNodesComImg[$nids6ComImg[3]]->field_image)][0]['uri'];
        ?>
        <div class="zbox wgd4 hgd3 boxNotListHor box0010 <?= $cadernoField ?>">
            <ul>
                <li class="wgd4 hgd3 node">
                <h1>
                <a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>">
                <?= $objTaxonomia->name ?> </a>
                </h1>
                <a target="_parent" class="img" href="<?= $urlNode ?>">
                <img src="<?= image_style_url('110x75', $image) ?>" width="110" height="75">
                </a>
                <p>
                    <a target="_parent" class="titulo <?= $cadernoField ?>" href="<?= $urlNode ?>">
                    <?= $objNodesComImg[$nids6ComImg[3]]->title ?> </a>
                </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="wgdcol wgd4" style="margin-right: 0px">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0002_4x8_1_normal/css/box.css?1415646571568">
        <?php
        //Recuperando o campo da categoria
        $cadernoSettings = getCadernoNode($objNodesComImg[$nids6ComImg[4]]->type);
        $cadernoField = $cadernoSettings['field'];
        $objCadernoCategoria = $objNodesComImg[$nids6ComImg[4]]->$cadernoField;
        //Recuperando o objeto taxonomy
        $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0]['tid']);

        $urlNode = url('node/' . $objNodesComImg[$nids6ComImg[4]]->nid);

        //recuperando as imagens
        $image = (!empty($objNodesComImg[$nids6ComImg[4]]->field_capa)) ? $objNodesComImg[$nids6ComImg[4]]->field_capa[key($objNodesComImg[$nids6ComImg[4]]->field_capa)][0]['uri'] : $objNodesComImg[$nids6ComImg[4]]->field_image[key($objNodesComImg[$nids6ComImg[4]]->field_image)][0]['uri'];
        ?>
        <div class="zbox wgd4 hgd8 box0002 boxPimg1 <?= $cadernoField ?>">
            <ul>
                <li class="wgd4 hgd8 node">
                <div class="wgd4 hgd1">
                    <h1 class="chapeu">
                    <a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>">
                    <?= $objTaxonomia->name ?> </a>
                    </h1>
                </div>
                <div class="wgd4 hgd6">
                    <a target="_parent" class="img" href="<?= $urlNode ?>">
                    <img src="<?= image_style_url('medium', $image) ?>" width="300" height="220">
                    </a>
                </div>
                <div class="wgd4 hgd2">
                    <p>
                        <a target="_parent" class="titulo <?= $cadernoField ?>" href="<?= $urlNode ?>">
                        <?= $objNodesComImg[$nids6ComImg[4]]->title ?> </a>
                    </p>
                </div>
                </li>
            </ul>
        </div>
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0010_4x3_1_normal/css/box.css?1415646571570">
        <?php
        //Recuperando o campo da categoria
        $cadernoSettings = getCadernoNode($objNodesComImg[$nids6ComImg[5]]->type);
        $cadernoField = $cadernoSettings['field'];
        $objCadernoCategoria = $objNodesComImg[$nids6ComImg[5]]->$cadernoField;
        //Recuperando o objeto taxonomy
        $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0]['tid']);

        $urlNode = url('node/' . $objNodesComImg[$nids6ComImg[5]]->nid);

        //recuperando as imagens
        $image = (!empty($objNodesComImg[$nids6ComImg[5]]->field_capa)) ? $objNodesComImg[$nids6ComImg[5]]->field_capa[key($objNodesComImg[$nids6ComImg[5]]->field_capa)][0]['uri'] : $objNodesComImg[$nids6ComImg[5]]->field_image[key($objNodesComImg[$nids6ComImg[5]]->field_image)][0]['uri'];
        ?>
        <div class="zbox wgd4 hgd3 boxNotListHor box0010 <?= $cadernoField ?>">
            <ul>
                <li class="wgd4 hgd3 node">
                <h1>
                <a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>">
                <?= $objTaxonomia->name ?> </a>
                </h1>
                <a target="_parent" class="img" href="<?= $urlNode ?>">
                <img src="<?= image_style_url('110x75', $image) ?>" width="110" height="75">
                </a>
                <p>
                    <a target="_parent" class="titulo undefined" href="<?= $urlNode ?>">
                    <?= $objNodesComImg[$nids6ComImg[5]]->title ?> </a>
                </p>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="wgdlinha" style="margin:0px;width:940px;overflow:hidden;">
    <div class="wgdcol wgd4" style="margin-left:0px">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0030_4x3_1_texto/css/box.css?1415646571572">
        <?php
        //Recuperando o campo da categoria
        $cadernoSettings = getCadernoNode($objNodesSemImg[$nids4SemImg[2]]->type);
        $cadernoField = $cadernoSettings['field'];
        $objCadernoCategoria = $objNodesSemImg[$nids4SemImg[2]]->$cadernoField;
        //Recuperando o objeto taxonomy
        $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0]['tid']);

        $urlNode = url('node/' . $objNodesSemImg[$nids4SemImg[2]]->nid);
        ?>
        <div class="zbox wgd4 hgd3 box0030 <?= $cadernoField ?>">
            <div class="wgd4 hgd3 node">
                <div class="wgd4 hgd1">
                    <h1>
                    <a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>">
                    <?= $objTaxonomia->name ?> </a>
                    </h1>
                </div>
                <div class="wgd4 hgd2">
                    <a target="_parent" href="<?= $urlNode ?>" class="titulo undefined">
                    <?= $objNodesSemImg[$nids4SemImg[2]]->title ?> </a>
                </div>
            </div>
        </div>
    </div>
    <div class="wgdcol wgd8" style="margin-right: 0px">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/box0021_8x3_1_texto/css/box.css?1415646571573">
        <?php
        //Recuperando o campo da categoria
        $cadernoSettings = getCadernoNode($objNodesSemImg[$nids4SemImg[3]]->type);
        $cadernoField = $cadernoSettings['field'];
        $objCadernoCategoria = $objNodesSemImg[$nids4SemImg[3]]->$cadernoField;
        //Recuperando o objeto taxonomy
        $objTaxonomia = taxonomy_term_load($objCadernoCategoria[key($objCadernoCategoria)][0]['tid']);

        $urlNode = url('node/' . $objNodesSemImg[$nids4SemImg[3]]->nid);
        ?>
        <div class="zbox wgd8 hgd3 box0021 <?= $cadernoField ?>">
            <div class="wgd8 hgd3 node">
                <div class="wgd8 hgd1">
                    <h1>
                    <a target="_parent" class="chapeu" href="<?= url('tags/' . $objTaxonomia->name) ?>">
                    <?= $objTaxonomia->name ?> </a>
                    </h1>
                </div>
                <div class="wgd8 hgd2">
                    <a target="_parent" href="<?= $urlNode ?>" class="titulo undefined">
                    <?= $objNodesSemImg[$nids4SemImg[3]]->title ?> </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
endif;