<!-- Fim da div de busca avançada -->
<ul class="listaResultado resultadoBusca">
<? 

  foreach ($noticias AS $key => $value): 
      
?>
  <?php
    if(!empty ($value->uri)){
  ?>
    <li class="ljhasimg">
      <img src="<?= image_style_url('home_cadernos', $value->uri); ?>" height="143" width="191"  alt="<?=$titulo ?>" class="imgH6Grande" />
  <?
    } else {
  ?>
    <li>
  <?
    }

  ?>
  
  <h6><?= format_date($value->created, 'long');?></h6>
  <h4><a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid)); ?>"><?=$value->title;?></a></h4>
  <p>
    <a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid)); ?>">
      <?php echo str_replace("[@#galeria#@]", "", str_replace("[@#podcast#@]", "", str_replace("[@#video#@]", "", !empty($value->body_summary)? $value->body_summary : truncate_utf8(strip_tags($value->body_value), '120', TRUE, TRUE)))); ?>
    </a>
  </p>
  <h5 class="fonte">
    Por <?= $value->fonte.'</h5>'; ?>
  <div class="tagsExibir">
    <!--<h5>Tags:</h5>
    <ul class="tags">
      <?/*foreach($value->tags AS $tKey => $tValue){?>
        <li><a href="<?=url(drupal_lookup_path('alias',"taxonomy/term/".$tValue->tid));?>" title="<?=$tValue->tag?>"><?=$tValue->tag?></a></li>
      <?}*/?>
    </ul>-->
  </div>
</li>
<? endforeach; ?>
</ul>
<div class="divPaginacao">
  <?= $vPaginacao;?>
</div>