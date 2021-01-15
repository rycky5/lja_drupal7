<script type="text/javascript" src="/sites/all/modules/leiaja/modules/capa/js/abas.js"></script>

<?php 
$flagPaginacao = $_GET['page']; 
if(!$flagPaginacao OR $flagPaginacao === '0'):
?>
<div class="divContainerGrande">
      <div class="cnt12">
        <div class="centroContainer">
       <?php
        $arrNodesDestaqueII = views_get_view_result('nova_capa_multimidia_videos', 'destaque_ii');
        $nidsPass = getNidsByViews($arrNodesDestaqueII);
        
        foreach ($arrNodesDestaqueII as $key => $node):
            $nid = $node->nid;
            $titulo = $node->node_title;
            $urlNode = drupal_lookup_path('alias',"node/".$node->nid);
            
            $tempCategoria = getDadosCategoria($node);
    
            if($tempCategoria){
                $chapeu = $tempCategoria['nome'];
                $urlChapeu = $tempCategoria['url'];
            }else{
                $chapeu = '';
                $urlChapeu = '';
            }
            
            $imagem = api_getImageCapaViewTratado($node);
        ?>
        <!-- box - Bloco Multimidia Imagens Destaque II -->
            <div class="wgd4 hgd8 boxPimg1">
                <div class="wgd4 hgd1">
                  <h1 class="titulo video">
                    <a href="<?php print $urlChapeu;?>">
                      <?php print $chapeu;?>
                    </a>
                  </h1>
                </div>
              <div class="wgd4 hgd6"><a href="/<?php print $urlNode; ?>">
                  <?php
                    $img = array();
                    $img['style']='multimidia_img_ii';
                    $img['uri']= $imagem['uriImg'];
                    $img['class']= array('lazy');
                    $img['alt']= $imagem['altImg'];
                    $img['title']= $imagem['ttImg'];
                    $img['width']= "300";
                    $img['height']= "220";

                    //imprimindo a tag <img> com os atributos desejados.
                    image_static_lazy($img);
                ?>
                </a>
              </div>
              <div class="wgd4 hgd2"><p><a href="/<?php print $urlNode;?>"><?php print $titulo; ?> </a></p></div>
            </div>
        <!-- /box -->

    <?php endforeach; ?>
        
   <div class="wgd4 hgd8 boxNotList1">
        <ul>
          <?php
          $arrNodesImgIv = views_get_view_result('nova_capa_multimidia_videos', 'imagem_iv', $nidsPass);
          $nidsPass = $nidsPass . ',' . getNidsByViews($arrNodesImgIv);
          
          foreach ($arrNodesImgIv as $key => $node):
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
          ?>
          <li class="wgd4 hgd2">
            <a href="/<?php print $urlNode;?>">
                <?php
                    $img = array();
                    $img['style']='multimidia_miniatura';
                    $img['uri']= $imagem['uriImg'];
                    $img['class']= array('lazy');
                    $img['alt']= $imagem['altImg'];
                    $img['title']= $imagem['ttImg'];
                    $img['width']= "73";
                    $img['height']= "55";

                    //imprimindo a tag <img> com os atributos desejados.
                    image_static_lazy($img);
                ?>
            </a>
            <h1><a href="/<?php print $urlNode;?>"><?php print $titulo; ?> </a></h1>
            <span class="video"><a href="<?php print $urlChapeu;?>"> <?php print $chapeu;?> </a></span>
          </li>  
          <?php endforeach; ?>
        </ul>
    </div>
        
     </div>
  </div>
</div>

<div class="divContainerGrande">
  <div class="cnt12">
    <div class="centroContainer">
      <div class="abreBox divisorBoxTop">
      <!-- abre o box --><div class="wgd12 hgd1"><h1 class="vermelho">MAIS VISTOS</h1></div><!-- /abre o box -->
      </div>
        <?php 
        $pathInclud = drupal_realpath('sites/all/themes/multimidia/template/includes/videos_mais_vistos.inc');
        require_once($pathInclud);
        ?>
    </div>
  </div>
</div>

<?php endif;?>

<div class="divContainerGrande">
  <div class="cnt12">
    <div class="centroContainer">
      <div class="abreBox divisorBoxTop">
        <!-- abre o box --><div class="wgd12 hgd1"><h1 class="vermelho">OUTROS VIDEOS</h1></div><!-- /abre o box -->
      </div>
        <?php 
            $arrObjNodes = views_get_view_result('nova_capa_multimidia_videos', 'page', $nidsPass);
            ?>
            <div class="wgd12 hgd12 boxNotListHor">
              <ul>
                <?php foreach ($arrObjNodes as $key=>$node):
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
                ?>
                  <li class="wgd4 hgd3">
                    <h1 class="video"><a href="<?php print $urlChapeu;?>"><?php print $chapeu;?></a></h1>
                    <a href="/<?php print $urlNode;?>">
                        <?php
                            $img = array();
                            $img['style']='multimidia_videos';
                            $img['uri']= $imagem['uriImg'];
                            $img['class']= array('lazy');
                            $img['alt']= $imagem['altImg'];
                            $img['title']= $imagem['ttImg'];
                            $img['width']= "100";
                            $img['height']= "77";

                            //imprimindo a tag <img> com os atributos desejados.
                            image_static_lazy($img);
                        ?>
                    </a>
                    <p><a href="/<?php print $urlNode;?>"><?php print $titulo; ?> </a></p>
                  </li>    
                <?php endforeach; ?>  
              </ul>
                <?php print theme('pager');?>
            </div> 
      <div class="fechaBox divisorBoxBottom">
        <!-- fecha o box --><div class="wgd12 hgd1"><h1 class="vermelho">&nbsp;</h1></div><!-- /fecha o box -->
      </div>    
    </div>
  </div>
</div>
