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
 * - $submitted: Submission information created from $name and $date during
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

// Pegando alinguagem
$strLinguagem = key($node->field_redireciona);
// Caso a notícia esteja sendo exibida em modo full = interna e o campo redireciona esteja setado
if(!empty ($node->field_redireciona[$strLinguagem][0]['value'])){
    
  // incluindo os arquivos necessários
  module_load_include('inc', 'leiaja', 'leiaja.api');

  // Atualizando os views das notícias
  api_atualizarViewNode($node->nid);

  // Redireciono a notícia para o link setado no campo redireciona
  header('Location: ' . $node->field_redireciona[$strLinguagem][0]['value']);
}

if(!empty($node->field_catnoticia) && $node->field_catnoticia["pt-br"][0]['tid'] == 13){
  echo "<style type='text/css' media='all'>
     @import url('/sites/all/themes/leiaja/css/tabela_pesquisas.css?".rand(1, 1000)."');
   </style><script type='text/javascript' src='/".path_to_theme()."/js/tabela_pesquisas.js?".rand(1, 1000)."'></script>";
}
?>
<script type="text/javascript" src="<?= '/'.path_to_theme().'/js/jquery.textareaCounter.js'; ?>"></script>
<script type="text/javascript" src="<?= '/'.path_to_theme().'/js/jquery.validate.min.js'; ?>"></script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"> {lang: 'pt-BR'}</script>
<link rel="stylesheet" media="screen" type="text/css" href="/sites/all/modules/galleryformatter/gallerystyles/greenarrows/greenarrows.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/sites/all/modules/galleryformatter/theme/galleryformatter.css" />
<?php if($node):?>
<!-- PRINT -->
  <h2 class="<?=$node->type == 'blogs_da_redacao'? 'tituloNoticia' : 'tituloNoticiaNode'?>"><span itemprop="name"><?= $title ?></span></h2>
  <h3 class="<?=$node->type == 'blogs_da_redacao'? 'descricaoNoticia' : 'descricaoNoticiaInterna'?>"><?= $node->body[$node->language][0]['summary']; ?></h3>
  <h5 class="autorNoticia">
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
var shareUrl    = 'http://<?= urlencode($_SERVER['SERVER_NAME'].$node_url) ?>';
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
  jQuery.post('http://<?= $_SERVER['SERVER_NAME']?>/ajax/node/share',
              {id:shareId,network:net}, function(rs){}, 'json');
}
</script>
<div id="divConteudoExibir">
	<div class="compartilhaTop">
      <div class="compartilhaRedes">
        <span>Compartilhar:</span><!-- NID =  -->
        <a href="javascript:void(0);" class="facebook" onclick="window.open(shareSocial.facebook.url, shareSocial.facebook.name, shareSocial.facebook.params);shareIt('facebook');"></a>
        <a href="javascript:void(0);" class="twitter" onclick="window.open(shareSocial.twitter.url, shareSocial.twitter.name, shareSocial.twitter.params);shareIt('twitter');"></a>
      </div>
      <iframe src="http://www.facebook.com/plugins/like.php?app_id=224681850906688&href=<?= urlencode('http://'.$_SERVER['SERVER_NAME'].$node_url) ?>&amp;send=true&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:235px; height:21px; margin:-1px 0 0;" allowTransparency="true"></iframe>
      <g:plusone size="medium"></g:plusone>
      <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="leiajaonline">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    </div>
    <?php 
      // Caso tenha alguma imagem ou uma galeria de imagens setada e não estiver marcado nenhuma posição de galeria
       if(!empty($node->field_image[$node->language][0]['uri']) && !strstr($node->body[$node->language][0]["value"], "[@#galeria#@]")) : ?>
        <?php if(!empty($node->field_image[$node->language][0]['alt'])) :?>
            <span style="color: #999999;float: right;font-family: Arial,Helvetica,sans-serif;font-size: 10px;margin: 0 0 3px;">
              Foto: <?= $node->field_image[$node->language][0]['alt'] ?>
            </span>
        <?php 
              endif; ?>
        <img rel="image_src" src="<?= image_style_url('large', $node->field_image[$node->language][0]['uri']); ?>" title="<?= $node->field_image[$node->language][0]['title'] ?>" />
        <?php 
            if(!empty($node->field_image[$node->language][0]['title'])) : ?>
                <strong class="tituloFoto"><?= $node->field_image[$node->language][0]['title'] ?></strong>
        <?php 
            endif;
      endif; 
      
        // EXIBINDO O V�?DEO DA SAMBATECH CASO EXISTA E SE O MESMO NÃO ESTIVER COM MARCAÇÃO DE POSIÇÃO
       if(!empty($node->field_videost["und"][0]["value"]) && !strstr($node->body[$node->language][0]["value"], "[@#video#@]")){
          
          echo $node->field_videost["und"][0]["value"];
          echo getEmbedNoticia($node, "videost");
       }
         //EXIBINDO O AUDIO DA SAMBATECH CASO EXISTA E SE O MESMO NÃO ESTIVER COM MARCAÇÃO DE POSIÇÃO
       if(!empty($node->field_audiost["und"][0]["value"]) && !strstr($node->body[$node->language][0]["value"], "[@#podcast#@]")){
          echo "<div class='audio-sambatech'>".$node->field_audiost["und"][0]["value"]."</div>";
          echo getEmbedNoticia($node, "audiost");          
       }
       
          ?>
        
        
    <div class="textoExibir textoNoticia">
      <span itemprop="description">
        <?php 
            // Caso esteja marcado alguma posição de galeria 
            if(preg_match("/[@#galeria#@]|[@#video#@]/", $node->body[$node->language][0]["value"])){
              hide($content['field_image']);
              // Array que conterá as hash para ser bustituida
              $strBucaGaleria   = "[@#galeria#@]";

              // Array que conterá os valores que a serem subistituidos
              $strSubstituicaoGaleria      = render($content['field_image']) . getEmbedNoticia($node, "imagem");

              $content["body"][0]["#markup"] = str_replace($strBucaGaleria,(empty($strSubstituicaoGaleria)) ? '' : $strSubstituicaoGaleria, $content["body"][0]["#markup"]);
            }
            
            // Caso esteja marcado alguma posição e vídeo sambatech
            if(preg_match("/[@#video#@]/", $node->body[$node->language][0]["value"])){

              // Array que conterá as hash para ser bustituida
              $strBucaVideo     = "[@#video#@]";

              // linguagem
              $strLinguagem = (!empty ($node->field_videost[$node->language][0]["value"])) ? $node->language : "und";
              
              // Embed de v�deo
              $strSubstituicaoVideo        = utf8_encode('<style>
                                                .videoAtivo {
                                                  background: #4E474C;
                                                  border: 2px solid #423939;
                                                  padding: 3px;
                                                }
                                              </style>

                                              <div class="content">
                                                <div class="colunas1 margin-top4 divMultimidiaBloco">
                                                  <h2 class="tituloH2 cinza"><a href="/multimidia" class="cinza" title="Multim�dia">&nbsp;</a></h2>
                                                  <div class="multimidia" style="width: 640px">
                                                    <span id="v�deo" style="width: 640px">
                                                      <script src="http://player.sambatech.com.br/current/samba-player.js?playerWidth=640&playerHeight=366&ph=5fbc59e8b8b00ec07528a1a61ea38524&m=9a9d2c9c1fd6a13554911204f056a2ff"></script>
                                                    </span>
                                                    <ul class="UlMultimidia">
                                                      <li><a href="javascript:void(0);" ><span class="iconeMultimidiaMaior iconeVidMaior"></span><span class="tituloVideoPlay"> Gerado Julio - Sociedade e Rela��o com a popula��o</span></a></li>
                                                    </ul>
                                                    <!-- Video -->
                                                    <div id="divMnuBlkVideo" style=";" class="container-multimidia-block">
                                                        <ul style="width:1875px">
                                                            <li class="videosMenores videoAtivo">
                                                              <span class="embedVideo" style="display: none">
                                                                <script src="http://player.sambatech.com.br/current/samba-player.js?playerWidth=640&playerHeight=366&ph=5fbc59e8b8b00ec07528a1a61ea38524&m=9a9d2c9c1fd6a13554911204f056a2ff&autoStart=true"></script>
                                                              </span>
                                                              <span class="tituloVideo" style="display: none">
                                                                Gerado Julio - Sociedade e Rela��o com a popula��o
                                                              </span>
                                                              <a href="javascript:void(0);" rel="a1" class="videoMenor" style="text-decoration: none" > 
                                                                <img class="imgH6Grande lazy"  rel=img11 src="http://static1.leiaja.com/sites/all/themes/leiaja/images/Gerald_ Julio_ 1.jpg" width="100" height="75" alt="Gerado Julio - Sociedade e Rela��o com a popula��o" title="Gerado Julio - Sociedade e Rela��o com a popula��o" />
                                                                <h6 class="tagVideo">
                                                                  <span class="iconeMultimidiaMenor iconeVidMenor"></span>
                                                                  <strong rel="strongTag1">Parte 1/7</strong>
                                                                </h6>
                                                                <a href="javascript:void(0);" class="tituloVideo" rel="aTitulo1">
                                                                 Gerado Julio - Sociedade e Rela��o com a popula��o
                                                                </a>
                                                              </a>
                                                            </li>
                                                            <li class="videosMenores">
                                                              <span class="embedVideo" style="display: none">
                                                                <script src="http://player.sambatech.com.br/current/samba-player.js?playerWidth=640&playerHeight=366&ph=5fbc59e8b8b00ec07528a1a61ea38524&m=6a843b58b4655998b53cc4e0042a6373&autoStart=true"></script>
                                                              </span>
                                                              <span class="tituloVideo" style="display: none">
                                                                Geraldo Julio - Aprova��o e Realiza��o de Obras
                                                              </span>
                                                              <a href="javascript:void(0);" rel="a1" class="videoMenor" style="text-decoration: none" > 
                                                                <img class="imgH6Grande lazy"  rel=img11 src="http://static1.leiaja.com/sites/all/themes/leiaja/images/Gerald_ Julio_2.jpg" width="100" height="75" alt="Geraldo Julio - Aprova��o e Realiza��o de Obras" title="Geraldo Julio - Aprova��o e Realiza��o de Obras" />
                                                                <h6 class="tagVideo">
                                                                  <span class="iconeMultimidiaMenor iconeVidMenor"></span>
                                                                  <strong rel="strongTag1">Parte 2/7</strong>
                                                                </h6>
                                                                <a href="javascript:void(0);" class="tituloVideo" rel="aTitulo1">
                                                                  Geraldo Julio - Aprova��o e Realiza��o de Obras
                                                                </a>
                                                              </a>
                                                            </li>
                                                            <li class="videosMenores">
                                                              <span class="embedVideo" style="display: none">
                                                                <script src="http://player.sambatech.com.br/current/samba-player.js?playerWidth=640&playerHeight=366&ph=5fbc59e8b8b00ec07528a1a61ea38524&m=38ee3e213e948a52788a623c7fcde156&autoStart=true"></script>
                                                              </span>
                                                              <span class="tituloVideo" style="display: none">
                                                                Geraldo Julio - Rela��o com a C�mara de Vereadores
                                                              </span>
                                                              <a href="javascript:void(0);" rel="a1" class="videoMenor" style="text-decoration: none" > 
                                                                <img class="imgH6Grande lazy"  rel=img11 src="http://static1.leiaja.com/sites/all/themes/leiaja/images/Gerald_ Julio_3.jpg" width="100" height="75" alt="Geraldo Julio - Rela��o com a C�mara de Vereadores" title="Geraldo Julio - Rela��o com a C�mara de Vereadores" />
                                                                <h6 class="tagVideo">
                                                                  <span class="iconeMultimidiaMenor iconeVidMenor"></span>
                                                                  <strong rel="strongTag1">Parte 3/7</strong>
                                                                </h6>
                                                                <a href="javascript:void(0);" class="tituloVideo" rel="aTitulo1">
                                                                  Geraldo Julio - Rela��o com a C�mara de Vereadores
                                                                </a>
                                                              </a>
                                                            </li>
                                                            <li class="videosMenores">
                                                              <span class="embedVideo" style="display: none">
                                                                <script src="http://player.sambatech.com.br/current/samba-player.js?playerWidth=640&playerHeight=366&ph=5fbc59e8b8b00ec07528a1a61ea38524&m=1576d18cc56d002a16df81ca59c19a4c&autoStart=true"></script>
                                                              </span>
                                                              <span class="tituloVideo" style="display: none">
                                                                Geraldo Julio - D�vidas da antiga gest�o
                                                              </span>
                                                              <a href="javascript:void(0);" rel="a1" class="videoMenor" style="text-decoration: none" > 
                                                                <img class="imgH6Grande lazy"  rel=img11 src="http://static1.leiaja.com/sites/all/themes/leiaja/images/Gerald_ Julio_4.jpg" width="100" height="75" alt="Geraldo Julio - D�vidas da antiga gest�o" title="Geraldo Julio - D�vidas da antiga gest�o" />
                                                                <h6 class="tagVideo">
                                                                  <span class="iconeMultimidiaMenor iconeVidMenor"></span>
                                                                  <strong rel="strongTag1">Parte 4/7</strong>
                                                                </h6>
                                                                <a href="javascript:void(0);" class="tituloVideo" rel="aTitulo1">
                                                                 Geraldo Julio - D�vidas da antiga gest�o
                                                                </a>
                                                              </a>
                                                            </li>
                                                            <li class="videosMenores">
                                                              <span class="embedVideo" style="display: none">
                                                                <script src="http://player.sambatech.com.br/current/samba-player.js?playerWidth=640&playerHeight=366&ph=5fbc59e8b8b00ec07528a1a61ea38524&m=1ee8b99e189c6897622f3b0ad3c00d9d&autoStart=true"></script>
                                                              </span>
                                                              <span class="tituloVideo" style="display: none">
                                                                Geraldo Julio - Implanta��o de Ciclofaixas
                                                              </span>
                                                              <a href="javascript:void(0);" rel="a1" class="videoMenor" style="text-decoration: none" > 
                                                                <img class="imgH6Grande lazy"  rel=img11 src="http://static1.leiaja.com/sites/all/themes/leiaja/images/Gerald_ Julio_5.jpg" width="100" height="75" alt="Geraldo Julio - Implanta��o de Ciclofaixas" title="Geraldo Julio - Implanta��o de Ciclofaixas" />
                                                                <h6 class="tagVideo">
                                                                  <span class="iconeMultimidiaMenor iconeVidMenor"></span>
                                                                  <strong rel="strongTag1">Parte 5/7</strong>
                                                                </h6>
                                                                <a href="javascript:void(0);" class="tituloVideo" rel="aTitulo1">
                                                                  Geraldo Julio - Implanta��o de Ciclofaixas
                                                                </a>
                                                              </a>
                                                            </li>
                                                            <li class="videosMenores">
                                                              <span class="embedVideo" style="display: none">
                                                                <script src="http://player.sambatech.com.br/current/samba-player.js?playerWidth=640&playerHeight=366&ph=5fbc59e8b8b00ec07528a1a61ea38524&m=98580b4b64b6614672bd6ccb52333af6&autoStart=true"></script>
                                                              </span>
                                                              <span class="tituloVideo" style="display: none">
                                                                Geraldo - Educa��o e Prouni do Recife
                                                              </span>
                                                              <a href="javascript:void(0);" rel="a1" class="videoMenor" style="text-decoration: none" > 
                                                                <img class="imgH6Grande lazy"  rel=img11 src="http://static1.leiaja.com/sites/all/themes/leiaja/images/Gerald_ Julio_6.jpg" width="100" height="75" alt="Geraldo - Educa��o e Prouni do Recife" title="Geraldo - Educa��o e Prouni do Recife" />
                                                                <h6 class="tagVideo">
                                                                  <span class="iconeMultimidiaMenor iconeVidMenor"></span>
                                                                  <strong rel="strongTag1">Parte 6/7</strong>
                                                                </h6>
                                                                <a href="javascript:void(0);" class="tituloVideo" rel="aTitulo1">
                                                                  Geraldo - Educa��o e Prouni do Recife
                                                                </a>
                                                              </a>
                                                            </li>
                                                            <li class="videosMenores">
                                                              <span class="embedVideo" style="display: none">
                                                                <script src="http://player.sambatech.com.br/current/samba-player.js?playerWidth=640&playerHeight=366&ph=5fbc59e8b8b00ec07528a1a61ea38524&m=246e1fef04cc819b50db42742e57a504&autoStart=true"></script>
                                                              </span>
                                                              <span class="tituloVideo" style="display: none">
                                                                Geraldo Julio - Tr�nsito e Rod�zio de Carros
                                                              </span>
                                                              <a href="javascript:void(0);" rel="a1" class="videoMenor" style="text-decoration: none" > 
                                                                <img class="imgH6Grande lazy"  rel=img11 src="http://static1.leiaja.com/sites/all/themes/leiaja/images/Gerald_ Julio_7.jpg" width="100" height="75" alt="Geraldo Julio - Tr�nsito e Rod�zio de Carros" title="Geraldo Julio - Tr�nsito e Rod�zio de Carros" />
                                                                <h6 class="tagVideo">
                                                                  <span class="iconeMultimidiaMenor iconeVidMenor"></span>
                                                                  <strong rel="strongTag1">Parte 7/7</strong>
                                                                </h6>
                                                                <a href="javascript:void(0);" class="tituloVideo" rel="aTitulo1">
                                                                  Geraldo Julio - Tr�nsito e Rod�zio de Carros
                                                                </a>
                                                              </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                  <!-- Fim Video -->
                                                  <div class="footerMultimidia">
                                                    <div class="passador">
                                                      <a href="javascript:void(0);" class="passaLeft" data-passador="anterior"></a>
                                                      <a href="javascript:void(0);" class="passaRight" data-passador="proximo"></a>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            <script type="text/javascript" src="http://www.leiaja.com/sites/all/themes/leiaja/js/multimidia.js?831"></script>
                                            <script type="text/javascript" >
                                               // Iniciando o jquery
                                              (function ($) {

                                                  $(document).ready(function(){
                                                    $(".videosMenores").click(function(){

                                                      // Removendo a classe ativa dos objeto
                                                      $(".videosMenores").each(function(){
                                                        $(this).removeClass("videoAtivo");
                                                      });

                                                      // Pegando o embed do v�deo
                                                      var strEmbedVideo = $(this).find(".embedVideo").html();
                                                      var strTituloVideo = $(this).find(".tituloVideo").html();

                                                      // Setando o v�deo e o titulo
                                                      $("#v�deo").html(strEmbedVideo);
                                                      $(".tituloVideoPlay").html(strTituloVideo);

                                                      // Setando no elemento atual a classe ativo
                                                      $(this).addClass("videoAtivo");
                                                    });
                                                  });


                                              })(jQuery);
                                            </script>
                                              </div>');

              // realizando a substituição
              $content["body"][0]["#markup"] = str_replace($strBucaVideo,(empty($strSubstituicaoVideo)) ? '' : $strSubstituicaoVideo, $content["body"][0]["#markup"]);
            }
            
            // Caso esteja marcado alguma posição e audio sambatech
            if(preg_match("/[@#podcast#@]/", $node->body[$node->language][0]["value"])){

              // Array que conterá as hash para ser bustituida
              $strBucaVideo     = "[@#podcast#@]";

              // linguagem
              $strLinguagem = (!empty ($node->field_audiost[$node->language][0]["value"])) ? $node->language : "und";
              $audioST= "<div class='audio-sambatech'>".$node->field_audiost[$strLinguagem][0]["value"]."</div>";
              // Embed de vídeo
              $strSubstituicaoVideo        = $audioST . getEmbedNoticia($node, "audiost");

              // realizando a substituição
              $content["body"][0]["#markup"] = str_replace($strBucaVideo,(empty($strSubstituicaoVideo)) ? '' : $strSubstituicaoVideo, $content["body"][0]["#markup"]);
            }
            
            print str_replace('##RECOMENDA##',(empty($vLeiaTambemHtml)) ? '' : $vLeiaTambemHtml,render($content['body'])); 
        ?>
        <?php print render($content['field_anexo']); ?>
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
      <?php// if($comment == '2'): ?>
<!--        <span class="spanCompartilhar">|</span><a href="javascript:void(0)" id="aComentar" class="btComentar" title="Comentar"></a>
        <span class="spanCompartilhar">(<?//= $comment_count ?>)</span>
        <a href="javascript:void(0)" id="aComentarios" title="Coment&aacute;rios">Coment&aacute;rios</a>-->
      <?php// endif; ?>
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
<?php if($comment == '2'): ## Verifica se comentarios estÃ£o abertos.?>
<!-- ComentÃ¡rios -->
<div class="containerAcoes" id="divComentario">
    
  <?php print render($content['comments']); ?>
    
    <?php if(!$logged_in): ?>
  <div class="contentAcoes">
    <h3>Login</h3>
    <div class="contentFormEsquerda">
      <p>Para enviar coment&aacute;rios &eacute; preciso ser usu&aacute;rio cadastrado.<br />
        <a href="<?= base_path().'cadastro' ?>">Ainda n&atilde;o sou cadastrado, quero fazer o meu registro agora!</a>
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
        <a class="esqueceuSenha" href="<?= base_path() ?>senha">Esqueceu sua senha?</a>
        <button class="form" type="submit" tabindex="3"><span>Entrar</span></button>
        <div class="enviando" style="display:none;">
          <img class="imgEnviando" src="<?= base_path().drupal_get_path('theme', 'leiaja')?>/images/loader.gif" alt="Carregando" />
          <h4>Enviando</h4>
        </div>
      </form>
    </div>
  </div>
<?php endif; ?>
</div>
<!-- Fim bloco comentario -->
<?php endif; ?>
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

//	  if(location.href.indexOf("#comment_form") != -1){
//		$("#divConteudoExibir,.tagsExibir").hide();
//		$("#divComentario").fadeIn();
//		$('html, body').animate({scrollTop:50}, 'slow');
//	  };
console.log($('#inpCorrigirMensagem'));
      $('#inpCorrigirMensagem').textareaCount({'originalStyle' : 'contador1', 'warningStyle' : 'vermelho', 'maxCharacterSize': 700, displayFormat: '#input/#max caracteres'});
      $('#inpComentarioMensagem').textareaCount({'originalStyle' : 'contador1', 'warningStyle' : 'vermelho', 'maxCharacterSize': 140, displayFormat: '#input/#max caracteres'});
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
  		}
	  });


	//validaÃ§Ã£o do formulÃ¡rio de login.
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