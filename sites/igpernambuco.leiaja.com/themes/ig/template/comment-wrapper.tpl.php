<?php

/**
 * @file
 * Bartik's theme implementation to provide an HTML container for comments.
 *
 * Available variables:
 * - $content: The array of content-related elements for the node. Use
 *   render($content) to print them all, or
 *   print a subset such as render($content['comment_form']).
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default value has the following:
 *   - comment-wrapper: The current template type, i.e., "theming hook".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * The following variables are provided for contextual information.
 * - $node: Node object the comments are attached to.
 * The constants below the variables show the possible values and should be
 * used for comparison.
 * - $display_mode
 *   - COMMENT_MODE_FLAT
 *   - COMMENT_MODE_THREADED
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess_comment_wrapper()
 * @see theme_comment_wrapper()
 */
// Realiando a interação
foreach($content['comments'] AS $value){
  if(is_array($value) && !empty ($value["#comment"]->cid)){
?>
    <div class="comment clearfix">
        <!--<h3><a href="/comment/<?= $value["#comment"]->cid ?>#comment-<?= $value["#comment"]->cid ?>" class="permalink" rel="bookmark">Sucesso!!!</a></h3>-->
        <div class="emissor col igd_11">
          <p><?= $value["#comment"]->name ?></p> <span><?= date("d-m-Y - H:i", $value["#comment"]->created) ?></span>
        </div>
        <div class="content">
            <div class="field field-name-comment-body field-type-text-long field-label-hidden">
                <div class="comentario">
                  <p>
                     <?= $value["#comment"]->comment_body["und"][0]["value"] ?>
                  </p>
                </div>
            </div>
        </div>
<!--              <ul class="links inline">
            <li class="comment-delete first"><a href="/comment/<?= $node->nid ?>/delete">apagar</a></li>
            <li class="comment-edit"><a href="/comment/<?= $node->nid ?>/edit">editar</a></li>
            <li class="comment-reply last"><a href="/comment/reply/<?= $node->nid ?>/<?= $value['#comment']->uid?>">responder</a></li>
        </ul>-->
    </div>
<?php
    }
  }
?>
<div class="ulPagiComent">
  <?php
     print theme('pager',array('tags' => array()));
  ?>
</div>
<?php
if($logged_in):
?>
    <div class="divMiniForm col igd_11">
      <span class="erroMensagem" style="display: none">Comentário cadastrado com sucesso!!!</span>
      <span class="acertoMensagem" style="display: none">Erro: Favor tentar novamente!!!</span>
      <a href="#" id="btSair"  class="sair">sair</a>
      <div>
        <form action="<?= base_path().'comment/reply/'.$node->nid ?>" method="post" accept-charset="UTF-8" id="frmComment" onsubmit="return validComment();" class="comment-form">
          <ul>
            <li>
              <label for="edit-author--2">Seu nome </label>
              <span property="foaf:name" typeof="sioc:UserAccount" about="/user/<?= $user->uid ?>" xml:lang="" class="username" title="Ver perfil do usuário."><?= $user->name ?></span>
            </li>
            <div style="display: none">
              <label for="edit-subject">Assunto </label>
              <input type="text" class="form-text obrigatorio" maxlength="64" size="60" value="<?=  $node->title ?>" name="subject" id="edit-subject">
            </div>
            <li id="edit-comment-body">
              <label for="edit-comment-body-und-0-value" >Coment&aacute;rio *</label>
              <textarea rows="12" cols="60" name="comment_body[und][0][value]" id="edit-comment-body-und-0-value" class="text-full form-textarea required obrigatorio"></textarea>
            </li>
            <li>
              <input type="hidden" name="form_token" value="<?= $content['comment_form']['form_token']['#value']; ?>" />
              <input type="hidden" name="form_build_id" value="<?= $content['comment_form']['form_build_id']['#value']; ?>" />
              <input type="hidden" name="form_id" value="<?= $content['comment_form']['form_id']['#value']; ?>">
              <input type="hidden" name="form_id" value="<?= $content['comment_form']['form_id']['#value']; ?>">
            </li>
            <li>
               <div>
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
             </li>
            <li>
              <input type="submit" class="form-submit" value="Salvar" name="op" id="edit-submit">
            </li>
            <li>
              <div id="strMsg" class="alerta"  style="display: none"><span>Enviando:</span> <img src='/sites/igpernambuco.leiaja.com/themes/ig/img/carregando4.gif' id='imgLoad' /></div>
            </li>
          </ul>
        </form>
        </div>
    </div>
<?php
endif; 
?>

<script type="text/javascript">
(function ($) {
  $(document).ready(function(){
      
      /**
       * Método de cadastro comun  todos
       */
//      $("#btEnviar").click(function(){
//          var parar = false;
//          // Válidando os campos
//          $(".obrigatorio").each(function(){
//              if($(this).val() == "" || $(this).val() == 0){
//                // Incluindo a classe de erro no input
//                $(this).addClass("erroInput");
//                parar = true;
//              }else{
//                // Removendo a classe de erro no input
//                $(this).removeClass("erroInput");
//              }
//          });
//          
//        $("#strMsg").html("Enviando...");
//        if(parar == false){// Se os campos estiverem preenchidos
//          // Url para submissão
//          var strUrl = $("#formCadastro").attr("action");
//          $("#btEnviar").hide();
//          $.post(strUrl,$("#formCadastro").serialize(),function(arrRetorno){
//            if(arrRetorno.bolRetorno){
//              $(".erroMensagem").html(arrRetorno.strMensagem).hide();
//              $(".acertoMensagem").html(arrRetorno.strMensagem).show();
//              parent.location.reload();
//            }else{
//               $(".erroMensagem").html(arrRetorno.strMensagem).show();
//            }
//            $("#btEnviar").show();  
//          },'json');
//        }else
//          $(".erroMensagem").html("Favor Preencher os campos em obrigatorios*").show();
//        
//        return false;
//      });
      
      // Caso o campo obrigatorio não tenha sido preenchido
      $(".obrigatorio").blur(function(){
          if($(this).val() == "" || $(this).val() == 0){
            $(this).addClass("erroInput");
            $(".erroMensagem").html("Favor Preencher os campos em obrigatorios*").show();
            parar = true;
          }else{
            $(this).removeClass("erroInput");
          }
      });
      
      $(".form-submit").click(function(){
          var parar = false;
          // Válidando os campos
          $("#frmComment").find(".obrigatorio").each(function(){
              if($(this).val() == "" || $(this).val() == 0){
                $(this).addClass("erroInput");
                parar = true;
              }else{
                 $(this).removeClass("erroInput");
              }
          });
          
          if(!parar){
            // Escondendo a mensagem de erro
            $(".erroMensagem").hide();
            // Mensagem de carregando
            $("#strMsg").show();
            // desabilitando o botão
            $(".form-submit").attr("disabled", "disabled");
            // Postando os dados do form de submit
            $.post("/comentario/salvar?id=<?= $node->nid ?>",
              $("#frmComment").serializeArray(),
              function(arrRetorno){
                // Escondendo o carregando
                $("#strMsg").hide();
                
                // caso de tudo certo
                if(arrRetorno.bolRetorno){
                  // Setando a mensagem de retorno
                  $(".erroMensagem").html(arrRetorno.strMensagem).hide();
                  $(".acertoMensagem").html(arrRetorno.strMensagem).show();
                  document.location.reload();
                }else{
                  $(".erroMensagem").html(arrRetorno.strMensagem).show();
                  $(".form-submit").removeAttr("disabled");
                }
              }
            ,"json");
          }else
            $(".erroMensagem").html("Favor Preencher os campos em obrigatorios*").show();
          
          return false;
      });
      
      /**
       * Método de cadastro comun  todos
       */
      $("#btSair").click(function(){
          if(confirm("Deseja Sair?")){
            // Mensagem de carregando
            $("#strMsg").show();
            $.post("/usuario/logout",$("#formCadastro").serialize(),function(arrRetorno){
                // Mensagem de carregando
                $("#strMsg").hide();
                parent.location.reload();
            },'json');
          }
          return false;
      });
  });
})(jQuery);
</script>
