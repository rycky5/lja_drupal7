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

if(!empty($node->field_catnoticia) && $node->field_catnoticia["pt-br"][0]['tid'] == 13){
  echo "<style type='text/css' media='all'>
     @import url('/sites/all/themes/leiaja/css/tabela_pesquisas.css?".rand(1, 1000)."');
   </style><script type='text/javascript' src='/".path_to_theme()."/js/tabela_pesquisas.js?".rand(1, 1000)."'></script>";
}

$urlCompleto = 'http://'.$_SERVER['SERVER_NAME'].$node_url;
?>

<div class="areaFlexivel">
<?php if($node):?>

  <div class="colunaEsquerdaGaleria">
    <h2 class="<?=$node->type == 'blogs_da_redacao'? 'tituloNoticia' : 'tituloNoticiaNode'?>"><span itemprop="name"><a href="<?php print $node_url;?>"><?= $title ?></a></span></h2>
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
        ;
      }
      if($jornalista == 'true'){
        echo 'por <strong>'.$node->name.'</strong>';
      }
      ?> | <?= $date ?>
      <? if($vDataRevisao = getRevisao($node->nid)): ?>
        | <i>Atualizada em: <?= $vDataRevisao; ?> </i>
      <? endif; ?>
    </h5>
    <div class="compartilhaTop">
      <div class="compartilhaRedes">
        <span>Compartilhar:</span><!-- NID =  -->
        <a href="javascript:void(0);" class="facebook" onclick="window.open('http://www.facebook.com/sharer.php?u=<?= $urlCompleto?>','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"></a>
        <a href="javascript:void(0);" class="twitter" onclick="window.open('http://twitter.com/intent/tweet?url=<?= $urlCompleto ?>&text=<?= $title ?>&via=leiajaonline', 'ventanacompartir','toolbar=no,width=550,height=420');"></a>
      </div>
      <iframe src="http://www.facebook.com/plugins/like.php?app_id=224681850906688&href=<?= $urlCompleto?>&amp;send=true&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:235px; height:21px; margin:-1px 0 0;" allowTransparency="true"></iframe>
      <g:plusone size="medium" url="<?= $urlCompleto?>"></g:plusone>
      <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="leiajaonline" url="<?= $urlCompleto?>" >Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    </div>

<script>
  // Load the Azur theme
  Galleria.loadTheme('http://carnaval.leiaja.com/sites/carnaval.leiaja.com/themes/carnaval2013/galleria/themes/azur/galleria.azur.min.js');
  Galleria.configure({
    _locale: {
      show_captions: 'Mostrar legendas',
      hide_captions: 'Ocultar legendas',
      play: 'Iniciar slideshow',
      pause: 'Parar slideshow',
      enter_fullscreen: 'Ver em fullscreen',
      exit_fullscreen: 'Sair do  fullscreen',
      next: 'Próxima imagem',
      prev: 'Imagem anterior',
      showing_image: 'Mostrando imagem %s a %s'
    }
  });
  
  // Initialize Galleria
  Galleria.run('#galleria');
</script>    

  </div>

<!-- Comeco coluna esquerda -->
<div class="colunaEsquerda" <?= (!empty($sem_colunadireita) && $sem_colunadireita) ? 'style="width:950px;"' : ''; ?>>

<div id="divConteudoExibir">
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
      
        // EXIBINDO O VÍDEO DA SAMBATECH CASO EXISTA E SE O MESMO NÃO ESTIVER COM MARCAÇÃO DE POSIÇÃO
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
            api_rederMultimidia($content, $node);
          // Printando o content
          print str_replace('##RECOMENDA##', "",render($content['body'])); 
        ?>
        <?php print render($content['field_anexo']); ?>
      </span>
    </div>
    <!-- ADSENSE -->
    <?php print render($AdsenseTexto);  ?>
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

 <?php endif; //fim da condição de node ?>

</div> <!-- Fim coluna esquerda -->
</div> <!-- Fim areaFlexivel -->