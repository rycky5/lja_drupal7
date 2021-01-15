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
 
 $arrNodesCarrocel = views_get_view_result('nova_capa_multimidia_videos', 'carrocel', $nidsPass);
 $qtde = count($arrNodesCarrocel) ;
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
        foreach ($arrNodesCarrocel as $key=>$node):
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
        
          <li class="wgd4">
            <div class="wgd4 hgd1"><h1 class="video"><a href="/<?php print $urlChapeu;?>"><?php echo $chapeu;?></a></h1></div>
            <div class="wgd4 hgd6 visualizarVideo">
              <div>
                <span>
                  <a href="/<?php print $urlNode;?>">
                    <?php
                      $img = array();
                      $img['style']     = 'multimidia_videos';
                      $img['uri']= $imagem['uriImg'];
                      $img['class']= array('lazy');
                      $img['alt']= $imagem['altImg'];
                      $img['title']= $imagem['ttImg'];
                      $img['width']     = "250";
                      $img['height']    = "149";
                      //imprimindo a tag <img> com os atributos desejados.
                      image_static_lazy($img);
                    ?>
                  </a>
                </span>
              </div>
            </div>
            <div class="wgd4 hgd2"><p><a href="/<?php echo $urlNode;?>"><?php print $titulo; ?></a></p></div>  
          </li>  
        
    <?php endforeach; ?>
    </ul>
    </div>
    <a href="#" class="passadorPequenoDir" data-passador="proximo"></a>
    <a href="#" class="passadorGrandeDir" data-passador="proximo"></a>       
</div>