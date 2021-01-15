<?php
/**
 * Arquivo que conterá o bloco de tecnologia da home
 * 
 * @author Alberto Medeiros
 */
//$vars = cache_get("teste_cache");
$baseModule = drupal_get_path('module', 'capa');
?>
<div class="wgd4 hgd9 boxSlideGourmet">
  <span><img src="/<?= $baseModule . '/images/' ?>logoNasocial.png" width="280" height="114" /></span>
  <div>
    <p class="left" data-passador="anterior"><img src="/<?= $baseModule . '/images/' ?>SlideGourmetEsquerda.jpg" width="35" height="143" /></p>
    <p class="right" data-passador="proximo"><img src="/<?= $baseModule . '/images/' ?>SlideGourmetDireita.jpg" width="35" height="143" /></p>
    <div class="container-slides-gourmet">
      <ul>
        <?php
        foreach ($arrObjNodes as $key => $node):
          $node = filtrarCampos($node);
          ?>
          <li>
            <a href="<?php echo $node['link']; ?>">
              <?php
              $img = array();
              $img['style'] = '';
              $img['uri'] = $node['uri'];
              $img['class'] = array('');
              $img['alt'] = $node['titulo'];
              $img['title'] = $node['titulo'];
              $img['width'] = "210";
              $img['height'] = "143";
//            $img['atribute'] = array('');
              //imprimindo a tag <img> com os atributos desejados.
              image_static_lazy($img);
              ?>
              <!--<img src="<?php // echo $node['urlImg']; ?>" border="0" width="210" height="143"/>-->
            </a>
            <p><a href="<?php echo $node['link']; ?>" class="link"><?php echo $node['titulo']; ?></a><p>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
