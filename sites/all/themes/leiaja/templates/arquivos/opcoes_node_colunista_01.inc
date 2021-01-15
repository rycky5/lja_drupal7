<!-- /PRINT -->
    <div class="compartilhaBottom">
      <a href="javascript:void(0);" id="aImprimir" class="btImprimir" title="Imprimir"></a>
      <span class="spanCompartilhar">|</span>
      <a href="javascript:void(0);" id="aFaleconosco" class="btFaleConosco" title="Fale Conosco"></a>
      <span class="spanCompartilhar">|</span>
      <a href="javascript:void(0);" id="aCorrigir" class="btCorrigir" title="Corrigir"></a>
      <span class="spanCompartilhar">|</span>
      <a href="javascript:void(0);" id="aRecomendar" class="btCompartilhar" title="Recomendar"></a>

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

<script type="text/javascript">
(function ($) {

  function subir(){
        compartilhaBottom = $('#baseBoxes').offset().top;
        compartilha = compartilhaBottom - 80;
        $('html, body').animate({scrollTop:compartilha}, 'slow');
  }
 
  $("#aCorrigir").click(function(){
    esconder();
    $("#divCorrigir").fadeIn();
    $(".imgCaptcha").attr('src','<?=base_path();?>formulario/captcha?'+Math.random());
    subir();
  })

  $("#aFaleconosco").click(function(){
    esconder();
    $("#divFaleconosco").fadeIn();
    $(".imgCaptcha").attr('src','<?=base_path();?>formulario/captcha?'+Math.random());
    subir();
  })

  $("#aRecomendar,#aRecomendarTopo,#aRecomendarTopoBotao").click(function(){
    esconder();
    $("#divRecomendar").fadeIn();
    $(".imgCaptcha").attr('src','<?=base_path();?>formulario/captcha?'+Math.random());
    subir();
  })

  $("#aImprimir").click(function(){
	  abreJanela('<?= base_path() ?>util/imprimir?l=<?= urlencode(base64_encode('node/'.$node->nid)) ?>');
  })

  function esconder(){
    $("#divConteudoExibir,.tagsExibir,#divCorrigir,#divRecomendar,#divFaleconosco,#divComentario").hide();//#divComentario
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
<?php
$pVal='';
if(isset($_GET['boxval'])){
    $pVal = $_GET['boxval'];
?>
        $("#<?=@$pVal?>").trigger('click');
<? }?>

      $('#inpCorrigirMensagem').textareaCount({'originalStyle' : 'contador1', 'warningStyle' : 'vermelho', 'maxCharacterSize': 700, displayFormat: '#input/#max caracteres'});
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
      	});

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

 	//fim do document ready
      });

  jQuery.fn.reset = function () {
    $(this).each (function() { this.reset(); });
  }
})(jQuery);

</script>