<?php
// $Id: node.tpl.php,v 1.2 2010/12/01 00:18:15 webchick Exp $

/**
 * @file
 * Bartik's theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */

?>
<script type="text/javascript" src="<?= base_path(true).'/'.path_to_theme().'/js/jquery.textareaCounter.js'; ?>"></script>
<script type="text/javascript" src="<?= base_path(true).'/'.path_to_theme().'/js/jquery.validate.min.js'; ?>"></script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"> {lang: 'pt-BR'}</script>
<?php if($node):?>
<!-- PRINT -->
  <h2 class="<?=$node->type == 'blogs_da_redacao'? 'tituloNoticia' : 'tituloNoticiaNode'?>"><span itemprop="name"><?= $title ?></span></h2>
  <h3 class="<?=$node->type == 'blogs_da_redacao'? 'descricaoNoticia' : 'descricaoNoticiaInterna'?>"><?= $node->body[$node->language][0]['summary']; ?></h3>
  <h5 class="autorNoticia">
      <? 
      $file = drupal_get_path('theme', 'leiaja').'/images/'.semAcentos($node->field_fonte[$node->language][0]['value']).'.jpg';
      if(empty($node->field_fonte[$node->language][0]['value'])){
      	echo $name;
      }else{
        if(file_exists($_SERVER['DOCUMENT_ROOT'].base_path().$file)){
		  echo "<img height='18' width='61' src='".base_path(true)."/$file' title='".$node->field_fonte[$node->language][0]['value']."'>";
		}else{
		  echo '<strong>'.$node->field_fonte[$node->language][0]['value'].',</strong>';
		}
      	;
      }
      if($jornalista == 'true'){
        echo 'por <strong>'.$node->name.'</strong>';
      }
      ?> | <?= $date ?>
      <? if($vDataRevisao = getRevisao($node->nid)): ?>
        | <i>Atualizada em: <?= $vDataRevisao; ?> </i>
      <? endif; ?>
    </h5>
<script type="text/javascript">
var shareUrl    = 'http://<?= urlencode($_SERVER['SERVER_NAME'].$node_url) ?>';
var shareId     = <?= $node->nid ?>;
var shareSocial = {facebook : {url    : 'http://www.facebook.com/share.php?u='+shareUrl,
		                           params : 'toolbar=no,width=700,height=400',
		                           name   : 'facebook'},
                   twitter  : {url    : 'http://twitter.com/intent/tweet?original_referer=' + shareUrl + '&url=' + shareUrl + '&text=<?= $title ?>&via=leiajaonline',
                               params : 'toolbar=no,width=550,height=420',
                               name:'Twitter'}
	                };
function shareIt(net)
{
  jQuery.post('http://<?= $_SERVER['SERVER_NAME']?>/ajax/node/share', 
              {id:shareId,network:net}, function(rs){}, 'json');
}
</script>
<div id="divConteudoExibir">	
	<div class="compartilhaTop">
      <div class="compartilhaRedes">
        <span>Compartilhar:</span><!-- NID =  -->
        <a href="javascript:void(0);" class="facebook" onclick="window.open(shareSocial.facebook.url, shareSocial.facebook.name, shareSocial.facebook.params);shareIt('facebook');"></a>
        <a href="javascript:void(0);" class="twitter" onclick="window.open(shareSocial.twitter.url, shareSocial.twitter.name, shareSocial.twitter.params);shareIt('twitter');"></a>
      </div>
      <iframe src="http://www.facebook.com/plugins/like.php?href=<?= urlencode('http://'.$_SERVER['SERVER_NAME'].$node_url) ?>&amp;send=true&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:235px; height:21px; margin:-1px 0 0;" allowTransparency="true"></iframe> 
      <g:plusone size="medium"></g:plusone>    
      <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="leiajaonline">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    </div>
    <?php if(!empty($node->field_image[$node->language][0]['uri'])) : ?>
      <?php if(!empty($node->field_image[$node->language][0]['alt'])) :?>
        <span class="creditoFoto">Foto: <?= $node->field_image[$node->language][0]['alt'] ?></span>
      <?php endif; ?>
      <img rel="image_src" src="<?= image_style_url('large', $node->field_image[$node->language][0]['uri']); ?>" title="<?= $node->field_image[$node->language][0]['title'] ?>" />      
      <?php if(!empty($node->field_image[$node->language][0]['title'])) : ?>
      <strong class="tituloFoto"><?= $node->field_image[$node->language][0]['title'] ?></strong>
      <?php endif; ?>
    <?php endif; ?>
    
    <div class="textoExibir textoNoticia">

<style type="text/css">
.cobertura_gabarito td a {
	background-color:#EA0C25;
	color:#fff;
	float:left;
	text-align:center;
	font:bold 20px arial;padding:10px;
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;
text-decoration:none;
}
.cobertura_gabarito td a:hover {
	background-color:#a20d1e;
}
#iframe_loading {
	background: #f5f5f5;
	width:100%;
	height:100px;
	border:1px dotted silver;
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;
float:left;
text-align:center;
font: bold 16px arial;
}
</style>
<script>
var iframeHeightIncrement;
//jQuery(document).ready( function() {
(function ($) {
  $(document).ready(function(){
	$.each($('.cobertura_gabarito td a'), function() {
		var elem = $(this);
		elem.attr('iframe', elem.attr('href'));
		elem.attr('href', 'javascript:void(0);');
	});
		
	$('.cobertura_gabarito td a').bind('click', function() {
		var iframe = $('#iframe_gabarito');
		if (iframe.size() === 0){
			$('.cobertura_gabarito table').after('<div id="iframe_loading"><p><img src="http://static1.leiaja.com/sites/all/themes/leiaja/images/loader.gif" /></p><p>Carregando gabarito</p></div><iframe id="iframe_gabarito" width="100%" height="1" onload="iframeHeightIncrement()" scrolling="no" frameborder="0" style="border:0px;" src="'+$(this).attr('iframe')+'"></iframe>');
		} else {
			$('#iframe_loading').show();
			iframe.attr('src', $(this).attr('iframe')).height('1px');
		}
	});
	iframeHeightIncrement =function(){
		var iframe = document.getElementById('iframe_gabarito'); 
    var doc = 'contentDocument' in iframe? iframe.contentDocument : iframe.contentWindow.document;
    iframe.style.height = doc.getElementById('divContainer').offsetHeight+'px';
		$('#iframe_loading').hide();
	}
  });
})(jQuery);
</script>
      <span itemprop="description" class="cobertura_gabarito">
        <?php print str_replace('##RECOMENDA##',(empty($vLeiaTambemHtml)) ? '' : $vLeiaTambemHtml,render($content['body'])); ?>        
        <?php print render($content['field_anexo']); ?>
      </span>
    </div>
    
    <?= render($AdsenseTexto); ?>
</div>
<!-- /PRINT -->
    <div class="compartilhaBottom">
      <a href="javascript:void(0);" id="aImprimir" class="btImprimir" title="Imprimir"></a>
      <span class="spanCompartilhar">|</span>
      <a href="javascript:void(0);" id="aFaleconosco" class="btFaleConosco" title="Fale Conosco"></a>
      <span class="spanCompartilhar">|</span>
      <a href="javascript:void(0);" id="aCorrigir" class="btCorrigir" title="Corrigir"></a>
      <span class="spanCompartilhar">|</span>
      <a href="javascript:void(0);" id="aRecomendar" class="btCompartilhar" title="Recomendar"></a>
      <?php if($comment == '2'): ?>
        <span class="spanCompartilhar">|</span><a href="javascript:void(0)" id="aComentar" class="btComentar" title="Comentar"></a>
        <span class="spanCompartilhar">(<?= $comment_count ?>)</span>
        <a href="javascript:void(0)" id="aComentarios" title="Coment&aacute;rios">Coment&aacute;rios</a>
      <?php endif; ?>
      <span class="spanCompartilhar marginLink">Link:</span>
      <div class="bgInputLink">
        <input type="text" value="<?= @$node->field_permlink[$node->language][0]['value'] ?>" />        
      </div>        
      <div class="compartilhaRedes">
      	<span>Compartilhar:</span>
        <a href="javascript:void(0);" class="facebook" onclick="window.open(shareSocial.facebook.url, shareSocial.facebook.name, shareSocial.facebook.params);shareIt('facebook');"></a>
        <a href="javascript:void(0);" class="twitter" onclick="window.open(shareSocial.twitter.url, shareSocial.twitter.name, shareSocial.twitter.params);shareIt('twitter');"></a>
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
<?php if($comment == '2'): ## Verifica se comentarios estÃ£o abertos.?>
<!-- ComentÃ¡rios -->
<div class="containerAcoes" id="divComentario" style="display:none;">
  <a href="javascript:void(0)" id="aComentarioFechar" class="fechar"></a>
<?php if(!$logged_in): ?>
  <div class="contentAcoes">
    <h3>Login</h3>
    <div class="contentFormEsquerda">
      <p>Para enviar coment&aacute;rios &eacute; preciso ser usu&aacute;rio cadastrado.<br />
        <a href="<?= base_path().'cadastro' ?>">Ainda n&atilde;o sou cadastrado, quero fazer o meu registro agora!</a>
      </p>
    </div>
    <div class="contentFormDireita">
      <form action="<?= base_path().'usuario/entrar?destination=node/'.$node->nid."#comment_form" ?>" method="post" accept-charset="UTF-8" id="user-login">
        <input type="hidden" name="form_build_id" value="<?= drupal_get_token('user_login_theme_form'); ?>" />
        <input type="hidden" name="form_id" value="user_login" />    
        <div class="inputGeral">
          <label for="inpUsuario">Nome Usu&aacute;rio</label>
          <div class="bgInputGeral"><input id="inpUsuario" tabindex="1" maxlength="240" type="text" name="name" maxlength="60" title="Nome Usu&aacute;rio"></div>
        </div>
        <div class="inputGeral">
          <label for="inpSenha">Senha</label>
          <div class="bgInputGeral"><input id="inpSenha" maxlength="240" tabindex="2" type="password" name="pass" maxlength="128" title="Senha"></div>
        </div>
        <a class="esqueceuSenha" href="<?= base_path() ?>senha">Esqueceu sua senha?</a>
        <button class="form" type="submit" tabindex="3"><span>Entrar</span></button>
        <div class="enviando" style="display:none;">
          <img class="imgEnviando" src="<?= base_path().drupal_get_path('theme', 'leiaja')?>/images/loader.gif" alt="Carregando" />
          <h4>Enviando</h4>
        </div>
      </form>
    </div>  
  </div>
<?php endif; ?>               
  <?php print render($content['comments']); ?>
</div>
<!-- Fim bloco comentario -->
<?php endif; ?>
<!-- Enviar correÃ§Ã£o -->
      <div id="divCorrigir" class="containerAcoes" style="display: none;">
      	<a href="javascript:void(0);" class="fechar"></a>
        <div class="contentAcoes">
          <form action="#" id="frmCorrigir" method="post" accept-charset="UTF-8">
            <h3>Corrigir</h3>
            <div class="contentFormEsquerda">
              <div class="inputGeral">
                <label>Seu nome</label>
                <div class="bgInputGeral"><input title="Seu nome" maxlength="240" tabindex="1" name="inpNome" type="text" /></div>
              </div>
              <div class="inputGeral">
                <label>Seu e-mail</label>
                <div class="bgInputGeral"><input title="Seu e-mail" maxlength="240" tabindex="2" name="inpEmail" type="text" /></div>
              </div>
              <div class="captcha">
                <img class="imgCaptcha" src="<?= base_path() ?>formulario/captcha" alt="Imagem captcha" />
                <a href="javascript:void(0);"class="btnRecaptcha"><span class="refresh"></span>Atualizar imagem</a>
                <span>Digite o texto acima</span>
                <div class="bgInputCaptcha"><input name="inpCaptcha" maxlength="5" tabindex="4" title="Texto referente a imagem" type="text" /></div>
              </div>
            </div>
            <div class="contentFormDireita">
              <div class="textAreaCorrigir">
                <label>Mensagem</label>
                <div class="bgTextAreaCorrigir"><textarea name="inpMensagem" tabindex="3" id="inpCorrigirMensagem" title="Mensagem"></textarea></div>
              </div>
              <button id="btnCorrigir" tabindex="4" type="button" class="form"><span>Enviar</span></button>
              <div id="divCorrigirEnviando" class="enviando" style="display:none;">
              	<img class="imgEnviando" src="<?= base_path().drupal_get_path('theme', 'leiaja')?>/images/loader.gif" alt="Carregando" />
              	<h4>Enviando</h4>
              </div>
            </div>    
          </form>     
        </div>
      </div>
<!-- Fim Enviar CorreÃ§Ã£o  -->
<!-- Fale conosco -->
     <div id="divFaleconosco" class="containerAcoes" style="display: none;">
      	<a href="javascript:void(0);" class="fechar"></a>
        <div class="contentAcoes">
          <form id="frmFaleconosco" action="#" method="post" accept-charset="UTF-8">
            <h3>Fale Conosco</h3>
            <div class="contentFormEsquerda">
              <div class="inputGeral">
                <label>Seu nome</label>
                <div class="bgInputGeral"><input name="inpNome" maxlength="240" tabindex="1" title="Seu nome" type="text" /></div>
              </div>
              <div class="selectUf">
                <label>UF</label>
                <div class="bgSelectUf">
                  <select name="selUF" tabindex="5">
                    <option value="AC">AC</option>
                    <option value="AL">AL</option>
                    <option value="AP">AP</option>
                    <option value="AM">AM</option>
                    <option value="BA">BA</option>
                    <option value="CE">CE</option>
                    <option value="DF">DF</option>
                    <option value="GO">GO</option>
                    <option value="ES">ES</option>
                    <option value="MA">MA</option>
                    <option value="MT">MT</option>
                    <option value="MS">MS</option>
                    <option value="MG">MG</option>
                    <option value="PA">PA</option>
                    <option value="PB">PB</option>
                    <option value="PR">PR</option>
                    <option value="PE">PE</option>
                    <option value="PI">PI</option>
                    <option value="RJ">RJ</option>
                    <option value="RN">RN</option>
                    <option value="RS">RS</option>
                    <option value="RO">RO</option>
                    <option value="RR">RR</option>
                    <option value="SP">SP</option>
                    <option value="SC">SC</option>
                    <option value="SE">SE</option>
                    <option value="TO">TO</option>
                  </select>
                </div>
              </div>
              <div class="inputSexo">
                <span>Sexo</span>
                <input type="radio" title="Masculino" tabindex="7" name="inpSexo" value="Masculino" id="sexo_masculino" />
                <label for="sexo_masculino">M</label>
                <input type="radio" title="Feminino" tabindex="8" name="inpSexo" value="Feminino" id="sexo_feminino" />
                <label for="sexo_feminino">F</label>
              </div>
              <div class="inputGeral">
                <label>Cidade</label>
                <div class="bgInputGeral"><input tabindex="6" maxlength="240" name="inpCidade" title="Cidade" type="text" /></div>
              </div>
              <div class="captcha">
                <img class="imgCaptcha" src="<?= base_path() ?>formulario/captcha"  />
                <a href="javascript:void(0);"class="btnRecaptcha"><span class="refresh"></span>Atualizar imagem</a>
                <span>Digite o texto acima</span>
                <div class="bgInputCaptcha"><input name="inpCaptcha" maxlength="5" tabindex="9" title="Texto referente a imagem" type="text" /></div>
              </div>
            </div>
            <div class="contentFormDireita">
              <div class="inputGeral">
                <label>Seu e-mail</label>
                <div class="bgInputGeral"><input name="inpEmail" maxlength="240" tabindex="2" title="Seu e-mail" type="text" /></div>
               </div>
              <div class="inputGeral">
                <label>Assunto</label>
                <div class="bgInputGeral"><input name="inpAssunto" maxlength="240" tabindex="3" title="Assunto" type="text" /></div>
              </div>
              <div class="textAreaGeral">
                <label>Seu Coment&aacute;rio</label>
                <div class="bgTextAreaGeral"><textarea name="inpMensagem" tabindex="4" id="inpFaleconoscoMensagem" title="Seu Coment&aacute;rio"></textarea></div>
              </div>
              <button id="btnFaleconosco" type="button" class="form" tabindex="10">
                <span>Enviar</span>
              </button>
              <div id="divFaleconoscoEnviando" class="enviando" style="display:none;">
              	<img class="imgEnviando" src="<?= base_path().drupal_get_path('theme', 'leiaja')?>/images/loader.gif" alt="Carregando" />
              	<h4>Enviando</h4>
              </div>
            </div>
          </form>
        </div>
      </div>      
<!--Fim Fale Conocoso-->
<!-- Recomendar -->
      <div id="divRecomendar" class="containerAcoes" style="display: none;">
      	<a href="javascript:void(0)" class="fechar"></a>
        <div class="contentAcoes">
          <form id="frmRecomendar" action="#" method="post" accept-charset="UTF-8">
            <h3>Recomendar</h3>
            <div class="contentFormEsquerda">
              <div class="inputGeral">
                <label>Seu nome</label>
                <div class="bgInputGeral"><input name="inpNome" maxlength="240" tabindex="1" title="Seu nome" type="text" /></div>
              </div>
          	  <div class="inputGeral">
                <label>Enviar para (e-mail)</label>
                <div class="bgInputGeral"><input name="inpEmailDestino" maxlength="240" tabindex="3" title="Enviar para" type="text" /></div>
              </div>
              <div class="captcha">
                <img class="imgCaptcha" src="<?= base_path() ?>formulario/captcha"  />
                <a href="javascript:void(0);"class="btnRecaptcha"><span class="refresh"></span>Atualizar imagem</a>
                <span>Digite o texto acima</span>
                <div class="bgInputCaptcha"><input name="inpCaptcha" maxlength="5" tabindex="5" title="Texto referente a imagem" type="text" /></div>
              </div> 
            </div>
            <div class="contentFormDireita">      
              <div class="inputGeral">
                <label>Seu e-mail</label>
                <div class="bgInputGeral"><input name="inpEmail" maxlength="240" tabindex="2" title="Seu e-mail" type="text" /></div>
              </div>  
              <div class="textAreaGeral">
                <label>Seu Coment&aacute;rio</label>
                <div class="bgTextAreaGeral"><textarea name="inpComentario" tabindex="4" id="inpRecomendarMensagem" title="Seu Coment&aacute;rio"></textarea></div>
              </div> 
              <button id="btnRecomendar" tabindex="6" type="button" class="form">
                <span>Enviar</span>
              </button>
              <div id="divRecomendarEnviando" class="enviando" style="display:none;">
              	<img class="imgEnviando" src="<?= base_path().drupal_get_path('theme', 'leiaja')?>/images/loader.gif" alt="Carregando" />
              	<h4>Enviando</h4>
              </div>
            </div>
          </form>
        </div>
      </div>      
<!--Fim Recomendar-->          
      
    <?php if(!empty($vUltimasSubcategoria)) : ?>
      <div class="ultimasExibir">
      	<h3>Ultimas Not&iacute;cias <?= $vUltimasSubcategoria[0]->subcategoria ?></h3>
        <ul class="ultimas">
        <?php foreach($vUltimasSubcategoria as $ult){ ?>
          <li><span>&raquo;</span><a href="<?= url(drupal_lookup_path('alias',"node/".$ult->nid)); ?>" title=""><?= $ult->title ?></a></li>
        <?php } ?>
        </ul>
      </div>
    <?php endif; ?>     
 <?php endif; ?>
      
<script type="text/javascript">
<!--
(function ($) {
  $(".fechar").bind("click", function(){
    $(this).parent().hide();
    $("#divConteudoExibir,.tagsExibir").fadeIn();
  })
  
  $("#aComentar,#aComentarios").bind("click", function(){
    esconder();
    $("#divComentario").fadeIn();
    subir();
  })

  $("#aCorrigir").bind("click", function(){
    esconder();
    $("#divCorrigir").fadeIn();
    $(".imgCaptcha").attr('src','<?=base_path();?>formulario/captcha?'+Math.random());
    subir();
  })
  
  $("#aFaleconosco").bind("click", function(){
    esconder();
    $("#divFaleconosco").fadeIn();
    $(".imgCaptcha").attr('src','<?=base_path();?>formulario/captcha?'+Math.random());
    subir();
  })
  
  $("#aRecomendar,#aRecomendarTopo,#aRecomendarTopoBotao").bind("click", function(){
    esconder();
    $("#divRecomendar").fadeIn();
    $(".imgCaptcha").attr('src','<?=base_path();?>formulario/captcha?'+Math.random());
    subir();
  })
  
  $("#aImprimir").bind("click", function(){
	  abreJanela('<?= base_path() ?>util/imprimir?l=<?= urlencode(base64_encode('node/'.$node->nid)) ?>');
  })

  function esconder(){
    $("#divConteudoExibir,.tagsExibir,#divCorrigir,#divComentario,#divRecomendar,#divFaleconosco").hide();
  }

  function subir(){
    compartilhaBottom = $(".compartilhaBottom").offset().top;
    compartilha = compartilhaBottom - 84;
    $('html, body').animate({scrollTop:compartilha}, 'slow');
  }
  

  // Formularios
  $("#btnCorrigir").bind('click',function(){
	if($('#frmCorrigir').valid()){
	  $("#divCorrigirEnviando").show();
      $(this).hide();	  	  
      $.post('<?= base_path() ?>formulario/corrigir', $('#frmCorrigir').serialize(), function(t){
        alert(t.status);
        if(t.retorno == true){
      	  $("#divCorrigir").hide();
          $("#divConteudoExibir,.tagsExibir").fadeIn();
          $("#frmCorrigir").reset();
        }
  	    $("#divCorrigirEnviando").hide();
        $('#btnCorrigir').show();      
      },'json');
	}
  })
  
  $("#btnRecomendar").bind('click',function(){
	if($('#frmRecomendar').valid()){
	  $("#divRecomendarEnviando").show();
	  $(this).hide();	  
      $.post('<?= base_path() ?>formulario/recomendar', $('#frmRecomendar').serialize(), function(t){
        alert(t.status);
        if(t.retorno == true){
    	  $("#divRecomendar").hide();
          $("#divConteudoExibir,.tagsExibir").fadeIn();
          $("#frmRecomendar").reset();
        }
  	    $("#divRecomendarEnviando").hide();
	    $('#btnRecomendar').show();      
      },'json');
	}
  })
  
  $("#btnFaleconosco").bind('click',function(){
	  if($('#frmFaleconosco').valid()){
  	    $("#divFaleconoscoEnviando").show();
	    $(this).hide();
        $.post('<?= base_path() ?>formulario/faleconosco', $('#frmFaleconosco').serialize(), function(t){
          alert(t.status);
          if(t.retorno == true){
    	    $("#divFaleconosco").hide();
            $("#divConteudoExibir,.tagsExibir").fadeIn();
            $("#frmFaleconosco").reset();
          }
          $("#divFaleconoscoEnviando").hide();
          $('#btnFaleconosco').show();
        },'json');
	  }
  })

  $(".btnRecaptcha").bind("click",function(){
     $(".imgCaptcha").attr('src','<?= base_path() ?>formulario/captcha?'+Math.random());
  });


  $(document).ready(function(){
	  
	  if(location.href.indexOf("#comment_form") != -1){
		$("#divConteudoExibir,.tagsExibir").hide();
		$("#divComentario").fadeIn();
		$('html, body').animate({scrollTop:50}, 'slow');
	  };
  
      $('#inpCorrigirMensagem').textareaCount({'originalStyle' : 'contador1', 'warningStyle' : 'vermelho', 'maxCharacterSize': 700, displayFormat: '#input/#max caracteres'});  
      $('#inpComentarioMensagem').textareaCount({'originalStyle' : 'contador1', 'warningStyle' : 'vermelho', 'maxCharacterSize': 140, displayFormat: '#input/#max caracteres'});  
      $('#inpFaleconoscoMensagem').textareaCount({'originalStyle' : 'contador2', 'warningStyle' : 'vermelho', 'maxCharacterSize': 240, displayFormat: '#input/#max caracteres'});  
      $('#inpRecomendarMensagem').textareaCount({'originalStyle' : 'contador2', 'warningStyle' : 'vermelho', 'maxCharacterSize': 140, displayFormat: '#input/#max caracteres'});  

      //ValidaÃ§Ã£o do formulÃ¡rio FaleConosco
      $("#frmFaleconosco").validate({
      		rules: {
    	  		inpNome: "required",
    	  		inpSexo: "required",
    	  		inpCidade: "required",
      			inpCaptcha: "required",
      	  		inpEmail: {
      			  required: true,
      			  email: true
      			},
      			inpAssunto: "required",
      			inpMensagem: "required"
      		},
      		messages: {
      			inpNome: "Seu Nome &eacute; obrigat&oacute;rio",
    	  		inpSexo: "Seu Sexo &eacute; obrigat&oacute;rio",
    	  		inpCidade: "Sua Cidade &eacute; obrigat&oacute;ria",
      			inpCaptcha: "Digite o texto da imagem acima",
      	  		inpEmail: {
      				required: "Seu e-mail &eacute; obrigat&oacute;rio",
      				email: "Informe um e-mail v&aacute;lido"
      			},
      			inpAssunto: "O Assunto &eacute; obrigat&oacute;rio",
      			inpMensagem: "Digite sua Mensagem"
      		},
      		wrapper: "h6",
      		errorElement: "span",
      		errorClass: "validacaoForm",
      		errorPlacement: function(error, element) {
      			error.insertBefore(element);
      		}
      });

  	//Valida o formulÃ¡rio de sugerir correÃ§Ã£o
      $("#frmCorrigir").validate({
      		rules: {
      	  		inpNome: "required",
      	  		inpEmail: {
      				required: true,
      				email: true
      			},
      			inpCaptcha: "required",
      			inpMensagem: "required"
      		},
      		messages: {
      			inpNome: "Seu Nome &eacute; obrigat&oacute;rio",
      	  		inpEmail: {
      				required: "O E-mail &eacute; obrigat&oacute;rio",
      				email: "Informe um e-mail v&aacute;lido"
      			},
      			inpCaptcha: "Digite o texto da imagem acima",
      			inpMensagem: "Digite sua Mensagem"
      		},
      		wrapper: "h6",
      		errorElement: "span",
      		errorClass: "validacaoForm",
      		errorPlacement: function(error, element) {
      			error.insertBefore(element);
      		}
      	})/*.showErrors: function (errorMap, errorList)
      	{
      	    this.defaultShowErrors();
      	    $.each(errorList, function (i, error)
      	    {
      	        $(error.element).css("display", "inline");
//      	        $('.validacaoForm').css("display", "inline");
      	    });
      	}*/;

    	//ValidaÃ§Ã£o do formulÃ¡rio Recomendar
        $("#frmRecomendar").validate({
        		rules: {
      	  		inpNome: "required",
        	  		inpEmail: {
        				required: true,
        				email: true
        			},
        			inpEmailDestino: {
        				required: true,
        				email: true
        			},
        			inpCaptcha: "required",
        			inpComentario: "required"
        		},
        		messages: {
        			inpNome: "Seu Nome &eacute; obrigat&oacute;rio",
        	  		inpEmail: {
        				required: "Seu e-mail &eacute; obrigat&oacute;rio",
        				email: "Informe um e-mail v&aacute;lido"
        			},
        			inpEmailDestino: {
        				required: "O Enviar Para(e-mail) &eacute; obrigat&oacute;rio",
        				email: "Informe um e-mail v&aacute;lido"
        			},
        			inpCaptcha: "Digite o texto da imagem acima",
        			inpComentario: "Digite seu Coment&aacute;rio"
        		},
        		wrapper: "h6",
          		errorElement: "span",
        		errorClass: "validacaoForm",
        		errorPlacement: function(error, element) {
        			error.insertBefore(element);
        		}
        });

    	
      //
	  $('#frmComment').validate({
		rules: {
		  "comment_body[und][0][value]": 'required'
	  	},
	  	messages: {
	  	  "comment_body[und][0][value]": "Digite seu Coment&aacute;rio"
		},
		wrapper: "h6",
  		errorElement: "span",
  		errorClass: "validacaoForm",
  		errorPlacement: function(error, element) {
  			error.insertBefore(element);
  		}
	  });

	  
	//validaÃ§Ã£o do formulÃ¡rio de login.
      $("#user-login").validate({
  		rules: {
  			name: "required",
  			
  			pass: {
  				required: true,
  				minlength: 3
  			}
  		},
  		messages: {
  			name: "O Login &eacute; obrigat&oacute;rio",
  			pass: {
  				required: "A Senha &eacute; obrigat&oacute;ria",
  				minlength: "A senha n&atilde;o pode ser menor que 3 caracteres"
  			}
  		},
  		wrapper: "h6",
  		errorElement: "span",
  		errorClass: "validacaoForm",
  		errorPlacement: function(error, element) {
  			error.insertBefore(element);
  		}
      });


  	//fim do document ready
      });

  jQuery.fn.reset = function () {
    $(this).each (function() { this.reset(); });
  } 

  validComment = function (){
	  if($('#frmComment').valid()){
		return true;
	  }else{
		return false;
	  }
  }
  
})(jQuery);
//-->
</script>