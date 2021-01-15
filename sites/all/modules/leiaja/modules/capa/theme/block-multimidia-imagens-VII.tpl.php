<div class="wgd4 hgd14 boxVerticalImagem">
  <?php foreach($arrObjNodes as $key=>$node):
  /*
   * para a primeira posicao
   */
//    if($key==0):
//      $imgCapa        = $node->_field_data["nid"]["entity"]->field_capa["pt-br"][0]["uri"];
//      //setando a img à variável
//      $imagem         = $node->_field_data["nid"]["entity"]->field_image["pt-br"][0]["uri"];
//      //fazendo a verificação se a img de capa existe. caso exista para ser setada à variavel;
//      $urlImgHorizontal            = (!empty($imgCapa)?$imgCapa:$imagem);
////      $urlImgHorizontal = image_static_url('multimidia_img_horizontal',$img);
//    endif;
 
    /*
     * fim para primeira posicao
     */
    //funcao que retornar o tratamento dos campos.
    if($key==0){
      $node->image_style = "multimidia_img_horizontal";
    }else{
      $node->image_style = "thumbnail";
    } 
    $node->image_style = "thumbnail";
    $node = filtrarCampos($node);
    if($key==0):?>
       <div class="wgd4 hgd5 destaque">
         <div class="wgd4 hgd1"><h1 class="video"><a href="<?php echo $node['linkChapeu']?>"><?php echo $node['chapeu'];?></a></h1></div>
         <div class="wgd4 hgd3">
           <a href="<?php echo $node['link'];?>">
             <?php
              $img = array();
              $img['style']='multimidia_img_horizontal';
              $img['uri']= $node["uri"];
              $img['class']= array('');
              $img['alt']= $node['titulo'];
              $img['title']= $node['titulo'];
              $img['width']= "300";
              $img['height']= "100";

              //imprimindo a tag <img> com os atributos desejados.
              image_static_lazy($img);
            ?>
<!--             <img width="300" height="100" alt="<?php // print $node['titulo']; ?>" title="<?php // print $node['titulo']; ?>"  src="<?php // echo $urlImgHorizontal; ?>" />-->
           </a>
         </div>
         <div class="wgd4 hgd2"><p><a href="<?php echo $node['link'];?>"><?php echo $node['titulo'];?></a></p></div>
       </div>
  <ul>
 <?php else:?>
   <li class="wgd4 hgd3">
     <h1 class="video"><a href="<?php echo $node['linkChapeu']?>"><?php echo $node['chapeu'];?></a></h1>
     <a href="<?php echo $node['link'];?>">
        <?php
              $img = array();
              $img['style']='thumbnail';
              $img['uri']= $node["uri"];
              $img['class']= array('');
              $img['alt']= $node['titulo'];
              $img['title']= $node['titulo'];
              $img['width']= "108";
              $img['height']= "82";

              //imprimindo a tag <img> com os atributos desejados.
              image_static_lazy($img);
        ?>
       <!--<img width="108" height="82" alt="<?php // print $node['titulo']; ?>" title="<?php // print $node['titulo']; ?>" src="<?php // echo $node['urlImg']; ?>" />-->
     </a>
     <p><a href="<?php echo $node['link'];?>"><?php echo $node['titulo'];?></a></p>
   </li>
 <?php endif;?>
 <?php endforeach;?>
 </ul>
</div>