<?php
/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */

// Includes necessários
module_load_include('inc', 'capa', 'capa.api');
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja') .'/template.api.inc';

//--------------------------
$arrNodePromoDestaSemImagem = views_get_view_result("caderno_esportes", "promo_destaq_semimg");
$nidPass = getNidsByViews($arrNodePromoDestaSemImagem);

$arrNodePromoDestaComImagem = views_get_view_result("caderno_esportes", "promo_destaq_comimg", $nidPass);
$nidPass = $nidPass .','. getNidsByViews($arrNodePromoDestaComImagem);

$arrNodeSemImagem = views_get_view_result("caderno_esportes", "sem_imagem", $nidPass);
$nidPass = $nidPass .','. getNidsByViews($arrNodeSemImagem);

$arrObjNodeImagem = views_get_view_result("caderno_esportes", "com_imagem", $nidPass);
$nidPass = $nidPass .','. getNidsByViews($arrObjNodeImagem);

//populando os dados para os blocos dos clubes
$arrNodesSportComImg = views_get_view_result("caderno_esportes", "sport_com_img", $nidPass);
$nidPass = $nidPass .','. getNidsByViews($arrNodesSportComImg);

$arrNodesSantaCruzComImg = views_get_view_result("caderno_esportes", "santa_cruz_com_img", $nidPass);
$nidPass = $nidPass .','. getNidsByViews($arrNodesSantaCruzComImg);

$arrNodesNauticoComImg = views_get_view_result("caderno_esportes", "nautico_com_img", $nidPass);
$nidPass = $nidPass .','. getNidsByViews($arrNodesNauticoComImg);

$arrNodesSport = views_get_view_result("caderno_esportes", "sport", $nidPass);
$nidPass = $nidPass .','. getNidsByViews($arrNodesSport);

$arrNodesSantaCruz = views_get_view_result("caderno_esportes", "santa_cruz", $nidPass);
$nidPass = $nidPass .','. getNidsByViews($arrNodesSantaCruz);

$arrNodesNautico = views_get_view_result("caderno_esportes", "nautico", $nidPass);
?>
<script type="text/javascript" src="/<?php print  drupal_get_path('theme', 'leiaja')."/js/carrossel.js" ?>"></script>
<script type="text/javascript">
  var arrFotos = new Array();
  <?php 
    foreach($arrNodePromoDestaComImagem as $key => $not):
      $vLink = url(drupal_lookup_path('alias',"node/".$not->nid));
      $vIndice = $key+1;
      // setando a img de capa à variável
      $imgCapa        = @$not->field_field_capa[0]["rendered"]["#item"]["uri"];
      // setando a img à variável
      $imagem         = @$not->field_field_image[0]["rendered"]["#item"]["uri"];
      //fazendo a verificação se a img de capa existe. caso exista para ser setada à variavel;
      $img            = (!empty($imgCapa)?$imgCapa:$imagem);
      
      // Pegando o subCaderno
      $strSubCategoria =api_getCategoria($not);
  ?>
      arrFotos[<?php print  $key ?>] = {"nid" : <?php print  $not->nid ?>,"title" : "<?php print  addslashes($not->node_title) ?>","link" : "<?php print  $vLink ?>","imagem_thumb" : "<?php print  image_static_url('home_thumb', $img); ?>","imagem_grd" : "<?php print  image_static_url('large', $img) ?>","imagem_med" : "<?php print  image_static_url('medium', $img) ?>","user" : "<?php print $GLOBALS['user']->uid.';'.$not->_field_data["nid"]["entity"]->nid?>","resumo":"<?php print   addslashes(trim(truncate_utf8($not->_field_data["nid"]["entity"]->body["pt-br"][0]["summary"],100,true,true))); ?>","subcategoria" : "<?php print  $not->field_field_catesporte[0]["rendered"]["#title"] ?>"};      
  <?php 
        if($key == 4)
          break;
     endforeach; 
  ?>
  (function ($) {
      $(document).ready(function(){
	initCarrossel('peq', false, arrFotos, 'noticiaSlideEsportes');
      });
  })(jQuery);
</script>
<a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodePromoDestaSemImagem[0]->nid)); ?>" class="linkNoticiaPrincipal">
  <h2 class="tituloCaderno"><?php print  $arrNodePromoDestaSemImagem[0]->node_title ?></h2>
  <h3 class="descricaoNoticia"><?php print  (!empty ($arrNodePromoDestaSemImagem[0]->_field_data["nid"]["entity"]->body["pt-br"][0]["summary"])) ? $arrNodePromoDestaSemImagem[0]->_field_data["nid"]["entity"]->body["pt-br"][0]["summary"] : limitaTexto(retiraHash($arrNodePromoDestaSemImagem[0]->_field_data["nid"]["entity"]->body["pt-br"][0]["value"]),140) ?></h3>
</a>
<div class="colunas2_1">
  <div class="contentCol bordaBottom">
    <strong><a class="linksStrong preto" href="<?php print  $arrNodeSemImagem[0]->field_field_catesporte[0]["rendered"]["#href"]; ?>"><?php print  $arrNodeSemImagem[0]->field_field_catesporte[0]["rendered"]["#title"]; ?></a></strong>
    <span id="leiamais1" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrNodeSemImagem[0]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[0]->nid)); ?>" title="Preview"></a>
    </span>
    <h4 class="noticiaH4"><a class="previewmodal1 links cinza" href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[0]->nid)); ?>"><?php print  $arrNodeSemImagem[0]->node_title ?></a></h4>
  </div>
  <div class="contentCol bordaBottom margin-top15">
    <strong><a class="linksStrong preto" href="<?php print  $arrNodeSemImagem[1]->field_field_catesporte[0]["rendered"]["#href"]; ?>"><?php print  $arrNodeSemImagem[1]->field_field_catesporte[0]["rendered"]["#title"]; ?></a></strong>
    <span id="leiamais2" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrNodeSemImagem[1]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[1]->nid)); ?>" title="Preview"></a>
    </span>
    <h4 class="noticiaH4"><a class="previewmodal2 links cinza" href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[1]->nid)); ?>"><?php print  $arrNodeSemImagem[1]->node_title ?></a></h4>
  </div>
  <div class="contentCol bordaBottom margin-top15">
    <strong><a class="linksStrong preto" href="<?php print  $arrNodeSemImagem[2]->field_field_catesporte[0]["rendered"]["#href"] ?>"><?php print  $arrNodeSemImagem[2]->field_field_catesporte[0]["rendered"]["#title"] ?></a></strong>
    <h5 class="noticiaH5"><a class="links cinza" href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[2]->nid)); ?>"><?php print  $arrNodeSemImagem[2]->node_title ?></a></h5>
  </div>
</div>

<div class="colunas2_1 colunaprincipal">
  <!-- Scroll --> 
  <div id="noticiaSlideEsportes" class="main_view margin-left25">				
    <div class="window" style="width:300px;height:226px;">
      <div class="image_reel"></div>
    </div>
	<div class="pagingMenor divPaginacao"></div>
    <div class="divContentImg divContentImgMenor">
 	  <div class="divContentImgEsquerda"></div>
    </div>
  </div>
  <!-- Fim Scroll -->
</div>

<div class="colunas3">
  <div class="contentCol">
    <h2 class="tagDestaqueH2 cinza"><?php print  $arrObjNodeImagem[0]->field_field_catesporte[0]["rendered"]["#title"] ?></h2>
    <a class='previewmodal3' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[0]->nid)); ?>">
      <?php
        $uriImg = newGetImageCapaView($arrObjNodeImagem[0]);
        $img = array();
        $img['style']   ='home_cadernos';
        $img['uri']     = $uriImg;
        $img['class']   = array('imgH6Grande');
        $img['alt']     = $arrObjNodeImagem[0]->node_title;
        $img['title']   = $arrObjNodeImagem[0]->node_title;
        $img['width']   = "191";
        $img['height']  = "143";

        //imprimindo a tag <img> com os atributos desejados.
        image_static_lazy($img);
        ?>
    </a>
    <strong><a href="<?php print  url($arrObjNodeImagem[0]->field_field_tags[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $arrObjNodeImagem[0]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
    <span id="leiamais3" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrObjNodeImagem[0]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[0]->nid)); ?>" title="Preview"></a>
    </span>
    <h6 class="noticiaH6 padding-bottom20"><a class='previewmodal3 links cinza' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[0]->nid)); ?>"><?php print  $arrObjNodeImagem[0]->node_title ?></a></h6>
    <div class="contentCol bordatop padding-top20">
      <strong><a href="<?php print  $arrNodeSemImagem[3]->field_field_catesporte[0]["rendered"]["#href"]; ?>" class="linksStrong preto"><?php print  $arrNodeSemImagem[3]->field_field_catesporte[0]["rendered"]["#title"] ?></a></strong>
      <h6 class="noticiaH6"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[3]->nid)); ?>" class="links cinza"><?php print  $arrNodeSemImagem[3]->node_title ?></a></h6>
    </div>
  </div>	
  
  <div class="contentCol margin-left25">
    <h2 class="tagDestaqueH2 cinza"><?php print  $arrObjNodeImagem[1]->field_field_catesporte[0]["rendered"]["#title"] ?></h2>
    <a class='previewmodal4' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[1]->nid)); ?>">
        <?php
            $uriImg = newGetImageCapaView($arrObjNodeImagem[1]);
            $img = array();
            $img['style']='home_cadernos';
            $img['uri']= $uriImg;
            $img['class']= array('imgH6Grande');
            $img['alt']= $arrObjNodeImagem[1]->node_title;
            $img['title']= $arrObjNodeImagem[1]->node_title;
            $img['width']= "191";
            $img['height']= "143";

            //imprimindo a tag <img> com os atributos desejados.
            image_static_lazy($img);
        ?>
      <!--<img src="<?php // print  image_style_url('home_cadernos', $arrObjNodeImagem[1]->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" alt="<?php // print  $arrObjNodeImagem[1]->node_title ?>" class="imgH6Grande" />-->
    </a>
    <strong><a href="<?php print  url($arrObjNodeImagem[1]->field_field_tags[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $arrObjNodeImagem[1]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
    <span id="leiamais4" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrObjNodeImagem[1]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[1]->nid)); ?>" title="Preview"></a>
    </span>
    <h6 class="noticiaH6 padding-bottom20"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[1]->nid)); ?>" class='previewmodal4 links cinza'><?php print  $arrObjNodeImagem[1]->node_title ?></a></h6>
    <div class="contentCol bordatop padding-top20">
      <strong><a href="<?php print  $arrNodeSemImagem[4]->field_field_catesporte[0]["rendered"]["#href"]; ?>" class="linksStrong preto"><?php print   $arrNodeSemImagem[4]->field_field_catesporte[0]["rendered"]["#title"] ?></a></strong>
      <h6 class="noticiaH6"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[4]->nid)); ?>" class="links cinza"><?php print  $arrNodeSemImagem[4]->node_title ?></a></h6>
    </div>
  </div>
  
  <div class="contentCol margin-left25">
    <h2 class="tagDestaqueH2 cinza"><?php print  $arrObjNodeImagem[2]->field_field_catesporte[0]["rendered"]["#title"] ?></h2>
    <a class='previewmodal5' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[2]->nid)); ?>">
       <?php
            $uriImg = newGetImageCapaView($arrObjNodeImagem[2]);
            $img = array();
            $img['style']='home_cadernos';
            $img['uri']= $uriImg;
            $img['class']= array('');
            $img['alt']= $arrObjNodeImagem[2]->node_title;
            $img['title']= $arrObjNodeImagem[2]->node_title;
            $img['width']= "191";
            $img['height']= "143";

            //imprimindo a tag <img> com os atributos desejados.
            image_static_lazy($img);
        ?>
      <!--<img src="<?php // print  image_style_url('home_cadernos', $arrObjNodeImagem[2]->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" alt="<?php // print  $arrObjNodeImagem[1]->node_title ?>" class="imgH6Grande" />-->
    </a>
    <strong><a href="<?php print  url($arrObjNodeImagem[2]->field_field_tags[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $arrObjNodeImagem[2]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
    <span id="leiamais5" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrObjNodeImagem[2]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[2]->nid)); ?>" title="Preview"></a>
    </span>
    <h6 class="noticiaH6 padding-bottom20"><a class='previewmodal5 links cinza' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[2]->nid)); ?>"><?php print  $arrObjNodeImagem[2]->node_title ?></a></h6>
    <div class="contentCol bordatop padding-top20">
      <strong><a href="<?php print  $arrNodeSemImagem[5]->field_field_catesporte[0]["rendered"]["#href"]; ?>" class="linksStrong preto"><?php print  $arrNodeSemImagem[5]->field_field_catesporte[0]["rendered"]["#title"] ?></a></strong>
      <h6 class="noticiaH6"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[5]->nid)); ?>" class="links cinza"><?php print  $arrNodeSemImagem[5]->node_title ?></a></h6>
    </div>
  </div>  
</div>     

<div class="colunas2 margin-top25">
  <?php print  render(getBlocos(array('33'))) ?>  
  <?php
        for($intContador = 6; $intContador <= 8 ; $intContador++){
          $objNode = $arrNodeSemImagem[$intContador]->_field_data["nid"]["entity"];
          $strSubCategoria = api_getCategoria($arrNodeSemImagem[$intContador]);
  ?>        
           <div class="contentCol bordaBottom <?php print  ($intContador > 7) ? 'margin-top15' : '' ?>  margin-left25 padding-bottom12">
            <strong><a class="linksStrong preto" href="<?php print  $strSubCategoria["linkChapeu"]; ?>"><?php print  $strSubCategoria["chapeu"] ?></a></strong>
            <h5 class="noticiaH5"><a class="links cinza" href="<?php print  url(drupal_lookup_path('alias',"node/".$objNode->nid)); ?>"><?php print  $objNode->title ?></a></h5>
          </div>
  <?php
        }
  ?>
</div>

<div class="colunas3">
    
    <!-- **********BLOCO DO SPORT ***********-->
    <?php 
    $tempNodePrint = $arrNodesSportComImg;
    $tempNodePrintTt = $arrNodesSport;
    ?>
    <div class="contentCol">
    <h2 class="tagDestaqueH2 cinza"><a href="/tags/sport" class="linksStrong preto">Sport</a></h2>
    <a class='previewmodal5' href="<?php print  url(drupal_lookup_path('alias',"node/".$tempNodePrint[0]->nid)); ?>">
    <?php
         $img = array();
         $img['style']='home_cadernos';
         if($tempNodePrint[0]->field_field_capa){$img['uri']= $tempNodePrint[0]->field_field_capa[0]["rendered"]["#item"]["uri"];}
         else{$img['uri']= $tempNodePrint[0]->field_field_image[0]['rendered']['#item']['uri'];}
         $img['class']= array('');
         $img['alt']= $tempNodePrint[0]->node_title;
         $img['title']= $tempNodePrint[0]->node_title;
         $img['width']= "191";
         $img['height']= "143";
         
         //imprimindo a tag <img> com os atributos desejados.
         image_static_lazy($img);
     ?>
    </a>
    <strong><a href="<?php print  url($tempNodePrint[0]->field_field_tags[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $tempNodePrint[0]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
    <span id="leiamais5" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$tempNodePrint[0]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$tempNodePrint[0]->nid)); ?>" title="Preview"></a>
    </span>
    <h6 class="noticiaH6 padding-bottom20"><a class='previewmodal5 links cinza' href="<?php print  url(drupal_lookup_path('alias',"node/".$tempNodePrint[0]->nid)); ?>"><?php print  $tempNodePrint[0]->node_title ?></a></h6>
    <div class="contentCol bordatop padding-top20 bordaBottom padding-bottom12">
      <strong><a href="/tags/sport" class="linksStrong preto">Sport</a></strong>
      <h6 class="noticiaH6"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$tempNodePrintTt[0]->nid)); ?>" class="links cinza"><?php print  $tempNodePrintTt[0]->node_title ?></a></h6>
    </div>
  </div>
    <?php 
    //destruindo a variável tempNodePrint
    unset($tempNodePrint); 
    unset($tempNodePrintTt); 
    ?>
    <!--FIM DO BLOCO DO SPORT-->
    
    <!-- **********BLOCO DO SANTA CRUZ ***********-->
    <?php 
    $tempNodePrint = $arrNodesSantaCruzComImg;
    $tempNodePrintTt = $arrNodesSantaCruz;
    ?>
    <div class="contentCol margin-left25">
    <h2 class="tagDestaqueH2 cinza"><a href="/tags/santa-cruz" class="linksStrong preto">Santa Cruz</a></h2>
    <a class='previewmodal5' href="<?php print  url(drupal_lookup_path('alias',"node/".$tempNodePrint[0]->nid)); ?>">
    <?php
         $img = array();
         $img['style']='home_cadernos';
         if($tempNodePrint[0]->field_field_capa){$img['uri']= $tempNodePrint[0]->field_field_capa[0]["rendered"]["#item"]["uri"];}
         else{$img['uri']= $tempNodePrint[0]->field_field_image[0]['rendered']['#item']['uri'];}
         $img['class']= array('');
         $img['alt']= $tempNodePrint[0]->node_title;
         $img['title']= $tempNodePrint[0]->node_title;
         $img['width']= "191";
         $img['height']= "143";
         
         //imprimindo a tag <img> com os atributos desejados.
         image_static_lazy($img);
     ?>
    </a>
    <strong><a href="<?php print  url($tempNodePrint[0]->field_field_tags[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $tempNodePrint[0]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
    <span id="leiamais5" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$tempNodePrint[0]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$tempNodePrint[0]->nid)); ?>" title="Preview"></a>
    </span>
    <h6 class="noticiaH6 padding-bottom20"><a class='previewmodal5 links cinza' href="<?php print  url(drupal_lookup_path('alias',"node/".$tempNodePrint[0]->nid)); ?>"><?php print  $tempNodePrint[0]->node_title ?></a></h6>
     <div class="contentCol bordatop padding-top20 bordaBottom padding-bottom12">
      <strong><a href="/tags/santa-cruz" class="linksStrong preto">Santa Cruz</a></strong>
      <h6 class="noticiaH6"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$tempNodePrintTt[0]->nid)); ?>" class="links cinza"><?php print  $tempNodePrintTt[0]->node_title ?></a></h6>
    </div>
  </div>
    <?php 
    //destruindo a variável tempNodePrint
    unset($tempNodePrint); 
    unset($tempNodePrintTt); 
    ?>
    <!--FIM DO BLOCO DO SANTA CRUZ-->
    
    <!-- **********BLOCO DO NÁUTICO ***********-->
    <?php 
    $tempNodePrint = $arrNodesNauticoComImg;
    $tempNodePrintTt = $arrNodesNautico;
    ?>
    <div class="contentCol margin-left25">
    <h2 class="tagDestaqueH2 cinza"><a href="/tags/náutico" class="linksStrong preto">Náutico</a></h2>
    <a class='previewmodal5' href="<?php print  url(drupal_lookup_path('alias',"node/".$tempNodePrint[0]->nid)); ?>">
    <?php
         $img = array();
         $img['style']='home_cadernos';
         if($tempNodePrint[0]->field_field_capa){$img['uri']= $tempNodePrint[0]->field_field_capa[0]["rendered"]["#item"]["uri"];}
         else{$img['uri']= $tempNodePrint[0]->field_field_image[0]['rendered']['#item']['uri'];}
         $img['class']= array('');
         $img['alt']= $tempNodePrint[0]->node_title;
         $img['title']= $tempNodePrint[0]->node_title;
         $img['width']= "191";
         $img['height']= "143";
         
         //imprimindo a tag <img> com os atributos desejados.
         image_static_lazy($img);
         
         //$image = image_style_url($img['style'], $img['uri']);
     ?>
        <!--<img src="<?php// print $image?>" alt="Medalhista olímpica, Yane sofre para arranjar patrocínio" class="imgH6Grande">-->
    </a>
    <strong><a href="<?php print  url($tempNodePrint[0]->field_field_tags[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $tempNodePrint[0]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
    <span id="leiamais5" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$tempNodePrint[0]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$tempNodePrint[0]->nid)); ?>" title="Preview"></a>
    </span>
    <h6 class="noticiaH6 padding-bottom20"><a class='previewmodal5 links cinza' href="<?php print  url(drupal_lookup_path('alias',"node/".$tempNodePrint[0]->nid)); ?>"><?php print  $tempNodePrint[0]->node_title ?></a></h6>
     <div class="contentCol bordatop padding-top20 bordaBottom padding-bottom12">
      <strong><a href="/tags/náutico" class="linksStrong preto">Náutico</a></strong>
      <h6 class="noticiaH6"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$tempNodePrintTt[0]->nid)); ?>" class="links cinza"><?php print  $tempNodePrintTt[0]->node_title ?></a></h6>
    </div>
  </div>
    <?php 
    //destruindo a variável tempNodePrint
    unset($tempNodePrint); 
    unset($tempNodePrintTt); 
    ?>
  <!--FIM DO BLOCO DO NAUTICO-->
  
</div>