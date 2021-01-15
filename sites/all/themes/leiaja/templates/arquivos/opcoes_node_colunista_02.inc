<!-- /PRINT -->
    <div class="compartilhaBottom">
       <a href="javascript:void(0);" id="aImprimir<?=$node->nid?>" class="btImprimir" title="Imprimir"></a>
      <span class="spanCompartilhar">|</span>
      <a href="<?php print $node_url;?>?boxval=aFaleconosco" id="aFaleconosco" class="btFaleConosco" title="Fale Conosco"></a>
      <span class="spanCompartilhar">|</span>
      <a href="<?php print $node_url;?>?boxval=aCorrigir" id="aCorrigir" class="btCorrigir" title="Corrigir"></a>
      <span class="spanCompartilhar">|</span>
      <a href="<?php print $node_url;?>?boxval=aRecomendar" id="aRecomendar" class="btCompartilhar" title="Recomendar"></a>
      <?php //if($comment == '2'): ?>
        <span class="spanCompartilhar">|</span><a href="<?php print $node_url;?>#divComentario" id="aComentar" class="btComentar" title="Comentar"></a>
        <span class="spanCompartilhar">(<?= $comment_count ?>)</span>
        <a href="<?php print $node_url;?>#divComentario" id="aComentarios" title="Coment&aacute;rios">Coment&aacute;rios</a>
      <?php //endif; ?>
      <span class="spanCompartilhar marginLink">Link:</span>
      <div class="bgInputLink">
        <input type="text" value="<?= @$node->field_permlink[$node->language][0]['value'] ?>" />
      </div>
      <div class="compartilhaRedes">
        <span>Compartilhar:</span><!-- NID =  -->
        <a href="javascript:void(0);" class="facebook" onclick="window.open('http://www.facebook.com/sharer.php?u=<?= $urlCompleto?>','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"></a>
        <a href="javascript:void(0);" class="twitter" onclick="window.open('http://twitter.com/intent/tweet?url=<?= $urlCompleto ?>&text=<?= $title ?>&via=leiajaonline', 'ventanacompartir','toolbar=no,width=550,height=420');"></a>
      </div>
    </div>

    <div class="tagsExibir">
      <h5>Tags:</h5>
      <ul class="tags">
        <?php
          foreach($node->field_tags[$node->language] as $not){
          	if(!empty($not['taxonomy_term']->tid)):
        ?>
              <li><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$not['taxonomy_term']->tid)); ?>" title=""><?= $not['taxonomy_term']->name;?></a></li>
  	    <?
  	         endif;
          }
        ?>
      </ul>
    </div>

<script type="text/javascript">

//script especifico para a opção de print nas páginas com listagem de nodes
(function ($) {
      $("#aImprimir<?=$node->nid?>").click(function(){
	  abreJanela('<?= $node_url?>?print=true');
  })
})(jQuery);

</script>