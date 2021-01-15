<div class="containerAcoes" id="divComentario<?= $key ?>" style="display:none;">
		  <a href="javascript:void(0)" id="aComentarioFechar" class="fechar"></a>
		<?php if(!$logged_in): ?>
		  <div class="contentAcoes">
		    <h3>Login</h3>
		    <div class="contentFormEsquerda">
		      <p>Para enviar comentário é preciso ser usuário cadastrado.<br />
		        <a href="<?= url(base_path().'cadastro/', array('absolute' => TRUE)) ?>">Ainda não sou cadastrado, quero fazer o meu registro agora!</a>
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
		        <a class="esqueceuSenha" href="<?= url(base_path().'senha', array('absolute' => TRUE)) ?>">Esqueceu sua senha?</a>
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
		<!-- Enviar correção -->
		      <div id="divCorrigir<?= $key ?>" class="containerAcoes" style="display: none;">
		      	<a href="javascript:void(0);" class="fechar"></a>
		        <div class="contentAcoes">
		          <form action="#" id="frmCorrigir<?= $key ?>" method="post" accept-charset="UTF-8">
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
		                <img class="imgCaptcha" src="<?= base_path() ?>formulario/captcha"  />
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
		<!-- Fim Enviar Correção  -->
		<!-- Fale conosco -->
		     <div id="divFaleconosco<?= $key ?>" class="containerAcoes" style="display: none;">
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
		      <div id="divRecomendar<?= $key ?>" class="containerAcoes" style="display: none;">
		      	<a href="javascript:void(0)" class="fechar"></a>
		        <div class="contentAcoes">
		          <form id="frmRecomendar<?= $key ?>" action="#" method="post" accept-charset="UTF-8">
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
                
<script type="text/javascript">
<!--
(function ($) {
  $(".fechar").bind("click", function(){
    $(this).parent().hide();
    $("#divConteudoExibir<?= $key ?>,.tagsExibir").fadeIn();
  })
  
  $("#aComentar<?= $key ?>,#aComentarios<?= $key ?>").bind("click", function(){
    esconder();
    $("#divComentario<?= $key ?>").fadeIn();
    subir();
  })

  $("#aCorrigir<?= $key ?>").bind("click", function(){
    esconder();
    $("#divCorrigir<?= $key ?>").fadeIn();
    $(".imgCaptcha").attr('src','<?= base_path() ?>formulario/captcha?'+Math.random());
    subir();
  })
  
  $("#aFaleconosco<?= $key ?>").bind("click", function(){
    esconder();
    $("#divFaleconosco<?= $key ?>").fadeIn();
    $(".imgCaptcha").attr('src','<?= base_path() ?>formulario/captcha?'+Math.random());
    subir();
  })
  
  $("#aRecomendar<?= $key ?>").bind("click", function(){
    esconder();
    $("#divRecomendar<?= $key ?>").fadeIn();
    $(".imgCaptcha").attr('src','<?= base_path() ?>formulario/captcha?'+Math.random());
    subir();
  })
  
  $("#aImprimir<?= $key ?>").bind("click", function(){
	  abreJanela('<?= base_path() ?>util/imprimir?l=<?= urlencode(base64_encode('node/'.$node->nid)) ?>');
  })

  function esconder(){
    $("#divConteudoExibir<?= $key ?>,.tagsExibir,#divCorrigir<?= $key ?>,#divComentario<?= $key ?>,#divRecomendar<?= $key ?>,#divFaleconosco<?= $key ?>").hide();
  }

  function subir(){
    vPosicao = $("#tituloNoticia<?= $key ?>").offset().top;
    $('html, body').animate({scrollTop:vPosicao}, 'slow');
  }

  // Formularios
  $("#btnCorrigir<?= $key ?>").bind('click',function(){
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
  
  $("#btnRecomendar<?= $key ?>").bind('click',function(){
	if($('#frmRecomendar').valid()){
	  $("#divRecomendarEnviando").show();
	  $(this).hide();	  
      $.post('<?= base_path() ?>formulario/recomendar', $('#frmRecomendar<?= $key ?>').serialize(), function(t){
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
  
  $("#btnFaleconosco<?= $key ?>").bind('click',function(){
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
      				email: "Informe um email v&aacute;lido"
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
      				required: "O Email &eacute; obrigat&oacute;rio",
      				email: "Informe um email v&aacute;lido"
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
        				email: "Informe um email v&aacute;lido"
        			},
        			inpEmailDestino: {
        				required: "O Enviar Para(e-amil) &eacute; obrigat&oacute;rio",
        				email: "Informe um email v&aacute;lido"
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
	  	  "comment_body[und][0][value]": "Digite seu Coment&aacue;rio"
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

