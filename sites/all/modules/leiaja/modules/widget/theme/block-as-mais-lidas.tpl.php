<?php
//Tpl do bloco As Mais - Gerado por views
?>

<?php
// 1 - do dia / 2 - da semana / 3 - do mês
$nodesMaisLidosDoDia = get_top_getclick(1);
$nodesMaisLidosSemana = get_top_getclick(2);
$nodesMaisLidosMes = get_top_getclick(3);
?>
<!-- Leia Já as Mais! -->
<div id="divAsMais" class="asMais">
  <h3 class="h3LeiaJa">
    <i class="azulClaro">Leia</i>
    <i class="vermelho margin-right7">J&aacute;</i>
    <i>as Mais!</i>
  </h3>

  <a id="aMaisLida" rel="Lida" href="javascript:void(0);" class="aba active">+ LIDAS</a>
  <!--<a id="aMaisCompartilhada" rel="Compartilhada" href="javascript:void(0);" class="aba">+ COMPARTILHADAS</a>-->

  <div id="divMaisLida" class="contentAbas">    
    <ul id="maisLidaDia" class="ulMaisLida">
      <?php foreach ($nodesMaisLidosDoDia as $notDia) { ?>
        <li><a href="<?= $notDia->url; ?>" class="cinza"><?= $notDia->titulo; ?></a></li>
      <?php } ?>
    </ul>
    <ul id="maisLidaMes" class="ulMaisLida" style="display:none;">
      <?php foreach ($nodesMaisLidosMes as $notMes) { ?>
        <li><a href="<?= $notMes->url; ?>" class="cinza"><?= $notMes->titulo; ?></a></li>
      <?php } ?>
    </ul>
    <ul id="maisLidaSemana" class="ulMaisLida" style="display:none;">
      <?php foreach ($nodesMaisLidosSemana as $notSem) { ?>
        <li><a href="<?= $notSem->url; ?>" class="cinza"><?= $notSem->titulo; ?></a></li>
      <?php } ?>
    </ul>
    
    <div class="asMaisTop">            
      <a href="javascript:void(0);" rel="Mes" id="aMaisLidaMes" title="Notícias mais lidas no mês">NO M&Ecirc;S</a>
      <a href="javascript:void(0);" rel="Semana" id="aMaisLidaSemana" title="Notícias mais lidas na Semana">NA SEMANA</a>
      <a href="javascript:void(0);" rel="Dia" id="aMaisLidaDia" title="Notícias mais lidas hoje">NO DIA</a>            
    </div>
  </div>
</div>  


<script type="text/javascript">
  (function($) {
    $('#divAsMais .aba').click(function(e) {
      //  e.preventDefault();
      var maisRel = $(this).attr('rel');
      $('#divAsMais .aba.active').removeClass('active');
      $(this).addClass('active');
      $('#divAsMais .contentAbas:visible').hide();
      $('#divAsMais #divMais' + maisRel).show();
      console.log('#divAsMais #divMais' + maisRel);
    });

    $('.asMaisTop a').click(function(e) {
      //e.preventDefault();
      var maisRel = $(this).attr('rel');
      $('.asMaisTop a.active').removeClass('active');
      $(this).addClass('active');
      $('#divMaisLida .ulMaisLida:visible').hide();
      $('#divMaisLida #maisLida' + maisRel).show();
    });
  })(jQuery);
</script>
<!-- Leia Já as Mais! -->