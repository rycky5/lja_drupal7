<?php

/**
 * Arquivo de notícia
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */
// Incluindo os arquivos necessários
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'ig') .'/template.api.inc';

@$_SESSION["strUrlOringem"] = url(drupal_lookup_path('alias',"node/".$node->nid));

?>

<script type="text/javascript" src="https://apis.google.com/js/plusone.js"> {lang: 'pt-BR'}</script>

  <!-- coluna esquerda -->
  <div class="esquerda col igd_12">
    <div class="titulo col igd_12">
      <h1 style="font-weight: bold"><a href="javascript:void(0)"><?= $node->title ?></a></h1>
      <h3><?= (!empty ($node->body["pt-br"])) ? $node->body["pt-br"][0]['summary'] : $node->body["und"][0]['summary']; ?></h3>
      <h2>
        <?php 
          if(empty($node->field_fonte[$node->language][0]['value'])){
            echo $name ;
          }else{
            $file = drupal_get_path('theme', 'ig').'/img/'.semAcentos($node->field_fonte[$node->language][0]['value']).'.jpg';
            if(file_exists($_SERVER['DOCUMENT_ROOT'].base_path().$file)){
              echo "<img height='18' src='/$file' title='".$node->field_fonte[$node->language][0]['value']."'>";
            }else{
              echo '<strong>'.$node->field_fonte[$node->language][0]['value'].'</strong>';
            }
          }
//          if($jornalista == 'true'){
//            echo ' por <strong>'.$node->name.'</strong>';
//          }
        ?> - 
          <?= ($node->created  < $node->revision_timestamp) ? preg_replace("/[^0-9\/\:\s]/", "", format_date($node->revision_timestamp, 'medium')) : $date  ?>
      </h2>
    </div>
    <div id="fb-root"></div>
    <div class="redes igd_12 linha">
      <div class="compartilhaRedes">
         <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="leiajaonline">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
         <g:plusone size="medium"></g:plusone>
         <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));</script>
          <div class="fb-like" data-send="false" data-layout="standard" data-width="250" data-href="<?= 'http://pernambuco.ig.com.br'.$node_url ?>" data-show-faces="false" data-colorscheme="light" data-action="recommend"></div>
      </div>
    </div>
    <div class="texto col igd_12 linha">
      <?php
        // Liguagem
        $strLinguagem = (!empty ($node->field_image[$node->language])) ? $node->language : "und";
        // Caso tenha um campo de imagem setada
        if(!empty ($node->field_image) && count($node->field_image[$strLinguagem]) == 1 && in_array($node->type, array_flip(getCadernos()))){
          // Array que conterá os valores que a serem subistituidos
          $strSubstituicaoGaleria      = render($content['field_image']) . getEmbedNoticia($node, "imagem");
          
          // Formatando a node
          $objNodeFormatado = api_formataNodeCapa($node);
      ?>
          <div class="imgGrande igd_12">

            <?php 
              // Exibindo a imagem
              api_geraImagem($objNodeFormatado, 'interna_noticia_280_187', 280, 187); 
            ?>
            <?php
              if(!empty ($node->field_image[$strLinguagem][0]['title'])){
            ?>
                <strong>
                  <?= $node->field_image[$strLinguagem][0]['title'] ?>
                  <?php
                    if(!empty ($node->field_image[$strLinguagem][0]['alt'])){
                  ?>
                      | Foto: <?= $node->field_image[$strLinguagem][0]['alt'] ?>
                  <?php
                    }
                  ?>
                </strong>
            <?php
              }
            ?>
          </div>
      <?php
        }
          // Chamando a função que irá renderizar galeria o vídeo ou o podcast 
          api_rederMultimidia($content, $node);

          // Printando o content
          print str_replace('##RECOMENDA##', "",render($content['body'])); 
       ?>
    </div>
    <div class="redes igd_12 linha">
      <div class="compartilhaRedes">
         <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="leiajaonline">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
         <g:plusone size="medium"></g:plusone>
         <div class="fb-like" data-send="false" data-layout="standard" data-href="<?= 'http://pernambuco.ig.com.br'.$node_url ?>" data-width="250" data-show-faces="false" data-colorscheme="light" data-action="recommend"></div>
      </div>
    </div>
<!--     /Compartilhar redes sociais -->

    <div class="comentario igd_12">
       <!-- Div Listagem de tags -->
    <div class="tagsExibir linha">
      <h5><strong>Leia tudo sobre:</strong></h5>
      <ul class="tags">
        <?php
          // Verificand a linguagem
          $strLinguagem = !empty ($node->field_tags['und']) ? "und" :  "pt-br";
          
          // Caso as tags existam
          if(isset($node->field_tags[$strLinguagem])){
            foreach($node->field_tags[$strLinguagem] as $not){
              if(!empty($not['taxonomy_term']->tid)):
        ?>
                <li><a href="http://www.leiaja.com<?= url(drupal_lookup_path('alias',"taxonomy/term/".$not['taxonomy_term']->tid)); ?>" title=""><?= $not['taxonomy_term']->name;?></a></li>
  	<?
             endif;
            }
          }
        ?>
      </ul>
    </div>
    <!-- /div Lista de Tags -->
    <?php
       if(1 != 1){
    ?>     
    <!-- Mensagem comentário -->
    <span>ANTES DE ESCREVER SEU COMENTÁRIO, LEMBRE-SE: o iG não publica comentários ofensivos, obscenos, que vão contra a lei, que não tenham o remetente identificado ou que não tenham relação com o conteúdo comentado. Dê sua opinião com responsabilidade!</span>
    <div id="comments" class="comment-wrapper">
       <?php
//          print render($content['comments']);
                                  // Recuperando a sessão do usuário
//          if(!$logged_in && ($user == null || $GLOBALS['user']->uid == 0)){
        ?>
        <div class="divMiniForm col igd_12">
          <h3>Para comentar é necessário efetuar o login no fomulario abaixo.</h3>
          <br />
          <h3>Caso não tenha login <a style="color: #1473A7;" href="http://igpernambuco.leiaja.com/cadastro?node=true">Cadastre-se</a></h3>
          <br />
          <span class="erroMensagem" style="display: none">Comentário cadastrado com sucesso!!!</span>
          <span class="acertoMensagem" style="display: none">Erro: Favor tentar novamente!!!</span>
          
          <form class="comment-form" action="/usuario/login" method="post" id="formCadastro" accept-charset="UTF-8">
              <ul>
                 <li>
                  <label for="strLogin">Login:</label>
                  <input type="text" name="strLogin" id="strLogin" class="strLogin obrigatorio"/>
                 </li>
                 <li>
                  <label for="strSenha">Senha:</label>
                  <input type="password" name="strSenha" id="strSenha" class="strSenha obrigatorio"/>
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
                 <li><input type="submit" value="Logar" id="btEnviar" /></li>
                 <li>
                  <div id="strMsg" class="alerta" style="display: none"><span>Enviando:</span> <img src='/sites/igpernambuco.leiaja.com/themes/ig/img/carregando4.gif' id='imgLoad' /></div>
                </li>
              </ul>
          </form>
        </div>
      </div>
    <?php
      }
     ?>
    </div>
<script type="text/javascript">
(function ($) {
  $(document).ready(function(){
      
      /**
       * Método de cadastro comun  todos
       */
      $("#btEnviar").click(function(){
        var parar = false;
        // Válidando os campos
        $(".obrigatorio").each(function(){
            if($(this).val() == "" || $(this).val() == 0){
              $(this).addClass("erroInput");
              parar = true;
            }else{
               $(this).removeClass("erroInput");
            }
        });
        if(parar == false){// Se os campos estiverem preenchidos
          // Escondendo a mensagem de erro
          $(".erroMensagem").hide();//
          // Url para submissão
          var strUrl = $("#formCadastro").attr("action");
          $("#btEnviar").hide();
          // mostrando o carregando
          $("#strMsg").show();
          $.post(strUrl,$("#formCadastro").serialize(),function(arrRetorno){
            // Escondendo o carregando
            $("#strMsg").hide();
            // Escondendo a mensagem de erro
            $(".erroMensagem").hide();
            if(arrRetorno.bolRetorno){
              // Setando a mensagem de retorno
              $(".erroMensagem").html(arrRetorno.strMensagem).hide();
              $(".acertoMensagem").html(arrRetorno.strMensagem).show();
              document.location.reload();
            }else{
              $(".erroMensagem").html(arrRetorno.strMensagem).show();
              $(".form-submit").removeAttr("disabled");
            }
            // Reezibindo o botão
            $("#btEnviar").show();  
          },'json');
        }else{
          $(".erroMensagem").html("Favor Preencher os campos em obrigatorios*").show();
        }
        return false;
      });
  });
})(jQuery);
</script>

<?php 
  // Printando o recomenda
  print recomenta($node, true); 
?>
</div>
<!-- /coluna esquerda -->

<!-- #NoticiaGerada# -->