<link type="text/css" rel="stylesheet" href="/sites/all/themes/leiaja/css/estilo.css" />
<script type="text/javascript" src="/sites/igpernambuco.leiaja.com/themes/ig/js/jquery.validate.min.js"></script>
<!-- coluna esquerda -->
<div class="esquerda col igd_11">
  <div class="caderno_noticias">
    <div class="contentAcoes" style="display:block;">
      <form action="<?=base_path()?>cadastro" id="frmCadastro" onsubmit="return validaCadastro();">
        <!-- Inicio Fale Conosco-->
              <h3>Cadastro</h3>
              <div class="contentFormCentro">
              <label><span class="form-required" title="Este campo é obrigatório.">* </span>Termo de uso</label>
              <div class="termoUsoContainer">
                <div class="bgTermoUsoTop"></div>
                  <div class="bgTermoUsoCenter">
                  <p>Os comentários não representam necessariamente a opinião do Leia Já e são de responsabilidade exclusiva de seus autores. Não é permitida a inclusão de comentários que atentem contra a lei, incentivem qualquer forma de preconceito, agridam pessoas, empresas ou instituições.</p>
                    <p>O Leia Já se reserva o direito de retirar do ar, sem notificação prévia, comentários que estejam em desacordo com o expresso neste aviso, ou que não se refiram ao tema da matéria.</p>
                  </div>
                  <div class="bgTermoUsoFooter"></div>
                </div>
                <input type="checkbox" id="termoUso" name="termoUso" tabindex="1">
                <label for="termoUso">Concordo e aceito o termo de uso acima</label>
              </div>
              <div class="contentFormEsquerda">
                <div class="inputGeral">
                  <label><span class="form-required" title="Este campo é obrigatório.">* </span>Login de Acesso <span class="textoLabel">Sem espaço nem caracteres especiais</span></label>
                  <div class="bgInputGeral">
                    <input type="text" title="Seu nome" name="name" id="name" tabindex="2">
                  </div>
                </div>
                <div class="inputGeral">
                  <label><span class="form-required" title="Este campo é obrigatório.">* </span>Senha <span class="textoLabel">No mínimo 6 digitos</span></label>
                  <div class="bgInputGeral">
                    <input type="password" title="Senha" name="senha" id="senha" tabindex="3">
                  </div>
                </div>
                <div class="inputGeral">
                  <label><span class="form-required" title="Este campo é obrigatório.">* </span>Confirma Senha</label>
                  <div class="bgInputGeral">
                    <input type="password" title="Confirma Senha" name="confirmasenha" tabindex="4">
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
                  <div class="bgInputGeral"><input type="text" title="Nome Completo" name="fullname" tabindex="5"></div>
                </div>
                <div class="inputGeral">
                  <label><span class="form-required" title="Este campo é obrigatório.">* </span>E-mail</label>
                  <div class="bgInputGeral"><input type="text" title="Seu e-mail" name="mail" id="mail" tabindex="6"></div>
                </div>
                <div class="selectUf">
                  <label><span class="form-required" title="Este campo é obrigatório.">* </span>UF</label>
                  <div class="bgSelectUf">
                    <select name="uf" tabindex="7">
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
                  <span><strong class="vermelho">*</strong> Sexo</span>
                  <input type="radio" id="sexo_masculino" name="Sexo" title="Masculino" value="1" tabindex="9">
                  <label for="sexo_masculino">M</label>
                  <input type="radio" id="sexo_feminino" name="Sexo" title="Feminino" value="0" tabindex="10">
                  <label for="sexo_feminino">F</label>
                </div>
                <div class="inputGeral">
                  <label><span class="form-required" title="Este campo é obrigatório.">* </span>Cidade</label>
                  <div class="bgInputGeral"><input type="text" title="Cidade" name="cidade" tabindex="8"></div>
                </div>
                <div class="inputGeral">
                  <label>Celular</label>
                  <div class="bgInputGeral"><input id="cel" type="text" title="Celular" name="cel" tabindex="11" /></div>
                </div>
                <div class="inputGeral">
                  <label>Deseja receber SMS?</label>
                  <div class="bgInputGeral"><input type="checkbox" title="SMS" name="sms" tabindex="12" checked="checked" /></div>
                </div>
                <div class="inputGeral">
                  <label>Deseja receber Newsletter?</label>
                  <div class="bgInputGeral"><input type="checkbox" title="Newsletter" name="spam" tabindex="13" checked="checked" /></div>
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
  <div id="retorno"></div>
<script type="text/javascript">
//Validação do formulário Recomendar
<!--
(function ($) {
  
  // Variável que ira conter a url de origem do usuário
  var strUrl = "<?= (!empty ($_SESSION["strUrlOringem"])) ? $_SESSION["strUrlOringem"] : ''?>";
  
  $("#cel").mask("(99)9999-9999");
  $(".btnRecaptcha").bind("click",function(){
		$(".imgCaptcha").attr('src','<?= base_path() ?>formulario/captcha?'+Math.random());
  });
  $(document).ready(function(){
//	jQuery.validator.addMethod("validMail", function(value, element){ return this.optional(element) || tryMail();}, "Esse Email j&aacute; est&aacute; cadastrado.");

    $(".imgCaptcha").attr('src','<?= base_path() ?>formulario/captcha?'+Math.random());

//	jQuery.validator.addMethod('tryMail', function(value, element){return this.optional(element) || tryMail();}, 'Esse Email j&aacute; est&aacute; cadastrado.');
    validaCadastro = function(){
      if($("#frmCadastro").valid()){
        $('#buttonEnviar').hide();
        $('#divActionEnviando').fadeIn();
        $.ajax({
          type: "POST",
          url: PATHR+'ajax/user/register',
          data: $('#frmCadastro').serialize(),
          success: function(data){
            if(data == 'recaptcha' ){
              alert('Favor atualize a image do captcha.');
            //}else if(isNaN(data) || data.substring(0,7) == 'http://'){
            }else if(data == "1"){
              alert('Cadastrado realizado com sucesso.');
              if(strUrl != ""){// Caso o usuário tenha vindo de algum espeial 
                 window.location.href = strUrl;
              }else{// se não redirciona para o leiaja
                //console.log(data);
                window.location.href = PATHR;
              }
            }else if(data != "1"){
              //console.log(data);
              alert('Cadastrado não foi realizado corretamente,\n favor tente novamente em alguns minutos.');
              //$("#frmCadastro").reset()
            }
            //window.location.href = '<?=base_path();?>';
          },
          complete: function(){
            $('#divActionEnviando').hide();
            $('#buttonEnviar').fadeIn();
          } 
        });
      }
      return false;
    }

    $("#frmCadastro").validate({
        rules: {
            name:{
                required: true,
                remote:{
                    type: "POST",
                    url: PATHR+'ajax/user/tryusername',
                    data: {
                        mail: function() {
                    return $("#name").val();
                    }
                }
              }
            },
            termoUso: "required",
            fullname: {
              required: true,
              maxlength: 250,
              minlength: 5
            },
            mail: {
                required: true,
                email: true,
                remote:{
                    type: "POST",
                    url: PATHR+'ajax/user/trymail',
                    data: {
                        mail: function() {
                    return $("#mail").val();
                    }
                }
              }
            },
            senha: {
                required: true,
                maxlength: 250,
                minlength: 6
            },
            confirmasenha: {
                required: true,
                equalTo: "#senha"
            },
            captcha: {
                required: true,
                maxlength: 5,
                minlength: 5
            },
            cidade: 'required',
            Sexo: "required"
        },
    messages: {
            termoUso: "Para efetuar o cadastro, &eacute; necess&aacute;rio aceitar os termos de uso.",
            fullname: {
              required: "Nome Completo &eacute; obrigat&oacute;rio.",
              maxlength: "Nome Completo deve ter no máximo 250 caracteres.",
              minlength: "Nome Completo deve ter ao menos 5 caracteres."
            },
            mail: {
              required: "E-mail &eacute; obrigat&oacute;rio.",
              email: "Informe um email v&aacute;lido.",
              remote: "Esse Email j&aacute; est&aacute; cadastrado."
            },
            name: {
              required: "Login &eacute; obrigat&oacute;rio.",
              remote: "Esse Login j&aacute; est&aacute; cadastrado."
            },
            senha: {
              required: "Senha &eacute; obrigat&oacute;ria.",
              maxlength: "A Senha deve ter no máximo 250 caracteres.",
              minlength: "A Senha deve ter ao menos 6 caracteres."
            },
            confirmasenha: {
              required: "Confirmação Senha &eacute; obrigat&oacute;ria.",
              equalTo: "Confirmação incorreta."
            },
            captcha: {
              required: "Captcha &eacute; obrigat&oacute;ria.",
              maxlength: "O Captcha deve ter exatamente 5 caracteres.",
              minlength: "O Captcha deve ter exatamente 5 caracteres."
            },
            cidade: 'Cidade &eacute; obrigat&oacute;ria.',
            Sexo: "Informe seu sexo."
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
  </div>
</div>