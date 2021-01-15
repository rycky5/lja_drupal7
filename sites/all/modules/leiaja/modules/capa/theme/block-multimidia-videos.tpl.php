<?php
/**
 * Arquivo que conterá o template dos bloco de Videos
 * Esse arquivo foi alterado
 * 
 * @author Weydson Fraga
 */ 
?>
<?php 
//add CSS à pagina de multimidia
 drupal_add_css(drupal_get_path('module', 'capa') . '/css/style_capa.css'); 
    switch ($qtde):
        case 9:
            $classGride = 'wgd12';
            break;
        case 6:
            $classGride = 'wgd8';
            break;
        case 3:
            $classGride = 'wgd4';       
            break;
    endswitch;
?>
<div class="<?php echo $classGride.' hgd8 boxVerVideo';?>">           
    <a href="#" class="passadorGrandeEsq" data-passador="anterior"></a>
    <a href="#" class="passadorPequenoEsq" data-passador="anterior"></a>
    <div class="carrossel">
    <ul>          
      <?php
        foreach ($arrObjNodes as $key=>$node):
          $node->image_style = "multimidia_videos";
          $node = filtrarCampos($node);
      ?>
        
          <li class="wgd4">
            <div class="wgd4 hgd1"><h1 class="video"><a href="<?php echo $node['linkChapeu'];?>"><?php echo $node['chapeu'];?></a></h1></div>
            <div class="wgd4 hgd6 visualizarVideo">
              <div>
                <span>
                  <a href="<?php echo $node['link'];?>">
                    <?php
                      $img = array();
                      $img['style']='multimidia_videos';
                      $img['uri']=$node['uri'];
          //            $img['class']=array('');
                      $img['alt']=$node['titulo'];
                      $img['title']=$node['titulo'];
                      $img['width']="250";
                      $img['height']="149";
          //            $img['atribute'] = array('');
                      //imprimindo a tag <img> com os atributos desejados.
                      image_static_lazy($img);
                    ?>
                    <!--<img width="250" height="149" src="<?php //echo $node['urlImg'];?>" />-->
                  </a>
                </span>
              </div>
            </div>
            <div class="wgd4 hgd2"><p><a href="<?php echo $node['link'];?>"><?php print $node['titulo']; ?></a></p></div>  
          </li>  
        
    <?php endforeach; ?>
    </ul>
    </div>
    <a href="#" class="passadorPequenoDir" data-passador="proximo"></a>
    <a href="#" class="passadorGrandeDir" data-passador="proximo"></a>       
</div>