<?php
//Tpl do bloco As Mais - Gerado por views
//die('aqui');
module_load_include('inc', 'capa', 'capa');
// Includes necessários
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja') .'/template.api.inc';

// Recuperando a views do bloco de carnaval
$resultViewsImagens = views_get_view_result('bloco_coberturas', 'bloco_cobertura_carnaval_topo_imagem');
$resultViews        = views_get_view_result('bloco_coberturas', 'bloco_cobertura_carnaval_topo');

// Criando o ignore das notícias com imagem
$strIgnore =  api_criaIgnore($resultViewsImagens);
$strIgnore .= api_criaIgnore($resultViews);
$strIgnore .= api_getNidIgnore();
?>
<div class="colunas3">
  <h2 class="tituloH2"><a href="/cultura" class="laranja" title="Cultura">Cultura</a></h2>

<?php
  
  $resultViews = views_get_view_result('blocos_horizontais_3imgs_home', 'block_cultura', $strIgnore);
  
foreach ($resultViews as $key => $value){

    $nid = $value->nid;
    $chamadaCapa = $value->_field_data['nid']['entity']->field_chamada_capa;
    $titulo = "";
    if(!empty($chamadaCapa[key($chamadaCapa)][0]['value'])):
      $language = key($chamadaCapa);
      $titulo = $chamadaCapa[$language][0]['value'];
    else:
      $titulo = $value->node_title;
    endif;
    $tid = $value->_field_data['nid']['entity']->field_catcultura['pt-br'][0]['tid'];
    $termTaxy = taxonomy_term_load($tid);
    $subcategoria = $termTaxy->name;
    $aliasUrlNode = url(drupal_lookup_path('alias',"node/".$nid));
    $ImageCapa = $value->field_field_capa;
    
    if(!empty($ImageCapa)){
        $uriImage = $value->field_field_capa[0]['rendered']['#item']['uri'];
    }else{
        $uriImage = $value->field_field_image[0]['rendered']['#item']['uri'];
    }
    
    if($key>0){$classeMargem = 'margin-left25';}else{$classeMargem='';}
    
    //verificando se imagem tem title
    if(!empty($value->field_field_image[0]['rendered']["title"])):
      $imgTitle = $value->field_field_image[0]['rendered']["title"];
      else:
      $imgTitle = $titulo;
    endif;
    
    //verificando se imagem tem o texto alternativo (alt)
    if(!empty($value->field_field_image[0]['rendered']["alt"])):
      $imgAlt = $value->field_field_image[0]['rendered']["alt"];
      else:
      $imgAlt = $imgTitle;
    endif;

?>

<div class="contentCol <?php print $classeMargem;?>">
    <a class="previewmodal12" href="<?=$aliasUrlNode?>">
        <?php
        $img = array();
        $img['style']='home_cadernos';
        $img['uri']=$uriImage;
        $img['class']=array('imgH6Grande');
        $img['alt']=$imgAlt;
        $img['title']=$imgTitle;
        $img['width']="191";
        $img['height']="143";
        
        //imprimindo a tag <img> com os atributos desejados.
        image_static_lazy($img);
      ?>
    </a>
    <strong><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$tid)); ?>" class="linksStrong laranja"><?=$subcategoria ?></a></strong>
  <h6 class="noticiaH6"><a class="previewmodal12links cinza" href="<?=$aliasUrlNode?>"><?=$titulo?></a></h6>
</div>  
  <?php } ?>
</div>

