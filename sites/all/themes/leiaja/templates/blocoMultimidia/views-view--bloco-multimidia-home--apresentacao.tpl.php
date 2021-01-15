<?php
//Multimidia
// $Id: block.tpl.php,v 1.10 2010/04/26 14:10:40 dries Exp $

/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user module
 *     is responsible for handling the default user navigation block. In that case
 *     the class would be "block-user".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 */
module_load_include('inc', 'videosambatech', 'videosambatech');
module_load_include('inc', 'capa', 'capa.api');
$vMultimidia['tvleiaja'] = views_get_view_result('bloco_multimidia_home', 'tvleiaja');
$vMultimidia['video'] = views_get_view_result('bloco_multimidia_home', 'page_video');
$vMultimidia['galeria'] = views_get_view_result('bloco_multimidia_home', 'page_galeria');
$vMultimidia['podcast'] = views_get_view_result('bloco_multimidia_home', 'page_podcast');
/*
 * views get result customizada com views_get_view - Views passar parametros para view.
 */

function formatarDados($arrayNodes, $bolAgregation = false, $bolVideo = false){
  $nodes  = Array();
  foreach($arrayNodes as $key=>$node){
    // Caso use agregation
    $strChaveNode = ($bolAgregation) ? "nid_1" : "nid";
    // Pegando as chaves
    $strChaveImg     = key($node->_field_data[$strChaveNode]["entity"]->field_capa);
    $strChaveImgCapa = key($node->_field_data[$strChaveNode]["entity"]->field_image);
    
    //setando a img de capa à variável
    $imgCapa        = (isset($node->_field_data[$strChaveNode]["entity"]->field_capa[$strChaveImg][0]["uri"])) ? $node->_field_data[$strChaveNode]["entity"]->field_capa[$strChaveImg][0]["uri"] : '';
    //setando a img à variável
    $imagem         = (isset($node->_field_data[$strChaveNode]["entity"]->field_image[$strChaveImgCapa][0]["uri"])) ? $node->_field_data[$strChaveNode]["entity"]->field_image[$strChaveImgCapa][0]["uri"] : '';
    
    //fazendo a verificação se a img de capa existe. caso exista para ser setada à variavel;
    $img            = (!empty ($imgCapa)) ? $imgCapa : $imagem;
    
    // Pegando os campo
    $nodes[$key]              = new stdClass();
    $nodes[$key]->thumbVideo  = $img;
    $nodes[$key]->nid         = $node->nid;
    $nodes[$key]->totalcount  = 0;
    $nodes[$key]->title       = strip_tags($node->node_title);
    $nodes[$key]->tag         = ($bolAgregation) ? $node->field_field_tags[0]["rendered"]["#options"]["entity"]->name : $node->field_field_tags[0]["rendered"]["#markup"];
    
  }
  // Caso for vídeos
  if($bolVideo){
    // reordenando o array pela sua chave que são os views da notícia
    krsort($nodes);
  }
  
  return $nodes;
}

$vMultimidia['tvleiaja'] = formatarDados($vMultimidia['tvleiaja'], false, true);
$vMultimidia['video'] = formatarDados($vMultimidia['video'],  false, true);
$vMultimidia['galeria'] = formatarDados($vMultimidia['galeria'], true);
$vMultimidia['podcast'] = formatarDados($vMultimidia['podcast'],  false, true);
?>
<!-- Home Apresentacao -->
      <div class="colunas1 margin-top4 divMultimidiaBloco">
          <h2 class="tituloH2 cinza"><a href="/multimidia" class="cinza" title="Multimídia">Multimídia</a></h2>
          <div class="multimidia">
          <ul class="UlMultimidia">
            <li><a href="javascript:void(0);" onclick="BlkMultimidiaCategoriaHover(this,'divMnuBlkTv');" class="active" ><span class="iconeMultimidiaMaior iconeTvMaior"></span><span>Tv Leia J&aacute;</span></a></li>
            <li><a href="javascript:void(0);" onclick="BlkMultimidiaCategoriaHover(this,'divMnuBlkVideo');"><span class="iconeMultimidiaMaior iconeVidMaior"></span><span>Videos</span></a></li>
            <li><a href="javascript:void(0);" onclick="BlkMultimidiaCategoriaHover(this,'divMnuBlkGaleria');"><span class="iconeMultimidiaMaior iconeGalMaior"></span><span>Galeria</span></a></li>
            <li><a href="javascript:void(0);" onclick="BlkMultimidiaCategoriaHover(this,'divMnuBlkPodcast');"><span class="iconeMultimidiaMaior iconePodMaior"></span><span>Podcast</span></a></li>
            <li id="divCarregando" style="position: absolute;right:0;margin-top: -7px;display:none;"><img rel='img1' src="/sites/all/themes/leiaja/images/loaderMultimidia.gif" alt="" /></li>
          </ul>
        <!-- TV Leiaja -->
          <div id="divMnuBlkTv" style="display:block;" class="container-multimidia-block">
            <ul style="width:1875px">
          <?php
            $vJSTv = 'var vMMTv = new Array();';
            foreach($vMultimidia['tvleiaja'] as $key => $vid):
              $vLink     = url(drupal_lookup_path('alias',"node/".$vid->nid));
              $vThumbGrd = image_style_url('home_cadernos', $vid->thumbVideo);
              $vJSTv .= "vMMTv[$key] = {'nid' : {$vid->nid}, 'titulo' : '".addslashes($vid->title)."', 'tag' : '{$vid->tag}', 'views' : {$vid->totalcount},'link' : '$vLink', 'thumbPeq' : '$vThumbGrd', 'thumbGrd' : '$vThumbGrd'};";
          ?>
	          <li class="videosMenores">
	          	<a href="<?= $vLink ?>" rel="a<?= $key+1 ?>" class="videoMenor">
                            <?php
                              $img = array();
                              $img['style']='home_cadernos';
                              $img['uri']=$vid->thumbVideo;
                              $img['class']=array('imgH6Grande');
                              $img['alt']=$vid->title;
                              $img['title']=$vid->title;
                              $img['width']="100";
                              $img['height']="75";
                              $img['atribute'] = array('rel'=>'img1'.($key+1));
                              //imprimindo a tag <img> com os atributos desejados.
                              image_static_lazy($img);
                            ?>
                        </a>
	            <span class="lerNoticiasMenor fixarVideoPequeno" id="leiamais45<?= $key+1 ?>">
	            	<a follow="<?=$GLOBALS['user']->uid.';'.$vid->nid.';0'?>" href="javascript:void(0);" title="Fixar no Mural" class="lerDepois"></a>
	          	</span>
	            <h6 class="tagVideo"><span class="iconeMultimidiaMenor iconeTvMenor"></span><strong rel="strongTag<?= $key+1 ?>"><?= $vid->tag ?></strong></h6>
	            <a href="<?= $vLink; ?>" class="tituloVideo" rel="aTitulo<?= $key+1 ?>"><?= $vid->title ?></a>
                  </li>
          <?php endforeach; ?>
          </ul>
        </div>
        <!-- Fim TV Leiaja -->
        <!-- Video -->
          <div id="divMnuBlkVideo" style="display:none;" class="container-multimidia-block">
            <ul style="width:1875px">
          <?php
            $vJSVideo = 'var vMMVideo = new Array();';
            foreach($vMultimidia['video'] as $key => $vid):
              $vLink     = url(drupal_lookup_path('alias',"node/".$vid->nid));
              $vThumbGrd = image_style_url('home_cadernos', $vid->thumbVideo);
              $vJSVideo .= "vMMVideo[$key] = {'nid' : {$vid->nid}, 'titulo' : '".addslashes($vid->title)."', 'tag' : '{$vid->tag}', 'views' : {$vid->totalcount},'link' : '$vLink', 'thumbPeq' : '$vThumbGrd', 'thumbGrd' : '$vThumbGrd'};";
          ?>
	          <li class="videosMenores">
	          	<a href="<?= $vLink ?>" rel="a<?= $key+1 ?>" class="videoMenor">
                          <?php
                              $img = array();
                              $img['style']='home_cadernos';
                              $img['uri']=$vid->thumbVideo;
                              $img['class']=array('imgH6Grande');
                              $img['alt']=$vid->title;
                              $img['title']=$vid->title;
                              $img['width']="100";
                              $img['height']="75";
                              $img['atribute'] = array('rel'=>'img1'.($key+1));
                              //imprimindo a tag <img> com os atributos desejados.
                              image_static_lazy($img);
                            ?>
                        </a>
	            <span class="lerNoticiasMenor fixarVideoPequeno" id="leiamais45<?= $key+1 ?>">
	            	<a follow="<?=$GLOBALS['user']->uid.';'.$vid->nid.';0'?>" href="javascript:void(0);" title="Fixar no Mural" class="lerDepois"></a>
	          	</span>
	            <h6 class="tagVideo"><span class="iconeMultimidiaMenor iconeVidMenor"></span><strong rel="strongTag<?= $key+1 ?>"><?= $vid->tag ?></strong></h6>
	            <a href="<?= $vLink; ?>" class="tituloVideo" rel="aTitulo<?= $key+1 ?>"><?= $vid->title ?></a>
                  </li>
          <?php endforeach; ?>
          </ul>
        </div>
        <!-- Fim Video -->
        <!-- Galeria -->
          <div id="divMnuBlkGaleria" style="display:none;" class="container-multimidia-block">
            <ul style="width:1875px">
          <?php
            $vJSGaleria = 'var vMMGaleria = new Array();';
            foreach($vMultimidia['galeria'] as $key => $vid):
              $vLink     = url(drupal_lookup_path('alias',"node/".$vid->nid));
              $vThumbGrd = image_style_url('home_cadernos', $vid->thumbVideo);
              $vJSGaleria .= "vMMGaleria[$key] = {'nid' : {$vid->nid}, 'titulo' : '".addslashes($vid->title)."', 'tag' : '{$vid->tag}', 'views' : {$vid->totalcount},'link' : '$vLink', 'thumbPeq' : '$vThumbGrd', 'thumbGrd' : '$vThumbGrd'};";
          ?>
	          <li class="videosMenores">
	          	<a href="<?= $vLink ?>" rel="a<?= $key+1 ?>" class="videoMenor">
                          <?php
                              $img = array();
                              $img['style']='home_cadernos';
                              $img['uri']=$vid->thumbVideo;
                              $img['class']=array('imgH6Grande');
                              $img['alt']=$vid->title;
                              $img['title']=$vid->title;
                              $img['width']="100";
                              $img['height']="75";
                              $img['atribute'] = array('rel'=>'img1'.($key+1));
                              //imprimindo a tag <img> com os atributos desejados.
                              image_static_lazy($img);
                            ?>
                        </a>
	            <span class="lerNoticiasMenor fixarVideoPequeno" id="leiamais45<?= $key+1 ?>">
	            	<a follow="<?=$GLOBALS['user']->uid.';'.$vid->nid.';0'?>" href="javascript:void(0);" title="Fixar no Mural" class="lerDepois"></a>
	          	</span>
	            <h6 class="tagVideo"><span class="iconeMultimidiaMenor iconeGalMenor"></span><strong rel="strongTag<?= $key+1 ?>"><?= $vid->tag ?></strong></h6>
	            <a href="<?= $vLink; ?>" class="tituloVideo" rel="aTitulo<?= $key+1 ?>"><?= $vid->title ?></a>
                  </li>
          <?php endforeach; ?>
          </ul>
        </div>
        <!-- Fim Galeria -->
        <!-- Podcast -->
          <div id="divMnuBlkPodcast" style="display:none;" class="container-multimidia-block">
            <ul style="width:1875px">
          <?php
            $vJSPodcast = 'var vMMPodcast = new Array();';
            foreach($vMultimidia['podcast'] as $key => $vid):
              $vLink     = url(drupal_lookup_path('alias',"node/".$vid->nid));
              $vThumbGrd = image_style_url('home_cadernos', $vid->thumbVideo);
              if(empty($vid->thumbVideo)){
                $vThumbGrd=base_path().drupal_get_path('theme', 'leiaja')."/images/thumbPodcast.jpg";
              }
              $vJSPodcast .= "vMMPodcast[$key] = {'nid' : {$vid->nid}, 'titulo' : '".addslashes($vid->title)."', 'tag' : '{$vid->tag}', 'views' : {$vid->totalcount},'link' : '$vLink', 'thumbPeq' : '$vThumbGrd', 'thumbGrd' : '$vThumbGrd'};";
          ?>
	          <li class="videosMenores">
	          	<a href="<?= $vLink ?>" rel="a<?= $key+1 ?>" class="videoMenor">
                          <?php
                              $img = array();
                              $img['style']='home_cadernos';
                              $img['uri']=$vid->thumbVideo;
                              $img['class']=array('imgH6Grande');
                              $img['alt']=$vid->title;
                              $img['title']=$vid->title;
                              $img['width']="100";
                              $img['height']="75";
                              $img['atribute'] = array('rel'=>'img1'.($key+1));
                              //imprimindo a tag <img> com os atributos desejados.
                              image_static_lazy($img);
                            ?>
                        </a>
	            <span class="lerNoticiasMenor fixarVideoPequeno" id="leiamais45<?= $key+1 ?>">
	            	<a follow="<?=$GLOBALS['user']->uid.';'.$vid->nid.';0'?>" href="javascript:void(0);" title="Fixar no Mural" class="lerDepois"></a>
	          	</span>
	            <h6 class="tagVideo"><span class="iconeMultimidiaMenor iconePodMenor"></span><strong rel="strongTag<?= $key+1 ?>"><?= $vid->tag ?></strong></h6>
	            <a href="<?= $vLink; ?>" class="tituloVideo" rel="aTitulo<?= $key+1 ?>"><?= $vid->title ?></a>
                  </li>
          <?php endforeach; ?>
          </ul>
        </div>
        <!-- Fim Podcast -->
          <div class="footerMultimidia">
            <div class="passador">
              <a href="javascript:void(0);" class="passaLeft" data-passador="anterior"></a>
              <a href="javascript:void(0);" class="passaRight" data-passador="proximo"></a>
            </div>
          </div>
        </div>
      </div>

<script type="text/javascript" src="/sites/all/themes/leiaja/js/multimidia.js?<?= rand(0,1000); ?>"></script>
