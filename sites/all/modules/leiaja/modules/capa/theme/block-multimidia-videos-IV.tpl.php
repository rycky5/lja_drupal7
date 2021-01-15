<?php
/**
 * Arquivo que conterá o template do bloco de Videos IV
 * 
 * @author Weydson Fraga
 */
foreach ($arrObjNodes as $key => $node):
  $node->image_style = "multimidia_videos";
  $node = filtrarCampos($node);
  ?>
  <li class="wgd4">
    <div class="wgd4 hgd1"><h1 class="video"><a href="<?php echo $node['linkChapeu']; ?>"><?php echo $node['chapeu']; ?></a></h1></div>
    <div class="wgd4 hgd6 visualizarVideo"><div><span>
          <?php
          $img = array();
          $img['style'] = 'multimidia_videos';
          $img['uri'] = $node['uri'];
          $img['class'] = array('');
          $img['alt'] = $node['titulo'];
          $img['title'] = $node['titulo'];
          $img['width'] = "250";
          $img['height'] = "149";
//            $img['atribute'] = array('');
          //imprimindo a tag <img> com os atributos desejados.
          image_static_lazy($img);
          ?>
          <!--<img width="250" height="149" alt="<?php // print $node['titulo']; ?>" title="<?php // print $node['titulo']; ?>" src="<?php // echo $node['urlImg']; ?>" />-->
        </span></div></div>
    <div class="wgd4 hgd2"><p><a href="<?php echo $node['link']; ?>"><?php print $node['titulo']; ?></a></p></div>  
  </li>
<?php endforeach; ?>