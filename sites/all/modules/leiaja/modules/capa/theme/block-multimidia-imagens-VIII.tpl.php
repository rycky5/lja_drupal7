<?php foreach($arrObjNodes as $key=>$node):
  
    // $node->image_style = "multimidia_img_grande";
    $node = filtrarCampos($node);
  ?>
<div class="wgd8 hgd14 boxImgGrande">  
    <div class="wgd8 hgd1"><h1 class="video"><a href="<?php echo $node['linkChapeu']; ?>"><?php echo $node['chapeu'];?></a></h1></div>
    <div class="wgd8 hgd12"><a href="<?php echo $node['link']; ?>">
        <?php
              $img = array();
              $img['style']='multimidia_img_grande';
              $img['uri']= $node["uri"];
              $img['class']= array('');
              $img['alt']= $node['titulo'];
              $img['title']= $node['titulo'];
              $img['width']= "620";
              $img['height']= "460";

              //imprimindo a tag <img> com os atributos desejados.
              image_static_lazy($img);
        ?>
        <!--<img width="620" height="460" alt="<?php // print $node['titulo']; ?>" title="<?php // print $node['titulo']; ?>" src="<?php // echo $node['urlImg']; ?>" />-->
      </a>
    </div>
    <div class="wgd8 hgd2"><p><a href="<?php echo $node['link']; ?>"><?php echo $node['titulo']; ?></a></p></div>
    </div>
         
<?php endforeach;?>          