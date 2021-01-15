<?php 
//include nos modulos
module_load_include('module', 'funcoes', 'funcoes');
module_load_include('inc', 'capa', 'capa');
?>
<div class="colunas3">
  <h2 class="tituloH2"><a href="/esportes" class="verde" title="Esportes">Esportes</a></h2>

<?php
$resultViews = views_get_view_result('blocos_horizontais_3imgs_home', 'block_esporte',api_getNidIgnore());

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
    $tid = $value->_field_data['nid']['entity']->field_catesporte['pt-br'][0]['tid'];
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
    <strong><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$tid)); ?>" class="linksStrong verde"><?=$subcategoria ?></a></strong>
    <span id="leiamais12" class="lerNoticiasMenor fixarSoNoticia">
    <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$nid.';0'?>"></a>
  </span>
    <h6 class="noticiaH6"><a class="previewmodal12links cinza" href="<?=$aliasUrlNode?>"><?= str_replace('\"', '"', $titulo) ?></a></h6>
</div>  
  <?php } ?>
</div>

