<?php 
//include nos modulos
module_load_include('module', 'funcoes', 'funcoes');
module_load_include('inc', 'capa', 'capa');
?>
<div class="colunas3">
  <h2 class="tituloH2"><a href="/carreiras" class="roxo" title="Carreiras">Carreiras</a></h2>

<?php
$resultViews = views_get_view_result('blocos_horizontais_3imgs_home', 'block_carreira',api_getNidIgnore());

foreach ($resultViews as $key => $value){

    $nid = $value->nid;
    $chamadaCapa = $value->_field_data['nid']['entity']->field_chamada_capa;
    
    if(!empty($chamadaCapa)):
      $titulo = $chamadaCapa['und'][0]['value'];
      else:
      $titulo = $value->node_title;
    endif;
    $tid = $value->_field_data['nid']['entity']->field_catnegocios['pt-br'][0]['tid'];
    $termTaxy = taxonomy_term_load($tid);
    $subcategoria = $termTaxy->name;
    $aliasUrlNode = url(drupal_lookup_path('alias',"node/".$nid));
    
    if ($key > 0) {
      $classeMargem = 'margin-left25';
    } else {
      $classeMargem = '';
    }
?>

<div class="contentCol <?php print $classeMargem;?>">
    <strong><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$tid)); ?>" class="linksStrong roxo"><?=$subcategoria ?></a></strong>
    <span id="leiamais12" class="lerNoticiasMenor fixarSoNoticia">
    <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$nid.';0'?>"></a>
  </span>
  <h6 class="noticiaH6"><a class="previewmodal12links cinza" href="<?=$aliasUrlNode?>"><?=$titulo?></a></h6>
</div>  
  <?php } ?>
</div>

