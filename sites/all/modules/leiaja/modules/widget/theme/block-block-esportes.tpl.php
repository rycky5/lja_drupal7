<?php
/**
 * Arquivo que conterá o bloco de tecnologia da home
 * 
 * @author Alberto Medeiros
 */
die("oi");
?>
<?php print render(getBlocos(array(array('widget','bloco-banner')))); ?>
<div class="colunas3">
  <h2 class="tituloH2"><a href="/esportes" class="verde" title="Tecnologia">Esportes</a></h2>
  <div class="contentCol">
          <a class="previewmodal12" href="<?= url(drupal_lookup_path('alias',"node/".$vHomeEsporte[0]->nid)); ?>"><img src="<?= image_style_url('home_cadernos', $vHomeEsporte[0]->uri); ?>" alt="<?= $vHomeEsporte[0]->title ?>" class="imgH6Grande" /></a>
          <strong><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$vHomeEsporte[0]->tid)); ?>" class="linksStrong verde"><?= $vHomeEsporte[0]->subcategoria ?></a></strong>
          <span id="leiamais12" class="lerNoticiasMenor fixarSoNoticia">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vHomeEsporte[0]->nid.';0'?>"></a>
    </span>
    <h6 class="noticiaH6"><a class="previewmodal12links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vHomeEsporte[0]->nid)); ?>"><?= $vHomeEsporte[0]->title ?></a></h6>
  </div>
  <div class="contentCol margin-left25">
          <a class="previewmodal13" href="<?= url(drupal_lookup_path('alias',"node/".$vHomeEsporte[1]->nid)); ?>"><img src="<?= image_style_url('home_cadernos', $vHomeEsporte[1]->uri); ?>" alt="<?= $vHomeEsporte[1]->title ?>" class="imgH6Grande" /></a>
          <strong><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$vHomeEsporte[1]->tid)); ?>" class="linksStrong verde"><?= $vHomeEsporte[1]->subcategoria ?></a></strong>
          <span id="leiamais13" class="lerNoticiasMenor fixarSoNoticia">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vHomeEsporte[1]->nid.';0'?>"></a>
    </span>
    <h6 class="noticiaH6"><a class="previewmodal13 links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vHomeEsporte[1]->nid)); ?>"><?= $vHomeEsporte[1]->title ?></a></h6>
  </div>
  <div class="contentCol margin-left25">
          <a class="previewmodal14" href="<?= url(drupal_lookup_path('alias',"node/".$vHomeEsporte[2]->nid)); ?>"><img src="<?= image_style_url('home_cadernos', $vHomeEsporte[2]->uri); ?>" alt="<?= $vHomeEsporte[2]->title ?>" class="imgH6Grande" /></a>
          <strong><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$vHomeEsporte[2]->tid)); ?>" class="linksStrong verde"><?= $vHomeEsporte[2]->subcategoria ?></a></strong>
          <span id="leiamais14" class="lerNoticiasMenor fixarSoNoticia">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vHomeEsporte[0]->nid.';0'?>"></a>
    </span>
    <h6 class="noticiaH6"><a class="previewmodal14 links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vHomeEsporte[2]->nid)); ?>"><?= $vHomeEsporte[2]->title ?></a></h6>
  </div>
</div>