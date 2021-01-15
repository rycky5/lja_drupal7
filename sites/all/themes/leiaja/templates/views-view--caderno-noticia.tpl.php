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

$arrNodePromoDestaComImagem = views_get_view_result("caderno_noticia", "promo_destaq_comimg");
$nidPass = getNidsByViews($arrNodePromoDestaComImagem);

$arrNodePromoDestaSemImagem = views_get_view_result("caderno_noticia", "promo_destaq_semimg",$nidPass);
$nidPass = $nidPass .','. getNidsByViews($arrNodePromoDestaSemImagem);

$arrNodeSemImagem = views_get_view_result("caderno_noticia", "sem_imagem", $nidPass);
$nidPass = $nidPass .','. getNidsByViews($arrNodeSemImagem);

$arrObjNodeImagem = views_get_view_result("caderno_noticia", "com_imagem", $nidPass);

// validando as imagens de capa
//$arrObjNodeImagem = api_corrigeImageCapa($arrObjNodeImagem);

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
      
      $texto = $not->_field_data["nid"]["entity"]->body["pt-br"][0]["summary"];
      if(!$texto or empty($texto)){$texto = limitaTexto(retiraHash($not->_field_data["nid"]["entity"]->body["pt-br"][0]["value"]), 150);}
      
      // Pegando o subCaderno
      $strSubCategoria =api_getCategoria($not);
  ?>
    arrFotos[<?php print  $key ?>] = {"nid" : <?php print  $not->nid ?>,"title" : "<?php print  addslashes($not->node_title) ?>","link" : "<?php print  $vLink ?>","imagem_thumb" : "<?php print  image_static_url('home_thumb', $img); ?>","imagem_grd" : "<?php print  image_static_url('large', $img) ?>","imagem_med" : "<?php print  image_static_url('medium', $img) ?>","user" : "<?php print $GLOBALS['user']->uid.';'.$not->nid?>","resumo":"<?php print addslashes(trim($texto)); ?>","subcategoria" : "<?php print  $not->field_field_catcultura[0]["rendered"]["#title"] ?>"};
  <?php 
        if($key == 4)
          break;
     endforeach; 
  ?>

  (function ($) {
    $(document).ready(function(){
	  initCarrossel( false, false, arrFotos, 'noticiaSlideNoticias');
    });
  })(jQuery);
</script>
 <div id="noticiaSlideNoticias" class="main_view">
        <div class="window">
          <div class="image_reel"></div>
        </div>
        <div class="paging divPaginacao"></div>
        <div class="divContentImg" style="position: absolute;margin: -85px 0 15px">
                <div class="divContentImgEsquerda"></div>
                <div class="divContentImgDireita"></div>
        </div>
  </div>
  <a class="linkNoticiaPrincipal" href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodePromoDestaSemImagem[0]->nid)); ?>" title="<?php print  $arrNodePromoDestaSemImagem[0]->node_title ?>">
  <h2 class="tituloNoticia preto"><?php print  $arrNodePromoDestaSemImagem[0]->node_title ?></h2>
  <h3 class="descricaoNoticia"><?php print  $arrNodePromoDestaSemImagem[0]->_field_data["nid"]["entity"]->body["pt-br"][0]["summary"] ?></h3>
</a>
<div class="colunas2">
  <div class="contentCol bordaBottom">
    <a class='previewmodal1' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[0]->nid)); ?>">
      <?php
            $uriImg = newGetImageCapaView($arrObjNodeImagem[0]);
            $img = array();
            $img['style']='home_thumb';
            $img['uri']= $uriImg;
            $img['class']= array('imgH4');
            $img['alt']= $arrObjNodeImagem[0]->node_title;
            $img['title']= $arrObjNodeImagem[0]->node_title;
            $img['width']= "100";
            $img['height']= "74";

            //imprimindo a tag <img> com os atributos desejados.
            image_static_lazy($img);
        ?>
    </a>
    <div class="containerImgH4">
      <strong><a href="<?php print  url($arrObjNodeImagem[0]->field_field_catnoticia[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $arrObjNodeImagem[0]->field_field_catnoticia[0]["rendered"]["#title"] ?></a></strong>
      <span id="leiamais1" class="lerNoticiasMenor">
        <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrObjNodeImagem[0]->nid?>"></a>
        <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[0]->nid)); ?>" title="Preview"></a>
      </span>
      <h4 class="noticiaH4"><a class='previewmodal1 links cinza' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[0]->nid)); ?>"><?php print  $arrObjNodeImagem[0]->node_title ?></a></h4>
    </div>
  </div>
  <div class="contentCol bordaBottom margin-left25">
      <a class='previewmodal2' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[1]->nid)); ?>">
         <?php
              $uriImg = newGetImageCapaView($arrObjNodeImagem[1]);
              $img = array();
              $img['style']='home_thumb';
              $img['uri']= $uriImg;
              $img['class']= array('imgH4');
              $img['alt']= $arrObjNodeImagem[1]->node_title;
              $img['title']= $arrObjNodeImagem[1]->node_title;
              $img['width']= "100";
              $img['height']= "74";

              //imprimindo a tag <img> com os atributos desejados.
              image_static_lazy($img);
        ?>
        <!--<img src="<?php // print  image_style_url('home_thumb',$arrObjNodeImagem[1]->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" alt="<?php // print  $arrObjNodeImagem[1]->node_title ?>" class="imgH4" width="100" height="74" />-->
      </a>
      <div class="containerImgH4">
      <strong><a href="<?php print  url($arrObjNodeImagem[1]->field_field_catnoticia[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $arrObjNodeImagem[1]->field_field_catnoticia[0]["rendered"]["#title"] ?></a></strong>
      <span id="leiamais2" class="lerNoticiasMenor">
        <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrObjNodeImagem[1]->nid?>"></a>
        <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[1]->nid)); ?>" title="Preview"></a>
      </span>
      <h4 class="noticiaH4"><a class='previewmodal2 links cinza' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[1]->nid)); ?>"><?php print  $arrObjNodeImagem[1]->node_title ?></a></h4>
    </div>
  </div>
  <div class="contentCol margin-top15">
      <a class='previewmodal3' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[2]->nid)); ?>">
         <?php
              $uriImg = newGetImageCapaView($arrObjNodeImagem[2]);
              $img = array();
              $img['style']='home_thumb';
              $img['uri']= $uriImg;
              $img['class']= array('imgH4');
              $img['alt']= $arrObjNodeImagem[2]->node_title;
              $img['title']= $arrObjNodeImagem[2]->node_title;
              $img['width']= "100";
              $img['height']= "74";

              //imprimindo a tag <img> com os atributos desejados.
              image_static_lazy($img);
        ?>
        <!--<img src="<?php //  print  image_style_url('home_thumb', $arrObjNodeImagem[2]->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" alt="<?php // print  $arrObjNodeImagem[2]->node_title ?>" class="imgH4" width="100" height="74" />-->
      </a>
      <div class="containerImgH4">
      <strong><a href="<?php print  url($arrObjNodeImagem[2]->field_field_catnoticia[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $arrObjNodeImagem[2]->field_field_catnoticia[0]["rendered"]["#title"] ?></a></strong>
      <span id="leiamais3" class="lerNoticiasMenor">
        <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrObjNodeImagem[2]->nid?>"></a>
        <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$vNoticiasFotos[7]->nid)); ?>" title="Preview"></a>
      </span>
      <h4 class="noticiaH4"><a class='previewmodal3 links cinza'  href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[2]->nid)); ?>"><?php print  $arrObjNodeImagem[2]->node_title ?></a></h4>
    </div>
  </div>
  <div class="contentCol margin-top15 margin-left25">
          <a class='previewmodal4' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[3]->nid)); ?>">
             <?php
              $uriImg = newGetImageCapaView($arrObjNodeImagem[3]);
              $img = array();
              $img['style']='home_thumb';
              $img['uri']= $uriImg;
              $img['class']= array('imgH4');
              $img['alt']= $arrObjNodeImagem[3]->node_title;
              $img['title']= $arrObjNodeImagem[3]->node_title;
              $img['width']= "100";
              $img['height']= "74";

              //imprimindo a tag <img> com os atributos desejados.
              image_static_lazy($img);
        ?>
            <!--<img src="<?php // print  image_style_url('home_thumb', $arrObjNodeImagem[3]->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" alt="<?php // print  $arrObjNodeImagem[3]->node_title ?>" class="imgH4" width="100" height="74" />-->
          </a>
          <div class="containerImgH4">
          <strong><a href="<?php print  url($arrObjNodeImagem[3]->field_field_catnoticia[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $arrObjNodeImagem[3]->field_field_catnoticia[0]["rendered"]["#title"] ?></a></strong>
          <span id="leiamais4" class="lerNoticiasMenor">
        <a class="lerDepois" title="Fixar no Mural"></a>
        <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[3]->nid)); ?>" title="Preview"></a>
      </span>
      <h4 class="noticiaH4"><a class='previewmodal4 links cinza' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[3]->nid)); ?>"><?php print  $arrObjNodeImagem[3]->node_title ?></a></h4>
    </div>
  </div>
  <?php print render(getBlocos(array('35')));?>
  <?php
      for($intContador = 0; $intContador <= 2; $intContador++){
  ?>
        <div class="contentCol bordaBottom margin-top15 margin-left25 padding-bottom12">
          <strong><a class="linksStrong preto" href="<?php print  url($arrNodeSemImagem[$intContador]->field_field_tags[0]["rendered"]["#href"]); ?>"><?php print  $arrNodeSemImagem[$intContador]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
          <h5 class="noticiaH5"><a class="links cinza" href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[$intContador]->nid)); ?>"><?php print  $arrNodeSemImagem[$intContador]->node_title; ?></a></h5>
        </div>
  <?php
      }
  ?>
    
</div>
<div class="colunas2_2 margin-top25">
  <div class="contentCol bordaBottom padding-bottom10">
    <strong><a class="linksStrong preto" href="<?php print  url($arrNodeSemImagem[3]->field_field_tags[0]["rendered"]["#href"]); ?>"><?php print  $arrNodeSemImagem[3]->field_field_tags[0]["rendered"]["#title"]; ?></a></strong>
    <h4 class="noticiaH4"><a class="links cinza" href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[3]->nid)); ?>"><?php print  $arrNodeSemImagem[3]->node_title; ?></a></h4>
  </div>
  <div class="contentCol bordaBottom margin-left25 padding-bottom10">
    <strong><a class="linksStrong preto" href="<?php print  url($arrNodeSemImagem[4]->field_field_tags[0]["rendered"]["#href"]); ?>"><?php print  $arrNodeSemImagem[4]->field_field_tags[0]["rendered"]["#title"]; ?></a></strong>
    <h4 class="noticiaH4"><a class="links cinza" href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[4]->nid)); ?>"><?php print  $arrNodeSemImagem[4]->node_title; ?></a></h4>
  </div>
  <div class="contentCol bordaBottom margin-top15 padding-bottom10">
    <strong><a class="linksStrong preto" href="<?php print  url($arrNodeSemImagem[5]->field_field_tags[0]["rendered"]["#href"]); ?>"><?php print  $arrNodeSemImagem[5]->field_field_tags[0]["rendered"]["#title"]; ?></a></strong>
    <h4 class="noticiaH4"><a class="links cinza" href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[5]->nid)); ?>"><?php print  $arrNodeSemImagem[5]->node_title; ?></a></h4>
  </div>
  <div class="contentCol bordaBottom margin-top15 margin-left25 padding-bottom10">
    <strong><a class="linksStrong preto" href="<?php print  url($arrNodeSemImagem[6]->field_field_tags[0]["rendered"]["#href"]); ?>"><?php print  $arrNodeSemImagem[6]->field_field_tags[0]["rendered"]["#title"]; ?></a></strong>
    <h4 class="noticiaH4"><a class="links cinza" href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[6]->nid)); ?>"><?php print  $arrNodeSemImagem[6]->node_title; ?></a></h4>
  </div>
</div>
<div class="colunas2_1 margin-left25 margin-top25">
  <div class="contentCol bordaBottom margin-bottom15">
          <a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[4]->nid)); ?>">
            <?php
              $uriImg = newGetImageCapaView($arrObjNodeImagem[4]);
              $img = array();
              $img['style']='home_thumb';
              $img['uri']= $uriImg;
              $img['class']= array('imgH4');
              $img['alt']= $arrObjNodeImagem[4]->node_title;
              $img['title']= $arrObjNodeImagem[4]->node_title;
              $img['width']= "100";
              $img['height']= "74";

              //imprimindo a tag <img> com os atributos desejados.
              image_static_lazy($img);
            ?>
            <!--<img src="<?php // print  image_style_url('home_thumb', $arrObjNodeImagem[4]->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" alt="<?php // print  $arrObjNodeImagem[4]->node_title ?>" class="imgH4" width="100" height="74" />-->
          </a>
          <div class="containerImgH4">
          <strong><a href="javascript:void(0);" class="linksStrong preto"><?php print  $arrObjNodeImagem[4]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
          <h4 class="noticiaH4"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[4]->nid)); ?>" class="links cinza"><?php print  $arrObjNodeImagem[4]->node_title ?></a></h4>
    </div>
  </div>
  <div class="contentCol bordaBottom">
          <a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[5]->nid)); ?>">
            <?php
              $uriImg = newGetImageCapaView($arrObjNodeImagem[5]);
              $img = array();
              $img['style']='home_thumb';
              $img['uri']= $uriImg;
              $img['class']= array('imgH4');
              $img['alt']= $arrObjNodeImagem[5]->node_title;
              $img['title']= $arrObjNodeImagem[5]->node_title;
              $img['width']= "100";
              $img['height']= "74";

              //imprimindo a tag <img> com os atributos desejados.
              image_static_lazy($img);
            ?>
            <!--<img src="<?php // print  image_style_url('home_thumb', $arrObjNodeImagem[5]->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" alt="<?php // print  $arrObjNodeImagem[5]->node_title ?>" class="imgH4" width="100" height="74" />-->
          </a>
          <div class="containerImgH4">
          <strong><a href="javascript:void(0);" class="linksStrong preto"><?php print  $arrObjNodeImagem[5]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
          <h4 class="noticiaH4"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[5]->nid)); ?>" class="links cinza"><?php print  $arrObjNodeImagem[5]->node_title ?></a></h4>
    </div>
  </div>
</div>
<!------INICIO colunas3------->
<div class="colunas3">
  <div class="contentCol">
    <h2 class="tagDestaqueH2 cinza"><?php print  $arrObjNodeImagem[6]->field_field_catnoticia[0]["rendered"]["#title"] ?></h2>
    <a class='previewmodal3' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[6]->nid)); ?>">
      <?php
        $uriImg = newGetImageCapaView($arrObjNodeImagem[6]);
        $img = array();
        $img['style']   ='home_cadernos';
        $img['uri']     = $uriImg;
        $img['class']   = array('imgH6Grande');
        $img['alt']     = $arrObjNodeImagem[6]->node_title;
        $img['title']   = $arrObjNodeImagem[6]->node_title;
        $img['width']   = "191";
        $img['height']  = "143";

        //imprimindo a tag <img> com os atributos desejados.
        image_static_lazy($img);
        ?>
    </a>
    <strong><a href="<?php print  url($arrObjNodeImagem[6]->field_field_tags[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $arrObjNodeImagem[6]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
    <span id="leiamais3" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrObjNodeImagem[6]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[6]->nid)); ?>" title="Preview"></a>
    </span>
    <h6 class="noticiaH6 padding-bottom20"><a class='previewmodal3 links cinza' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[6]->nid)); ?>"><?php print  $arrObjNodeImagem[6]->node_title ?></a></h6>
    <div class="contentCol bordatop padding-top20">
      <strong><a href="<?php print  url(drupal_lookup_path('alias', $arrNodeSemImagem[7]->field_field_catnoticia[0]["rendered"]["#href"])); ?>" class="linksStrong preto"><?php print  $arrNodeSemImagem[7]->field_field_catnoticia[0]["rendered"]["#title"] ?></a></strong>
      <h6 class="noticiaH6"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[7]->nid)); ?>" class="links cinza"><?php print  $arrNodeSemImagem[7]->node_title ?></a></h6>
    </div>
  </div>	
  
  <div class="contentCol margin-left25">
    <h2 class="tagDestaqueH2 cinza"><?php print  $arrObjNodeImagem[7]->field_field_catnoticia[0]["rendered"]["#title"] ?></h2>
    <a class='previewmodal4' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[7]->nid)); ?>">
        <?php
            $uriImg = newGetImageCapaView($arrObjNodeImagem[7]);
            $img = array();
            $img['style']='home_cadernos';
            $img['uri']= $uriImg;
            $img['class']= array('imgH6Grande');
            $img['alt']= $arrObjNodeImagem[7]->node_title;
            $img['title']= $arrObjNodeImagem[7]->node_title;
            $img['width']= "191";
            $img['height']= "143";

            //imprimindo a tag <img> com os atributos desejados.
            image_static_lazy($img);
        ?>
      <!--<img src="<?php // print  image_style_url('home_cadernos', $arrObjNodeImagem[1]->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" alt="<?php // print  $arrObjNodeImagem[1]->node_title ?>" class="imgH6Grande" />-->
    </a>
    <strong><a href="<?php print  url($arrObjNodeImagem[7]->field_field_tags[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $arrObjNodeImagem[7]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
    <span id="leiamais4" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrObjNodeImagem[7]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[7]->nid)); ?>" title="Preview"></a>
    </span>
    <h6 class="noticiaH6 padding-bottom20"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[7]->nid)); ?>" class='previewmodal4 links cinza'><?php print  $arrObjNodeImagem[7]->node_title ?></a></h6>
    <div class="contentCol bordatop padding-top20">
      <strong><a href="<?php print url(drupal_lookup_path('alias', $arrNodeSemImagem[8]->field_field_catnoticia[0]["rendered"]["#href"])); ?>" class="linksStrong preto"><?php print   $arrNodeSemImagem[8]->field_field_catnoticia[0]["rendered"]["#title"] ?></a></strong>
      <h6 class="noticiaH6"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[8]->nid)); ?>" class="links cinza"><?php print  $arrNodeSemImagem[8]->node_title ?></a></h6>
    </div>
  </div>
  
  <div class="contentCol margin-left25">
    <h2 class="tagDestaqueH2 cinza"><?php print  $arrObjNodeImagem[8]->field_field_catnoticia[0]["rendered"]["#title"] ?></h2>
    <a class='previewmodal5' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[8]->nid)); ?>">
       <?php
            $uriImg = newGetImageCapaView($arrObjNodeImagem[8]);
            $img = array();
            $img['style']='home_cadernos';
            $img['uri']= $uriImg;
            $img['class']= array('imgH6Grande');
            $img['alt']= $arrObjNodeImagem[8]->node_title;
            $img['title']= $arrObjNodeImagem[8]->node_title;
            $img['width']= "191";
            $img['height']= "143";

            //imprimindo a tag <img> com os atributos desejados.
            image_static_lazy($img);
        ?>
      <!--<img src="<?php // print  image_style_url('home_cadernos', $arrObjNodeImagem[2]->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" alt="<?php // print  $arrObjNodeImagem[1]->node_title ?>" class="imgH6Grande" />-->
    </a>
    <strong><a href="<?php print  url($arrObjNodeImagem[8]->field_field_tags[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $arrObjNodeImagem[8]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
    <span id="leiamais5" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrObjNodeImagem[8]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[8]->nid)); ?>" title="Preview"></a>
    </span>
    <h6 class="noticiaH6 padding-bottom20"><a class='previewmodal5 links cinza' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[8]->nid)); ?>"><?php print  $arrObjNodeImagem[8]->node_title ?></a></h6>
    <div class="contentCol bordatop padding-top20">
      <strong><a href="<?php print url(drupal_lookup_path('alias', $arrNodeSemImagem[9]->field_field_catnoticia[0]["rendered"]["#href"])); ?>" class="linksStrong preto"><?php print  $arrNodeSemImagem[9]->field_field_catnoticia[0]["rendered"]["#title"] ?></a></strong>
      <h6 class="noticiaH6"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[9]->nid)); ?>" class="links cinza"><?php print  $arrNodeSemImagem[9]->node_title ?></a></h6>
    </div>
  </div>  
</div> 
