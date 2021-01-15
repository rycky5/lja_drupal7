<?php
//Chamadas de variáveis
$subMenuIndice = 0;
module_load_include('inc', 'widget', 'widget');
$vSubConteudos = initContentMenuRecentes();
$vSubMaisLida = initContentMenuMaisLida();
//esta views retorna os dados menu;
$subMenu  = views_get_view_result('rodape');
//echo '<pre>';
//print_r($subMenu);
//die();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Tudo que você precisa saber. Notícias, Carreiras, Esportes, Cultura, Tecnologia, Vídeos e muito mais... | LeiaJá</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <meta name="description" content="Tudo que você precisa saber. Notícias, Politica, Carreiras, Esportes, Cultura, Tecnologia, Multimídia e muito mais | LeiaJá" />
        <meta name="og:title" content="Leiaja.com Tudo que você precisa saber" />
        <meta name="og:description" content="Tudo que você precisa saber. Notícias, Politica, Carreiras, Esportes, Cultura, Tecnologia, Multimídia e muito mais" />
        <meta name="og:image" content="http://www.leiaja.com/images/leiaja_acento.jpg" />
        <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
        <meta http-equiv="PRAGMA" content="NO-CACHE">
        <meta name="copyright" content="LeiaJá">
        <meta name="keywords" content="notícia, politica, carreiras, educação, esporte, cultura, tecnologia, multimidía, rádio, tv leiajá, empreendedorismo, leiajáimagens, vestibular, empregos, opinião, hallsocial, f1team, acerto de contas,revistas, compras, computador, corpo, saúde, moda, carros, cinema, crianças, diversão, arte, economia, internet, jogos, novelas, tempo, trânsito, últimas notícias, viagem, jornalismo, informação, entretenimento, lazer, análise, internet, televisão, fotografia, imagem, som, áudio, vídeo, fotos, humor, música, Eleições, Pesquisa Eleitoral, Eleições Municipais, Política, eleitores, urnas, TRE, Prefeitos, <?= @$vMetaKeyWords ?>" />
        <meta name="robots" content="ALL" />
        <meta name="distribution" content="Global" />
        <meta name="rating" content="General" />
        <meta name="author" lang="pt-br" content="LeiaJá" />
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja/css/boxes/estilo.css">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja/css/boxes/grid.css">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja/css/boxes/capa.css">
        <script type="text/javascript" src="/sites/all/themes/leiaja/css/boxes/jquerycapa.min.js"></script>
        <script type="text/javascript" src="/sites/all/themes/leiaja/css/boxes/boxes.js"></script>

    </head>

    <body>
        <script type="text/javascript" src="//js.statig.com.br/barraiG/parceiros/barraiGv2.js"></script>
        <div class="topo">
            <div class="containerCapa">
                <h1 class="logo"><a href="javascript:void();"><img src="<?= 'http://' . $_SERVER['SERVER_NAME'] . '/' . drupal_get_path('theme', 'leiaja') ?>/images/logo_leiaja.png" /></a></h1>
                <div class="banner">
                    <div>
                       <?php
                       print render(getBlocos(array('8')));
                       ?>
                    </div>
                </div>
                <div class="menu">
                    <ul>
                        <?php
                        $vMenuPrincipal = array(
                            array(
                                'href' => 'noticias',
                                'title' => 'Notícias'
                            ),
                            array(
                                'href' => 'politica',
                                'title' => 'Política'
                            ),
                            array(
                                'href' => 'carreiras',
                                'title' => 'Carreiras'
                            ),
                            array(
                                'href' => 'esportes',
                                'title' => 'Esportes'
                            ),
                            array(
                                'href' => 'cultura',
                                'title' => 'Cultura'
                            ),
                            array(
                                'href' => 'tecnologia',
                                'title' => 'Tecnologia'
                            ),
                            array(
                                'href' => 'multimidia',
                                'title' => 'Multimídia'
                        ));
                        // Construção do menu.
                        $cont = 0;
                        foreach ($vMenuPrincipal as $menu):
                        ?>
                            <li>
                                <a href="javascript:void();"><?= $menu['title'] ?> <span class="arrow"></span></a>
                                <div  class="submenu menu<?= ucfirst($menu['href']) ?>">			
                                    <div class="menuContentLeft">
                                        <ul>
                                            <?php
                                            if($menu['href'] != 'multimidia'):
                                                foreach ($subMenu as $valueSubMenu) :
                                                    if($valueSubMenu->taxonomy_vocabulary_machine_name == $menu['href']):
                                            ?>
                                            <li><a href="<?= strstr(url('taxonomy/term/' . $valueSubMenu->tid), 'http') ? url('taxonomy/term/' . $valueSubMenu->tid, array('absolute' => true)) : url('taxonomy/term/' . $valueSubMenu->tid, array('absolute' => true)) ?>"><?= ucfirst($valueSubMenu->taxonomy_term_data_name) ?></a></li>
                                            <?php
                                                    endif;
                                                endforeach;
                                            else:
                                                $arrMenuMultiUrl = array('/multimidia/fotos','/multimidia/infograficos','/multimidia/podcasts','/multimidia/tv','/multimidia/videos','/imagens');
                                                $arrMenuMultiNome = array('fotos','infograficos','podcasts','Tv LeiaJá','vídeos','imagens');
                                                foreach ($arrMenuMultiNome as $keyMulti => $valueMult):
                                            ?>
                                                    <li><a href="http://www1.leiaja.com<?= $arrMenuMultiUrl[$keyMulti] ?>"><?= ucfirst($valueMult) ?></a></li>
                                            <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </ul>
<!--                                        <div class="bannerPatrocinador">
                                        </div>-->
                                    </div>
                                    <div class="menuContentRight">
                                        <div class="maisLida">
                                            <a href="<?= $vSubMaisLida["{$menu['href']}"]["link_node"] ?>"  title="<?= $vSubMaisLida["{$menu['href']}"]["titulo"] ?>"><img src="<?= $vSubMaisLida["{$menu['href']}"]["imagem"] ?>" width="175" height="132" alt="<?= $vSubMaisLida["{$menu['href']}"]["titulo"] ?>"></a>
                                            <h3>Mais Lida</h3>
                                            <h4><a href="" title="<?= $vSubMaisLida["{$menu['href']}"]["link_node"] ?>" ><?= $vSubMaisLida["{$menu['href']}"]["titulo"] ?></a></h4>
                                            <h5><a href="" title="<?= $vSubMaisLida["{$menu['href']}"]["link_node"] ?>" ><?= $vSubMaisLida["{$menu['href']}"]["resumo"] ?></a></h5>
                                        </div>
                                        <?php
                                        if($menu['href'] != 'multimidia'):
                                        ?>
                                        <ul class="menuUltimas">
                                            <li><h3><a href="javascript:void(0);" title="">Últimas Notícias</a></h3></li>
                                            <?php
                                            
                                                foreach ($vSubConteudos[$menu['href']] as $valueSubConteudo):
                                            ?>
                                                    <li><strong><?= date('d/m H:i',$valueSubConteudo->node_created) ?>  - </strong><a href="<?= url('node/' . $valueSubConteudo->nid) ?>" title="<?= $valueSubConteudo->node_title ?>" class="aUltimas"><?= $valueSubConteudo->node_title ?></a></li>                  
                                            <?php
                                                endforeach;
                                            ?>
                                        </ul>
                                        <?php
                                        else:
                                        ?>
                                            <div class="carrocelMultimidia">
                                                <ul>
                                                <?php
                                                foreach ($vSubConteudos[$menu['href']] as $valueMultimidia):                                                   
                                                ?>
                                                    <li><a href="<?= url('node/' . $valueMultimidia->nid) ?>" onmouseover="multimidiaLegendaHover('titulo336521')"><img class="imgH4" height="75" width="100" title="<?= $valueMultimidia->title ?>" alt="<?= $valueMultimidia->title ?>" src="<?= (!empty($valueMultimidia->uriThumbVideo)) ? image_style_path('home_thumb', $valueMultimidia->uriThumbVideo) : image_style_path('home_thumb', $valueMultimidia->uri) ?>"></a></li>
                                                <?php
                                                endforeach;
                                                ?>
                                                </ul>
                                            </div>
                                            <h6 id="titulo336521" rel="mnuMM" style="display: none;">Classificação Livre está recheado de música pernambucana</h6>
                                        <?php
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </li>
                        <?php
                        endforeach;
                        ?>
                    </ul>
                </div>
                <div class="busca">
                    <form class="search-form" action="http://www1.leiaja.com/search/node" id="search-form" method="get" accept-charset="UTF-8">
                        <div>
                            <input type="text" name="keys" class="search_box" />
                            <input type="hidden" name="form_id" value="search_theme_form" />
                            <input type="hidden" name="form_token" value="<?php print drupal_get_token('search_theme_form'); ?>" />
                            <button type="submit" name="op" value="search">Buscar</button>
                        </div>
                    </form>
                </div>
                <div class="banner_lateral">
                    
                    <!-- LeiaJá - WSS - (160x600) -->
                    <div class="wsz" data-pid="5828">
                        <!-- BEGIN ADVERTPRO CODE -->
                        <script type="text/javascript">
                        document.write('<scr'+'ipt src="http://ads.leiaja.com/servlet/view/banner/javascript/zone?zid=28&pid=0&random='+Math.floor(89999999*Math.random()+10000000)+'&millis='+new Date().getTime()+'&referrer='+encodeURIComponent(document.location)+'" type="text/javascript"></scr'+'ipt>');
                        </script>
                        <!-- END ADVERTPRO CODE -->
                    </div>

                </div>
            </div>
        </div>
        <div id="content">
            <div class="containerCapa">
                ##@content@##
            </div>
        </div>
        <div class="rodape">
            <div class="containerCapa colunas">
                <div class="mapaSite">
                    <ul style="display:none">
      <?php 
      //DECLARAÇÃO DAS VARIÁVEIS
      $caderno = "";  
      $cont = 0;  
      $arrMenuMulti = array('fotos','../imagens','infograficos','podcasts','tv','videos');
      //INICIO #MENU - ITERAÇÃO DO MENU
      foreach($subMenu as $menu):?>
        <?php 
      //INICIO #COLUNA CONDIÇÃO APLICADA SE O CADERNO FOR DIFERENTE INICIAR OUTRA COLUNA
        if($caderno !=  $menu->taxonomy_vocabulary_name):?>
          <?php 
           // INICIO #CARREIRAS: Condição para manter os itens de carreira na mesma coluna de Politica
          if($menu->taxonomy_vocabulary_name !=  "Carreiras"):?>
            </ul>
            <ul class="coluna">
          <?php endif; //FIM #CARREIRAS?>
            <li class="sessaoMapa">
              <a href="/<?php print $menu->taxonomy_vocabulary_machine_name; ?>">
                <?php print $menu->taxonomy_vocabulary_name;?>
              </a>
            </li>
        <?php
        //FIM #COLUNA
        endif;  
        //Setando o nome do caderno à variável.
        $caderno = $menu->taxonomy_vocabulary_name;
        ?>
        <?php
        //CONDIÇÃO QUE VERIFICA SE NÃO É O CADERNO POLITICA E MULTIMIDIA PARA LISTAR OS TERMOS DA TAXONOMIA;
        if($menu->taxonomy_vocabulary_name !=  "Política"):
          //CUSTOMIZACAO DO SUBMENU DE MULTIMIDIA.
          if($menu->taxonomy_vocabulary_name ==  "Multimídia"):
            $url  = "/multimidia/".$arrMenuMulti[$cont++];
          else:
            $url = url(drupal_lookup_path('alias',"taxonomy/term/".$menu->tid));
          endif;//FIM CUSTOMIZACAO SUBMENU MULTIMIDIA
        //SUBMENUS?>
        <li>
          <a href="<?php print $url; ?>" class="itemMapa">
            - <?php print $menu->taxonomy_term_data_name;?>
          </a>
        </li>
        <?php endif;//FIM VERIFICACAO SE É DO CADERNO POLITICA?>
      <?php 
      //FIM #MENU - ITERAÇÃO
      endforeach;?>
        <li class="sessaoMapa"><a href="/colunistas">Colunistas</a></li>
        <li class="sessaoMapa"><a href="/blogs">Blogs</a></li>
        <li class="sessaoMapa"><a href="/promocoes">Promo&ccedil;&otilde;es</a></li>
          </ul>
          
                </div>
            </div>
            <div class="copyright">
                <div class="containerCapa">
                    <ul>
                        <li><a href="<?= $_SERVER['SERVER_NAME'] ?>/editorial">EDITORIAL</a></li>
                        <li><a href="<?= $_SERVER['SERVER_NAME'] ?>/expediente">EXPEDIENTE</a></li>
                        <li><a href="<?= $_SERVER['SERVER_NAME'] ?>/fale-conosco">FALE CONOSCO</a></li>
                    </ul>
                    <p>Copyright. 2011. LEIAJÁ. Todos os direitos reservados.</p>
                </div>
            </div>
        </div>

        <script type="text/javascript">

        $(function() {
        

              $(window).scroll(function () {
                if ($(this).scrollTop() > 40) {
                  $("#content, .topo").addClass('fixed');
                } else {
                  $("#content, .topo").removeClass('fixed');
                }
              });


        });

        </script>
    </body>

</html>