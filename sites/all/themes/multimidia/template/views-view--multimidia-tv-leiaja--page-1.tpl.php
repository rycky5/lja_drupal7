<?php
//Template da capa da TV LEIAJA do sub caderno de Multimidia
?>
<?php

module_load_include('inc', 'capa', 'capa');
$pathTema = path_to_theme('multimidia');

// TV LEIA JA
$slideTvleiaja = get_nodes_views('multimidia_tv_leiaja');
$nodesProgsDest = get_nodes_views('capa_multi_tvleiaja_abas','page_10');
$nodesProgsMaisVisto = get_nodes_views('capa_multi_tvleiaja_abas','page_9');
$nodesProgsMaisCompart = get_nodes_views('capa_multi_tvleiaja_abas','page_8');

$nodesProg_JogoRapido = get_nodes_views('capa_multi_tvleiaja_abas','page_1');
$nodesProg_OpiniaoBrasil = get_nodes_views('capa_multi_tvleiaja_abas','page_2');
$nodesProg_GourmetCasa= get_nodes_views('capa_multi_tvleiaja_abas','page_3');
$nodesProg_ClassLivre= get_nodes_views('capa_multi_tvleiaja_abas','page_4');
$nodesProg_NotaPe= get_nodes_views('capa_multi_tvleiaja_abas','page_5');
$nodesProg_NaSocial= get_nodes_views('capa_multi_tvleiaja_abas','page_6');
$nodesTvAbas_Vencer= get_nodes_views('capa_multi_tvleiaja_abas','page_7');
//-------------------------------------------------------------------

    
/**
 * Blocos da TVLEIAJA da capa
 * A var $arrTvLeiaJa não está sendo utilizada, pois não outras chamadas para essas views nessa pagina
 */

$tvProgsMaisVisto = getTemaBloco($nodesProgsMaisVisto, 'block-multi-tv-bnIV', 4);

$tvProg_MaisCompart = getTemaBloco($nodesProgsMaisCompart,'block-multi-titulos2',5);

$tvProg_OpiniaoBrasil = getTemaBloco($nodesProg_OpiniaoBrasil, 'block-multi-imagens-dest-II', 2);
$arrProg_OpiniaoBrasil = $tvProg_OpiniaoBrasil['array'];
$tvProg_OpiniaoBrasil_II = getTemaBloco($arrProg_OpiniaoBrasil, 'block-multi-img-III', 4);

$tvProg_JogoRapido = getTemaBloco($nodesProg_JogoRapido, 'block-multi-tv-bnI', 4);

$tvLeiaJaAbas_GourmetCasa = getTemaBloco($nodesTvAbas_GourmetCasa, 'block-multi-tv-bnIV', 4);

$tvProg_ClassLivre = getTemaBloco($nodesProg_ClassLivre, 'block-multi-videos', 9);

$tvProg_NotaPe = getTemaBloco($nodesProg_NotaPe, 'block-multi-videos', 6);

$tvProg_NaSocial = getTemaBloco($nodesProg_NaSocial, 'block-multi-tv-bnIII', 4);

$tvLeiaJaAbas_Vencer= getTemaBloco($nodesTvAbas_Vencer, 'block-multi-tv-bnIV', 4);

//slides tvleiaja
$blocoSlideBnI = getTemaBloco($slideTvleiaja,'block-multi-tv-bnI',4);
$arrSlideTvleiaja = $blocoSlideBnI['array'];

//slide 3D - videos mais vistos.
$slideshow3D = getTemaBloco($nodesProgsDest,'block-multi-tv-bnV',6);
//$arrSlideTvleiaja = $slideshow3D['array'];

$tvLeiaJa_GourmetCasa = getTemaBloco($nodesProg_GourmetCasa, 'block-multi-img-vertical', 12);

?>
<script type="text/javascript" src="/sites/all/modules/leiaja/modules/capa/js/abas.js"></script>
    <!-- containergrande-->
<div class="divContainerGrande">
    <div class="cnt12">
        <div class="centroContainer containerBox3d">
        <!-- BOX -->
        <!-- slide 3D -->
           <?php print $slideshow3D['html'];?>
          <!-- /slide 3D-->
        <!--/BOX-->
        </div>
    </div>
</div>
    <!-- / containergrande-->
    
    <!-- containergrande containerLinha -->
	<div class="divContainerGrande">
      <div class="cnt12">
        <div class="centroContainer">
          <div class="abreBox divisorBoxTop">
            <!-- abre o box --><div class="wgd4 hgd1"><h1 class="vermelho">Jogo Rápido</h1></div><!-- /abre o box -->
            <!-- abre o box --><div class="wgd8 hgd1"><h1 class="vermelho">Nota PE</h1></div><!-- /abre o box -->
          </div>
            
             <!-- box -->
              <?php print $tvProg_JogoRapido['html'];?>
             <!-- box -->
             <!-- box -->
              <?php print $tvProg_NotaPe['html'];?>
             <!-- box -->
             
             <!-- box -->
             <?php print $tvLeiaJaAbas_ClassLivre['html'];?>
             <!-- box -->      
          </div>
      </div>
    </div>
    <!-- /containergrande containerLinha -->
    
    <!-- containergrande containerLinha -->
    <div class="divContainerGrande containerLinha bbn">
    <div class="cnt12">
      <div class="centroContainer">
        <div class="abreBox divisorBoxTop">
          <!-- abre o box --><div class="wgd12 hgd1"><h1 class="azul">Gourmet em Casa</h1></div><!-- /abre o box -->
        </div>
         <!-- box -->
         <!-- slide img verticais -->
          <?php print $tvLeiaJa_GourmetCasa['html'];?>
         <!-- /slide img verticais-->
          <!-- /box -->
        </div>
      </div>
    </div>
    <!-- /containergrande containerLinha -->
    
  <!-- containergrande containerLinha-->
<div class="divContainerGrande">
  <div class="cnt12">
    <div class="centroContainer">
      <div class="abreBox divisorBoxTop">
        <!-- abre o box --><div class="wgd12 hgd1"><h1 class="vermelho">BLOGS</h1></div><!-- /abre o box -->
      </div>
        <!-- box -->
         <div class="wgd8 hgd4 boxListImg">

           <div class="wgd2  hgd4">
             <a href="http://hallsocial.leiaja.com"><img src="/sites/all/themes/multimidia/images/blog_hallsocial.jpg" /></a>
           </div>

           <div class="wgd2 hgd4">
             <a href="/blogs/esportes"><img src="/sites/all/themes/multimidia/images/blog_jogadarapida.jpg" /></a>
           </div>

           <div class="wgd2 hgd4">
             <a href="/blogs/carreiras"><img src="/sites/all/themes/multimidia/images/blog_networking.jpg" /></a>
           </div>

           <div class="wgd2 hgd4">
             <a href="/blogs/cultura"><img src="/sites/all/themes/multimidia/images/blog_nograu.jpg" /></a>
           </div>

         </div>
         <!-- /box -->
        <!-- box -->
         <div class="wgd4 hgd4 divBanner300x100">
           <div class="wgd4 hgd4">
           <span>PUBLICIDADE</span>
             <!-- END ADVERTPRO CODE -->
              <?=render(getBlocos(array('34')));?>
           </div>
         </div>
         <!-- /box -->      
    </div>
  </div>
</div>

<!-- /containergrande containerLinha-->
    
    <!-- containergrande-->
    <div class="divContainerGrande">
      <div class="cnt12">
        <div class="centroContainer">
          <div class="abreBox divisorBoxTop">
            <!-- abre o box --><div class="wgd12 hgd1"><h1 class="azul">Classificação Livre</h1></div><!-- /abre o box -->
          </div>
           <!-- BOX - Programa CLassificação Livre -->
            <div class="recentes containerVideos"><?php print $tvProg_ClassLivre['html'];?></div>
           <!-- BOX -->   
        </div>
      </div>
    </div>
    <!-- /containergrande-->
    
    <!-- containergrande containerLinha -->
	<div class="divContainerGrande">
      <div class="cnt12">
        <div class="centroContainer">
          <div class="abreBox divisorBoxTop">
            <!-- abre o box --><div class="wgd4 hgd2"><h1 class="vermelho">PUBLICIDADE</h1></div><!-- /abre o box -->
            <!-- abre o box --><div class="wgd4 hgd2"><h1 class="vermelho">Na Social</h1></div><!-- /abre o box -->
            <!-- abre o box --><div class="wgd4 hgd2"><h1 class="vermelho">MAIS COMPARTILHADOS</h1></div><!-- /abre o box -->
          </div>
            
            <!-- box -->
            <div class="wgd4 hgd8 boxNotSemImg">
              <!-- BEGIN ADVERTPRO CODE -->
                <script type="text/javascript">
                document.write('<scr'+'ipt src="http://ads.leiaja.com/servlet/view/banner/javascript/zone?zid=2&pid=0&random='+Math.floor(89999999*Math.random()+10000000)+'&millis='+new Date().getTime()+'&referrer='+encodeURIComponent(document.location)+'" type="text/javascript"></scr'+'ipt>');
                </script>
              <!-- END ADVERTPRO CODE -->
              <?=render(getBlocos(array('34')));?>
            </div>
             <!-- box -->
            
             <!-- box -->
              <?php print $tvProg_NaSocial['html'];?>
             <!-- box -->
             
             <!-- box -->
             <?php print $tvProg_MaisCompart['html'];?>
             <!-- box -->
        </div>
      </div>
    </div>
    <!-- /containergrande containerLinha -->
    
    <!-- containergrande containerLinha -->
    <div class="divContainerGrande">
      <div class="cnt12">
        <div class="centroContainer">
          <div class="abreBox divisorBoxTop">
            <!-- abre o box --><div class="wgd12 hgd1"><h1 class="azul">Opinião Brasil</h1></div><!-- /abre o box -->
<!--             abre o box <div class="wgd8 hgd1"><h1 class="vermelho">Mais um box</h1></div> /abre o box -->
          </div>
           <!--box-->
            <?php print $tvProg_OpiniaoBrasil['html'];?>
           <!--/box-->      
           <!--box-->
           <?php print $tvProg_OpiniaoBrasil_II['html'];?>
           <!--/box--> 
        </div>
      </div>
    </div>
    <!-- /containergrande containerLinha -->
 
    <!-- Esse bloco nao pode ser modulado por causa das abas de videos-->
    <!-- containergrande containerLinha -- TV LEIAJA com abas -->
    <div class="divContainerGrande">
    <div class="cnt12">
        <div class="centroContainer">
             <div class="abreBox divisorBoxTop">
<!-- abre o box --><div class="wgd12 hgd1"><h1 class="vermelho">MAIS VISTOS</h1></div><!-- /abre o box -->
             </div>
     <!-- box -->
    
     <!-- box -->
        <div class="jogo_rapido container_tv_abas"><?php print $tvProgsMaisVisto['html'];?> </div>
     <!-- box -->
     
    </div>
  </div>
</div>
    <!-- /containergrande containerLinha -->