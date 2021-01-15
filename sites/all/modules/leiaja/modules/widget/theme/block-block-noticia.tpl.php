<?php
/**
 * Arquivo que conterá o bloco de tecnologia da home
 * 
 * @author Alberto Medeiros
 */
?>
<div class="colunas3">
  <h2 class="tituloH2"><a href="/tecnologia" class="vermelho" title="Tecnologia">Notícias</a></h2>
  <div class="contentCol">
          <a class="previewmodal12" href="<?= url(drupal_lookup_path('alias',"node/".$vHomeNoticia[0]->nid)); ?>"><img src="<?= image_style_url('home_cadernos', $vHomeNoticia[0]->uri); ?>" alt="<?= $vHomeNoticia[0]->title ?>" class="imgH6Grande" /></a>
          <strong><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$vHomeNoticia[0]->tid)); ?>" class="linksStrong vermelho"><?= $vHomeNoticia[0]->subcategoria ?></a></strong>
          <span id="leiamais12" class="lerNoticiasMenor fixarSoNoticia">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vHomeNoticia[0]->nid.';0'?>"></a>
    </span>
    <h6 class="noticiaH6"><a class="previewmodal12links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vHomeNoticia[0]->nid)); ?>"><?= $vHomeNoticia[0]->title ?></a></h6>
  </div>
  <div class="contentCol margin-left25">
          <a class="previewmodal13" href="<?= url(drupal_lookup_path('alias',"node/".$vHomeNoticia[1]->nid)); ?>"><img src="<?= image_style_url('home_cadernos', $vHomeNoticia[1]->uri); ?>" alt="<?= $vHomeNoticia[1]->title ?>" class="imgH6Grande" /></a>
          <strong><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$vHomeNoticia[1]->tid)); ?>" class="linksStrong vermelho"><?= $vHomeNoticia[1]->subcategoria ?></a></strong>
          <span id="leiamais13" class="lerNoticiasMenor fixarSoNoticia">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vHomeNoticia[1]->nid.';0'?>"></a>
    </span>
    <h6 class="noticiaH6"><a class="previewmodal13 links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vHomeNoticia[1]->nid)); ?>"><?= $vHomeNoticia[1]->title ?></a></h6>
  </div>
  <div class="contentCol margin-left25">
          <a class="previewmodal14" href="<?= url(drupal_lookup_path('alias',"node/".$vHomeNoticia[2]->nid)); ?>"><img src="<?= image_style_url('home_cadernos', $vHomeNoticia[2]->uri); ?>" alt="<?= $vHomeNoticia[2]->title ?>" class="imgH6Grande" /></a>
          <strong><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$vHomeNoticia[2]->tid)); ?>" class="linksStrong vermelho"><?= $vHomeNoticia[2]->subcategoria ?></a></strong>
          <span id="leiamais14" class="lerNoticiasMenor fixarSoNoticia">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vHomeNoticia[0]->nid.';0'?>"></a>
    </span>
    <h6 class="noticiaH6"><a class="previewmodal14 links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vHomeNoticia[2]->nid)); ?>"><?= $vHomeNoticia[2]->title ?></a></h6>
  </div>
</div>