<?php 
$flagPaginacao = $_GET['page']; 
if(!$flagPaginacao OR $flagPaginacao === '0'):
?>
<!-- containergrande containerLinha -->
<div class="divContainerGrande">
  <div class="cnt12">
    <div class="centroContainer">
        
       <!--box-->
        <?php 
        $bloco_img_vii = drupal_realpath('sites/all/themes/multimidia/template/includes/bloco_multimidia_imagens_vii.inc');
        require_once($bloco_img_vii);
        ?>
       <!--/box-->    
       
       <!--box-->
       <?php 
        $bloco_img_viii = drupal_realpath('sites/all/themes/multimidia/template/includes/bloco_multimidia_imagens_viii.inc');
        require_once($bloco_img_viii);
        ?>
       <!--/box--> 
    </div>
  </div>
</div>
<!-- /containergrande containerLinha -->

 <!-- containergrande containerLinha -->
    <div class="divContainerGrande containerLinha">
    <div class="cnt12">
      <div class="centroContainer">
        <!-- slide img verticais -->
         <?php 
        $bloco_img_vertical = drupal_realpath('sites/all/themes/multimidia/template/includes/mais_vistos_imagens.inc');
        require_once($bloco_img_vertical);
        ?>
        <!-- /slide img verticais-->
        </div>
      </div>
    </div>
   <!-- /containergrande containerLinha -->

   <?php endif;?>
   
<div class="divContainerGrande">
  <div class="cnt12">
    <div class="centroContainer">
      <div class="abreBox divisorBoxTop">
        <!-- abre o box --><div class="wgd12 hgd1"><h1 class="vermelho">Outras Imagens</h1></div><!-- /abre o box -->
      </div>
        <?php 
            $arrObjNodes = views_get_view_result('nova_capa_multimidia_imagens', 'page', $nidsPass);
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
                <?php
                print theme('pager');?>
            </div> 
      <div class="fechaBox divisorBoxBottom">
        <!-- fecha o box --><div class="wgd12 hgd1"><h1 class="vermelho">&nbsp;</h1></div><!-- /fecha o box -->
      </div>    
    </div>
  </div>
</div>