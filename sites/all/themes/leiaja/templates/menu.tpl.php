<?php
//Chamadas de variáveis
$subMenuIndice = 0;
module_load_include('inc', 'widget', 'widget');
$vSubConteudos = initContentMenuRecentes();
$vSubMaisLida = initContentMenuMaisLida();
//esta views retorna os dados menu;
$subMenu  = views_get_view_result('rodape');
?>

<script type="text/javascript">
(function ($) {
  multimidiaLegendaHover = function(pId){
    $("[rel='mnuMM']").hide();
    $("#"+pId).show();
  }
  
  multimidiaCategoriaHover = function(pObj, pId){
    $("#divMnuVideo,#divMnuGaleria,#divMnuPodcast,#divMnuInfografico").hide();
    $(".UlMultimidiaMenu a").removeClass('active');
    $(pObj).addClass('active');
    $("#"+pId).show();
  }
})(jQuery);
</script>
<?
$banner = array('11' => array('28', false), '60' => array('23', true), '2322' => array('26', false), '31' => array('25', false), '2326' => array('24', true), '26' => array('27', false));
?>

<div id="divMenuOver">
  <div id="divMenuTopo" class="divMenu">
    <div class="divMenuContent">
      <div><a href="http://www.leiaja.com<?= base_path() ?>" class="logolink"><h1 class="logo"></h1></a></div>
      <div class="busca">
<!--        <div id="anunciobusca">
            <?php
//              if ($_SERVER['SERVER_NAME'] == 'www.leiaja.com' || $_SERVER['SERVER_NAME'] == 'sgc.leiaja.com')
//                print render(getBlocos(array('61')));
//              else
//                print render(getBlocos(array('58')));
            ?>
        </div>-->
  	    <form class="search-form" action="http://www1.leiaja.com/search/node" id="search-form" method="get" accept-charset="UTF-8">
              <div>
                <input type="text" name="keys" class="search_box" />
                <input type="hidden" name="form_id" value="search_theme_form" />
                <input type="hidden" name="form_token" value="<?php print drupal_get_token('search_theme_form'); ?>" />
                <button type="submit" name="op" value="search">Buscar</button>
              </div>
  	    </form>
      </div>
      <ul class="menu"> 	  
      <?php
        $vMenuPrincipal = array(
                    array(
                        'href'=>'noticias',
                        'title'=>'Notícias'
                    ),
                    array(
                        'href'=>'politica',
                        'title'=>'Política'
                    ),
                    array(
                        'href'=>'carreiras',
                        'title'=>'Carreiras'
                    ),
                    array(
                        'href'=>'esportes',
                        'title'=>'Esportes'
                    ),
                    array(
                        'href'=>'cultura',
                        'title'=>'Cultura'
                    ),
                    array(
                        'href'=>'tecnologia',
                        'title'=>'Tecnologia'
                    ),
                    array(
                        'href'=>'multimidia',
                        'title'=>'Multimídia'
                    ));  
        // Construção do menu.
        $cont = 0;
        foreach($vMenuPrincipal as $indice => $menu){
      ?>
        <li class="menu<?= ucfirst($menu['href']) ?>">
          <a href="<?= base_path().$menu['href'] ?>"><?= $menu['title'] ?></a>
          <!-- Menu Interno -->
          <div class="menuAberto">
            <div class="menuTop">
              <div class="menuTopSeta positionSeta"></div>
            </div>
            <div class="menuContent">
              <div class="menuContentLeft">
                <ul>
                  <?php 
                    // Constrói os submenus/tags
                  $item = "";
                    while ($subMenu[0]->taxonomy_vocabulary_machine_name == $menu['href']) {
                        if($menu['href'] != 'multimidia'){
                        $item = array_shift($subMenu);
                        //Interferência para os subcapas de Multimidia
                          ?>
                          <li>
                            <a href="<?php print substr(url(drupal_lookup_path('alias',"taxonomy/term/".$item->tid)),0, 4) == 'http' ? url(drupal_lookup_path('alias',"taxonomy/term/".$item->tid), array('absolute' => TRUE)): 'http://www1.leiaja.com'. url(drupal_lookup_path('alias',"taxonomy/term/".$item->tid)) ?>" >
                              <?php print $item->taxonomy_term_data_name;?>
                            </a>
                          </li>
                  <?php
                        }else{ 
                            $arrMenuMultiUrl = array('/multimidia/fotos','/multimidia/infograficos','/multimidia/podcasts','/multimidia/tv','/multimidia/videos','/imagens');
                            $arrMenuMultiNome = array('fotos','infograficos','podcasts','Tv LeiaJá','vídeos','imagens');
                            foreach ($arrMenuMultiNome as $key => $valueMult) {
                            ?>
                                <li><a href="<?php print substr($arrMenuMultiUrl[$key],0, 4) == 'http' ? $arrMenuMultiUrl[$key]: 'http://www1.leiaja.com'. $arrMenuMultiUrl[$key] ?>"><? print ucfirst($valueMult);?></a></li>
                      <?php
                            }break;
                        }
                    }
                  ?>
                </ul>
                <div class="bannerPatrocinador">
                <? if(!empty($sub['tid']) && !empty($banner[$sub['tid']][1])){?>
                  <span>PATROC�?NIO</span>
                   <?= render(getBlocos(array($banner[$sub['tid']][0])));?>
                <? }?>
                </div>
              </div>
              <div class="menuContentRight">
                <div class="maisLida">
                 
                    <a href="/<?= $vSubMaisLida[$menu['href']]['link_node']?>" class="aImg" title="<?= $vSubMaisLida[$menu['href']]['titulo'] ?>"><img src="<?=$vSubMaisLida[$menu['href']]['imagem']?>" width="175" height="132" alt="<?= $vSubMaisLida[$menu['href']]['titulo'] ?>" /></a>
                    <h3>Mais Lida</h3>
                    <h4><a href="/<?= $vSubMaisLida[$menu['href']]['link_node'] ?>" title="<?= $vSubMaisLida[$menu['href']]['titulo'] ?>" class="maisLidaH4"><?=$vSubMaisLida[$menu['href']]['titulo']?></a></h4>
                    <h5><a href="/<?= $vSubMaisLida[$menu['href']]['link_node'] ?>" title="<?= $vSubMaisLida[$menu['href']]['titulo'] ?>" class="maisLidaH5"><?= $vSubMaisLida[$menu['href']]['resumo'] ?></a></h5>
                
                </div>
                <?php if($menu['href'] == 'multimidia') :?>
	              <div class="carrocelMultimidia">
	              	 <ul>
	              	   <?php
		                  $vHtmlH6 = "";
		                  foreach($vSubConteudos[$menu['href']] as $key => $vid):
		                    ## Carrega imagem de preview de acordo com o tipo.
		                    if($vid->subcategoria == 'Infográficos'):
		                      $vImagem  = base_path().drupal_get_path('theme', 'leiaja')."/images/thumbPodcast.jpg";
		                      $vEstilo  = 'iconeInfMenor';
		                    elseif($vid->subcategoria == 'Podcasts' || (!empty($vid->podcast) && $vid->podcast==1) && empty($vid->uri)):
		                      $vImagem  = base_path().drupal_get_path('theme', 'leiaja')."/images/thumbPodcast.jpg";
		                      $vEstilo  = 'iconePodMenor';
		                    elseif ($vid->subcategoria == 'Vídeos'):
		                      $vEstilo  = 'iconeVidMenor';
		                      $vImagem  = image_style_url('home_thumb', $vid->uriThumbVideo); 
		                    elseif ($vid->subcategoria == 'TV Leia Já'):
		                      $vEstilo  = 'iconeTvMenor';
		                      $vImagem  = image_style_url('home_thumb', $vid->uriThumbVideo); 
		                    else:                                       
		                      $vEstilo  = 'iconeGalMenor';
		                      $vImagem  = image_style_url('home_thumb', $vid->uri);
		                    endif;
		                     
		                    $vHtmlH6 .= "<h6 id=\"titulo{$vid->nid}\" rel=\"mnuMM\" ".(($key == 0) ? '' : 'style="display:none;"')."><span class=\"iconeMultimidiaMenor $vEstilo\"></span>{$vid->title}</h6>";
		               ?>
                           <li><a href="<?= url(drupal_lookup_path('alias',"node/".$vid->nid)); ?>" onmouseover="multimidiaLegendaHover('titulo<?= $vid->nid ?>')"><img class="imgH4" height="75" width="100" title="<?= $vid->title ?>" alt="<?= $vid->title ?>" src="<?= $vImagem ?>" /></a></li>
	                   <?php endforeach; ?>
	                 </ul>
	              </div>
	               <?= $vHtmlH6 ?>                
                <?php else: ?>
	                <ul class="menuUltimas">
	                  <li><h3><a href="javascript:void(0);" title="">&Uacute;ltimas Not&iacute;cias</a></h3></li>
	                  <?php 
	                    foreach($vSubConteudos[$menu['href']] as $not){
	                  ?>
	                    <li><strong><?= date('d/m G:i ',$not->node_created)?> - </strong><a href="<?= url(drupal_lookup_path('alias',"node/".$not->nid)); ?>" title="<?= $not->node_title ?>" class="aUltimas"><?= $not->node_title ?></a></li>                  
	                  <?php 
	                    }
	                  ?>
                  </ul>
                <?php endif; ?>
              </div>
            </div>
            <div class="menuFooter"></div>
          </div>          
        </li>	  
	  <?php 
         }
      ?>  
  	  </ul>



  <div id="bannerSkyscraper">
    <div class="bannerSkyscraper">


<!-- LeiaJá - WSS - (160x600) -->
<div class="wsz" data-pid="5828">
<!-- BEGIN ADVERTPRO CODE -->
<script type="text/javascript">
document.write('<scr'+'ipt src="http://ads.leiaja.com/servlet/view/banner/javascript/zone?zid=28&pid=0&random='+Math.floor(89999999*Math.random()+10000000)+'&millis='+new Date().getTime()+'&referrer='+encodeURIComponent(document.location)+'" type="text/javascript"></scr'+'ipt>');
</script>
<!-- END ADVERTPRO CODE -->
    </div>

  </div>
    <style>
    #bannerSkyscraper { float:right;position:relative;z-index:999;display:none;z-index:500 }
    .menuCloud .bannerSkyscraper { margin-top:14px !important; }
    .bannerSkyscraper { position:absolute;width:160px;height:600px;float:right;margin:56px 0px 0px 103px }
    </style>
  </div>



    </div>
  </div>
</div>