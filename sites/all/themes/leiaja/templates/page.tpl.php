<?php //die('aqui');   ?>

<div id="page-wrapper">
  <div id="page">
    <div class="divBannerTop">
      <div class="divBannerTopContent">
        <div class="banner1"><?php print render($page['banner1']); ?><!-- /.section, /#banner1 --></div>
        <div class="publicidadeTop"><b></b></div>
      </div>
    </div>
    <?php require_once 'menu.tpl.php'; // Carrega Menu. ?>

    <!--INICIO DA FAIXA-->
    <?php
    if ($page['cobertura']): print render($page['cobertura']);
    endif;
    ?>
    <!--FIM DA FAIXA-->
    <?
    if (!empty($cobertura) && count($vNoticiasTagFotos) >= $ComFotos && count($vNoticiasTag) >= $SemFotos && !empty($numTemplate)) {
      if (empty($vCadernoNome)) {
        $vCadernoNome = $estiloCaderno;
      }
      include_once $_SERVER['DOCUMENT_ROOT'] . '/' . drupal_get_path('module', 'leiaja') . '/template/cobertura.template' . $numTemplate . '.php';
    }
    ?>
    <div <?= (!empty($cobertura)) ? '' : 'id="divContainer"'; ?> class="divContainer bgBranco <?= (@$node->type) ? $node->type : ''; ?> caderno_<?= @semAcentos(strtolower($vCadernoNome)); ?>">
      <div class="divContainerContent">
        <? if (@$node->type): // Exibe a barra de navegação caso seja um node.4 ?>
          <!--Brad camb-->
          <div class="divMapeamento">
            <ul>
              <li><a title="Leia Já" href="<?= base_path() ?>">LeiaJá</a><span class="seta"></span></li>
              <? if (!empty($vCrumb->machine_name)) { ?>
                <li><a title="<?= $vCrumb->categoria ?>" href="<?= base_path() . $vCrumb->machine_name ?>">
                    <?= $vCrumb->categoria ?>
                  </a><span class="seta"></span></li>
                <li><a class="active" title="<?= $vCrumb->subcategoria ?>" href="<?= url(drupal_lookup_path('alias', 'taxonomy/term/' . $vCrumb->tid)) ?>">
                    <?= $vCrumb->subcategoria ?>
                  </a></li>
              <? } else { ?>
                <li><a title="<?= ucwords(drupal_lookup_path('alias', "node/" . arg(1))); ?>" href="<?= base_path() . drupal_lookup_path('alias', "node/" . arg(1)); ?>">
                    <?= ucwords(drupal_lookup_path('alias', "node/" . arg(1))); ?>
                  </a></li>
              <? } ?>
            </ul>
            <div class="divContentMapeamento"> <a id="aRecomendarTopo" title="Recomendar" href="javascript:void(0);">Recomendar</a> <a id="aRecomendarTopoBotao" class="btCompartilhar" title="Recomendar" href="javascript:void(0);"></a> <span>|</span> <a id="aPrintTopo" title="Imprimir" href="javascript:void(0);">Imprimir</a> <a id="aPrintTopoBotao" class="btImprimir" title="Imprimir" href="javascript:void(0);"></a> </div>
          </div>
          <!--Fim do Brad camb-->
        <? endif; ?>
        <?php if (@$is_caderno) : ## Verifica se é capa do caderno.?>
          <div class="divSubCadernos">
              <?
            if (isset($campeonato)) {
              ?>
              <script type="text/javascript">
                (function ($) {
                  $(document).ready(function(){
            
                    bloco = $('#h4_futebol_campeonatos');
            
                    $(bloco).find('.selectCampeonato .clicavel').bind('click', function(){
              
                      var pai = $(this).parent();
                      var ul = pai.find('ul');
              
                      ul.find('li a').unbind('click').bind('click', function(){
                        pai.find('.clicavel span').text($(this).text());
                        ul.hide();
                        window.location = $(this).attr('rel');
                      });
              
                      if($(ul).is(':visible')){
                        $(bloco).find('.selectCampeonato ul').hide();
                      }else{
                        $(bloco).find('.selectCampeonato ul').show();
                      }
                    })
                  })
                })(jQuery)
              </script>
              <h2 class="cinza">Futebol </h2>
              <h4 id="h4_futebol_campeonatos"> <span>|</span>
                <div class="selectCampeonato">
                  <div class="clicavel" style="float: left;width: 100%;height: 100%;"><span>
                      <?= $campeonato->nome; ?>
                    </span></div>
                  <ul style="margin-top:0;">
                    <? foreach ($campeonatos as $value) { ?>
                      <li><a rel="/esportes/futebol/campeonato/<?= $value->alias; ?>/classificacao">
                          <?= $value->nome; ?>
                        </a></li>
                    <? } ?>
                  </ul>
                </div>
              </h4>
              <? }else if($vCadernoNome == "Tags"){ ?>
            <h3 class="cinza" teste="teste04">Tópicos 
              <span>
                <?php
                if($tag!=""){
                  print " | ".$tag;
                }
                ?>
              </span></h3>
            <? } else { ?>
              <h2 class="cinza" teste="teste04">
                <?= $vCadernoNome ?>
              </h2>
              <ul>
                <?php
                // Constrói os submenus/tags
                foreach ($vSubCategorias[arg(0)] as $sub) {
                  ?>
                  <li><a href="<?= url(drupal_lookup_path('alias', "taxonomy/term/" . $sub['tid'])); ?>">
                      <?= $sub['title'] ?>
                    </a></li>
                  <?php
                }
                ?>
              </ul>
            <? } ?>
          </div>
        <?php endif; ?>
        <div class="colunaEsquerda" <?= (!empty($sem_colunadireita) ? 'style="width:950px;"' : ''); ?>>
          <!-- /.section, /#content -->
          <?php
          print render($page['content']);
          ?>
          <?php
          print render($page['content2']);
          ?>
          <!-- /.section, ./#content2 --> 
        </div>
        <?php if (empty($sem_colunadireita)): ?>
          <div class="colunaDireita"> <?php print render($page['colunaDireita']); ?><!-- /.section, ./#colunaDireita --> 
          </div>
        <?php endif; ?>
        <?= render($page['shop']) ?>
        <!-- /.section, /#shop -->
        <style>
          .Widget960x300{width:948px;}
          .Widget960x300 .footer{width:928px;}
          .Widget960x300 .offers li{margin:0 8px;}
          .tabs{margin:0 10px 0 0;}
          #buscaofertas-373865{float:left;}
        </style>
      </div>
    </div>
    <?php require_once 'rodape.tpl.php'; ?>
