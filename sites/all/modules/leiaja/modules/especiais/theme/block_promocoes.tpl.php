<?php
// $Id: block.tpl.php,v 1.10 2010/04/26 14:10:40 dries Exp $

/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user module
 *     is responsible for handling the default user navigation block. In that case
 *     the class would be "block-user".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 */
$local=$_SERVER['REQUEST_URI'];
?>
<?php if(!empty($vPromocoes)):?>
<div class="widget-promocoes">
  <?php if(count($vPromocoes)>1):?>
  <div class="container-controls">
    <span botao="-1" class="prev">prev</span>
    <span botao="1" class="next">next</span>
  </div>
  <?endif;?>
<ul class="containerFestas margin-top15">
  <?php foreach($vPromocoes as $key=>$promocao){?>
  <li class="contentFestas bgZebrado">
          <div class="participe">
             <a href="/promocoes" class="button">Ver todas as promoções</a>
          </div>
	<div class="conteudoFestas">
            <a class="titulo" href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$promocao->tid)); ?>"><?=$promocao->name?></a>
            <h6>Sorteio <?= formatarBancoData($promocao->field_data_sorteio["und"][0]["value"]);?></h6>
            <h6 style="display:none">Sorteio <?=$promocao->data_sorteio?> às <?=$promocao->hora_sorteio?></h6>
            <p class="container-img-promocoes"><img src="<?= image_style_url('home_thumb_promocao', $promocao->field_imagecrop["und"][0]["uri"]); ?>" width="270" /></p>
            <p><?=truncate_utf8($promocao->description,120,true, true)?></p>
        </div>    
  </li>
  <?}?>
</ul>

</div>
<style>

</style>
<script>
//jQuery(".widget-promocoes li").eq(0).animate({
//  marginTop:"-285px"
//});
jQuery(".widget-promocoes li").click(function(){
  console.log("clicou")
});

/*
 * qtd de promoções existentes na lista
 */
var qtd_promocoes=jQuery(".widget-promocoes li").size();
var larguraWidget=300;
var larguraLista= (larguraWidget*qtd_promocoes)+"px";
jQuery(".widget-promocoes ul").css("width",larguraLista);
jQuery(".widget-promocoes li").eq(0).addClass("ativo");

jQuery(".widget-promocoes [botao]").click(function(){
  var passador=jQuery(this).attr("botao");
  var listaPromocoes=jQuery(".widget-promocoes ul");
  var liAtiva=jQuery(".widget-promocoes li").index(jQuery(".widget-promocoes .ativo"));
  var ultimaPos=jQuery(".widget-promocoes li").length-1;
  var margem=300;
  if(passador ==-1){
    jQuery(".widget-promocoes .ativo").removeClass("ativo").prev().addClass("ativo");
    var size=jQuery(".widget-promocoes .ativo").size();
    if(size==0){
      jQuery(".widget-promocoes li").eq(ultimaPos).addClass("ativo");
      margem=-(larguraWidget*ultimaPos)+"px";
      listaPromocoes.animate({marginLeft:margem});
    }else{
      liAtiva=jQuery(".widget-promocoes li").index(jQuery(".widget-promocoes .ativo"));
      margem=-(larguraWidget*liAtiva)+"px";
      listaPromocoes.animate({marginLeft:margem});
    }    
  }else{    
    jQuery(".widget-promocoes .ativo").removeClass("ativo").next().addClass("ativo");
    var size=jQuery(".widget-promocoes .ativo").size();
    if(size==0){
      jQuery(".widget-promocoes li").eq(0).addClass("ativo");
      listaPromocoes.animate({marginLeft:0})
    }else{
      liAtiva=jQuery(".widget-promocoes li").index(jQuery(".widget-promocoes .ativo"));
      margem=-(larguraWidget*liAtiva)+"px";
      listaPromocoes.animate({marginLeft:margem});
    }    
  }
//    jQuery(".widget-promocoes li").slideUp();
});
</script>
<?php endif; ?>