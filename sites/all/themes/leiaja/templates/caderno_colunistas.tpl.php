<?php
//ESTA TPL ESTAH EM DESUSO
/**
 * @file views-view.tpl.php
 * Main view template
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
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */

module_load_include('inc', 'widget', 'widget');
$resultBlogs = conteudoBlogsRedacao(4);

print render(getBlocos(array(array('views','colunistas_taxonomy-colunista'))));
//imprimindo o bloco de colunistas
?>
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
  <h2 class="tituloH2"><a href="/blogs" class="cinza" title="Blogs Parceiros">Blogs Parceiros</a></h2>
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