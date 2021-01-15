<?php
//tpl do bloco de notícias gerais da home do LeiaJá

module_load_include('inc', 'capa', 'capa');

//declacao de variaveis
$nidsIgnores = '';

//obtendo todos os nids já usados na capa
$nodesIgnores = api_getNidIgnore();
//obtendo dados de views
$resultSemImgs = views_get_view_result('bloco_geral', 'sem_img',$nodesIgnores);


//----------IGNORANDO OS NIDS JAH USADOS--------------
foreach ($resultSemImgs as $value) {
    $nidsIgnores.= $value->nid.',';
}
$nodesIgnores = $nidsIgnores.$nodesIgnores;
//----------IGNORANDO OS NIDS JAH USADOS--------------

//obtendo dados de views
$resultComImgs = views_get_view_result('bloco_geral', 'com_img',$nodesIgnores);

//----------IGNORANDO OS NIDS JAH USADOS--------------
//atualizando a lista de nids ignores
foreach ($resultComImgs as $value) {
    $nidsIgnores.= $value->nid.',';
}
$nodesIgnores = $nidsIgnores.$nodesIgnores;

//atualizando cache dos nids já usada da home
api_IgnoreBlocoGeral($nodesIgnores);
//----------IGNORANDO OS NIDS JAH USADOS--------------


//função para criação dos dados a serrem renderizados abaixo. Como o uso de uma estrutura de repitição é desapropriado por causa do html,
//tenta preencher essa lacuna. 
function constroiDados($arrDados, $key){
  
    // Caso houver chamada de capa uso a mesma se não uso o titulo
    $titulo = (!empty ($arrDados[$key]->_field_data['nid']['entity']->field_chamada_capa[key($arrDados[$key]->_field_data['nid']['entity']->field_chamada_capa)][0]["value"])) 
            ? $arrDados[$key]->_field_data['nid']['entity']->field_chamada_capa[key($arrDados[$key]->_field_data['nid']['entity']->field_chamada_capa)][0]["value"]
            : $arrDados[$key]->node_title;
    
    $nid        = $arrDados[$key]->nid;
    $urlNode    = drupal_lookup_path('alias',"node/".$nid);
    $tid        = $arrDados[$key]->field_field_tags[0]['rendered']['#options']['entity']->tid;
    $urlTag     = $arrDados[$key]->field_field_tags[0]['rendered']['#href'];
    $urlTag     = drupal_lookup_path('alias',$urlTag);
    $NomeTag    = $arrDados[$key]->field_field_tags[0]['rendered']['#options']['entity']->name;
    
    //setando as imagens que serão usadas
    $imgCapa = $arrDados[$key]->field_field_capa;
    if($imgCapa){$baseImg = $arrDados[$key]->field_field_capa;
    }elseif($arrDados[$key]->field_field_image){$baseImg = $arrDados[$key]->field_field_image;}
        
    if($baseImg){
        
        $uriImg = $baseImg[0]['rendered']['#item']['uri'];
        $ttImg  = $baseImg[0]['rendered']['#item']['title'];
        $altImg  = $baseImg[0]['rendered']['#item']['alt'];
        
    }else{
        $uriImg = '';
        $ttImg  = '';
        $altImg = '';
    }
    
    //criando o retorno da função. Todos as variáveis que serão usadas (printadas)
    $retorno = array(
        'titulo'    => $titulo,
        'urlNode'   => $urlNode,
        'nomeTag'   => $NomeTag,
        'urlTag'    => $urlTag,
        'uriImg'    => $uriImg,
        'ttImg'     => $ttImg,
        'altImg'    => $altImg,
        'cor'    => getCores(str_replace("caderno_", "", $arrDados[$key]->_field_data['nid']['entity']->type))
    );
    
    return $retorno;
}
?>
<!--<style>
.novobloco_destaque { background:  url(http://static1.leiaja.com/sites/all/themes/leiaja/images/bgblocosaojoao.png) top center no-repeat;padding-top:33px; }
.divbgsaojoao { background:  url(http://static1.leiaja.com/sites/all/themes/leiaja/images/bgblocosaojoao2.png) bottom center no-repeat;padding-bottom:20px;margin-bottom:15px;display: inline-block;clear:both; }
.novobloco_destaque .noticiaH3 { font-size: 19px }
.novobloco_destaque .noticiaH2 { font-size: 22px }
</style>-->


<div class="novobloco_destaque" style="display: inline-block;clear:both;">
<div class="divbgsaojoao">
  <div class="colunas2_1 margin-bottom15">

    <div class="contentCol bordaBottom padding-bottom7">
        <?php 
        $key = 0;
        $tempDados = constroiDados($resultSemImgs, 0);?>
      <strong>
        <a href="/<?php print $tempDados['urlTag'];?>" class="linksStrong <?= $tempDados["cor"] ?>"><?php print $tempDados['nomeTag'];?></a>
      </strong>
      <h2 class="noticiaH2" style="height:60px;"><a class="links cinza" href="/<?php print $tempDados['urlNode'];?>" title=""><span class="geo-chamada1-titulo"><?php print $tempDados['titulo'];?></span>
      </a>
      </h2>
    </div>

    <div class="contentCol bordaBottom padding-bottom7 margin-top15" style="height:110px;">
        <?php $tempDados = constroiDados($resultSemImgs, 1);?>
      <strong>
            <a href="/<?php print $tempDados['urlTag'];?>" class="linksStrong <?= $tempDados["cor"] ?>"><?php print $tempDados['nomeTag'];?></a>
      </strong>
      <h3 class="noticiaH3"><a class="links cinza" href="/<?php print $tempDados['urlNode'];?>" title="<?php print $tempDados['titulo'];?>"><span class="geo-chamada1-titulo"><?php print $tempDados['titulo'];?> </span>
      </a>
      </h3>
      <?php $tempDados = constroiDados($resultSemImgs, 2);?>
      <a style="display: block; min-width: 300px;" href="/<?php print $tempDados['urlNode'];?>" class="links cinza bullet"><span>•</span> <?php print $tempDados['titulo'];?></a>
      <?php $tempDados = constroiDados($resultSemImgs, 3);?>
      <a style="display: block; min-width: 300px;" href="/<?php print $tempDados['urlNode'];?>" class="links cinza bullet"><span>•</span> <?php print $tempDados['titulo'];?></a>
    </div>


  </div><!-- FIM colunas2_1 -->

  <div class="colunas2_2 margin-left25 margin-bottom15">
    <div class="contentCol bordaBottom padding-bottom10">
        <?php 
        $key=0;
        $tempDados = constroiDados($resultComImgs, $key);?>
          <a href="/<?php print $tempDados['urlNode'];?>">
            <?php
                $img = array();
                $img['style']   = 'home_cadernos';
                $img['uri']     = $tempDados['uriImg'];
                $img['class']   = array('imgH6Pequena');
                $img['alt']     = $tempDados['altImg'];
                $img['title']   = $tempDados['ttImg'];
                $img['width']   = "148";
                $img['height']  = "111";

                //imprimindo a tag <img> com os atributos desejados.
                image_static_lazy($img);
              ?>
          </a>
          <div class="containerImgH4" style="width:135px;">
            <strong><a href="/<?php print $tempDados['urlTag'];?>" class="linksStrong <?= $tempDados["cor"] ?>"><?php print $tempDados['nomeTag'];?></a></strong>
            <h3 class="noticiaH3" style="height:97px;"><a href="/<?php print $tempDados['urlNode'];?>" class="links cinza"><?php print $tempDados['titulo'];?></a></h3>
          </div>
    </div>
    <div class="contentCol bordaBottom padding-bottom10 margin-left25">
        <?php $tempDados = constroiDados($resultComImgs, ++$key);?>
          <a href="/<?php print $tempDados['urlNode'];?>">
              <?php
                $img = array();
                $img['style']   = 'home_cadernos';
                $img['uri']     = $tempDados['uriImg'];
                $img['class']   = array('imgH6Pequena');
                $img['alt']     = $tempDados['altImg'];
                $img['title']   = $tempDados['ttImg'];
                $img['width']   = "148";
                $img['height']  = "111";

                //imprimindo a tag <img> com os atributos desejados.
                image_static_lazy($img);
              ?>
          </a>
          <div class="containerImgH4" style="width:135px;">
            <strong><a href="/<?php print $tempDados['urlTag'];?>" class="linksStrong <?= $tempDados["cor"] ?>"><?php print $tempDados['nomeTag'];?></a></strong>
            <h3 class="noticiaH3" style="height:97px;"><a href="/<?php print $tempDados['urlNode'];?>" class="links cinza"><?php print $tempDados['titulo'];?></a></h3>
          </div>
    </div>
  </div><!-- FIM colunas2_2 -->


</div>
</div>