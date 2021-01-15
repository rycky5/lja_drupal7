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
drupal_add_js(drupal_get_path('theme', 'leiaja') . '/js/jquery.validate.min.js');

?>
<div class="colunaEsquerda">
<script type="text/javascript" src="<?=base_path(true).drupal_get_path('theme', 'leiaja') . '/js/jquery.validate.min.js'?>"></script>
<? if($title == 'Fale Conosco'){
      	?>
      	<!-- Fale conosco -->
     <div id="divFaleconosco" class="containerAcoes caderno_noticias">
      	<a href="javascript:void(0);" class="fechar"></a>
        <div class="contentAcoes">
          <form id="frmFaleconosco" action="#" method="post" accept-charset="UTF-8">
            <h3>Fale Conosco / (81) 3334-3333</h3>
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
                <?php
                    //Lendo as bibliotecas
                    $arrLibraries = libraries_get_libraries();
                    //Incluindo a biblioteca do reCAPTCHA
                    require_once $_SERVER['DOCUMENT_ROOT']."/".$arrLibraries["recaptcha"]."/recaptchalib.php";
                    //Definindo a public_key do reCAPTCHA
                    $publicKey = KEY_PUBLIC_RECAPTCHA;
                    //Exibindo o reCAPTCHA
                    echo recaptcha_get_html($publicKey);
                ?>
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
	<script type="text/javascript">
	<!--
	(function ($) {

	  $(".btnRecaptcha").bind("click",function(){
		$(".imgCaptcha").attr('src','<?= base_path() ?>formulario/captcha?'+Math.random());
	  });

	$(document).ready(function(){

	$(".imgCaptcha").attr('src','<?= base_path() ?>formulario/captcha?'+Math.random());
$("#btnFaleconosco").bind('click',function(){
	  if($('#frmFaleconosco').valid()){
	    $("#divFaleconoscoEnviando").show();
	    $(this).hide();
      $.post('<?= base_path() ?>formulario/faleconosco', $('#frmFaleconosco').serialize(), function(t){
        alert(t.status);
        if(t.retorno == true){
          $("#frmFaleconosco").reset();
        }
        $("#divFaleconoscoEnviando").hide();
        $('#btnFaleconosco').show();
      },'json');
	  }
})
      //Validação do formulário FaleConosco
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
//fim do document ready
	      });

	})(jQuery);
	//-->
</script>
      	<?
      }else{
      ?>
	<h2 class="tituloNoticia"><span itemprop="name"><?= $title ?></span></h2>

    <?php if(!empty($node->field_image[$node->language][0]['uri'])) : ?>
      <?php if(!empty($node->field_image[$node->language][0]['alt'])) :?>
        <span class="creditoFoto">Foto: <?= $node->field_image[$node->language][0]['alt'] ?></span>
      <?php endif; ?>
      <img src="<?= image_style_url('large', $node->field_image[$node->language][0]['uri']); ?>" title="<?= $node->field_image[$node->language][0]['title'] ?>" />

      <?php if(!empty($node->field_image[$node->language][0]['title'])) : ?>
      <strong class="tituloFoto"><?= $node->field_image[$node->language][0]['title'] ?></strong>
      <?php endif; ?>
    <?php endif; ?>

    <div class="textoExibir textoNoticia">
      <span itemprop="description">
        <?= $node->body[$node->language][0]['value']; ?>
      </span>
    </div>
<script type="text/javascript">
var shareUrl    = 'http://<?= urlencode($_SERVER['SERVER_NAME'].$node_url) ?>';
var shareId     = <?= $node->nid ?>;
var shareSocial = {facebook : {url    : 'http://www.facebook.com/share.php?app_id=224681850906688&u='+shareUrl,
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
    <div class="compartilhaBottom">
      <a href="javascript:void(0);" class="btImprimir" title="Imprimir"></a>
      <span class="spanCompartilhar">|</span>
      <a href="javascript:void(0);" class="btCompartilhar" title="Compartilhar"></a>
      <div class="compartilhaRedes">
      	<span>Compartilhar:</span>
        <a href="javascript:void(0);" class="facebook" onclick="window.open(shareSocial.facebook.url, shareSocial.facebook.name, shareSocial.facebook.params);shareIt('facebook');"></a>
        <a href="javascript:void(0);" class="twitter" onclick="window.open(shareSocial.twitter.url, shareSocial.twitter.name, shareSocial.twitter.params);shareIt('twitter');"></a>
      </div>
    </div>
    <? }?>


</div>