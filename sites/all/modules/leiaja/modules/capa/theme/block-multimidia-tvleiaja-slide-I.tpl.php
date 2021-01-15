<div class="wgd4 hgd9 boxRedondo container-slideshow">
  <div class="boxMenor">
      <ul class="slideshow-lista slider">
        <?php foreach($arrObjNodes as $key=>$node):
          //funcao que retornar o tratamento dos campos.
//          echo "<pre>";
//          var_dump($node);
//          die;
          $node = filtrarCampos($node);
        ?>
          <li class="slide slide<?=$key;?>"> 
              <a href="<?php echo $node['link'];?>">
                 <?php
            $img = array();
            $img['style']='medium';
            $img['uri']=$node['uri'];
//            $img['class']=array('');
            $img['alt']=$node['titulo'];
            $img['title']=$node['titulo'];
            $img['width']="298";
            $img['height']="205";
//            $img['atribute'] = array('');
            //imprimindo a tag <img> com os atributos desejados.
            image_static_lazy($img);
          ?>
<!--<img src="<?php //echo $node['urlImg']; ?>" border="0" width="298" height="205" />-->
              </a>
              <h2><a href="<?php echo $node['link'];?>" class="vermelho"><?php echo $node['titulo'];?></a></h2>
              <!-- aaa --->
              <p><a href="<?php echo $node['link'];?>"><?php echo limitaTexto(retiraHash($node['conteudo']),85)?></a></p>
              <!-- bb --->
         </li>
      <?php endforeach;?>
      </ul>
    <!-- paginacao-->
    <div class="paginacao">
      <ul>
        <li><a href="javascript:void(0);" class="ativo">&nbsp;</a></li>
        <li><a href="javascript:void(0);">&nbsp;</a></li>
        <li><a href="javascript:void(0);">&nbsp;</a></li>
        <li><a href="javascript:void(0);">&nbsp;</a></li>
      </ul>
    </div>
    <!-- paginacao-->	
   </div>
</div>