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
<link rel="stylesheet" media="screen" type="text/css" href="<?= base_path(true) ?>/sites/all/modules/galleryformatter/gallerystyles/greenarrows/greenarrows.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?= base_path(true) ?>/sites/all/modules/galleryformatter/theme/galleryformatter.css" />
<h5 class="autorNoticia" style="border: 0px;"><?@$node->field_chapeu[$node->language][0]['value']?></h5>
<h2 class="tituloNoticiaNode"><span itemprop="name"><?= $title ?></span></h2>
<h3 class="descricaoNoticiaInterna"><span itemprop="description"><?= $node->body[$node->language][0]['summary']; ?></span></h3>
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
    };
  }
  ?> | <?= $date ?>
  <?/* if($vDataRevisao = getRevisao($node->nid)): ?>
    | <i>Atualizada em: <?= $vDataRevisao; ?></i>
  <? endif; */?>      
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
        <span>Compartilhar:</span>
        <a href="javascript:void(0);" class="facebook" onclick="window.open(shareSocial.facebook.url, shareSocial.facebook.name, shareSocial.facebook.params);shareIt('facebook');"></a>
        <a href="javascript:void(0);" class="twitter" onclick="window.open(shareSocial.twitter.url, shareSocial.twitter.name, shareSocial.twitter.params);shareIt('twitter');"></a>
      </div>
      <iframe src="http://www.facebook.com/plugins/like.php?href=<?= urlencode('http://'.$_SERVER['SERVER_NAME'].$node_url) ?>&amp;send=true&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:235px; height:21px; margin: -1px 0 0;" allowTransparency="true"></iframe>
      <g:plusone size="medium"></g:plusone>         
      <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="leiajaonline">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    </div>
    <link type="text/css" rel="stylesheet" media="all" href="<?= base_path().drupal_get_path('theme', 'leiaja'); ?>/css/spacegallery.css" />   
    <?php
      if(!empty($node->field_imagecrop["und"][0])){
        echo "<span class='creditoFotoGrande'>{$node->field_imagecrop["und"][0]["alt"]}</span>";
        echo "<img title='' src='".image_style_url('image_wide_large', $node->field_imagecrop["und"][0]["uri"])."' rel='image_src'>";
        echo "<strong class='tituloFoto'>{$node->field_imagecrop["und"][0]["title"]}</strong>";
      }
      hide($content['comments']);
      hide($content['links']);
      hide($content['field_tags']);
      hide($content['field_fonte']);
      hide($content['field_subespecial']);
      hide($content['field_capa']);
      hide($content['field_imagecrop']);
      hide($content['field_infografico']);
      hide($content['field_permlink']);
      hide($content['body']);
      print render($content);      
    ?>
    <?php if(!empty($node->field_video[$node->language])): ?>
      <div class="detalhesVideo">
    	<span>Embed</span>
        <div class="bgInputEmbed">
            <input name="embed" type="text" value='<?= '<iframe src="http://'.$_SERVER['HTTP_HOST']."/embed/".urlencode(base64_encode($node->nid)).'" scrolling="no" frameborder="0" width="625" height="352"></iframe>' ?>' onclick="this.focus();this.select();" />
        </div>
        <span class="views">Views:<strong><?= getNodeViews($node->nid) ?></strong></span>
      </div>
    <?php endif; ?>
    <div class="textoExibir textoNoticia"> 
      <?php print str_replace('##RECOMENDA##',(empty($vLeiaTambemHtml)) ? '' : $vLeiaTambemHtml,render($content['body'])); ?>
      <?php 
        if (!empty($node->field_infografico[$node->language])): 
          foreach($node->field_infografico[$node->language] as $info):
            if($info['filemime'] == 'application/x-shockwave-flash') :   

               echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="625" height="360">
                       <param name=movie value="'.file_create_url($info['uri']).'"> 
                       <param name=quality value=high> 
                       <param name=bgcolor value=#333399> 
                       <embed src="'.file_create_url($info['uri']).'" quality=high bgcolor=#fff width="625" height="352" name="Yourfilename" align="" TYPE="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
                       </embed> 
                     </object>';
            else:
              echo '<img src="'.file_create_url($info['uri']).'" alt="'.$info['description'].'" />';
            endif;
          endforeach; 
        endif; 
      ?>      
    </div>
    <?=render($AdsenseTexto);?>
</div>
    <div class="compartilhaBottom">
        <!-- 
      <a href="javascript:void(0);" class="btImprimir" title="Imprimir"></a>
      <span class="spanCompartilhar">|</span>
        -->
      <a href="javascript:void(0);" class="btCompartilhar" title="Recomendar"></a>
      <span class="spanCompartilhar">|</span><a href="javascript:void(0);" id="aComentar" class="btComentar" title="Comentar"></a>
      <span class="spanCompartilhar">(<?= $comment_count ?>)</span>
      <a href="javascript:void(0);" title="Coment&aacute;rios" id="aComentarios">Coment&aacute;rios</a>
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
<!--
    <div class="tagsExibir">
      <h5>Tags:</h5>
      <ul class="tags">
        <?php 
          /*foreach($node->field_tags[$node->language] as $not){
            if(!empty($not['taxonomy_term']->tid)):
        ?>
              <li><a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$not['taxonomy_term']->tid)); ?>" title=""><?= $not['taxonomy_term']->name;?></a></li>
  	<?
  	    endif;
          } */
        ?>       
      </ul>
    </div>
-->

<?php if($comment == '2'): ## Verifica se comentarios estão abertos.?>
<!-- Comentários -->
<div class="containerAcoes" id="divComentario" style="display:none;">
  <a href="javascript:void(0)" id="aComentarioFechar" class="fechar"></a>
<?php if(!$logged_in): ?>
  <div class="contentAcoes">
    <h3>Login</h3>
    <div class="contentFormEsquerda">
      <p>Para enviar comentário é preciso ser usuário cadastrado.<br />
        <a href="<?= base_path().'cadastro' ?>">Ainda não sou cadastrado, quero fazer o meu registro agora!</a>
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
        <a class="esqueceuSenha" href="<?= base_path() ?>user/password">Esqueceu sua senha?</a>
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
    //$('html, body').animate({scrollTop:50}, 'slow');
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

  	//Valida o formulário de sugerir correção
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

    	//Validação do formulário Recomendar
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

	  
	//validação do formulário de login.
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