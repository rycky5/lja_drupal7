<div class="contentAcoes" id="loginComment">
      <span class="erroMensagem" style="display:none"><?php print $msgRetorno;?></span>
    <h3>Login</h3>
    <div class="contentFormEsquerda">
      <p>Para enviar coment&aacute;rios &eacute; preciso ser usu&aacute;rio cadastrado.<br />
        <a href="<?= url(base_path().'cadastro', array('absolute' => TRUE)) ?>">Ainda n&atilde;o sou cadastrado, quero fazer o meu registro agora!</a>
      </p>
    </div>
    <div class="contentFormDireita">
      <form action="<?= base_path().'usuario/entrar?destination='.$node_url?>" method="post" accept-charset="UTF-8" id="user-login">
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
        <div class="captcha_form">
            <script type="text/javascript"> 
                //Thema do Recaptcha
                var RecaptchaOptions = {
                   theme : 'white'  
                };  
            </script>  
            <?php
              // Lendo as livrarias
              $arrLibraries = libraries_get_libraries();
              // Incluindo o arquivo necessário
              require_once $_SERVER['DOCUMENT_ROOT'].'/'.$arrLibraries["recaptcha"]."/recaptchalib.php";
              // Chave publica do leiajá
              $publickey = "6Ld8j9oSAAAAAMKVtavNhEKZixkmWpaYwpfzYSBH";
              // Exibindo o recaptcha
              print recaptcha_get_html($publickey);
            ?>
        </div>
      </form>
    </div>
  </div>

<script type="text/javascript">
(function ($) {
  $(document).ready(function(){
      
    $(".form").click(function(){
        if($("#recaptcha_response_field").val() == null || $("#recaptcha_response_field").val() == ""){
            alert("Favor preencher o código da imagem!!!");
            return false
        }
    });
    //validaÃ§Ã£o do formulÃ¡rio de login.
    $("#user-login, .captcha_form").validate({
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

  });
  
   
})(jQuery);
</script>

