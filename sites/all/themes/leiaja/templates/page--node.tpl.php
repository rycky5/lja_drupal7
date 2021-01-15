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
          <?php
          print render($page['content']);
          ?>
          <!-- /.section, /#content -->
          <? //= render($vBlocos['ultimasNoticias']);  ?>
          <?php
          print render($page['content2']);
          ?>
          <!-- /.section, ./#content2 --> 
          <div class="colunaDireita"> 
            <?php print render($page['colunaDireita']); ?><!-- /.section, ./#colunaDireita --> 
          </div>
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
