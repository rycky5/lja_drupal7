<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/estilo.css"/>
<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/grid.css"/>
<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/box0016_4x7_1_iframe/css/box.css"/>
<script type="text/javascript" src="/sites/all/themes/leiaja2/js/boxes/jquery.min.js"></script>

<?php
// 1 - do dia / 2 - da semana / 3 - do mês
$nodesMaisLidosDoDia = get_top_getclick(1);
$nodesMaisLidosSemana = get_top_getclick(2);
$nodesMaisLidosMes = get_top_getclick(3);
?>

<!-- Leia Já as Mais! -->
<div id="divAsMais" class="zbox wgd4 hgd7 box0016 iframeinterna" style="margin:0px;">
  <h1><b>As mais lidas</b> <span>do dia</span></h1>

  <div class="maisLidasLista cinza">    
    <ul class="maisLidaDia">
      <?php foreach ($nodesMaisLidosDoDia as $notDia) { ?>
        <li><a target="_parent" href="<?= $notDia->url; ?>"><?= $notDia->titulo; ?></a></li>
      <?php } ?>
    </ul>
    <ul class="maisLidaMes" style="display:none;">
      <?php foreach ($nodesMaisLidosMes as $notMes) { ?>
        <li><a target="_parent" href="<?= $notMes->url; ?>"><?= $notMes->titulo; ?></a></li>
      <?php } ?>
    </ul>
    <ul class="maisLidaSemana" style="display:none;">
      <?php foreach ($nodesMaisLidosSemana as $notSem) { ?>
        <li><a target="_parent" href="<?= $notSem->url; ?>"><?= $notSem->titulo; ?></a></li>
      <?php } ?>
    </ul>
    
    <div class="asMaisLidasBotoes">            
      <a href="javascript:void(0);" rel="maisLidaMes" class="btnlink" title="As mais lidas do mês">DO M&Ecirc;S</a>
      <a href="javascript:void(0);" rel="maisLidaSemana" class="btnlink" title="As mais lidas da Semana">DA SEMANA</a>
      <a href="javascript:void(0);" rel="maisLidaDia" class="btnlink" title="As mais lidas do dia">DO DIA</a>            
    </div>
  </div>
  

<?php
if(isset($_GET['response_type']) && $_GET['response_type'] != 'embed'):
    $path = drupal_get_path('theme', 'leiaja');
?>
<!--<script type="text/javascript" src="/sites/all/themes/leiaja/misc/jquery.js"></script>-->
<?php
endif;
?>

<script type="text/javascript">
  (function($) {
    $('.asMaisLidasBotoes a').click(function(e) {
      var este = $(this),
          classe = este.attr('rel');
      $('.asMaisLidasBotoes a').attr('style','');
      este.attr('style','opacity:0.7');
      $('.maisLidasLista ul').hide();
      $('.maisLidasLista .'+classe).show();
      $('#divAsMais h1 span').text(este.text().toLowerCase());
    });
  })(jQuery);
</script>
<!-- Leia Já as Mais! -->
