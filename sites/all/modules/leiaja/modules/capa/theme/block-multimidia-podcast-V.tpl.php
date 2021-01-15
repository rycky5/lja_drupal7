<div class="wgd4 hgd8 podcast">
  <?php foreach($arrObjNodes as $key=>$node):
    //funcao que retornar o tratamento dos campos.
    $node = filtrarCampos($node);
    if($key==0):?>
      <div class="wgd4 hgd3 playerExibicao">
       <h1 class="video chapeu"><a href="<?php echo $node['linkChapeu'];?>"><?php echo $node['chapeu'];?></a></h1>
       <p class="titvideo"><a href="javascript:void(0)<?php //echo $node['link'];?>" data_id="<?php echo $node['podcast_id'];?>"><?php echo $node['titulo'];?></a></p>
       <div id="playerPodcast">
         <?php echo $node['podcast'];?>
       </div>
      </div>
      <ul>
    <?php else:?>
      <li class="wgd4 hgd2">
      <h1 class="video chapeu"><a href="<?php echo $node['linkChapeu'];?>"><?php echo $node['chapeu'];?></a></h1>
      <p class="titvideo"><a href="javascript:void(0)" data_id="<?php echo $node['podcast_id'];?>"><?php echo $node['titulo'];?></a></p>
      </li>
    <?php endif;?>
  <?php endforeach;?>
  </ul>
</div>