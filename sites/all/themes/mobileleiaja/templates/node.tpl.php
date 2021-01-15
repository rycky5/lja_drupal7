<?php

/**
 * @file
 * Default theme implementation to display a node.
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
$vid = (!empty($node->field_catcolunista[$node->language][0]["taxonomy_term"]->vid))? $node->field_catcolunista[$node->language][0]["taxonomy_term"]->vid: $node->field_catblog[$node->language][0]["taxonomy_term"]->vid;
?>
<div class="<?= ($vid == 10 || $vid == 12)? 'blog '.$classe : $classe;?>" id="verMateria">
  <? if($node->field_catblog[$node->language][0]["taxonomy_term"]->vid == 12){?>
  <h1 class="titulo" id="blog<?=$classe?>">
    <img alt="<?=$node->field_catblog[$node->language][0]["taxonomy_term"]->name;?>" src="<?= base_path().drupal_get_path('theme', 'mobileleiaja').'/images/blog'.$node->field_catblog[$node->language][0]["taxonomy_term"]->tid.'.jpg'?>">
  </h1>
  <?}elseif($node->field_catcolunista[$node->language][0]["taxonomy_term"]->vid == 10){ ?>
  <div class="destaque2" id="colunista">
    <div class="bg <?=$classe;?>">
      <p class="foto">
        <a href="javascript:void(0);">
          <img alt="<?=$node->field_catcolunista[$node->language][0]["taxonomy_term"]->name;?>" src="<?= base_path().drupal_get_path('theme', 'leiaja').'/images/foto-coluna-'.$node->field_catcolunista[$node->language][0]["taxonomy_term"]->tid.'.jpg'?>">
        </a>
      </p>
      <h1><?=$node->field_catcolunista[$node->language][0]["taxonomy_term"]->field_coluna['und'][0]['value'];?></h1>
      <div class="titulo"><?=$node->field_catcolunista[$node->language][0]["taxonomy_term"]->field_perfil['und'][0]['value'];?></div>
    </div>
  </div>
  <? }?>
  <div class="conteudo">
    <!--
    <ul class="ul" id="socialbar">
      <li class="label">Compartilhar:</li>
      <li class="facebook"><a href="#">Facebook</a></li>
      <li class="google"><a href="#">Google+</a></li>
      <li class="twitter"><a href="#">Twitter</a></li>
    </ul>
    -->
    <h1><b><?=$node->field_tags[$node->language][0]["taxonomy_term"]->name;?></b></h1>
    <p class="titulo"><?=$node->title?></p>
    <p class="fonte"><b><?= (empty($node->field_fonte[$node->language][0]['value'])) ? $name : $node->field_fonte[$node->language][0]['value'] ?></b> | <?= $date ?></p>
    <p class="chamada"><em><?= $node->body[$node->language][0]['summary']; ?></em></p>
    <?if(!empty($node->field_image[$node->language][0]['uri'])){?>
    <p class="foto">
      <span>Foto: <?= $node->field_image[$node->language][0]['alt'] ?></span>
      <img alt="<?= $node->field_image[$node->language][0]['title'] ?>" src="<?= image_style_url('medium', $node->field_image[$node->language][0]['uri']); ?>">
    </p>
    <?}?>
    <div class="texto">
      <?php print str_replace('##RECOMENDA##','',render($content['body'])); ?>
    </div>
  </div>
  <?= (empty($vLeiaTambemHtml))? '' : $vLeiaTambemHtml;?>
</div>