<!-- Capa caderno termos -->      
     <div class="colunas2">
        <a class="previewmodal1" href="<?= url(drupal_lookup_path('alias',"node/".$vViewNoticiaImage[0]->nid)); ?>">
        	<img height="225" width="300" src="<?= image_style_url('medium', $vViewNoticiaImage[0]->uri);?>" alt="<?=$vViewNoticiaImage[0]->title;?>">
        </a>
      	<div class="contentCol margin-left25 bordaBottom padding-bottom15">
          <strong>
          	<a class="linksStrong preto" href="<?=base_path()."taxonomy/term/{$vViewNoticiaImage[0]->tags[0]->tid}";?>">
          	  <?=$vViewNoticiaImage[0]->tags[0]->tag;?>
          	</a>
          </strong>
          <span id="leiamais1" class="lerNoticiasMenor">
            <a class="lerDepois" title="Leia Depois" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vViewNoticiaImage[0]->nid?>"></a>
            <a class="lerJa" lerja="<?=url(drupal_lookup_path('alias',"node/".$vViewNoticiaImage[0]->nid));?>" title="Leia J&aacute;"></a>
          </span>
          <h3 class="noticiaH2">
          	<a class="previewmodal1 links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vViewNoticiaImage[0]->nid)); ?>">
          	  <?=$vViewNoticiaImage[0]->title;?>
          	</a>
          </h3>
        </div>
        <div class="contentCol bordaBottom padding-bottom15 margin-top15 margin-left25">
        	<strong>
        		<a href="<?=base_path()."taxonomy/term/{$vViewNoticias[0]->tags[0]->tid}";?>" class="linksStrong preto">
        		  <?=$vViewNoticias[0]->tags[0]->tag;?>
        		</a>
        	</strong>
          <span id="leiamais2" class="lerNoticiasMenor">
            <a class="lerDepois" title="Leia Depois" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vViewNoticias[0]->nid?>"></a>
            <a class="lerJa" lerja="<?=url(drupal_lookup_path('alias',"node/".$vViewNoticias[0]->nid));?>" title="Leia J&aacute;"></a>
          </span>        	
          <h3 class="noticiaH3">
          	<a class="previewmodal2 links cinza" href="<?=url(drupal_lookup_path('alias',"node/".$vViewNoticias[0]->nid));?>">
          	  <?=$vViewNoticias[0]->title;?>
          	</a>
          </h3>
        </div>
      </div>  
      <div class="colunas2_2">
        <div class="contentCol bordaBottom padding-bottom10 margin-top25">
          <strong>
          	<a class="linksStrong preto" href="<?=base_path()."taxonomy/term/{$vViewNoticias[1]->tags[0]->tid}";?>">
          	  <?= $vViewNoticias[1]->tags[0]->tag;?>
          	</a>
          </strong>
          <h4 class="noticiaH4">
          	<a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vViewNoticias[1]->nid)); ?>">
          	  <?= substr($vViewNoticias[1]->title, 0, 60);?>
          	</a>
          </h4>
        </div>
        <div class="contentCol bordaBottom margin-left25 margin-top25 padding-bottom10">
          <strong>
          	<a class="linksStrong preto" href="<?=base_path()."taxonomy/term/{$vViewNoticias[2]->tags[0]->tid}";?>">
          	  <?= $vViewNoticias[2]->tags[0]->tag;?>
          	</a>
          </strong>
          <h4 style="" class="noticiaH4">
          	<a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vViewNoticias[2]->nid)); ?>">
              <?= substr($vViewNoticias[2]->title, 0, 60);?>
          	</a>
          </h4>
        </div>
        <div class="contentCol bordaBottom padding-bottom10 margin-top15">
          <strong>
          	<a class="linksStrong preto" href="<?=base_path()."taxonomy/term/{$vViewNoticias[3]->tags[0]->tid}";?>">
          	  <?= $vViewNoticias[3]->tags[0]->tag;?>
          	</a>
          </strong>
          <h4 class="noticiaH4">
          	<a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vViewNoticias[3]->nid)); ?>">
          	  <?= substr($vViewNoticias[3]->title, 0, 60);?>
          	</a>
          </h4>
        </div>
        <div class="contentCol bordaBottom margin-left25 margin-top15 padding-bottom10">
          <strong>
          	<a class="linksStrong preto" href="<?=base_path()."taxonomy/term/{$vViewNoticias[4]->tags[0]->tid}";?>">
          	  <?= $vViewNoticias[4]->tags[0]->tag;?>
          	</a>
          </strong>
          <h4 style="" class="noticiaH4">
          	<a class="links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vViewNoticias[4]->nid));?>">
          	  <?= substr($vViewNoticias[4]->title, 0, 60);?>
          	</a>
          </h4>
        </div>
       </div>
     
      <div class="colunas2_1 margin-left25 margin-top25">
        <div class="contentCol bordaBottom margin-bottom15">
        	<a class="previewmodal3" href="<?= url(drupal_lookup_path('alias',"node/".$vViewNoticiaImage[1]->nid));?>">
        	  <img class="imgH4" title="<?= $vViewNoticiaImage[1]->body_summary;?>" src="<?= image_style_url('home_thumb', $vViewNoticiaImage[1]->uri);?>" alt="<?=$vViewNoticiaImage[1]->title;?>">
        	</a>
        	<div class="containerImgH4">
          	<strong>
          	  <a class="linksStrong preto" href="<?=base_path()."taxonomy/term/{$vViewNoticiaImage[1]->tags[0]->tid}";?>">
          	    <?= $vViewNoticiaImage[1]->tags[0]->tag;?>
          	  </a>
          	</strong>
          	<span id="leiamais3" class="lerNoticiasMenor">
              <a class="lerDepois" title="Leia Depois" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vViewNoticiaImage[1]->nid?>"></a>
              <a class="lerJa" lerja="<?= url(drupal_lookup_path('alias',"node/".$vViewNoticiaImage[1]->nid)); ?>" title="Leia J&aacute;"></a>
            </span>    
          	<h4 class="noticiaH4">
          	  <a class="previewmodal3 links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vViewNoticiaImage[1]->nid));?>">
          	    <?= $vViewNoticiaImage[1]->title;?>
          	  </a>
          	</h4>
          </div>
        </div>
        <div class="contentCol bordaBottom">
        	<a class="previewmodal4" href="<?= url(drupal_lookup_path('alias',"node/".$vViewNoticiaImage[2]->nid));?>">
        	  <img class="imgH4" title="<?= $vViewNoticiaImage[2]->body_summary;?>" src="<?= image_style_url('home_thumb', $vViewNoticiaImage[2]->uri);?>" alt="<?=$vViewNoticiaImage[2]->title;?>">
        	</a>
        	<div class="containerImgH4">
          	<strong><a class="linksStrong preto" href="<?=base_path()."taxonomy/term/{$vViewNoticiaImage[2]->tags[0]->tid}";?>"><?= $vViewNoticiaImage[2]->tags[0]->tag;?></a></strong>
          	<span id="leiamais4" class="lerNoticiasMenor">
              <a class="lerDepois" title="Leia Depois" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$vViewNoticiaImage[2]->nid?>"></a>
              <a class="lerJa" lerja="<?= url(drupal_lookup_path('alias',"node/".$vViewNoticiaImage[2]->nid)); ?>" title="Leia J&aacute;"></a>
            </span>    
          	<h4 class="noticiaH4">
          	  <a class="previewmodal4 links cinza" href="<?= url(drupal_lookup_path('alias',"node/".$vViewNoticiaImage[2]->nid));?>">
          	    <?= $vViewNoticiaImage[2]->title;?>
          	  </a>
          	</h4>
          </div>
        </div>
      </div>       
      
      <!-- Fim Capa termos --> 