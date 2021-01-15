<?php
/**
 * Arquivo que conterá o bloco com 3 notícias da cobertura de carnaval
 * 
 * 
 * @author Alberto Medeiros
 */
// Includes necessários
//require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja') .'/template.api.inc';

module_load_include('inc', 'capa', 'capa');
?>

<div class="colunas3" style="">
  <h2 class="tituloH2"><a href="http://www.leiaja.com/esportes/futebol" class="vermelho" title="Campeonato Pernambucano">Imposto de Renda</a></h2>

<?php
// Recuperando a views de cultura
$resultViewsEsporte = views_get_view_result('blocos_horizontais_3imgs_home', 'block_esporte',api_getNidIgnore());

$arrNid = array();
foreach ($resultViewsEsporte as $key => $value){
  if(!empty ($value->nid))
    $arrNid[] = $value->nid;
}
// Implodindo o array
$strIgnore = implode(",", $arrNid);

// Criando o ignore das notícias pra evitar o que vem da capa
$strIgnore .= api_getNidIgnore();



// Recuperando a views do bloco de carnaval
$resultViews        = views_get_view_result('bloco_coberturas', 'bloco_cobertura_carnaval_3_img', $strIgnore);

foreach ($resultViews as $key => $value){

    $nid = $value->nid;
    $chamadaCapa = $value->_field_data['nid']['entity']->field_chamada_capa;
    if(!empty($chamadaCapa)):
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
    <strong><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$tid)); ?>" class="linksStrong vermelho"><?=$subcategoria ?></a></strong>
    <span id="leiamais12" class="lerNoticiasMenor fixarSoNoticia">
    <a class="lerDepois" title="Fixar no Mural" href="javascript:void(0);" follow="<?=$GLOBALS['user']->uid.';'.$nid.';0'?>"></a>
  </span>
  <h6 class="noticiaH6"><a class="previewmodal12links cinza" href="<?=$aliasUrlNode?>"><?=$titulo?></a></h6>
</div>  
  <?php } ?>
</div>


