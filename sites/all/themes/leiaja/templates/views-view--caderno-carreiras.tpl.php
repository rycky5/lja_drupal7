<?php
/**
 * @file views-view.tpl.php
 * Main view template
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
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */

// Incluindo os arquivos necessários
module_load_include('inc', 'capa', 'capa.api');
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja') .'/template.api.inc';

$arrNodePromoDestaSemImagem = views_get_view_result("caderno_carreiras", "promo_destaq_semimg");
$nidPass = getNidsByViews($arrNodePromoDestaSemImagem);

$arrNodePromoDestaComImagem = views_get_view_result("caderno_carreiras", "promo_destaq_comimg", $nidPass);
$nidPass = $nidPass .','. getNidsByViews($arrNodePromoDestaComImagem);

$arrNodeSemImagem = views_get_view_result("caderno_carreiras", "sem_imagem", $nidPass);
$nidPass = $nidPass .','. getNidsByViews($arrNodeSemImagem);

$arrObjNodeImagem = views_get_view_result("caderno_carreiras", "com_imagem", $nidPass);

// validando as imagens de capa
//$arrObjNodeImagem = api_corrigeImageCapa($arrObjNodeImagem);

?>
<script type="text/javascript" src="/<?php print drupal_get_path('theme', 'leiaja')."/js/carrossel.js" ?>"></script>
<script type="text/javascript">
  var arrFotos = new Array();
  <?php
    foreach($arrNodePromoDestaComImagem as $key => $not):
      $vLink = url(drupal_lookup_path('alias',"node/".$not->nid));
      
      // setando a img de capa à variável
      $imgCapa        = @$not->field_field_capa[0]["rendered"]["#item"]["uri"];
      // setando a img à variável
      $imagem         = @$not->field_field_image[0]["rendered"]["#item"]["uri"];
      //fazendo a verificação se a img de capa existe. caso exista para ser setada à variavel;
      $img            = (!empty($imgCapa)?$imgCapa:$imagem);
      // incrementando 
      $vIndice = $key+1;
      
      $texto = $not->_field_data["nid"]["entity"]->body["pt-br"][0]["summary"];
      if(!$texto or empty($texto)){$texto = limitaTexto(retiraHash($not->_field_data["nid"]["entity"]->body["pt-br"][0]["value"]), 150);}
      
  ?>
    arrFotos[<?php print $key ?>] = {"nid" : <?php print $not->nid ?>,"title" : "<?php print addslashes($not->node_title) ?>","link" : "<?php print $vLink ?>","imagem_thumb" : "<?php print image_static_url('home_thumb', $img); ?>","imagem_grd" : "<?php print image_static_url('large', $img) ?>","imagem_med" : "<?php print image_static_url('medium', $img) ?>","user" : "<?=$GLOBALS['user']->uid.';'.$not->nid?>","resumo":"<?php print addslashes(trim($texto)); ?>","subcategoria" : "<?php print $not->field_field_catcultura[0]["rendered"]["#title"] ?>"};
  <?php 
      if($key == 4)
          break;
      endforeach;
  ?>
  (function ($) {
	    $(document).ready(function(){
		  initCarrossel(false, false, arrFotos, 'noticiaSlideCarreiras');
	    });
  })(jQuery);
</script>
<a class="linkNoticiaPrincipal" href="<?php print url(drupal_lookup_path('alias',"node/".$arrNodePromoDestaSemImagem[0]->nid)); ?>" title="">
  <h2 class="tituloCaderno"><?php print $arrNodePromoDestaSemImagem[0]->node_title;?></h2>
  <h3 class="descricaoNoticia"><?php print $arrNodePromoDestaSemImagem[0]->_field_data["nid"]["entity"]->body["pt-br"][0]["summary"];?></h3>
</a>
<div class="colunas2 colunaprincipal">
    
<div id="noticiaSlideCarreiras" class="main_view">
        <div class="window">
          <div class="image_reel"></div>
        </div>
        <div class="paging divPaginacao"></div>
        <div class="divContentImg" style="position: absolute;margin: -85px 0 15px">
                <div class="divContentImgEsquerda"></div>
                <div class="divContentImgDireita"></div>
        </div>
  </div>
  <!-- Scroll -->
<!--  <div id="noticiaSlideCarreiras" class="main_view">
    <div class="window" style="width:300px;height:226px;">
      <div class="image_reel"></div>
    </div>
          <div class="divPaginacao pagingMenor"></div>
    <div class="divContentImg divContentImgMenor">
                  <div class="divContentImgEsquerda"></div>
    </div>
  </div>-->
  <!-- Fim Scroll -->
</div>
<div class="colunas2_1">
  <h2 class="tagDestaqueH2 cinza"><?php print $arrObjNodeImagem[0]->field_field_catnegocios_1[0]["rendered"]["#title"] ?></h2>
  <div class="contentCol bordaBottom">
    <a href="<?php print url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[0]->nid)); ?>" class="previewmodal4">
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
      <!--<img class="imgH4" alt="<?php // print $arrObjNodeImagem[0]->node_title ?>" src="<?php // print image_style_url('home_thumb', $arrObjNodeImagem[0]->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" width="100" height="74" />-->
    </a>
    <div class="containerImgH4">
      <strong><a class="linksStrong preto" href="<?php print url($arrObjNodeImagem[0]->field_field_tags[0]["rendered"]["#href"]); ?>"><?php print $arrObjNodeImagem[0]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
      <span id="leiamais4" class="lerNoticiasMenor">
        <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$arrObjNodeImagem[0]->nid?>"></a>
        <a class="lerJa" lerja="<?php print url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[0]->nid)); ?>" title="Preview"></a>
      </span>
      <h4 class="noticiaH4"><a class="previewmodal4 links cinza" href="<?php print url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[0]->nid)); ?>"><?php print $arrObjNodeImagem[0]->node_title ?></a></h4>
    </div>
  </div>
  <div class="contentCol bordaBottom margin-top15 margin-bottom15">
    <h5 class="noticiaH5"><a href="<?php print url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[0]->nid)); ?>" class="links cinza"><?php print $arrNodeSemImagem[0]->node_title ?></a></h5>
  </div>
  <h2 class="tagEspecialH2 cinza"><?php print $arrObjNodeImagem[1]->field_field_catnegocios[0]["rendered"]["#title"] ?></h2>
  <div class="contentCol bordaBottom">
    <a href="<?php print url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[1]->nid)); ?>" class="previewmodal5">
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
    </a>
    <div class="containerImgH4">
      <strong><a class="linksStrong preto" href="<?php print url($arrObjNodeImagem[1]->field_field_tags[0]["rendered"]["#href"]); ?>"><?php print $arrObjNodeImagem[1]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
      <span id="leiamais5" class="lerNoticiasMenor">
        <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$arrObjNodeImagem[1]->nid?>"></a>
        <a class="lerJa" lerja="<?php print url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[1]->nid)); ?>" title="Preview"></a>
      </span>
      <h4 class="noticiaH4"><a class="previewmodal5 links cinza" href="<?php print url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[1]->nid)); ?>"><?php print $arrObjNodeImagem[1]->node_title ?></a></h4>
    </div>
  </div>
  <div class="contentCol bordaBottom margin-top15">
    <h5 class="noticiaH5"><a href="<?php print url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[1]->nid)); ?>" class="links cinza"><?php print $arrNodeSemImagem[1]->node_title ?></a></h5>
  </div>
</div>
<div class="colunas2_1 margin-left25">
  <h2 class="tagDestaqueH2 cinza"><?php print $arrObjNodeImagem[2]->field_field_catnegocios[0]["rendered"]["#title"] ?></h2>
  <a class="margin-top7" href="<?php print url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[2]->nid)); ?>">
    <?php
       $uriImg = newGetImageCapaView($arrObjNodeImagem[2]);
       $img = array();
       $img['style']='medium';
       $img['uri']= $uriImg;
       $img['class']= array('');
       $img['alt']= $arrObjNodeImagem[2]->node_title;
       $img['title']= $arrObjNodeImagem[2]->node_title;
       $img['width']= "300";
       $img['height']= "226";
       
       //imprimindo a tag <img> com os atributos desejados.
       image_static_lazy($img);
     ?>
    <!--<img height="226" width="300" src="<?php // print image_style_url('medium', $arrObjNodeImagem[2]->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" alt="<?php // print $arrObjNodeImagem[2]->node_title ?>" />-->
  </a>
  <div class="contentCol margin-top7">
    <h4 class="noticiaH4"><a href="<?php print url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[2]->nid)); ?>" class="links cinza"><?php print $arrObjNodeImagem[2]->node_title ?></a></h4>
  </div>
  <?=render(getBlocos(array('34')));?>
</div>
<!------INICIO colunas3------->
<div class="colunas3">
  <div class="contentCol">
    <h2 class="tagDestaqueH2 cinza"><?php print  $arrObjNodeImagem[3]->field_field_catnegocios_1[0]["rendered"]["#title"] ?></h2>
    <a class='previewmodal3' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[3]->nid)); ?>">
      <?php
        $uriImg = newGetImageCapaView($arrObjNodeImagem[3]);
        $img = array();
        $img['style']   ='home_cadernos';
        $img['uri']     = $uriImg;
        $img['class']   = array('imgH6Grande');
        $img['alt']     = $arrObjNodeImagem[3]->node_title;
        $img['title']   = $arrObjNodeImagem[3]->node_title;
        $img['width']   = "191";
        $img['height']  = "143";

        //imprimindo a tag <img> com os atributos desejados.
        image_static_lazy($img);
        ?>
    </a>
    <strong><a href="<?php print  url($arrObjNodeImagem[3]->field_field_tags[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $arrObjNodeImagem[3]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
    <span id="leiamais3" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrObjNodeImagem[3]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[3]->nid)); ?>" title="Preview"></a>
    </span>
    <h6 class="noticiaH6 padding-bottom20"><a class='previewmodal3 links cinza' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[3]->nid)); ?>"><?php print  $arrObjNodeImagem[3]->node_title ?></a></h6>
    <div class="contentCol bordatop padding-top20">
      <strong><a href="<?php print  url(drupal_lookup_path('alias', $arrNodeSemImagem[2]->field_field_catnegocios_1[0]["rendered"]["#href"])); ?>" class="linksStrong preto"><?php print  $arrNodeSemImagem[2]->field_field_catnegocios_1[0]["rendered"]["#title"] ?></a></strong>
      <h6 class="noticiaH6"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[2]->nid)); ?>" class="links cinza"><?php print  $arrNodeSemImagem[2]->node_title ?></a></h6>
    </div>
  </div>	
  
  <div class="contentCol margin-left25">
    <h2 class="tagDestaqueH2 cinza"><?php print  $arrObjNodeImagem[4]->field_field_catnegocios_1[0]["rendered"]["#title"] ?></h2>
    <a class='previewmodal4' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[4]->nid)); ?>">
        <?php
            $uriImg = newGetImageCapaView($arrObjNodeImagem[4]);
            $img = array();
            $img['style']='home_cadernos';
            $img['uri']= $uriImg;
            $img['class']= array('imgH6Grande');
            $img['alt']= $arrObjNodeImagem[4]->node_title;
            $img['title']= $arrObjNodeImagem[4]->node_title;
            $img['width']= "191";
            $img['height']= "143";

            //imprimindo a tag <img> com os atributos desejados.
            image_static_lazy($img);
        ?>
      <!--<img src="<?php // print  image_style_url('home_cadernos', $arrObjNodeImagem[1]->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" alt="<?php // print  $arrObjNodeImagem[1]->node_title ?>" class="imgH6Grande" />-->
    </a>
    <strong><a href="<?php print  url($arrObjNodeImagem[4]->field_field_tags[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $arrObjNodeImagem[4]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
    <span id="leiamais4" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrObjNodeImagem[4]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[4]->nid)); ?>" title="Preview"></a>
    </span>
    <h6 class="noticiaH6 padding-bottom20"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[4]->nid)); ?>" class='previewmodal4 links cinza'><?php print  $arrObjNodeImagem[4]->node_title ?></a></h6>
    <div class="contentCol bordatop padding-top20">
      <strong><a href="<?php print url(drupal_lookup_path('alias', $arrNodeSemImagem[3]->field_field_catnegocios_1[0]["rendered"]["#href"])); ?>" class="linksStrong preto"><?php print   $arrNodeSemImagem[3]->field_field_catnegocios_1[0]["rendered"]["#title"] ?></a></strong>
      <h6 class="noticiaH6"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[3]->nid)); ?>" class="links cinza"><?php print  $arrNodeSemImagem[3]->node_title ?></a></h6>
    </div>
  </div>
  
  <div class="contentCol margin-left25">
    <h2 class="tagDestaqueH2 cinza"><?php print  $arrObjNodeImagem[5]->field_field_catnegocios_1[0]["rendered"]["#title"] ?></h2>
    <a class='previewmodal5' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[5]->nid)); ?>">
       <?php
            $uriImg = newGetImageCapaView($arrObjNodeImagem[5]);
            $img = array();
            $img['style']='home_cadernos';
            $img['uri']= $uriImg;
            $img['class']= array('imgH6Grande');
            $img['alt']= $arrObjNodeImagem[5]->node_title;
            $img['title']= $arrObjNodeImagem[5]->node_title;
            $img['width']= "191";
            $img['height']= "143";

            //imprimindo a tag <img> com os atributos desejados.
            image_static_lazy($img);
        ?>
      <!--<img src="<?php // print  image_style_url('home_cadernos', $arrObjNodeImagem[2]->field_field_capa[0]["rendered"]["#item"]["uri"]); ?>" alt="<?php // print  $arrObjNodeImagem[1]->node_title ?>" class="imgH6Grande" />-->
    </a>
    <strong><a href="<?php print  url($arrObjNodeImagem[5]->field_field_tags[0]["rendered"]["#href"]); ?>" class="linksStrong preto"><?php print  $arrObjNodeImagem[5]->field_field_tags[0]["rendered"]["#title"] ?></a></strong>
    <span id="leiamais5" class="lerNoticiasMenor">
      <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid.';'.$arrObjNodeImagem[5]->nid?>"></a>
      <a class="lerJa" lerja="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[5]->nid)); ?>" title="Preview"></a>
    </span>
    <h6 class="noticiaH6 padding-bottom20"><a class='previewmodal5 links cinza' href="<?php print  url(drupal_lookup_path('alias',"node/".$arrObjNodeImagem[5]->nid)); ?>"><?php print  $arrObjNodeImagem[5]->node_title ?></a></h6>
    <div class="contentCol bordatop padding-top20">
      <strong><a href="<?php print url(drupal_lookup_path('alias', $arrNodeSemImagem[4]->field_field_catnegocios_1[0]["rendered"]["#href"])); ?>" class="linksStrong preto"><?php print  $arrNodeSemImagem[4]->field_field_catnegocios_1[0]["rendered"]["#title"] ?></a></strong>
      <h6 class="noticiaH6"><a href="<?php print  url(drupal_lookup_path('alias',"node/".$arrNodeSemImagem[4]->nid)); ?>" class="links cinza"><?php print  $arrNodeSemImagem[4]->node_title ?></a></h6>
    </div>
  </div>  
</div> 