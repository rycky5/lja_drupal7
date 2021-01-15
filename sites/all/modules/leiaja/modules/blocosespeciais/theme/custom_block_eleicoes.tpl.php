<style>

#eleicoes { float:left;width:625px;min-height:451px;background: #f5f9fd url(/sites/all/themes/leiaja/images/capa_especiais/eleicoes/bg.png) left bottom no-repeat; ;padding-left:10px;margin: 0px 0px 15px -5px; }
#eleicoes strong a { color:#004267 !important;text-transform: uppercase; }
#eleicoes h1 {width:635px;height:71px;text-indent:-5000px;margin-left:-10px;background: url(/sites/all/themes/leiaja/images/capa_especiais/eleicoes/barra.png) no-repeat; }
#eleicoes h1 a , #eleicoes h2 a img{ float:right;width:88px;height:31px;padding:0px;margin:0px; }
#eleicoes h1 a{ margin:32px 10px 0px 0px !important; }
#eleicoes  a.elemento { position:absolute;width:285px;height:76px;margin:0px;background:url(/sites/all/themes/leiaja/images/capa_especiais/eleicoes/elemento.png) no-repeat bottom left;text-indent: -5000px }
#eleicoes  img.imgH4 { width:133px !important;height:100px !important;border:5px solid #053999; }
#eleicoes .alturaciclo { height:77px;overflow:hidden;}
#eleicoes span, #eleicoes a,#eleicoes h1, #eleicoes h2, #eleicoes h3, #eleicoes h4{color:#004267;}
#eleicoes h2, #eleicoes h3{font-size: 21px; line-height: 23px;}

</style>

<div id="eleicoes">
    <a href="http://www1.leiaja.com/eleicoes/" class="elemento">Ir para o site de Eleições;</a>
	<h1>
		<span>Eleições</span>
		<!-- BEGIN ADVERTPRO CODE -->
                <script type="text/javascript">
                document.write('<scr'+'ipt src="http://ads.leiaja.com/servlet/view/banner/javascript/zone?zid=21&pid=0&random='+Math.floor(89999999*Math.random()+10000000)+'&millis='+new Date().getTime()+'&referrer='+encodeURIComponent(document.location)+'" type="text/javascript"></scr'+'ipt>');
                </script>
                <!-- END ADVERTPRO CODE -->
	</h1>

	<div class="colunas2_1">
        <div class="contentCol bordaBottom padding-bottom7 margin-top15 alturaciclo" >
            <strong>
                <a href="<?php echo $nodes[0]->linkChapeu ?>" class="linksStrong vermelho"><?php echo $nodes[0]->chapeu ?></a>
            </strong>
            <h2 class="noticiaH2"><a class="links cinza" href="<?=drupal_get_path_alias('node/'.$nodes[0]->nid)?>" title=""><span class="geo-chamada1-titulo"><?= empty($nodes[0]->field_chamada_capa['und'][0]['value'])? $nodes[0]->title : $nodes[0]->field_chamada_capa['und'][0]['value'] ;?></span>
                </a>
            </h2>
        </div>

        <div class="contentCol bordaBottom margin-top15 ">
            <a href="<?=drupal_get_path_alias('node/'.$nodes[1]->nid)?>"><img src="<?=image_style_url('medium', $nodes[1]->imagem)?>" width="133" height="100" title="" class="imgH4"></a>
            <div class="containerImgH4" style="width:135px;">
                <strong><a href="<?php echo $nodes[1]->linkChapeu ?>" class="linksStrong vermelho"><?php echo $nodes[1]->chapeu ?></a></strong>
                <h4 class="noticiaH4"><a href="<?=drupal_get_path_alias('node/'.$nodes[1]->nid)?>" class="links cinza"><?= empty($nodes[1]->field_chamada_capa['und'][0]['value'])? $nodes[1]->title : $nodes[1]->field_chamada_capa['und'][0]['value'] ;?></a></h4>
            </div>
        </div>

         <div class="contentCol  margin-top15">
            <strong>
                <a href="<?php echo $nodes[2]->linkChapeu ?>" class="linksStrong vermelho"><?php echo $nodes[2]->chapeu ?></a>
            </strong>
            <h3 class="noticiaH3"><a class="links cinza" href="<?=drupal_get_path_alias('node/'.$nodes[2]->nid)?>" title=""><span class="geo-chamada1-titulo"><?= empty($nodes[2]->field_chamada_capa['und'][0]['value'])? $nodes[2]->title : $nodes[2]->field_chamada_capa['und'][0]['value'] ;?></span>
                </a>
            </h3>
        </div>

    </div>


	<div class="colunas2_1" style="margin-left:20px">
         <div class="contentCol bordaBottom padding-bottom7 margin-top15 alturaciclo">
            <strong>
                <a href="<?php echo $nodes[3]->linkChapeu ?>" class="linksStrong vermelho"><?php echo $nodes[3]->chapeu ?></a>
            </strong>
            <h3 class="noticiaH3"><a class="links cinza" href="<?=drupal_get_path_alias('node/'.$nodes[3]->nid)?>" title=""><span class="geo-chamada1-titulo"><?= empty($nodes[3]->field_chamada_capa['und'][0]['value'])? $nodes[3]->title : $nodes[3]->field_chamada_capa['und'][0]['value'] ;?></span>
                </a>
            </h3>
        </div>

        <div class="contentCol bordaBottom margin-top15">
            <a href="<?=drupal_get_path_alias('node/'.$nodes[4]->nid)?>"><img src="<?=image_style_url('medium', $nodes[4]->imagem)?>" width="148" height="111" title="" class="imgH4"></a>
            <div class="containerImgH4" style="width:135px;">
                <strong><a href="<?php echo $nodes[4]->linkChapeu ?>" class="linksStrong vermelho"><?php echo $nodes[4]->chapeu ?></a></strong>
                <h4 class="noticiaH4"><a href="<?=drupal_get_path_alias('node/'.$nodes[4]->nid)?>" class="links cinza"><?= empty($nodes[4]->field_chamada_capa['und'][0]['value'])? $nodes[4]->title : $nodes[4]->field_chamada_capa['und'][0]['value'] ;?></a></h4>
            </div>
        </div>

         <div class="contentCol  margin-top15">
            <strong>
                <a href="<?php echo $nodes[5]->linkChapeu ?>" class="linksStrong vermelho"><?php echo $nodes[5]->chapeu ?></a>
            </strong>
            <h3 class="noticiaH3"><a class="links cinza" href="<?=drupal_get_path_alias('node/'.$nodes[5]->nid)?>" title=""><span class="geo-chamada1-titulo"><?= empty($nodes[5]->field_chamada_capa['und'][0]['value'])? $nodes[5]->title : $nodes[5]->field_chamada_capa['und'][0]['value'] ;?></span>
                </a>
            </h3>
        </div>

    </div>
</div>