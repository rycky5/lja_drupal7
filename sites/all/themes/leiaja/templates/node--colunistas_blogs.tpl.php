<?php
//nova tpl para as paginas "/blogs" e "/colunsitas"
?>

<?php
module_load_include('inc', 'widget', 'widget');
module_load_include('inc', 'cadernos', 'cadernos');

//As cores padrão para os categorias no tema leiaja definida numa variável global
$corCategoria = array(
    'noticias' => 'vermelho',
    'carreiras' => 'roxo',
    'esportes' => 'verde',
    'tecnologia' => 'azulClaro',
    'cultura' => 'laranja',
    'politica' => 'cinza'
);

$outParceiros = page_colunistas();
$vEspeciais = $outParceiros['vEspeciais'];
$vBlogsParceiros = $outParceiros['vBlogsParceiros'];

$resultBlogs = conteudoBlogsRedacao(4);
?>
<div class="colunaEsquerda">
    <?php print render(getBlocos(array(array('views','colunistas_taxonomy-colunista')))); //imprimindo o bloco de colunistas?>
  <div class="colunas1">
  <h2 class="tituloH2 cinza">Blogs da Redação</h2>
  <ul class="listaBlogsRedacao">

  <?php
  foreach ($resultBlogs as $key => $value) {
  ?>
    <li>
    <!-- 
    //terminar a listagem dos blogs da redação -->
      <a class="previewmodal<?= "6$key" ?>" href="<?= $value['urlTax']; ?>">
        <img src="<?=$value['urlImg'];?>" 
          alt="<?=$value['subcategoria'];?>" class="imgH6Pequena" />
      </a>
      <a class="previewmodal<?= "6$key" ?>" href="<?= $value['urlTax']; ?>"><strong class="<?= $corCategoria[$value['parent']]?>"><?=$value['subcategoria']?></strong></a>
      <span id="leiamais<?= "6$key" ?>" class="lerNoticiasMenor fixarSoNoticia">
        <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$value['tid'].';3'?>"></a>
      </span>
      <a class="previewmodal<?= "6$key" ?>" href="<?= $value['urlNode']; ?>"><h6><?=$value['title']?></h6></a>
    </li>
  <? } ?>
  </ul>
  </div>
  <div class="colunas2">
    <h2 class="tituloH2"><a href="javascript:void(0);" class="cinza" title="Especiais LeiaJa">Especiais LeiaJá</a></h2>
    <? 
    $count = 0;
    if($vEspeciais){
    foreach ($vEspeciais AS $key => $value){
      $count++;
      ?>
        <div class="banner5 margin-bottom25 <?=($count%2 != 0)? '': ' margin-left25';?>" style="border: 1px #000;">
          <a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$value->tid)); ?>" class="previewmodal4"><img class="imgH4" width="300px" height="100px" alt="<?= $value->name ?>" src="<?= file_create_url($value->field_imagecrop["und"][0]["uri"]); ?>"></a>
        </div>
      <?
    }
    }
    ?>
  </div>
  <div class="colunas4">
    <h2 class="tituloH2"><a href="/blogs" class="cinza" title="Blogs Parceiros">Blogs e Parceiros</a></h2>
    <? 
    foreach ($vBlogsParceiros AS $key => $value){
    ?>
    <div class="contentCol blogsLeiaJa <?=($key%4 == 0)? '': ' margin-left25';?>">
      <a class="previewmodal<?= "50$key" ?>" href="<?=$value->alias;?>">
        <img src="<?= base_path().drupal_get_path('theme', 'leiaja').'/images/blogs-parceiros-'.$value->tid.'.png'?>" alt="<?=$value->name;?>" class="imgBlogs" />
      </a>
          <span id="leiamais<?= "50$key" ?>" class="lerNoticiasMaior fixarBlog">
        <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$value->tid.';2'?>"></a>
      </span>
    </div>
    <? 
    }
    ?>
  </div>
</div>