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
 * - $submitted: Submission information created from $name and $date during>>>>>>>
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

require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja') .'/template.api.inc';

if(!empty($node->field_catnoticia) && $node->field_catnoticia["pt-br"][0]['tid'] == 13){
  echo "<style type='text/css' media='all'>
     @import url('/sites/all/themes/leiaja/css/tabela_pesquisas.css?".rand(1, 1000)."');
   </style><script type='text/javascript' src='/".path_to_theme()."/js/tabela_pesquisas.js?".rand(1, 1000)."'></script>";
}

// Parse no id da node
$intNid = (int) arg(1);

// Pegando alinguagem do campo
$strLinguagem = key($node->field_galeria_full);

// Setando margin top negativo pra coluna da direita caso não tenha galeria
$strEstilo = (!empty($node->field_galeria_full[$strLinguagem]) && $node->field_galeria_full[$strLinguagem][0]["value"] == 1) ? 'style="width: 625px;"' : "" ;

// Recuperando o subcaderno da notícia
$strField = api_getCategoriaNode($node->type);

if(!empty ($node->{$strField})){
  // Criando o objeto
  $objCetegoria = $node->{$strField};

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
  <!-- Fim do Brad camb -->
<?php
}

if(empty($node->field_galeria_full[$strLinguagem]) ||  $node->field_galeria_full[$strLinguagem][0]["value"] == 0){
      echo '<div class="colunaEsquerda">';
}
// Caso for notícia estática
if(arg(0) == "nodeestatica"){
?>
  <script type="text/javascript" src="http://static1.leiaja.com/sites/all/modules/galleryformatter/theme/infiniteCarousel.js"></script>
  <script type="text/javascript" src="http://static1.leiaja.com/sites/all/modules/galleryformatter/theme/galleryformatter.js"></script>
<?php
}
?>

<script type="text/javascript" src="http://static1.leiaja.com/sites/all/themes/leiaja/js/jquery.textareaCounter.js"></script>
<script type="text/javascript" src="http://static1.leiaja.com/sites/all/themes/leiaja/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"> {lang: 'pt-BR'}</script>
<link rel="stylesheet" media="screen" type="text/css" href="http://static1.leiaja.com/sites/all/modules/galleryformatter/gallerystyles/greenarrows/greenarrows.css" />
<link rel="stylesheet" media="screen" type="text/css" href="http://static1.leiaja.com/sites/all/modules/galleryformatter/theme/galleryformatter.css" />
<?php if($node):?>
<!-- PRINT -->
  <h2 class="<?=$node->type == 'blogs_da_redacao'? 'tituloNoticia' : 'tituloNoticiaNode'?>" <?= $strEstilo ?>><span itemprop="name"><?= $title ?></span></h2>
  <h3 class="<?=$node->type == 'blogs_da_redacao'? 'descricaoNoticia' : 'descricaoNoticiaInterna'?>" <?= $strEstilo ?>><?= $node->body[$node->language][0]['summary']; ?></h3>
  <h5 class="autorNoticia" <?= $strEstilo ?>>
      <?
      $file = drupal_get_path('theme', 'leiaja').'/images/'.semAcentos($node->field_fonte[$node->language][0]['value']).'.jpg';
      if(empty($node->field_fonte[$node->language][0]['value'])){
      	echo $name;
      }else{
        if(file_exists($_SERVER['DOCUMENT_ROOT'].base_path().$file)){
		  echo "<img height='18' src='/$file' title='".$node->field_fonte[$node->language][0]['value']."'>";
        }else{
          echo '<strong>'.$node->field_fonte[$node->language][0]['value'].',</strong>';
        }
      }
      if($jornalista == 'true'){
        echo 'por <strong>'.$node->name.'</strong>';
      }
      ?> | <?= $date ?>
      <? if($vDataRevisao = getRevisao($node->nid)): ?>
        | <i>Atualizada em: <?= $vDataRevisao; ?> </i>
      <? endif; ?>
    </h5>
    <script type="text/javascript">
      var shareUrl    = 'http://<?= urlencode("www.leiaja.com".$node_url) ?>';
      var shareId     = <?= $node->nid ?>;
      var shareSocial = {facebook : {url    : 'http://www.facebook.com/share.php?app_id=224681850906688&u='+shareUrl,
                                                 params : 'toolbar=no,width=700,height=400',
                                                 name   : 'facebook'},
                         twitter  : {url    : 'http://twitter.com/intent/tweet?original_referer=' + shareUrl + '&url=' + shareUrl + '&text=<?= $title ?>&via=leiajaonline',
                                     params : 'toolbar=no,width=550,height=420',
                                     name:'Twitter'}
                              };
    </script>
    <div class="compartilhaTop">
      <div class="compartilhaRedes">
        <span>Compartilhar:</span><!-- NID =  -->
        <a href="javascript:void(0);" class="facebook" onclick="window.open(shareSocial.facebook.url, shareSocial.facebook.name, shareSocial.facebook.params);"></a>
        <a href="javascript:void(0);" class="twitter" onclick="window.open(shareSocial.twitter.url, shareSocial.twitter.name, shareSocial.twitter.params);"></a>
      </div>
      <iframe src="http://www.facebook.com/plugins/like.php?app_id=224681850906688&href=<?= urlencode('http://www.leiaja.com'.$node_url) ?>&amp;send=true&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:235px; height:21px; margin:-1px 0 0;" allowTransparency="true"></iframe>
      <g:plusone size="medium"></g:plusone>
      <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="leiajaonline">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    </div>
    <p>&nbsp;</p>
<?php
    // Pegando alinguagem do campo
    $strLinguagem = key($node->field_galeria_full);
    
    // Se a notícia estiver setada para abrir em galeria full
    if(!empty($node->field_galeria_full[$strLinguagem]['0']['value']) && $node->field_galeria_full[$strLinguagem]['0']['value'] == 1 && count($node->field_image[$node->language]) > 1){
      getGaleriaFull($node);
    }
    
    if(!empty($node->field_galeria_full[$strLinguagem]['0']['value']) && $node->field_galeria_full[$strLinguagem]['0']['value'] == 1):
?>
    <p>&nbsp;</p>
    <div class="colunaEsquerda">
<?php endif; ?>
  <div id="divConteudoExibir">
      <?php 
        // Caso tenha alguma imagem ou uma galeria de imagens setada e não estiver marcado nenhuma posição de galeria
         if(!empty($node->field_image) && count($node->field_image[key($node->field_image)]) == 1 && !strstr($node->body[$node->language][0]["value"], "[@#galeria#@]")) : ?>
          <?php if(!empty($node->field_image[$node->language][0]['alt'])) :?>
              <span style="color: #999999;float: right;font-family: Arial,Helvetica,sans-serif;font-size: 10px;margin: 0 0 3px;">
                Foto: <?= $node->field_image[$node->language][0]['alt'] ?>
              </span>
          <?php 
                endif; 
                
                $img = array();
                $img['style']='large';
                $img['uri']=$node->field_image[$node->language][0]['uri'];
//                $img['class']=array('imgH6Grande');
                $img['alt']=$node->field_image[$node->language][0]['title'];
                $img['title']=$node->field_image[$node->language][0]['title'];
                $img['width']="625";
                $img['height']="470";

                image_static_lazy($img);
          ?>
          <?php 
              if(!empty($node->field_image[$node->language][0]['title'])) : ?>
                  <strong class="tituloFoto"><?= $node->field_image[$node->language][0]['title'] ?></strong>
          <?php 
              endif;
        endif; 
        ?>


      <div class="textoExibir textoNoticia">
        <span itemprop="description">
          <?php 
              // Exibindo o conteúdo multimídia
              api_rederMultimidia($content, $node);
              
              // Criando o html do leia também
              $vLeiaTambemHtml = recomenta($node);

              // Caso a notícia possúa o leia tbm faço a troca
              print str_replace('##RECOMENDA##',(empty($vLeiaTambemHtml)) ? '' : $vLeiaTambemHtml,render($content['body'])); 
          
              // Caso tenha um anexo
              if(!empty ($node->field_anexo[key($node->field_anexo)])){
                // Lendo o arquivo
                $objFile = file_load($node->field_anexo[key($node->field_anexo)][0]["fid"]);
                
       ?>
                <div class="field field-name-field-anexo field-type-file field-label-above">
                  <div class="field-label">Anexo:&nbsp;</div>
                  <div class="field-items">
                    <div class="field-item even">
                      <span class="file">
                        <img class="file-icon" alt="" title="" src="/modules/file/icons/application-octet-stream.png">
                        <a href="<?= file_create_url($objFile->uri) ?>" type="; length=" title="<?= $objFile->title ?>"><?= $node->field_anexo[key($node->field_anexo)][0]["description"] ?></a>
                      </span>
                    </div>
                  </div>
                </div>
       <?php
              }
          ?>
        </span>
      </div>
      <!-- ADSENSE -->
      <?php print render($AdsenseTexto);  ?>
  </div>
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
  <!-- Comentários -->
  <div class="containerAcoes" id="divComentario">
      <div class="fb-comments" data-href="<?= 'http://www.leiaja.com'.$node_url ?>" data-numposts="10" data-colorscheme="light"></div>  
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

      <?php 
      //nome da view:
      $nameView = "ultimas_noticias";
      //displayName da view:
      $displayName = 'subcadernos';
      //array de cadernos
      $cadernos  =  array("caderno_noticias"=>'noticia',"caderno_politica"=>'politica',"caderno_carreiras"=>'negocios',"caderno_esportes"=>'esporte',"caderno_cultura"=>'cultura',"caderno_tecnologia"=>'tecnologia',"caderno_multimidia"=>'multimidia');
      //setando o caderno a qual os nodes devem ser retornados;
      $caderno = $cadernos[$node->type];
      //setando a view;
      $view = views_get_view($nameView);
      //setando o id do node para não ser exibido na lista;
      $view->display[$displayName]->display_options["filters"]["nid"]["value"]["value"]=$node->nid;
      //setando o caderno a ser retornado no campo.
      $categoria  = "field_cat".$caderno;
      //pegando o campo e adicionando
      $campo  = $categoria."_tid";
      //setando o $id_taxonomia;
      $id_taxonomia = $node->{$categoria}["pt-br"][0]["tid"];
      //name da subcategoria
      $subcatName = $node->{$categoria}["pt-br"][0]["taxonomy_term"]->name;
      //setando o $id_taxonomia no display do campo correto
      $view->display[$displayName]->display_options["arguments"][$campo]["default_argument_options"]["argument"] = $id_taxonomia;
      //setando o display desejado.
      $view->set_display($displayName);
      $view->pre_execute();
      $view->execute();
      //setando o resultado da view na variavel vUltimasSubcategoria;
      $vUltimasSubcategoria = $view->result;

      if(!empty($vUltimasSubcategoria)) : ?>
        <div class="ultimasExibir">
          <h3>Ultimas Not&iacute;cias <?= $subcatName ?></h3>
          <ul class="ultimas">
          <?php foreach($vUltimasSubcategoria as $ult){ ?>
            <li><span>&raquo;</span><a href="<?= url(drupal_lookup_path('alias',"node/".$ult->nid)); ?>" title="<?=$ult->node_title?>"><?= $ult->node_title ?></a></li>
          <?php } ?>
          </ul>
        </div>
      <?php endif; ?>
   <?php endif; ?>

  <script type="text/javascript">
  <!--
  (function ($) {
    $(".fechar").bind("click", function(){
      $(this).parent().hide();
      $("#divConteudoExibir,.tagsExibir,#divComentario").fadeIn();
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
      $("#divConteudoExibir,.tagsExibir,#divCorrigir,#divRecomendar,#divFaleconosco,#divComentario").hide();//#divComentario
    }

    function subir(){
      compartilhaBottom = $(".compartilhaBottom").offset().top;
      compartilha = compartilhaBottom - 84;
      $('html, body').animate({scrollTop:compartilha}, 'slow');
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
          })/*.showErrors: function (errorMap, errorList)
          {
              this.defaultShowErrors();
              $.each(errorList, function (i, error)
              {
                  $(error.element).css("display", "inline");
  //      	        $('.validacaoForm').css("display", "inline");
              });
          }*/;

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
  //-->
  </script>
</div>
<!-- FIM COLUNA DA ESQUERDA -->