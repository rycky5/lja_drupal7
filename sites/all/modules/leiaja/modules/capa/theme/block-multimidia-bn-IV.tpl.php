<?php
/**
 * Arquivo que conterá o template dos bloco de Videos
 * Esse arquivo foi alterado
 * 
 * @author Weydson Fraga
 */
//add CSS à pagina de multimidia
drupal_add_css(drupal_get_path('module', 'capa') . '/css/style_capa.css');
?>
<div class="wgd12 hgd5 box4Cols">
  <ul>
    <?php
    foreach ($arrObjNodes as $key => $node):
      $node->image_style = "multimidia_tv_leiaja_abas";
      $node = filtrarCampos($node);
      ?>

      <li>
        <a href="<?php echo $node['link']; ?>">
          <?php
          $img = array();
          $img['style'] = 'multimidia_tv_leiaja_abas';
          $img['uri'] = $node['uri'];
//            $img['class']=array('');
          $img['alt'] = $node['titulo'];
          $img['title'] = $node['titulo'];
          $img['width'] = "220";
          $img['height'] = "94";
//            $img['atribute'] = array('');
          //imprimindo a tag <img> com os atributos desejados.
          image_static_lazy($img);
          ?>
          <!--<img width="220" height="94" src="<?php //echo $node['urlImg'];    ?>" />-->
        </a>
        <h1><a href="<?php echo $node['link']; ?>"><?php print limitaTexto($node['titulo'], 40); ?></a></h1>
        <p><a href="<?php echo $node['link']; ?>"><?php print limitaTexto($node['conteudo'], 80); ?></a></p>			
      </li>

    <?php endforeach; ?>

  </ul>
</div>