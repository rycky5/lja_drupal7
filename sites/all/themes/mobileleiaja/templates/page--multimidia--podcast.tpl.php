<div class="view podcast" id="multimidia">
        	<h1 class="cabecalho2"><span>Multimídia</span></h1>
            <div class="principal">
                <p class="titulo">Cuba autorizará venda de casas e carros ainda este ano.</p>
            	<p class="foto"><img alt="Chuva de granizo na Rede Record, Zona Oeste de São Paulo" src="images/podcast.jpg"></p>
                <p class="fonte"><b>Agência Estado</b> | ter, 12/07/2011 - 16:10</p>
                <p class="chamada"><em>Para Alex Zornig, diretor financeiro da Oi - que aceitou oferta de equipamentos de rede da Huawei -, chineses estão ocupando espaço dos norte-americanos e europeus</em></p>
            </div>
        	<h1 class="cabecalho2"><span>Podcasts relacionados</span></h1>
            <ul class="ul">
            <? 
            $count=0;
            foreach($vPodcast AS $key => $value){
            ?>
              <li class="<?=($count%2 == 0)? 'odd' : 'even'?>">
                <a href="<?=url(drupal_lookup_path('alias',"node/".$value->nid));?>">
                  <?=$value->title?>
                </a>
              </li>
            <? 
            $count++;
            }
            ?>
            </ul>
        </div>