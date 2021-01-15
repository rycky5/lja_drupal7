<?php
//Blogs da Redação
// $Id: block.tpl.php,v 1.10 2010/04/26 14:10:40 dries Exp $

/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user module
 *     is responsible for handling the default user navigation block. In that case
 *     the class would be "block-user".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 */
?>
 <div class="colunas2_1">
      	<h2 class="tagDestaqueH2 cinza">Destaque</h2>
        <?php 
          if($vDestaqueTopo[0]->tid == '2328'){
              $vImagemTopo = base_path(true)."/".drupal_get_path('theme', 'leiaja')."/images/thumbGrandePodcast.jpg";
          }else{
             $vImagemTopo = image_style_url('medium', (empty($vDestaqueTopo[0]->urithumbvideo)) ? $vDestaqueTopo[0]->uri : $vDestaqueTopo[0]->urithumbvideo);
          }
        ?>
        <a class="margin-top7" href="<?= url(drupal_lookup_path('alias',"node/".$vDestaqueTopo[0]->nid)); ?>"><img class='previewmodal1' width="300" height="225" src="<?= $vImagemTopo;  ?>" alt='<?= $vDestaqueTopo[0]->title ?>'></a>
        <div class="contentCol margin-top7 bordaBottom margin-bottom15">
          <strong><span class="iconeMultimidiaMenor iconeTvMenor"></span><a class="linksStrong preto" href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$vDestaqueTopo[0]->tid2)); ?>"><?= $vDestaqueTopo[0]->tag ?></a></strong>
          <span id="leiamais1" class="lerNoticiasMenor fixarSoNoticia">
            <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vDestaqueTopo[0]->nid?>"></a>
          </span>          
          <h6 class="noticiaH6"><a class='previewmodal1 links cinza' href="<?= url(drupal_lookup_path('alias',"node/".$vDestaqueTopo[0]->nid)); ?>"><?= $vDestaqueTopo[0]->title ?></a></h6>
        </div>
        <h2 class="tagDestaqueH2"><a class="cinza" href="<?=url('multimidia/podcasts', array('absolute' => true));?>" title="Podcast">Podcast</a></h2>	
        <div class="contentCol bordaBottom">
       	  <strong><span class="iconeMultimidiaMenor iconePodMenor"></span><a class="linksStrong preto" href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$vPodcast[0]->tid2)); ?>"><?= $vPodcast[0]->tag ?></a></strong>
          <span id="leiamais2" class="lerNoticiasMenor fixarSoNoticia">
            <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vPodcast[0]->nid?>"></a>
          </span>         	  
          <h6 class="noticiaH6"><a class='previewmodal2 links cinza' href="<?= url(drupal_lookup_path('alias',"node/".$vPodcast[0]->nid)); ?>"><?= $vPodcast[0]->title ?></a></h6>
        </div>
      </div>  
      <div class="colunas2_1 margin-left25">
      	<h2 class="tagEspecialH2"><a class="cinza" href="<?=url('multimidia/fotos', array('absolute' => true));?>" title="Galerias">Galerias</a></h2>
      	<?php foreach($vGaleriasTopo as $key => $gal): ?>
          <div class="contentCol bordaBottom <?= ($key != 0) ? 'margin-top15' : '';  ?>">
        	<a href="<?= url(drupal_lookup_path('alias',"node/".$gal->nid)); ?>"><img class='previewmodal<?= "10".$key ?> imgH4' src="<?= image_style_url('home_thumb', $gal->uri); ?>" alt="<?= $gal->title ?>" /></a>
        	<div class="containerImgH4">
          	  <strong><span class="iconeMultimidiaMenor iconeGalMenor"></span><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$gal->tid2)); ?>" class="linksStrong preto"><?= $gal->tag; ?></a></strong>
              <span id="leiamais<?= "10".$key ?>" class="lerNoticiasMenor fixarSoNoticia">
                <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$gal->nid?>"></a>
              </span>  
          	  <h4 class="noticiaH4"><a class='previewmodal<?= "10".$key ?> links cinza' href="<?= url(drupal_lookup_path('alias',"node/".$gal->nid)); ?>"><?= $gal->title; ?></a></h4>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="colunas3 bordaBottom padding-bottom12">
      	<h2 class="tagDestaqueH2 cinza"><a class="cinza" href="<?=url('multimidia/videos', array('absolute' => true));?>" title="Vídeos">V&iacute;deos</a></h2>
      	<?php foreach($vVideos as $key => $vid): ?>
          <div class="contentCol <?= ($key != 0) ? 'margin-left25' : ''; ?>">
        	<a href="<?= url(drupal_lookup_path('alias',"node/".$vid->nid)); ?>"><img class="previewmodal<?= "20".$key ?> imgH6Grande" alt="<?= $vid->title; ?>" src="<?= image_style_url('home_cadernos', $vid->urithumbvideo); ?>"></a>
         	<strong><span class="iconeMultimidiaMenor iconeVidMenor"></span><a class="linksStrong" href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$vid->tid2)); ?>"><?= $vid->tag; ?></a></strong>
            <span id="leiamais<?= "20".$key ?>" class="lerNoticiasMenor fixarSoNoticia">
              <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vid->nid?>"></a>
            </span>  
         	<h6 class="noticiaH6"><a class="previewmodal<?= "20".$key ?> links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vid->nid)); ?>"><?= $vid->title; ?></a></h6>
          </div>
      	<?php endforeach; ?>
      </div>
      <div class="colunas3 bordaBottom padding-bottom12">
      	<h2 class="tagDestaqueH2 cinza"><a class="cinza" href="<?=url('multimidia/tv', array('absolute' => true));?>" title="TV Leia Já">TV Leia J&aacute;</a></h2>
      	<?php foreach($vTvLeiaja as $key => $info): ?>
          <div class="contentCol <?= ($key != 0) ? 'margin-left25' : ''; ?>">
        	<a href="<?= url(drupal_lookup_path('alias',"node/".$info->nid)); ?>"><img class="previewmodal<?= "30".$key ?> imgH6Grande" alt="<?= $info->title; ?>" src="<?= image_style_url('home_cadernos', $info->urithumbvideo); ?>"></a>
         	<strong><span class="iconeMultimidiaMenor iconeVidMenor"></span><a class="linksStrong" href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$info->tid2)); ?>"><?= $info->tag; ?></a></strong>
            <span id="leiamais<?= "30".$key ?>" class="lerNoticiasMenor fixarSoNoticia">
              <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$info->nid?>"></a>
            </span>
         	<h6 class="noticiaH6"><a class="previewmodal<?= "30".$key ?> links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$info->nid)); ?>"><?= $info->title; ?></a></h6>
          </div>
      	<?php endforeach; ?>
      </div>
      <div class="colunas3 padding-bottom12">
      	<h2 class="tagDestaqueH2 cinza"><a class="cinza" href="<?=url('multimidia/infograficos', array('absolute' => true));?>" title="Infogr&aacute;ficos">Infogr&aacute;ficos</a></h2>
      	<?php foreach($vInfograficos as $key => $info): ?>
          <div class="contentCol <?= ($key != 0) ? 'margin-left25' : ''; ?>">
            <? /* <a href="<?= url(drupal_lookup_path('alias',"node/".$info->nid)); ?>"><img class="previewmodal<?= "40".$key ?> imgH6Grande" alt="<?= $info->title; ?>" src="<?= image_style_url('home_cadernos', $info->urithumbvideo); ?>"></a> */ ?>
            <strong><span class="iconeMultimidiaMenor iconeVidMenor"></span><a class="linksStrong" href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$info->tid2)); ?>"><?= $info->tag; ?></a></strong>
            <span id="leiamais<?= "40".$key ?>" class="lerNoticiasMenor fixarSoNoticia">
              <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$info->nid?>"></a>
            </span>  
            <h6 class="noticiaH6"><a class="previewmodal<?= "40".$key ?> links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$info->nid)); ?>"><?= $info->title; ?></a></h6>
          </div>
      	<?php endforeach; ?>
      </div> 