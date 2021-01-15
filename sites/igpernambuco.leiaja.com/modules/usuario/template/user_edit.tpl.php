<link type="text/css" rel="stylesheet" href="/sites/all/themes/leiaja/css/estilo.css" />
<script type="text/javascript" src="/sites/igpernambuco.leiaja.com/themes/ig/js/jquery.validate.min.js"></script>
<!-- coluna esquerda -->
<div class="esquerda col igd_11">
  <div class="caderno_noticias">
    <div class="contentAcoes" style="display:block; ">
      <form action="<?=base_path()?>user/register" id="frmAlteracao" onsubmit="return validaCadastro();">
        <!-- Inicio Fale Conosco-->
              <h3>Alteração de Cadastro</h3>

              <div class="contentFormEsquerda">
                <div class="inputGeral">
                  <label><span class="form-required" title="Este campo é obrigatório.">* </span>Login de Acesso <span class="textoLabel">Sem espaço nem caracteres especiais</span></label>
                  <div class="bgInputGeral">
                    <input type="text" title="Seu nome" name="name" id="name" value="<?=@$user->name;?>" disabled="disabled">
                  </div>
                </div>
                <div class="inputGeral">
                  <label><span class="form-required" title="Este campo é obrigatório.">* </span>Senha <span class="textoLabel">No mínimo 6 digitos</span></label>
                  <div class="bgInputGeral">
                    <input type="password" title="Senha" name="senha" id="senha" tabindex="2">
                  </div>
                </div>
                <div class="inputGeral">
                  <label><span class="form-required" title="Este campo é obrigatório.">* </span>Confirma Senha</label>
                  <div class="bgInputGeral">
                    <input type="password" title="Confirma Senha" name="confirmasenha" tabindex="3">
                  </div>
                </div>
                <div class="">
                  <?php
                       // Lendo as livrarias
                       $arrLibraries = libraries_get_libraries();
                       // Incluindo o arquivo necessário
                       require_once $_SERVER['DOCUMENT_ROOT'].'/'.$arrLibraries["recaptcha"]."/recaptchalib.php";

                       // Chave publica do leiajá
                       $publickey = "6Ld8j9oSAAAAAMKVtavNhEKZixkmWpaYwpfzYSBH";

                       // Exibindo o recaptcha
                       echo recaptcha_get_html($publickey);
                  ?>
                </div>
              </div>
              <div class="contentFormDireita">
              <div class="inputGeral">
                  <label><span class="form-required" title="Este campo é obrigatório.">* </span>Nome Completo</label>              
                    <div class="bgInputGeral"><input type="text" title="Nome Completo" name="fullname" value="<?=@db_query("SELECT field_fullname_value FROM field_data_field_fullname WHERE entity_id = '".$user->uid."'")->fetchField();?>" tabindex="4"></div>
                </div>
                <div class="inputGeral">
                  <label><span class="form-required" title="Este campo é obrigatório.">* </span>E-mail</label>
                  <div class="bgInputGeral"><input type="text" title="Seu e-mail" name="mail" id="mail" value="<?=@$user->mail?>" disabled="disabled"></div>
                </div>
                <div class="selectUf">
                  <label><span class="form-required" title="Este campo é obrigatório.">* </span>UF</label>
                  <div class="bgSelectUf">
                    <select name="uf" tabindex="5">
                      <option value="">Selecione...</option>
                      <? 
                      $UFs = array( 'AC','AL','AM','AP','BA','CE','DF','ES','GO','MA',
                                    'MG','MS','MT','PA','PB','PE','PI','PR','RJ','RN',
                                    'RO','RR','RS','SC','SE','SP','TO');
                      $user_uf = @db_query("SELECT field_uf_value FROM field_data_field_uf WHERE entity_id = '".$user->uid."'")->fetchField();

                      foreach($UFs as $UF){
                      ?>
                      <option <?=($user_uf == $UF)?'selected="selected"':'';?> value="<?=$UF ?>"><?=$UF ?></option>
                      <?    
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="inputSexo">
                  <span><strong class="vermelho">*</strong> Sexo</span>
                  <input type="radio" id="sexo_masculino" name="Sexo" tabindex="7" title="Masculino" value="1" <? echo ($user->field_sexo['und'][0]['value'] == '1')?'checked="checked"':''; ?> >
                  <label for="sexo_masculino">M</label>
                  <input type="radio" id="sexo_feminino" name="Sexo" tabindex="8" title="Feminino" value="0" <? echo ($user->field_sexo['und'][0]['value'] == '0')?'checked="checked"':''; ?> >
                  <label for="sexo_feminino">F</label>
                </div>
                <div class="inputGeral">
                  <label><span class="form-required" title="Este campo é obrigatório.">* </span>Cidade</label>
                  <div class="bgInputGeral"><input type="text" title="Cidade" name="cidade"  value="<?=@db_query("SELECT field_cidade_value FROM field_data_field_cidade WHERE entity_id = '".$user->uid."'")->fetchField();?>" tabindex="6"></div>
                </div>
                <div class="inputGeral">
                  <label>Celular</label>
                  <div class="bgInputGeral"><input id="cel" type="text" title="Celular" name="cel" tabindex="11" value="<?=@db_query("SELECT field_cel_value FROM field_data_field_cel WHERE entity_id = '".$user->uid."'")->fetchField();?>" /></div>
                </div>
                <div class="inputGeral">
                  <label>Deseja receber SMS?</label>
                  <div class="bgInputGeral"><input type="checkbox" title="SMS" name="sms" tabindex="12" <? echo (@db_query("SELECT field_sms_value FROM field_data_field_sms WHERE entity_id = '".$user->uid."'")->fetchField())? 'checked="checked"': '';?> /></div>
                </div>
                <div class="inputGeral">
                  <label>Deseja receber Newsletter?</label>
                  <div class="bgInputGeral"><input type="checkbox" title="Newsletter" name="spam" tabindex="13" <? echo (@db_query("SELECT field_spam_value FROM field_data_field_spam WHERE entity_id = '".$user->uid."'")->fetchField())? 'checked="checked"': '';?> /></div>
                </div>
                <button class="form" id="buttonEnviar">
                  <span>Enviar</span>
                </button>
                  <div style="display: none;" class="enviando" id="divActionEnviando">
                    <img src="/sites/all/themes/leiaja/images/loader.gif" class="imgEnviando">
                    <h4>Enviando</h4>
                  </div>
              </div>
              <!--Fim Fale Conocoso-->      
      </form>
    </div>
<script type="text/javascript">
//Validação do formulário Recomendar
<!--
(function ($) {
  
  $("#cel").mask("(99)9999-9999");
  
  $(".btnRecaptcha").bind("click",function(){
	$(".imgCaptcha").attr('src','<?= base_path() ?>formulario/captcha?'+Math.random());
  });
  $(document).ready(function(){

	$(".imgCaptcha").attr('src','<?= base_path() ?>formulario/captcha?'+Math.random());
	validaCadastro = function(){
	  if($("#frmAlteracao").valid()){
            $('#buttonEnviar').hide();
            $('#divActionEnviando').fadeIn();
            $.ajax({
              type: "POST",
              url: PATHR+"ajax/user/edit",
              data: $('#frmAlteracao').serialize(),
              success: function(data){
                  //alert(data);
//		return data;
                if(data == 'recaptcha'){
                  alert('Favor informe o captcha corretamente.');
                }else if(data == 'true'){
                  alert('Alteração realizada com sucesso.');
                }else if(data == 'false'){
                  alert('Alteração não foi realizada corretamente,\n favor tente novamente em alguns minutos.');
                }
//		$('#retorno').innerHTML(data);
              },
              complete: function(){
                $('#divActionEnviando').hide();
                $('#buttonEnviar').fadeIn();
              } 
            });
	  }
	  return false;
	}
	$("#frmAlteracao").validate({
            rules: {
                senha: {
                    maxlength: 250,
                    minlength: 6
                },
                confirmasenha: {
                    equalTo: "#senha"
                },
                inpCaptcha: {
                    required: true,
                    maxlength: 5,
                    minlength:5
                }
            },
            messages: {
                senha: {
                  maxlength: "A Senha deve ter no máximo 250 caracteres.",
                  minlength: "A Senha deve ter ao menos 6 caracteres."
                },
                confirmasenha: {
                  equalTo: "Confirmação incorreta."
                },
                inpCaptcha: {
                    required: 'Favor digite a imagem abaixo.',
                    maxlength: 'O campo deve ter exatamente 5 caracteres',
                    minlength: 'O campo deve ter exatamente 5 caracteres'
                }
            },
            wrapper: "h6",
            errorElement: "span",
            errorClass: "validacaoForm",
            errorPlacement: function(error, element) {
                error.insertBefore(element);
            }
	});

  });
})(jQuery);
//-->
</script> 
  </div>
</div>