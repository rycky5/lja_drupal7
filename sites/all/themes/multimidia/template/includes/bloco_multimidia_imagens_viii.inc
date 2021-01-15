<?php 
$arrNodesImgVIII = views_get_view_result('nova_capa_multimidia_imagens', 'imagens_viii', $nidsPass);
$nidsPass = $nidsPass . ',' . getNidsByViews($arrNodesImgVIII);

foreach($arrNodesImgVIII as $key=>$node):
    $nid = $node->nid;
    $titulo = $node->node_title;
    $urlNode = drupal_lookup_path('alias',"node/".$node->nid);

    //pegando o chapeu (categoria)
    $tempNode = $node;
    $tempCategoria = getDadosCategoria($tempNode);
    
    if($tempCategoria){
        $chapeu = $tempCategoria['nome'];
        $urlChapeu = $tempCategoria['url'];;
    }else{
        $chapeu = '';
        $urlChapeu = '';
    }

    $imagem = api_getImageCapaViewTratado($node);
  ?>
<div class="wgd8 hgd14 boxImgGrande">  
    <div class="wgd8 hgd1"><h1 class="video"><a href="<?php print $urlChapeu; ?>"><?php print $chapeu;?></a></h1></div>
    <div class="wgd8 hgd12"><a href="/<?php print $urlNode; ?>">
        <?php
              $img = array();
              $img['style']='multimidia_img_grande';
              $img['uri']= $imagem['uriImg'];
              $img['class']= array('lazy');
              $img['alt']= $imagem['altImg'];
              $img['title']= $imagem['ttImg'];
              $img['width']= "620";
              $img['height']= "460";

              //imprimindo a tag <img> com os atributos desejados.
              image_static_lazy($img);
        ?>
      </a>
    </div>
    <div class="wgd8 hgd2"><p><a href="/<?php print $urlNode; ?>"><?php print $titulo; ?></a></p></div>
    </div>
         
<?php endforeach;?>          