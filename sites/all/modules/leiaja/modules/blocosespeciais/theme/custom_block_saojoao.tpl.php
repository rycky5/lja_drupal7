<style>
#saojoao { float:left;width:625px;min-height:450px;padding-bottom: 25px; background: #d3c8b8 url(/sites/all/themes/leiaja/images/capa_especiais/saojoao/bg.jpg) left bottom no-repeat; ;padding-left:10px;margin: 0px 0px 15px -5px; }
#saojoao .rollContent{ float:left;width:615px; margin-top: -15px;}
#saojoao strong a{color:#6b4534!important;text-transform: uppercase; }
#saojoao a.elemento{position:absolute; width:150px;height:124px;margin:-20px 0 0 235px; background:url(/sites/all/themes/leiaja/images/capa_especiais/saojoao/elemento.png) no-repeat top left;text-indent: -5000px; }
#saojoao h1{width:635px;height:92px;text-indent:-5000px;margin-left:-10px;background: url(/sites/all/themes/leiaja/images/capa_especiais/saojoao/barra.png) no-repeat; }
#saojoao h1 a{float:right; width:88px; height:31px; padding:0px; margin:60px 10px 0px 0px;} 
#saojoao img.imgH3{ width:290px !important;height:190px !important;border:5px solid #7e3100; margin-bottom: 10px; }
#saojoao img.imgH4{ width:133px !important;height:100px !important;border:5px solid #7e3100; margin-bottom: 10px;}
#saojoao .alturaciclo{min-height:50px;overflow:hidden; padding-bottom: 5px;}
#saojoao .colunas2_1 .contentCol{padding-bottom: 15px;}
#saojoao span, #saojoao a,#saojoao h1, #saojoao h2, #saojoao h3, #saojoao h4{color:#6b4534;}
#saojoao h2, #saojoao h3, #saojoao h4{font-size: 19px; line-height: 21px;}
#saojoao .bordaBottom{background:url(/sites/all/themes/leiaja/images/capa_especiais/saojoao/separador.gif) repeat-x bottom left;}

#saojoao .ajuste-coll-right .contentCol{ padding-bottom: 23px; margin-top: 20px;}
#saojoao .ajuste-tamanho-titulo h3, #saojoao .ajuste-tamanho-titulo h4{font-size: 22px; line-height: 24px;}
#saojoao .ajuste-coll-right .contentCol:first-child{margin-top: 15px;}
</style>



<div id="saojoao">
    <a href="http://saojoao.leiaja.com" class="elemento">Ir para o site do São João;</a>
	<h1>
		<span>São João</span>
		<!-- BEGIN ADVERTPRO CODE -->
                <script type="text/javascript">
                document.write('<scr'+'ipt src="http://ads.leiaja.com/servlet/view/banner/javascript/zone?zid=21&pid=0&random='+Math.floor(89999999*Math.random()+10000000)+'&millis='+new Date().getTime()+'&referrer='+encodeURIComponent(document.location)+'" type="text/javascript"></scr'+'ipt>');
                </script>
                <!-- END ADVERTPRO CODE -->
	</h1>

	<div class="rollContent">
        <div class="contentCol bordaBottom padding-bottom7 margin-top15 alturaciclo" >
            <strong>
                <a href="<?php echo $nodes[0]->linkChapeu ?>" class="linksStrong vermelho"><?php echo $nodes[0]->chapeu ?></a>
            </strong>
            <h2 class="noticiaH2"><a class="links cinza" href="<?=drupal_get_path_alias('node/'.$nodes[0]->nid)?>" title=""><span class="geo-chamada1-titulo"><?= empty($nodes[0]->field_chamada_capa['und'][0]['value'])? $nodes[0]->title : $nodes[0]->field_chamada_capa['und'][0]['value'] ;?></span>
                </a>
            </h2>
        </div>
        </div>
    
    
        <div class="colunas2_1">
        <div class="contentCol bordaBottom margin-top15 ">
            <a href="<?=drupal_get_path_alias('node/'.$nodes[1]->nid)?>"><img src="<?=image_style_url('medium', $nodes[1]->imagem)?>" width="260" height="170" title="" class="imgH3"></a>
            <div class="containerImgH4" style="width:260px;">
                <strong><a href="<?php echo $nodes[1]->linkChapeu ?>" class="linksStrong vermelho"><?php echo $nodes[1]->chapeu ?></a></strong>
                <h4 class="noticiaH4"><a href="<?=drupal_get_path_alias('node/'.$nodes[1]->nid)?>" class="links cinza"><?= empty($nodes[1]->field_chamada_capa['und'][0]['value'])? $nodes[1]->title : $nodes[1]->field_chamada_capa['und'][0]['value'] ;?></a></h4>
            </div>
        </div>
            
        <div class="contentCol margin-top15">
            <strong>
                <a href="<?php echo $nodes[2]->linkChapeu ?>" class="linksStrong vermelho"><?php echo $nodes[2]->chapeu ?></a>
            </strong>
            <h3 class="noticiaH3"><a class="links cinza" href="<?=drupal_get_path_alias('node/'.$nodes[2]->nid)?>" title=""><span class="geo-chamada1-titulo"><?= empty($nodes[2]->field_chamada_capa['und'][0]['value'])? $nodes[2]->title : $nodes[2]->field_chamada_capa['und'][0]['value'] ;?></span>
                </a>
            </h3>
        </div>
        </div>


	<div class="colunas2_1 ajuste-coll-right" style="margin-left:18px">
            <div class="contentCol bordaBottom margin-top15 ajuste-tamanho-titulo">
                <strong>
                    <a href="<?php echo $nodes[3]->linkChapeu ?>" class="linksStrong vermelho"><?php echo $nodes[3]->chapeu ?></a>
                </strong>
                <h3 class="noticiaH3"><a class="links cinza" href="<?=drupal_get_path_alias('node/'.$nodes[3]->nid)?>" title=""><span class="geo-chamada1-titulo"><?= empty($nodes[3]->field_chamada_capa['und'][0]['value'])? $nodes[3]->title : $nodes[3]->field_chamada_capa['und'][0]['value'] ;?></span>
                    </a>
                </h3>
            </div>
            
            <div class="contentCol bordaBottom margin-top15">
                <a href="<?=drupal_get_path_alias('node/'.$nodes[4]->nid)?>"><img src="<?=image_style_url('medium', $nodes[4]->imagem)?>" width="290" height="190" title="" class="imgH4"></a>
                <div class="containerImgH4" style="width:140px;">
                    <strong><a href="<?php echo $nodes[4]->linkChapeu ?>" class="linksStrong vermelho"><?php echo $nodes[4]->chapeu ?></a></strong>
                    <h4 class="noticiaH4"><a href="<?=drupal_get_path_alias('node/'.$nodes[4]->nid)?>" class="links cinza"><?= empty($nodes[4]->field_chamada_capa['und'][0]['value'])? $nodes[4]->title : $nodes[4]->field_chamada_capa['und'][0]['value'] ;?></a></h4>
                </div>
            </div>
            
            <div class="contentCol padding-bottom7 margin-top15 alturaciclo ajuste-tamanho-titulo">
            <strong>
                <a href="<?php echo $nodes[5]->linkChapeu ?>" class="linksStrong vermelho"><?php echo $nodes[5]->chapeu ?></a>
            </strong>
            <h3 class="noticiaH3"><a class="links cinza" href="<?=drupal_get_path_alias('node/'.$nodes[5]->nid)?>" title=""><span class="geo-chamada1-titulo"><?= empty($nodes[5]->field_chamada_capa['und'][0]['value'])? $nodes[5]->title : $nodes[5]->field_chamada_capa['und'][0]['value'] ;?></span>
                </a>
            </h3>
        </div>
    </div>
</div>

