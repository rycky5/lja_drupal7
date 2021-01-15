<?php
//URL's fontes para os iframes
$urlRodadas            = 'http://futebol.leiaja.com/jogoSmall_List.aspx';
$urlClassificacoes    = 'http://futebol.leiaja.com/ClassificacaoSmall_List.aspx';

// Construções dos iframes
$frameRodadas = '<iframe class="scroll" frameborder="0" hspace="0" src="http://futebol.leiaja.com/jogoSmall_List.aspx" id="TB_iframeContent" name="TB_iframeContent" style="width:310px;height:440px;z-index:0;"> </iframe>';
$frameClassificacoes  = '<iframe class="scroll" frameborder="0" hspace="0" src="http://futebol.leiaja.com/ClassificacaoSmall_List.aspx" id="TB_iframeContent" name="TB_iframeContent" style="width:310px;height:400px;z-index:0;"> </iframe>';


//imprimindo o iframe retornado aleatoriamente
print $arrFrame[$tempFrame];
?>
<div id="frameFutebol">
  Carregano ...
</div>
<script type="text/javascript">
  (function ($) {
    
    var frame = Math.floor((Math.random()*2)+1);
    
    if(frame == 1)
      $("#frameFutebol").html('<iframe class="scroll" frameborder="0" hspace="0" src="http://futebol.leiaja.com/jogoSmall_List.aspx" id="TB_iframeContent" name="TB_iframeContent" style="width:310px;height:440px;z-index:0;"> </iframe>');
    else
      $("#frameFutebol").html('<iframe class="scroll" frameborder="0" hspace="0" src="http://futebol.leiaja.com/ClassificacaoSmall_List.aspx" id="TB_iframeContent" name="TB_iframeContent" style="width:310px;height:400px;z-index:0;"> </iframe>');
  })(jQuery);
</script>

