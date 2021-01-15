<?php 
    //Novo TPL para o novo blodo de "Blogs da Redação com 3 elementos", criada com Views

    module_load_include('inc', 'widget', 'widget');
    $resultBlogs = conteudoBlogsRedacao(3);
?>

<div class="zbox wgd4 hgd7 box0018" id="blogsDaRedacao">
    <h1><a href="/blogs" class="cinza" title="Blogs da redação"><b>Blogs</b></a></h1>
    <ul class="listaBlogsRedacao cinza">
      <?php
      foreach ($resultBlogs as $key => $value):
      ?>
      <li>       
        <a class="previewmodal7<?=$key?>" href="<?= $value['urlNode'] ?>">
          <img src="<?=$value['urlImg']; ?>" alt="<?= $value['subcategoria'] ?>" class="imgH6Pequena" />
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>


