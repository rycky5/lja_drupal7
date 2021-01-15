<?php
/**
 * Arquivo que conterá o formulário de login e senha e comentário para portal
 * 
 * @author Alberto Medeiros <alberto.medeiros@seducacional.com>
 */

##############################################
########## CHAVES RECAPTCHA ##################
##############################################
define('KEY_PUBLIC_RECAPTCHA', "6Le7fuASAAAAAMP_BhMSXNTeIjnxrhB3naARAqbH");
define('KEY_PRIVATE_RECAPTCHA', "6Le7fuASAAAAANlCUOxS5bS2uN0qBUjVTO1FwItm");
##############################################

// Lendo as livrarias
$arrLibraries = "../../../sites/all/libraries/curl";

$strCaptcha = '';

// Caso o usuário não tenha sessão
//if(empty ($_SESSION["user"])){
?>

<script type="text/javascript">
      <!--
      (function ($) {
          $.post("/usuariologado", {}, function(arrRetorno){
            // Verificando se o usuário está logado
            if(!arrRetorno.bolLogado){
              $("#loginComment").show(200);
              var objCaptcha = $("#loginComment").find(".recaptcha");
              $(".captcha_form").html($("#form_recaptcha").show());
            }else{
              // Caso o usuário esteja logado mostro o form de comentário
              $("#cadastroComent").show(200);
              $("#strNome").val(arrRetorno.strNome);
              
              $(".recaptchaComentario").html($("#form_recaptcha").show());
            }
          },"json");
        
      })(jQuery);
      //-->
</script>

  <!-- Formulário de login e senha -->
    <div class="contentAcoes" id="loginComment" style="display: none">
      <span class="erroMensagem" style="display:none"><?php print @$msgRetorno;?></span>
      <h3>Login</h3>
      <div class="contentFormEsquerda">
        <p>Para enviar coment&aacute;rios &eacute; preciso ser usu&aacute;rio cadastrado.<br />
          <a href="/cadastro">Ainda n&atilde;o sou cadastrado, quero fazer o meu registro agora!</a>
        </p>
      </div>
      <div class="contentFormDireita">
        <form action="/estatico/registro.php" method="post" accept-charset="UTF-8" id="user-login">
          <input type="hidden" name="form_build_id" value="" />
          <input type="hidden" name="form_id" value="user_login" />
          <div class="inputGeral">
            <label for="inpUsuario">Nome Usu&aacute;rio</label>
            <div class="bgInputGeral"><input id="inpUsuario" tabindex="1" maxlength="240" type="text" name="name" maxlength="60" title="Nome Usu&aacute;rio"></div>
          </div>
          <div class="inputGeral">
            <label for="inpSenha">Senha</label>
            <div class="bgInputGeral"><input id="inpSenha" maxlength="240" tabindex="2" type="password" name="pass" maxlength="128" title="Senha"></div>
          </div>
          <a class="esqueceuSenha" href="/senha">Esqueceu sua senha?</a>
          <button class="form form-login" type="submit" tabindex="3"><span>Entrar</span></button>
          <div class="enviando" style="display:none;">
            <img class="imgEnviando" src="/sites/all/themes/leiaja/images/loader.gif" alt="Carregando" />
            <h4>Enviando</h4>
          </div>
          <div class="captcha_form">
          </div>
        </form>
      </div>
    </div>

    <script type="text/javascript">
      (function ($) {
        $(document).ready(function(){

          $(".form-login").click(function(){
              // Se o captcha não estiver preenchido
              if($("#recaptcha_response_field").val() == null || $("#recaptcha_response_field").val() == ""){
                  alert("Favor preencher o código da imagem!!!");
                  return false
              }
          });
          

        });
      })(jQuery);
    </script>
<?php 
//}else{ // Caso o usuário tenha efetuado login e senha
  
  // Recuperando o obejto usuário
//  $objUser = $_SESSION["user"];
?>  
    
  <!-- INCÍCIO FORMULÁRIO COMENTÁRIO -->
  <div class="contentAcoes" id="cadastroComent" style="display: none">
    <span class="erroMensagem" style="display: none">Erro: Favor tentar novamente!!!</span>
    <span class="acertoMensagem" style="display: none">Comentário cadastrado com sucesso!!!</span>
    <h3>Escrever seu coment&aacute;rio</h3>
    <form action="/comentario/estatico/salvar" method="post" accept-charset="UTF-8" id="frmComment" >
      <input type="hidden" name="form_id" value="<?= base64_encode(base64_encode($intNid ."-leiaja" )) ?>" />
      <div class="contentFormEsquerda">
        <div style="display:none" class="areaLoading">
            <img width="42px" src='/sites/all/themes/leiaja/images/loader.gif' />
        </div>
        <div class="inputGeral">
          <label>Seu nome</label>
          <div class="bgInputGeralDisabled"><input title="Seu nome" value="" disabled="disabled" id="strNome" type="text" /></div>
        </div>
          <p>Ao enviar qualquer coment&aacute;rio &agrave;s not&iacute;cias, o usu&aacute;rio declara-se ciente e aceita integralmente o <a href="/alteracao" title="termo de uso">termo de uso</a>.</p>
      </div>
      <div class="contentFormDireita">
        <div class="textAreaCorrigir">
          <label>Seu coment&aacute;rio</label>
          <div class="bgTextAreaCorrigir"><textarea class="required" id="inpComentarioMensagem" name="comment_body[und][0][value]" title="Mensagem"></textarea></div>
        </div>
        <div class="recaptchaComentario">
        </div>
        <img src="http://hallsocial.leiaja.com/sites/all/themes/blogsocial/images/carregando4.gif" class="loading" style="display: none" />
        <button type="submit" class="form form-submit form-comentario"><span>Comentar</span></button>
      </div>
    </form>
  </div>

  <div id="form_recaptcha" style="display: none">
    <script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=<?= KEY_PUBLIC_RECAPTCHA ?>"></script>
    <noscript>
        <iframe src="http://www.google.com/recaptcha/api/noscript?k=<?= KEY_PUBLIC_RECAPTCHA ?>" height="300" width="500" frameborder="0"></iframe><br/>
        <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
        <input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
    </noscript>
  </div>
  
  <!-- FIM DO FORMULÁRIO COMENTÁRIO -->
  <script type="text/javascript">
  (function ($) {
    $(document).ready(function(){
         $(".form-comentario").click(function(){
              // Se o captcha não estiver preenchido
              if($("#recaptcha_response_field").val() == null || $("#recaptcha_response_field").val() == ""){
                  alert("Favor preencher o código da imagem!!!");
                  return false
              }
          });
    });
  })(jQuery);
  </script>
<?php
//}