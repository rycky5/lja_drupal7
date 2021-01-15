<?php
// Criando a constant pra estatico
$strUrlStatic = "http://static1.leiaja.com/";

require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja') .'/template.api.inc';


// Pegando alinguagem do campo
$strLinguagem = key($node->field_galeria_full);

// Setando margin top negativo pra coluna da direita caso não tenha galeria
$strEstilo = (!empty($node->field_galeria_full[$strLinguagem][0]["value"])) ? "" : 'style="width: 625px;"';

// Recuperando o subcaderno da notícia
$strField = api_getCategoriaNode($node->type);

// Criando o objeto
$objCetegoria = $node->{$strField};

if(!empty ($objCetegoria)){
  
  // Recuperando o objeto taxonomia
  $objTaxonomia = taxonomy_term_load($objCetegoria[key($objCetegoria)][0]["tid"]);
  
  // Lendo o vocabulário da base
  $objVocabulario = taxonomy_vocabulary_load($objTaxonomia->vid);
  
?>
  <!--Brad camb-->
  <div class="divMapeamento" style="display: block">
    <ul>
      <li><a title="Leia Já" href="<?= base_path() ?>">LeiaJá</a><span class="seta"></span></li>
        <li>
          <a title="<?= $objVocabulario->name ?>" href="<?= base_path() . $objVocabulario->machine_name ?>">
            <?= $objVocabulario->machine_name ?>
          </a><span class="seta"></span></li>
        <li>
          <a class="active" title="<?= $objTaxonomia->name ?>" href="<?= url(drupal_lookup_path('alias', 'taxonomy/term/' . $objTaxonomia->tid)) ?>">
            <?= $objTaxonomia->name ?>
          </a>
        </li>
    </ul>
    <div class="divContentMapeamento"> <a id="aRecomendarTopo" title="Recomendar" href="javascript:void(0);">Recomendar</a> <a id="aRecomendarTopoBotao" class="btCompartilhar" title="Recomendar" href="javascript:void(0);"></a> <span>|</span> <a id="aPrintTopo" title="Imprimir" href="javascript:void(0);">Imprimir</a> <a id="aPrintTopoBotao" class="btImprimir" title="Imprimir" href="javascript:void(0);"></a> </div>
  </div>
  <!--Fim do Brad camb-->
<?php
}
if(!empty($node->field_galeria_full[$strLinguagem][0]) && $node->field_galeria_full[$strLinguagem][0]["value"] == 0){
  $strStylo = (arg(0) != "nodeestatica") ? "" : 'style="width: 650px"';
  echo "<div class='colunaEsquerda' ".$strStylo.">";
}
?>

<script type="text/javascript" src="<?= $strUrlStatic.path_to_theme().'/js/jquery.textareaCounter.js'; ?>"></script>
<script type="text/javascript" src="<?= $strUrlStatic.path_to_theme().'/js/jquery.validate.min.js'; ?>"></script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"> {lang: 'pt-BR'}</script>
<link rel="stylesheet" media="screen" type="text/css" href="<?= $strUrlStatic ?>/sites/all/modules/galleryformatter/gallerystyles/greenarrows/greenarrows.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?= $strUrlStatic ?>/sites/all/modules/galleryformatter/theme/galleryformatter.css" />
<h2 class="tituloNoticia" <?= $strEstilo ?>><span itemprop="name"><?= $title ?></span></h2>

<h3 class="descricaoNoticia" <?= $strEstilo ?>><span itemprop="description"><?= $node->body[$node->language][0]['summary']; ?></span></h3>
<h5 class="autorNoticia" <?= $strEstilo ?>>
 <?
  $file = drupal_get_path('theme', 'leiaja').'/images/'.semAcentos($node->field_fonte[$node->language][0]['value']).'.jpg';
  if(empty($node->field_fonte[$node->language][0]['value'])){
    echo $name;
  }else{
    if(file_exists($_SERVER['DOCUMENT_ROOT'].base_path().$file)){
      echo "<img height='18' width='61' src='http://static1.leiaja.com/$file' title='".$node->field_fonte[$node->language][0]['value']."'>";
    }else{
      echo '<strong>'.$node->field_fonte[$node->language][0]['value'].',</strong>';
    };
  }
  ?> | <?= $date ?>
  <? if($vDataRevisao = getRevisao($node->nid)): ?>
    | <i>Atualizada em: <?= $vDataRevisao; ?></i>
  <? endif; ?>
</h5>
<script type="text/javascript">
var shareUrl    = 'http://<?= urlencode('www.leiaja.com/'.$node_url) ?>';
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
  jQuery.post('http://www.leiaja.com/ajax/node/share',
              {id:shareId,network:net}, function(rs){}, 'json');
}
</script>
<?php
  if(!empty($node->field_galeria_full[$strLinguagem][0]["value"])){
?>
    <p>&nbsp;</p>
    <div class="colunaEsquerda" <?= (arg(0) != "nodeestatica") ? "" : 'style="width: 650px"'?>>
<?php    
    }
?>
  <div id="divConteudoExibir">
          <div class="compartilhaTop">
        <div class="compartilhaRedes">
          <span>Compartilhar:</span>
          <a href="javascript:void(0);" class="facebook" onclick="window.open(shareSocial.facebook.url, shareSocial.facebook.name, shareSocial.facebook.params);shareIt('facebook');"></a>
          <a href="javascript:void(0);" class="twitter" onclick="window.open(shareSocial.twitter.url, shareSocial.twitter.name, shareSocial.twitter.params);shareIt('twitter');"></a>
        </div>
        <iframe src="http://www.facebook.com/plugins/like.php?app_id=224681850906688&href=<?= urlencode('http://www.leiaja.com/'.$node_url) ?>&amp;send=true&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:235px; height:21px; margin: -1px 0 0;" allowTransparency="true"></iframe>
        <g:plusone size="medium"></g:plusone>
        <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="leiajaonline">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
      </div>
  <div style="float:left;">
      <?php
        hide($content['comments']);
        hide($content['links']);
        hide($content['field_tags']);
        hide($content['field_fonte']);
        hide($content['field_capa']);
        hide($content['field_infografico']);
        hide($content['field_permlink']);
        hide($content['field_redireciona']);
        hide($content['field_videost']);
        hide($content['body']);

      ?>
    </div>

      <div class="textoExibir textoNoticia" style="width: 625px">
        <?php 
          // Exibindo o conteúdo multimídia
          api_rederMultimidia($content, $node);

          // Criando o html do leia também
          $vLeiaTambemHtml = recomenta($node);
              
          // Rederizando o conteúdo multimídia
          print str_replace('##RECOMENDA##',(empty($vLeiaTambemHtml)) ? '' : $vLeiaTambemHtml,render($content['body'])); 

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

  </div>
      <div class="compartilhaBottom">
        <a href="javascript:void(0);" id="aRecomendar" class="btCompartilhar" title="Recomendar"></a>
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
  </div>
  <!-- Enviar correção -->
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
  <!-- Fim Enviar Correção  -->
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
  //    jQuery('#aFaleconosco').bind("click", function(){jQuery('#divComentario').css({display:'none'});})

  (function ($) {
    $(".fechar").bind("click", function(){
      $(this).parent().hide();
      $("#divConteudoExibir,.tagsExibir,#divComentario").fadeIn();
    })

  //  $("#aComentar,#aComentarios").bind("click", function(){
  //    esconder();
  //    $("#divComentario").fadeIn();
  //    subir();
  //  })

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
      $("#divConteudoExibir,.tagsExibir,#divCorrigir,#divRecomendar,#divFaleconosco,#divComentario").hide();
    }

    function subir(){
      $('html, body').animate({scrollTop:50}, 'slow');
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
                  },submitHandler: function(form) {
                    // Recuperando os dados
                    var dados = $(form).serialize();
                    // desabilitando o botão
                    $(".form-submit").attr("disabled", "disabled");
                    $('.areaLoading').show();
                    
                    // Postando para a url
                    $.post("/estatico/comentario.php", dados, function(arrRetorno){
                      // Escondendo o carregando
                      $(".areaLoading").hide();
                      
                      alert(arrRetorno.strMensagem);
                      if(arrRetorno.bolRetono == true){
                        location.reload();
                      }else{
                        // Alterando o captcha
                        javascript:Recaptcha.reload();
                      }
                      // Removendo o disabled do botão
                      $(".form-submit").removeAttr("disabled");
                    },"json");
                    return false;
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
                  } , submitHandler: function(form) {
                    // Recuperando os dados
                    var dados = $(form).serialize();
                    
                    // Postando para a url
                    $.post("/estatico/registro.php", dados, function(arrRetorno){
                      if(arrRetorno.bolRetono == true){
                        alert(arrRetorno.strMensagem);
                        location.reload();
                      }else{
                        // Exibindo a mensagem
                        alert("Erro no Login/Senha!!!");
                        
                        // Alterando o captcha
                        javascript:Recaptcha.reload();
                      }
                    },"json");
                    return false;
                  }
        });  //fim validate


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
</div>