<?php
//URL's fontes para os iframes
$urlRodadas            = 'http://futebol.leiaja.com/jogoSmall_List.aspx';
$urlClassificacoes    = 'http://futebol.leiaja.com/ClassificacaoSmall_List.aspx';

// Construções dos iframes
$frameRodadas = '<iframe class="scroll" frameborder="0" hspace="0" src="'.$urlRodadas.'" id="TB_iframeContent" name="TB_iframeContent" style="width:310px;height:440px;z-index:0;"> </iframe>';
$frameClassificacoes  = '<iframe class="scroll" frameborder="0" hspace="0" src="'.$urlClassificacoes.'" id="TB_iframeContent" name="TB_iframeContent" style="width:310px;height:400px;z-index:0;"> </iframe>';

?>
<div>
    <?php print $frameClassificacoes;?>
</div>
<div>
    <?php print $frameRodadas;?>
</div>
