<!--ARQUIVO BLOCO DE IMAGENS VII-->

<div class="wgd4 hgd14 boxVerticalImagem">
  <?php 
  $arrNodesImgVII = views_get_view_result('nova_capa_multimidia_imagens', 'imagens_vii');
  $nidsPass = getNidsByViews($arrNodesImgVII);
  
  foreach($arrNodesImgVII as $key=>$node):
    $nid = $node->nid;
    $titulo = $node->node_title;
    $urlNode = drupal_lookup_path('alias',"node/".$node->nid);
    
    $tempCategoria = getDadosCategoria($node);
    
    if($tempCategoria){
        $chapeu = $tempCategoria['nome'];
        $urlChapeu = $tempCategoria['url'];;
    }else{
        $chapeu = '';
        $urlChapeu = '';
    }
    
    $imagem = api_getImageCapaViewTratado($node);
    
    if($key==0):?>
       <div class="wgd4 hgd5 destaque">
         <div class="wgd4 hgd1"><h1 class="video"><a href="<?php print $urlChapeu?>"><?php print $chapeu;?></a></h1></div>
         <div class="wgd4 hgd3">
           <a href="/<?php print $urlNode;?>">
             <?php
              $img = array();
              $img['style']='multimidia_img_horizontal';
              $img['uri']= $imagem['uriImg'];
              $img['class']= array('lazy');
              $img['alt']= $imagem['altImg'];
              $img['title']= $imagem['ttImg'];
              $img['width']= "300";
              $img['height']= "100";

              //imprimindo a tag <img> com os atributos desejados.
              image_static_lazy($img);
            ?>
           </a>
         </div>
         <div class="wgd4 hgd2"><p><a href="/<?php print $urlNode;?>"><?php print $titulo;?></a></p></div>
       </div>
  <ul>
 <?php else:?>
   <li class="wgd4 hgd3">
     <h1 class="video"><a href="<?php print $urlChapeu?>"><?php print $chapeu;?></a></h1>
     <a href="/<?php print $urlNode;?>">
        <?php
            $img = array();
            $img['style']='thumbnail';
            $img['uri']= $imagem['uriImg'];
            $img['class']= array('lazy');
            $img['alt']= $imagem['altImg'];
            $img['title']= $imagem['ttImg'];
            $img['width']= "108";
            $img['height']= "82";

            //imprimindo a tag <img> com os atributos desejados.
            image_static_lazy($img);
        ?>
     </a>
     <p><a href="/<?php print $urlNode;?>"><?php print $titulo;?></a></p>
   </li>
 <?php endif;?>
 <?php endforeach;?>
 </ul>
</div>