<?php
if (strpos($_SERVER[REQUEST_URI], 'interna')) { // returns false if '?' isn't there
    $css = 'box0019node';
} else {
    $css = 'box0019';
}
if (strpos($_SERVER[REQUEST_URI], 'qnt=10')) { // returns false if '?' isn't there
    $hgd = 'hgd16';
} else {
    $hgd = 'hgd8';
}
?> 

<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/estilo.css"/>
<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/grid.css"/>
<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/box0019_4x8_1_iframe/css/box.css"/>


<div class="zbox wgd4 <?php echo $hgd ?> <?php echo $css ?> ultimasNoticias iframeinterna box0019" style="margin:0px;">
    <h1><a href="<?= LEIAJAURL ?>/ultimas" target="_parent"><b>Últimas&nbsp;</b><span>Notícias</span></a></h1>
 	<ul class="ultimasNoticiasLista cinza">
        <?php foreach ($objNodes as $value): ?>
            <li><a target="_parent" title="<?= $value->title ?>" href="<?= url('node/' . $value->nid, array('absolute' => true)); ?>"><strong><?= date('G:i', $value->created) ?></strong> - <?= $value->title ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>

