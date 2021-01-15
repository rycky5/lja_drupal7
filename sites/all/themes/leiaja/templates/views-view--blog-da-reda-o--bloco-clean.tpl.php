<?php

module_load_include('inc', 'widget', 'widget');
$resultBlogs = conteudoBlogsRedacao(3);

?>

<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/box0018_4x8_1_iframe/css/box.css"/>
<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/estilo.css"/>
<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/grid.css"/>

<div class="zbox wgd4 hgd8 box0018 iframeinterna" id="blogsDaRedacao">
    <h1><a target="_parent" href="/blogs" class="cinza" title="Blogs da redação"><b>Blogs</b><span></span></a></h1>
    <ul class="listaBlogsRedacao cinza">
      <?php
        foreach ($resultBlogs as $key => $value):
      ?>
      <li>       
        <a target="_parent" class="previewmodal7<?=$key?>" href="<?= $value['urlNode'] ?>">
          <img src="<?=$value['urlImg']; ?>" alt="<?= $value['subcategoria'] ?>" class="<?= getCores($value['parent']) ?>" />
          <span><?= $value['title'] ?></span>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>

</div>


