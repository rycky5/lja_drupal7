
<div class="compartilhaBottom">
      <a href="javascript:void(0);" id="aImprimir<?= $key ?>" class="btImprimir" title="Imprimir"></a>
      <span class="spanCompartilhar">|</span>
      <a href="javascript:void(0);" id="aFaleconosco<?= $key ?>" class="btFaleConosco" title="Fale Conosco"></a>
      <span class="spanCompartilhar">|</span>
      <a href="javascript:void(0);" id="aCorrigir<?= $key ?>" class="btCorrigir" title="Corrigir"></a>
      <span class="spanCompartilhar">|</span>
      <a href="javascript:void(0);" id="aRecomendar<?= $key ?>" class="btCompartilhar" title="Recomendar"></a>
      <span class="spanCompartilhar">|</span><a href="javascript:void(0)" id="aComentar" class="btComentar" title="Comentar"></a>
      <span class="spanCompartilhar">(<?= $node->comment_count ?>)</span>
      <a href="javascript:void(0)" id="aComentarios<?= $key ?>" title="Coment&aacute;rios">Coment&aacute;rios</a>
      <span class="spanCompartilhar marginLink">Link:</span>
      <div class="bgInputLink">
          <input type="text" value="<?= $node->permlink ?>" />
      </div>        
      <div class="compartilhaRedes">
      	<span>Compartilhar:</span>
        <a href="javascript:void(0);" onclick="void(window.open('http://www.facebook.com/share.php?u=' + encodeURIComponent('http://<?= $_SERVER['SERVER_NAME'].$node_url ?>'), 'facebook','toolbar=no,width=700,height=400'))" class="facebook"></a>
        <a href="javascript:void(0);" onclick="void(window.open('http://twitter.com/intent/tweet?original_referer=<?= urlencode('http://'.$_SERVER['SERVER_NAME'].$node_url) ?>&url=<?= urlencode('http://'.$_SERVER['SERVER_NAME'].$node_url) ?>&text=<?= $title ?>&via=leiajaonline', 'Twitter','toolbar=no,width=550,height=420'))" target="_blank" class="twitter"></a>
      </div>
</div>