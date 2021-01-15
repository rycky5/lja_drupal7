<div class="wgd12 hgd9 boxSlideImgVertical container-slideshow">
  <ul class="slider">
   <?php 
   $arrNodesImgMaisVistas = views_get_view_result('nova_capa_multimidia_imagens', 'mais_vistos', $nidsPass);
   $nidsPass = $nidsPass . ',' . getNidsByViews($arrNodesImgMaisVistas);
   
   foreach($arrNodesImgMaisVistas as $key=>$node):
        $nid = $node->nid;
        $titulo = $node->node_title;
        $urlNode = drupal_lookup_path('alias',"node/".$node->nid);
        $conteudo = strip_tags($node->field_body[0]['raw']['value']);
        $conteudo = limitaTexto(retiraHash($conteudo),140);

        $tempCategoria = getDadosCategoria($node);
        
    if($tempCategoria){
        $chapeu = $tempCategoria['nome'];
        $urlChapeu = $tempCategoria['url'];;
    }else{
        $chapeu = '';
        $urlChapeu = '';
    }

        $imagem = api_getImageCapaViewTratado($node);
   ?>
   <li class="wgd4 hgd8">
     <div class="wgd2 hgd8">
       <a href="/<?php print $urlNode;?>">
         <?php
            $img = array();
            $img['style']='multimidia_img_vertical';
            $img['stylethumb']="multimidia_img_vert_low";
            $img['uri']= $imagem['uriImg'];
            $img['class']= array('lazy');
            $img['alt']= $imagem['altImg'];
            $img['title']= $imagem['ttImg'];
            $img['width']="140";
            $img['height']="300";
            
            //imprimindo a tag <img> com os atributos desejados.
            image_static_lazy($img);
          ?>
         </a>
     </div>
     <div class="wgd2 hgd8">
       <h1><a href="<?php print $urlChapeu;?>"><?php print $chapeu;?></a></h1>
       <h2><a href="/<?php print $urlNode;?>"><?php print $titulo;?></a></h2>
       <p><a href="/<?php print $urlNode;?>"><?php print $conteudo;?></a></p>
     </div>
   </li>
    <?php endforeach;?>
  </ul>
  <!-- paginacao -->
  <div class="paginacao">
   <ul>
     <li><a href="#" class="ativo">&nbsp;</a></li>
     <?php foreach($arrNodesImgMaisVistas as $key=>$node):
     if($key!=0 && $key %3 == 0):?>
       <li><a href="#" >&nbsp;</a></li>
     <?endif;?>
     <?php endforeach;?>
   </ul>
  </div>
<!-- /paginacao -->
</div>