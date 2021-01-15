<?php
$conteudo = views_get_view_result('futebol_campeonato', 'page');
$url = arg(2);


function limitaTextoFutebol($string, $limit, $break=" ", $pad="...") {
	// return with no change if string is shorter than $limit
	if(strlen($string) <= $limit)
		return $string; 
 
	// is $break present between $limit and the end of the string?
	if(false !== ($breakpoint = strpos($string, $break, $limit))) {
		if($breakpoint < strlen($string) - 1) {
			$string = substr($string, 0, $breakpoint) . $pad;
		}
	}
    return $string;
}
global $base_url;
?>
<div class="caderno_esportes">
    <ul class="listaResultado resultadoBusca">
      <h2 class="maisNoticiasH2 cinza">Mais Notícias</h2>
    <?php 
    foreach ($conteudo as $value) {

        $nid = $value->nid;
        $titulo = $value->node_title;
        $aliasUrlNode = $base_url.url(drupal_lookup_path('alias',"node/".$nid));
        $fonte = $value->_field_data['nid']['entity']->field_fonte['pt-br'][0]['safe_value'];
        $sumario = $value->_field_data['nid']['entity']->body['pt-br'][0]['summary'];
        if(!empty($sumario)){
            $desc = $sumario;
        }else{
            $desc = limitaTextoFutebol(retiraHash($value->_field_data['nid']['entity']->body['pt-br'][0]['value']), 300);
        }
        $desc = strip_tags($desc);
        
        $ImageCapa = $value->field_field_capa;
        $imagem = $value->field_field_image;
        if(!empty($ImageCapa)){
            $uriImage = $value->field_field_capa[0]['rendered']['#item']['uri'];
            $vImagem = image_style_url('home_cadernos', $uriImage); 
        }elseif(!empty($imagem)){
            $uriImage = $value->field_field_image[0]['rendered']['#item']['uri'];
            $vImagem = image_style_url('home_cadernos', $uriImage); 
        }else{
            $vImagem = "";
        }
        
        $vTags = $value->_field_data['nid']['entity']->field_tags['pt-br'];
        
    ?>
    <li class="ljhasimg">
        <?php 
        if(!empty($vImagem)){
        ?>
        <a href="<?php print $aliasUrlNode;?>"><img src="<?print $vImagem;?>" height="143" width="191" alt="<?print $titulo;?>" class="imgH6Grande"></a>
        <?php } ?>
        <h4><a href="<?print $aliasUrlNode;?>"><?php print $titulo;?></a></h4>
          <p><a href="<?php print $aliasUrlNode;?>"><?php print $desc;?></a></p>
          <h5 class="fonte">por <?php print $fonte;?></h5>
          <div class="tagsExibir">
            <h5>Tags:</h5>
            <ul class="tags">
                <?php
                foreach ($vTags as $value){
                    $tid = $value['tid'];
                    $objTaxy = taxonomy_term_load($tid); 
                    $nomeTag = $objTaxy->name;
                    $tid = $objTaxy->tid;
                    $urlTag = drupal_lookup_path('alias',"taxonomy/term/".$tid);
                ?>
                 <li><a href="/<?php print $urlTag;?>" title="<?php print $nomeTag;?>"><?php print $nomeTag;?></a></li>
                <?php }?>
            </ul>
          </div>
    </li>
        
        <?php } ?>
    </ul>
    
    <div class="divPaginacao">
       <div class="paginacao2"> 
           <?php print theme('pager');?>
       </div>         
    </div>

</div>