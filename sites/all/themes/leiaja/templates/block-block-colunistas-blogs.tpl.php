<?php 
//Novo TPL para o novo bloco de Colunistas e Blogs da redação juntos, dados via views e consultas
//Tpl do bloco que fica nos cadernos
?>

<?php

module_load_include('inc', 'widget', 'widget');
$resultBlogs = conteudoBlogsRedacao(2);

$pathTema = "sites/all/themes/leiaja";

$corCategoria = array('noticias' => 'vermelho',
                        'carreiras' => 'roxo',
                        'esportes' => 'verde',
                        'politica' => 'azulEscuro',
                        'tecnologia' => 'azulClaro',
                        'cultura' => 'laranja',
                        'carnaval_2012' => 'laranja',
                        'multimidia' => 'cinza',
                        'blog_social' => 'laranja');
?>

<div class="colunas2_2 margin-left25 margin-top15">
<h2 class="tituloH2 tituloH2Colunista cinza"><a title="Colunistas" class="cinza" href="/colunistas">Colunistas</a></h2>

<?php
//Blogs da Redação
// $Id: block.tpl.php,v 1.10 2010/04/26 14:10:40 dries Exp $
      foreach($resultCols as $key => $value){
            $nid = $value->nid;   
            $tid = $value->tid;
            $ttNode = $value->title;
            $termTaxy = taxonomy_term_load($tid);
            $subcategoria = $termTaxy->name;
            $parent = $value->parent;
            $ttColuna = $value->name;
            $urlColuna = drupal_lookup_path('alias', 'taxonomy/term/'.$tid);
            $urlNode = drupal_lookup_path('alias', 'node/'.$nid);
            $urlImgCol='http://static1.leiaja.com/sites/all/themes/leiaja/images/foto-coluna-'.$tid.'.jpg';
            if($key > 0){$classe='margin-left25';}
?>

          <div class="contentCol margin-top11 margin-bottom10 <?Php print $classe?>">
            <a class="previewmodal5" href="/<?= $urlColuna ?>"><img src="<?= $urlImgCol?>" alt="<?= $subcategoria ?>" class="imgH6Pequena" /></a>
            <strong><a href="/<?= $urlColuna ?>" class="linksStrong <?= $corCategoria[$parent]?>"><?=$ttColuna ?></a></strong>
            <span id="leiamais5" class="lerNoticiasMenor seguirColunista">
              <a class="lerDepois" title="Fixar Colunista no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vColunistas[0]->tid.';3'?>"></a>
            </span>
            <h6 class="colunistaH6"><a class="previewmoda<?="90$count"?> links cinza" href="/<?=$urlNode ?>"><?=$ttNode?></a></h6>
          </div>
  
  <?php } ?>
</div>

  <div class="colunas2_1 margin-left25">
    <h2 class="tagDestaqueH2 cinza margin-top25"><a href="/blogs" class="cinza" title="Blogs da redação">Blogs da Reda&ccedil;&atilde;o</a></h2>
    <ul class="listaBlogsRedacao">
      <?
      foreach ($resultBlogs as $key => $value) {
      ?>
      <li>       
        <a class="previewmodal7<?=$key?>" href="<?= $value['urlNode'] ?>">
          <img src="<?=$value['urlImg']; ?>" alt="<?= $value['subcategoria'] ?>" class="imgH6Pequena" />
        </a>
        <a class="previewmodal7<?=$key?>" href="<?= $value['urlTax'] ?>"><strong class="<?= $corCategoria[$parent] ?>"><?= $value['subcategoria'] ?></strong></a>
        <span id="leiamais7<?=$key?>" class="lerNoticiasMenor fixarSoNoticia">
          <a class="lerDepois" title="Fixar Blog no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$value['tid'].';1'?>"></a>
        </span>
        <a class="previewmodal7<?=$key?>" href="<?= $value['urlNode'] ?>"><h6><?= $value['title'] ?></h6></a>
      </li>
      <?}?>
    </ul>
  </div>