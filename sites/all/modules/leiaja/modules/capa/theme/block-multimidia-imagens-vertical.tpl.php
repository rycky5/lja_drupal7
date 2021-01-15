<div class="wgd12 hgd9 boxSlideImgVertical container-slideshow">
  <ul class="slider">
   <?php foreach($arrObjNodes as $key=>$node):
   $node->image_style = "multimidia_img_vertical";
   $node  = filtrarCampos($node);?>
   <li class="wgd4 hgd8">
     <div class="wgd2 hgd8">
       <a href="<?php print $node['link'];?>">
         <?php
            $img = array();
            $img['style']='multimidia_img_vertical';
            $img['stylethumb']="multimidia_img_vert_low";
            $img['uri']=$node['uri'];
//            $img['class']=array('');
            $img['alt']=$node['titulo'];
            $img['title']=$node['titulo'];
            $img['width']="140";
            $img['height']="300";
//            $img['atribute'] = array('');
            //imprimindo a tag <img> com os atributos desejados.
            image_static_lazy($img);
          ?>
         <!--<img class="lazy" width="140" height="300" alt="<?php //print $node['titulo']; ?>" title="<?php //print $node['titulo']; ?>" src="<?php //echo $node['urlImg'];?>" />-->
         </a>
     </div>
     <div class="wgd2 hgd8">
       <h1><a href="<?php echo $node['link'];?>"><?php echo $node['chapeu'];?></a></h1>
       <h2><a href="<?php echo $node['link'];?>"><?php echo $node['titulo'];?></a></h2>
       <p><a href="<?php echo $node['link'];?>"><?php echo limitaTexto(retiraHash($node['conteudo']),140);?></a></p>
     </div>
   </li>
    <?php endforeach;?>
  </ul>
  <!-- paginacao -->
  <div class="paginacao">
   <ul>
     <li><a href="#" class="ativo">&nbsp;</a></li>
     <?php foreach($arrObjNodes as $key=>$node):
     if($key!=0 && $key %3 == 0):?>
       <li><a href="#" >&nbsp;</a></li>
     <?endif;?>
     <?php endforeach;?>
   </ul>
  </div>
<!-- /paginacao -->
</div>