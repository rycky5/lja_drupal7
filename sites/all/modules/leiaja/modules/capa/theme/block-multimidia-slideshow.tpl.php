<?php
/**
 * Arquivo que conterá o bloco de slideshow da pagina multimidia
 * 
 * @author Henrique da Penha
 */

?>
<div class="divContainerGrande slideCromo">
      <div class="cnt12">
        <div class="centroContainer">
        <div class="wgd12 hgd10 container-slideshow" style="overflow:hidden">
          <div class="slider">
          <?php 
          foreach($arrObjNodes as $key=>$node):
            @$node->image_style = 'large';
            $node = filtrarCampos($node);
            ?>
          <!-- slide <?php echo $key?>-->
          <div class="slide slide<?php echo $key?>">
            <a href="<?php echo $node['link'];?>">
              <div class="sombra"></div>
              <div class="conteudo">
                <h1><?php echo $node['titulo'];?></h1>
                <p>
                  <?php echo retiraHash($node['conteudo']);?>
                </p>              
                <a class="lermais" href="<?php echo $node['link'];?>"><?php echo $node['titulo'];?></a>
              </div>
              <?php
//            $img = array();
//            $img['style']='large';
//            $img['uri']=$node['uri'];
////            $img['class']=array('');
//            $img['alt']=$node['titulo'];
//            $img['title']=$node['titulo'];
//            $img['width']="470";
//            $img['height']="360";
////            $img['atribute'] = array('');
//            //imprimindo a tag <img> com os atributos desejados.
//            image_static_lazy($img);
          ?>
              <img src="<?php echo image_static_url('large',$node['uri']); ?>" width="470" height="360" />
             </a>
          </div>
          <!-- /slide <?php echo $key?>-->
         
        <?php endforeach;?>
          </div>
          <!-- paginacao-->
          <div class="paginacao">
            <ul>
              <li><a href="#" class="ativo">&nbsp;</a></li>
              <li><a href="#">&nbsp;</a></li>
              <li><a href="#">&nbsp;</a></li>
              <li><a href="#">&nbsp;</a></li>
            </ul>
          </div>
          <!-- paginacao-->
        </div>
      </div>
      </div>
</div>

<?php
// drupal_add_js(drupal_get_path('module', 'capa').'/js/util.js');

  ?>