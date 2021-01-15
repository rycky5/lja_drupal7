





    <link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/box0018b_12x7_1_iframe/css/box.css"/>
    <link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/estilo.css"/>
    <link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/grid.css"/>

    <div class="zbox wgd12 hgd7 box0018b" id="blogsDaRedacaoHorizontal">
        <h1><a target="_parent" href="/especiais" class="cinza" title="Blogs da redação"><b>Blogs</b><span></span></a></h1>
        <ul class="listaBlogsRedacao cinza">
            <?php
            foreach ($ultimasBlogs as $key => $value):
                ?>
                <li>       
                    <a target="_parent" href="<?= $value->url ?>">
                        <img src="<?= image_style_url('90x67', $value->uri_image) ?>" alt="<?= $value->titulo ?>" />
                        <span><?= $value->titulo ?></span>
                    </a>
                </li>
            <?php 
            endforeach; 
            ?>
        </ul>
    </div>

