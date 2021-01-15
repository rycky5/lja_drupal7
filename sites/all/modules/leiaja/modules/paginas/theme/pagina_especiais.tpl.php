<?php
//Incluindo o widget.inc
module_load_include('inc', 'widget', 'widget');
//Recuperando os blogs da redação
$resultBlogs = conteudoBlogsRedacao();

//Recuperando o objeto vocabulario "blogs_parceiros"
$vocabulary = taxonomy_vocabulary_machine_name_load('blogs_parceiros');
//Carregando todas os termos relacionados ao vocabulario
$terms = entity_load('taxonomy_term', FALSE, array('vid' => $vocabulary->vid));
?>

<div class="col-left">
    <div class="blogs-redacao">
        <h2 class="tituloH2 cinza"><span>Blogs da Redação</span></h2>
        <ul class="listaBlogsRedacao">

            <?php
            foreach ($resultBlogs as $key => $value) :
                ?>
                <li>
                    <!-- 
                    //terminar a listagem dos blogs da redação -->
                    <a class="previewmodal<?= "6$key" ?>" href="<?= $value['urlTax']; ?>">
                        <img src="<?= $value['urlImg']; ?>" 
                             alt="<?= $value['subcategoria']; ?>" class="imgH6Pequena" />
                    </a>
                    <a class="previewmodal<?= "6$key" ?>" href="<?= $value['urlTax']; ?>"><strong class="<?= $corCategoria[$value['parent']] ?>"><?= $value['subcategoria'] ?></strong></a>
                    <span id="leiamais<?= "6$key" ?>" class="lerNoticiasMenor fixarSoNoticia">
                        <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?= $GLOBALS['user']->uid . ';' . $value['tid'] . ';3' ?>"></a>
                    </span>
                    <a class="previewmodal<?= "6$key" ?>" href="<?= $value['urlNode']; ?>"><h6><?= $value['title'] ?></h6></a>
                </li>
                <?php
            endforeach;
            ?>
        </ul>
    </div>

    <div class="blogs-parceiros">
        <h2 class="tituloH2"><a href="/blogs" class="cinza" title="Blogs Parceiros"><span>Blogs Parceiros</span></a></h2>
        <?php
        foreach ($terms as $key => $term) :
            if (!empty($term->field_imagem[key($term->field_imagem)][0]['uri'])):
                $pathBlogs = taxonomy_term_uri($term);
                $url = url($pathBlogs['path'], array('absolute' => TRUE));
                ?>
                <div class="contentCol blogsLeiaJa <?= ($key % 4 == 0) ? '' : ' margin-left25'; ?>">
                    <a class="previewmodal<?= "50$key" ?>" href="<?= str_replace($_SERVER['SERVER_NAME'] . '/', '', $url) ?>">
                        <img src="<?= image_style_url('90x67', $term->field_imagem[key($term->field_imagem)][0]['uri']) ?>" alt="<?= $term->name; ?>" class="imgBlogs" />
                    </a>
                </div>
                <?php
            endif;
        endforeach;
        ?>
    </div>
</div>

<div class="especiais-leiaja">
    <h2 class="tituloH2"><a href="javascript:void(0);" class="cinza" title="Especiais LeiaJa"><span>Especiais LeiaJá</span></a></h2>
    <?php
    $count = 0;
    if ($vEspeciais) :
        foreach ($vEspeciais AS $key => $value) :
            $count++;
            ?>
            <div class="banner5 margin-bottom25 <?= ($count % 2 != 0) ? '' : ' margin-left25'; ?>" style="border: 1px #000;">
                <a href="<?= url(drupal_lookup_path('alias', "taxonomy/term/" . $value->tid)); ?>" class="previewmodal4"><img class="imgH4" width="300px" height="100px" alt="<?= $value->name ?>" src="<?= file_create_url($value->field_imagecrop["und"][0]["uri"]); ?>"></a>
            </div>
            <?php
        endforeach;
    endif;
    ?>
</div>


