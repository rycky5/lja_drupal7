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
?>
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
</script>
  	<div class="divPreviewTop">
    	<h1 class="logo"></h1>
      <?= render($vBlockBannerPreview) ?>
      <div class="barraPreview">
        <a id="aImprimirPreview" title="Imprimir" class="btImprimir" href="javascript:void(0);"></a>
        <span class="spanCompartilhar">|</span>
        <a id="aMenoZoom" title="Menos Zoom" class="btMenosZoom" href="javascript:void(0);"></a>
        <span class="spanCompartilhar">|</span>
        <a id="aMaisZoom" title="Mais Zoom" class="btMaisZoom" href="javascript:void(0);"></a>
        <div class="compartilhaRedes">
          <span>Compartilhar:</span>
          <a href="javascript:void(0);" class="facebook" onclick="window.open(shareSocial.facebook.url, shareSocial.facebook.name, shareSocial.facebook.params)"></a>
          <a href="javascript:void(0);" class="twitter" onclick="window.open(shareSocial.twitter.url, shareSocial.twitter.name, shareSocial.twitter.params)"></a>
        </div>
      </div>
    </div>
    <div id="divPreviewNoticia" class="divPreviewNoticia tamanhoMedio <?= $node->type ?>">
    	<h2 class="tituloNoticia"><?= $title ?></h2>
      <h3 class="descricaoNoticia"><?= $node->body[$node->language][0]['summary']; ?></h3>
      <h5 class="autorNoticia">
      <?
      $file = drupal_get_path('theme', 'leiaja').'/images/'.semAcentos($node->field_fonte[$node->language][0]['value']).'.jpg';
      if(empty($node->field_fonte[$node->language][0]['value'])){
      	echo $name;
      }else{
        if(file_exists($_SERVER['DOCUMENT_ROOT'].base_path().$file)){
	  echo "<img height='18' width='61' src='".base_path(true)."/$file' title='".$node->field_fonte[$node->language][0]['value']."'>";
	}else{
	  echo '<strong>'.$node->field_fonte[$node->language][0]['value'].',</strong>';
	};
      }
      ?> | <?= $date ?>
      <? if($vDataRevisao = getRevisao($node->nid)): ?>
        | <i>Atualizada em: <?= $vDataRevisao; ?></i>
      <? endif; ?>
      </h5>
      <?php if(!empty($node->field_image[$node->language][0]['uri'])) : ?>
        <div class="containerImgPreview">
          <?php if(!empty($node->field_image[$node->language][0]['alt'])) :?>
            <span class="creditoFoto">Foto: <?= $node->field_image[$node->language][0]['alt'] ?></span>
          <?php endif; ?>
          <img src="<?= image_style_url('medium', $node->field_image[$node->language][0]['uri']); ?>" title="<?= $node->field_image[$node->language][0]['title'] ?>" />

          <?php if(!empty($node->field_image[$node->language][0]['title'])) : ?>
            <strong class="tituloFoto"><?= $node->field_image[$node->language][0]['title'] ?></strong>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <?php print str_replace('##RECOMENDA##','',render($content['body'])); ?>
      <div class="containerButtonIntegra">
      	<a href="http://<?= $_SERVER['SERVER_NAME'].$node_url ?>" title="Leia na &Iacute;ntegra">Leia na &Iacute;ntegra</a>
      </div>
    </div>
    <script type="text/javascript">
      (function ($) {
    	    // Versão de Impressão
    	    $("#aImprimirPreview").bind("click", function () {
    	        abreJanela("http://<?= $_SERVER['SERVER_NAME'].$node_url ?>?print=true");
    	    });

    	    // Acessibilidade no preview (zoom).
    	    $("#aMenoZoom").bind("click", function () {
    	      vZoomPosicao--;
    	      if (vClassesZoom[vZoomPosicao] != undefined) {
    	        vClasseAntiga = vClassesZoom[vZoomPosicao + 1];
    	        vClasseAtiva = vClassesZoom[vZoomPosicao];

    	        $('#divPreviewNoticia').removeClass(vClasseAntiga).addClass(vClasseAtiva);
    	      } else {
    	        alert("Você já está no tamanho mínimo.");
    	        vZoomPosicao++;
    	      }
    	    });

            var vZoomPosicao = 1;
            var vClassesZoom = new Array('tamanhoMinimo', 'tamanhoMedio', 'tamanhoGrande', 'tamanhoEnorme');

    	    $("#aMaisZoom").bind("click", function () {
    	      vZoomPosicao++;
    	      if (vClassesZoom[vZoomPosicao] != undefined) {
    	        vClasseAntiga = vClassesZoom[vZoomPosicao - 1];
    	        vClasseAtiva = vClassesZoom[vZoomPosicao];

    	        $('#divPreviewNoticia').removeClass(vClasseAntiga).addClass(vClasseAtiva);
    	      } else {
    	        alert("Você já está no tamanho máximo.");
    	        vZoomPosicao--;
    	      }
    	    });

	 })(jQuery);
    </script>