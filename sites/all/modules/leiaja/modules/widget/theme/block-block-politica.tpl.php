<?php
/**
 * Arquivo que conterá o bloco de tecnologia da home
 * 
 * @author Alberto Medeiros
 */

$objNodePrimeiro = node_load($vHomePolitica[0]->nid);
$objNodeSegundo = node_load($vHomePolitica[1]->nid);
$objNodeTerceiro = node_load($vHomePolitica[2]->nid);

$objTagPrimeiro = taxonomy_term_load($objNodePrimeiro->field_tags["pt-br"][0]["tid"]);
$objTagSegundo = taxonomy_term_load($objNodeSegundo->field_tags["pt-br"][0]["tid"]);
$objTagTerceiro = taxonomy_term_load($objNodeTerceiro->field_tags["pt-br"][0]["tid"]);


//$arrObjTaxonomia = 
?>
<div class="colunas3">
  <h2 class="tituloH2"><a href="/politica" class="azulEscuro" title="Politica">Política</a></h2>
  <div class="contentCol">
          <a class="previewmodal12" href="<?= url(drupal_lookup_path('alias',"node/".$vHomePolitica[0]->nid)); ?>"><img src="<?= image_style_url('home_cadernos', $vHomePolitica[0]->uri); ?>" alt="<?= $vHomePolitica[0]->title ?>" class="imgH6Grande" /></a>
          <strong><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$objTagPrimeiro->tid)); ?>" class="linksStrong azulEscuro" style="text-transform: capitalize"><?= $objTagPrimeiro->name ?></a></strong>
          <span id="leiamais12" class="lerNoticiasMenor fixarSoNoticia">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vHomePolitica[0]->nid.';0'?>"></a>
    </span>
    <h6 class="noticiaH6"><a class="previewmodal12links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vHomePolitica[0]->nid)); ?>"><?= $vHomePolitica[0]->title ?></a></h6>
  </div>
  <div class="contentCol margin-left25">
          <a class="previewmodal13" href="<?= url(drupal_lookup_path('alias',"node/".$vHomePolitica[1]->nid)); ?>"><img src="<?= image_style_url('home_cadernos', $vHomePolitica[1]->uri); ?>" alt="<?= $vHomePolitica[1]->title ?>" class="imgH6Grande" /></a>
          <strong><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$objTagSegundo->tid)); ?>" class="linksStrong azulEscuro" style="text-transform: capitalize"><?= $objTagSegundo->name ?></a></strong>
          <span id="leiamais13" class="lerNoticiasMenor fixarSoNoticia">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vHomePolitica[1]->nid.';0'?>"></a>
    </span>
    <h6 class="noticiaH6"><a class="previewmodal13 links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vHomePolitica[1]->nid)); ?>"><?= $vHomePolitica[1]->title ?></a></h6>
  </div>
  <div class="contentCol margin-left25">
          <a class="previewmodal14" href="<?= url(drupal_lookup_path('alias',"node/".$vHomePolitica[2]->nid)); ?>"><img src="<?= image_style_url('home_cadernos', $vHomePolitica[2]->uri); ?>" alt="<?= $vHomePolitica[2]->title ?>" class="imgH6Grande" /></a>
          <strong><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$objTagTerceiro->tid)); ?>" class="linksStrong azulEscuro" style="text-transform: capitalize"><?= $objTagTerceiro->name ?></a></strong>
          <span id="leiamais14" class="lerNoticiasMenor fixarSoNoticia">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vHomePolitica[0]->nid.';0'?>"></a>
    </span>
    <h6 class="noticiaH6"><a class="previewmodal14 links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vHomePolitica[2]->nid)); ?>"><?= $vHomePolitica[2]->title ?></a></h6>
  </div>
</div>