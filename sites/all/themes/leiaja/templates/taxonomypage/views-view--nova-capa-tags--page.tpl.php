<?php
//ESTA TPL SUBSTITUI O SISTEMA PADRÃO DE TAXYNOMIAS DO TEMA
?>

<style type="text/css">
  .bloco-topo-taxonomia{font-family:arial}
  .bloco-topo-taxonomia ul li a img{display:none}
  .bloco-topo-taxonomia ul li.views-row-1 a img,.bloco-topo-taxonomia ul li.views-row-5 a img,.bloco-topo-taxonomia ul li.views-row-8 a img{display:block}
  .bloco-topo-taxonomia ul li a{color: #4C4B4C;text-decoration:none}
  .topicos-taxonomia{font-size:11px;}
  .topicos-taxonomia a{color:#000}
  .topicos-taxonomia a:hover{text-decoration: underline}
  .bloco-topo-taxonomia .views-row-1 .imagem-destaque img{margin-right: 25px;}
  .bloco-topo-taxonomia .views-row-1 .titulo-noticia,.bloco-topo-taxonomia .views-row-2 .titulo-noticia{border-bottom: 1px dotted #AAA;width: 300px;float: left;padding-bottom: 15px;font-size: 26px}
  .bloco-topo-taxonomia .titulo-noticia a{}
  .bloco-topo-taxonomia .views-row.views-row-2,.bloco-topo-taxonomia .views-row.views-row-1{border-bottom:none;margin:0;}
  .bloco-topo-taxonomia .views-row-3,.bloco-topo-taxonomia .views-row-6{clear: both;}
  .bloco-topo-taxonomia .views-row.views-row-3,.bloco-topo-taxonomia .views-row.views-row-6{margin:25px 0 0 0;}
  .bloco-topo-taxonomia .views-row{border-bottom: 1px dotted #AAA;margin: 25px 0 0 25px;padding-bottom: 15px;min-height: 80px;}
  /*estilos blocos de noticias menores*/
  .bloco-topo-taxonomia .views-row-3,
  .bloco-topo-taxonomia .views-row-4,
  .bloco-topo-taxonomia .views-row-6,
  .bloco-topo-taxonomia .views-row-7,
  .bloco-topo-taxonomia .views-row-9,
  .bloco-topo-taxonomia .views-row-10{width: 137px;float: left;font-size: 12.3px;line-height: 19px}
  .bloco-topo-taxonomia .views-row.views-row-9.views-row-odd {clear: both;margin-left: 0!important;}
  /*fim estilos blocos de noticias menores*/
  .bloco-topo-taxonomia .views-row-5,.bloco-topo-taxonomia .views-row-8{font-size: 17px;width: 300px;float:left;}
  .bloco-topo-taxonomia .views-row-5 img,.bloco-topo-taxonomia .views-row-8 img{width:100px;height:75px;margin-right: 15px;}
  
  /*listagem*/
  .maisNoticiasH2 {font-family: Arial,Helvetica,sans-serif;font-size: 20px;margin: 15px 0;color:#EA0C25}
  .listagem-mais-noticias-por-taxonomia{clear:both;font-family: arial;color:#000;float: left;}
  .listagem-mais-noticias-por-taxonomia a{text-decoration: none}
  .listagem-mais-noticias-por-taxonomia a:hover{text-decoration:underline}
  .listagem-mais-noticias-por-taxonomia .titulo-noticia-taxonomia a{color: black;font-size: 16px;}
  .listagem-mais-noticias-por-taxonomia p{font-size: 12px;color: #666;}
  .listagem-mais-noticias-por-taxonomia .tagsExibir a{font-size: 12px;color: #EA0C25;text-decoration: none; font-weight: bold;margin: 0 5px;}
  .listagem-mais-noticias-por-taxonomia .tagsExibir h5{margin-right: 10px}
  
  .listagem-mais-noticias-por-taxonomia li{overflow: hidden}
  .tem-imagem{float:left;margin-right: 22px}



  .resultadoBusca{
   margin-top: 20px;
  }
</style>

<?php
    // Recuperando o objeto node
    $arrObjNode = $view->result;

    // Recuperando a páginação
    $flagPaginacao = @$_GET['page']; 
?>

<?php 
  
  // Caso não seja paginação
  if($flagPaginacao == '0' OR !$flagPaginacao):
    
    // Recuperando as notícias
    $dadosDestcComImg = views_get_view_result('nova_capa_tags', 'page', arg(2));
    
    // Recuperando os Nids
    $nidsPass = getNidsByViews($dadosDestcComImg);
    $tamanho = count($dadosDestcComImg);
    
    $dadosDestacSemImg = views_get_view_result('nova_capa_tags', 'sem_img', $nidsPass, arg(2));
    
    if($tamanho == 3 && count($dadosDestacSemImg) == 5){
        
        $nidsPass = $nidsPass .','. getNidsByViews($dadosDestacSemImg);
        $tamanho = $tamanho + count($dadosDestacSemImg);
  
        $contImg = 0;
        $cont = 0;
?>
<div class="term-listing-heading">

<div class="taxonomy-term vocabulary-tags">
    <div class="view">
        
    <div class="view-content">
    <div class="bloco-topo-taxonomia">    
        <ul>     
        <?php 
        $flagImg = false;
        for($i=0;$i<8;$i++):
            
            if(in_array($i, array(0,4,7))){
                $value = @$dadosDestcComImg[$contImg];
                $flagImg = true;
                $intChave = 
                $contImg++;
                $image = @api_getImageCapaViewTratado($value);
            }else{
                $value = @$dadosDestacSemImg[$cont];
                $flagImg = false;
                $cont++;
            }
        
            $nid = @$value->nid;
            $titulo = @$value->node_title;
            $urlNode = @drupal_lookup_path('alias',"node/".$value->nid);
            $nomeChapeu = @$value->field_field_tags[0]['rendered']['#title'];
            $urlChapeu = @$value->field_field_tags[0]['rendered']['#href'];
            $urlChapeu = @drupal_lookup_path('alias', $urlChapeu);
            
            if($i == 0){
                $height = '225';
                $width = '300'; 
                $estilo = 'medium';
            }else{
                $height = '75';
                $width = '100';
                $estilo = 'home_thumb';
            }
        ?>
            <li class="views-row views-row-<?php print $i+1;?> views-row-odd views-row-<?php print odd_even($i);?>">  
                
            <?php if($flagImg):?>
              <div class="imagem-destaque">
                  <a href="/<?php print $urlNode;?>">
                      <?php
                          $img = array();
                          $img['style']= $estilo;
                          $img['uri']= $image['uriImg'];
                          $img['class']= array('imgH4');
                          $img['alt']= $image['altImg'];
                          $img['title']= $image['ttImg'];
                          $img['width']= $width;
                          $img['height']= $height;

                          //imprimindo a tag <img> com os atributos desejados.
                          image_static_lazy($img);
                          
                      ?>
                  </a>
              </div>  
            <?php endif;?>
                
            <strong class="field-content topicos-taxonomia"><a href="/<?php print $urlChapeu;?>" typeof="skos:Concept" property="rdfs:label skos:prefLabel" datatype="" class="active"><?php print $nomeChapeu;?></a></strong>    
            <h3 class="field-content titulo-noticia"><a href="/<?php print $urlNode;?>"><?php print $titulo;?></a></h3>  
            </li>
        <?php endfor;?>
            
      </ul>
    </div>    
    </div>
  
</div> 
</div>
</div>

<div class="banner_colunista">
    <div class="publicidade">
    <?php
         $blockBanner = block_load('block','34');
         $renderable_blockI=_block_get_renderable_array(_block_render_blocks(array($blockBanner)));
         print render($renderable_blockI);
     ?>
    </div>
    
    <div class="colunas2_2 margin-left25 margin-top11">
    <h2 class="tagDestaqueH2 cinza">Colunistas</h2>
    <?php
         $blocColunistas = block_load('widget','bloco-getcolunistas');
         $renderable_blockII=_block_get_renderable_array(_block_render_blocks(array($blocColunistas)));
         print render($renderable_blockII);
     ?>
    </div>
</div>
  
<?php
      // Caso Tenha notícias suficientes para montar a página de cima
      // Esxluo as nodes da parte de baixo
      $arrObjNode = ignoreNoticia($arrObjNode, $nidsPass);
      $arrObjNode = ignoreNoticia($arrObjNode, $nidsPass);
      
    }
endif;?>

<div class="listagem-mais-noticias-por-taxonomia listaResultado resultadoBusca">
    <h2 class="maisNoticiasH2" style="float:none">Mais Notícias</h2>
      <div class="view-content">
        <div class="container-taxonomy-page">    
          <ul>
          <?php 
          foreach ($arrObjNode as $value):
              $nid = $value->nid;
              $titulo = $value->node_title;
              $urlNode = drupal_lookup_path('alias',"node/".$value->nid);
              
              $language = key($value->_field_data['nid']['entity']->body);
              if(!empty($value->_field_data['nid']['entity']->body[$language][0]['summary'])){
                  $texto = $value->_field_data['nid']['entity']->body[$language][0]['summary'];
              }else{
                  $texto = $value->_field_data['nid']['entity']->body[$language][0]['value'];
                  $texto = limitaTexto(strip_tags(retiraHash($texto)), 200);
              }
              
              $arrTags = $value->field_field_tags;
              $image = @api_getImageCapaViewTratado($value);
          ?>
              <li class="views-row-odd views-row-first">  
                  <div class="tem-imagem">
                      <?php if(!empty($image['uriImg'])): ?>
                        <a href="/<?php print $urlNode;?>">
                          <?php
                              $img = array();
                              $img['style']= 'home_cadernos';
                              $img['uri']= $image['uriImg'];
                              $img['class']= array('imgH4');
                              $img['alt']= $image['altImg'];
                              $img['title']= $image['ttImg'];
                              $img['width']= '191';
                              $img['height']= '143';

                              //imprimindo a tag <img> com os atributos desejados.
                              image_static_lazy($img);
                          ?>
                        </a>
                      <?php endif;?>
                  </div>
                  <span class="views-field views-field-title"> 
                      <span class="field-content titulo-noticia-taxonomia">
                          <a href="/<?php print $urlNode;?>">
                            <?php print $titulo;?>
                          </a>
                      </span>  
                  </span>  
                  <div class="views-field views-field-body">       
                      <p class="field-content">
                            <?php print $texto;?>
                      </p>  
                  </div>  
                  <div class="views-field views-field-field-tags tagsExibir">    
                      <h5 class="views-label views-label-field-tags">Tags: </h5>    
                      <div class="field-content tag-topico tags">
                          <?php 
                          foreach ($arrTags as $tag):
                              $nomeTag = $tag['rendered']['#title'];
                              $urlTag = $tag['rendered']['#href'];
                              $urlTag = drupal_lookup_path('alias',$urlTag);
                           ?>
                            <a href="/<?php print $urlTag;?>" typeof="skos:Concept" property="rdfs:label skos:prefLabel" datatype="" class="active">
                              <?php print $nomeTag;?>
                            </a>
                          <?php endforeach;?>
                      </div>  
                  </div>
              </li>
              <?php endforeach;?>
          </ul>
             <?php print theme('pager');?>
        </div>   
      </div>
</div> 

<?php
      function odd_even($count){
          if($count == 1){$flag = 'first';}
          elseif($count % 2 == 0){$flag = 'even';}
          else{$flag = 'odd';}
          
          return $flag;
      }
?>
