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
<div class="conteudo">
    <div class="bloco_esquerda">
      <div class="player_titulo">
        <p>AO VIVO</p>
        <h3><?php echo $node->body[$node->language][0]['summary']; ?></h3>
        <div>
            <span class="ativo">
                <em><a href="/aovivo/">Canal</a></em>
                <strong><a href="/aovivo/">1</a></strong>
            </span>
            <span>
                <em><a href="/aovivo2">Canal</a></em>
                <strong><a href="/aovivo2">2</a></strong>
            </span>
        </div>
   </div>
   <div class="player">
    <span id="spanVideo"><?php echo $node->field_embed_aovivo["und"][0]["value"];?></span>
   </div>
</div><!--fim bloco esquerda-->
<div class="bloco_direita">
    <div class="titulo_menor"><img src="/sites/all/themes/aovivo/images/tit_proximoseventos.jpg" width="330" height="40" alt="Próximos eventos" /></div>
    <div class="fb-like" >
      <iframe src="http://www.facebook.com/plugins/like.php?href=http://www.facebook.com/LeiaJaOnline"
        scrolling="no" frameborder="0"
        style="border:none; width:450px; height:30px"></iframe>
    </div>
    <p class="texto_menor"><?php print render($content['body']); ?></p>
    <span class="compartilhe">COMPARTILHAR
        <a class="popup" href="http://www.facebook.com/sharer.php?u=http://leiaja.com/aovivo"><img src="/sites/all/themes/aovivo/images/r_facebook.png" alt="Facebook" width="26" height="25" border="0" /></a>
        <a class="popup" href="https://twitter.com/share?text=<?php print $node->field_texto_twitter[$node->language][0]['value']?>" ><img src="/sites/all/themes/aovivo/images/r_twitter.png" alt="Twitter" width="26" height="25" border="0" /></a>
    </span>
</div><!--fim bloco direita-->
<div class="bloco_esquerda">
    <div class="titulo_grande"><img src="/sites/all/themes/aovivo/images/tit_twitter.jpg" width="592" height="40" alt="Twiiter" /></div>
    <div class="twitter">
    <script type="text/javascript" src="http://widgets.twimg.com/j/2/widget.js"></script>
    <script>
    new TWTR.Widget({
      version: 2,
      type: 'search',
      search: 'from:leiajaonline OR <?= str_replace(",", "#", $node->field_hash_tag["und"][0]['value'])?> ',
    interval: 5000,
      width: 600,
      height: 130,
      theme: {
        shell: {
          background: 'transparent',
          color: '#333'
        },
        tweets: {
          background: 'transparent',
          color: '#4a4637',
          links: '#838FC7'
        }
      },
      features: {
        scrollbar: true,
        loop: true,
        live: true,
        hashtags: true,
        timestamp: true,
        avatars: true,
        behavior: 'default'
      }
    }).render().start();
    </script>
    </div>
</div><!--fim bloco esquerda-->
<div class="bloco_direita">
    <div class="titulo_menor"><img src="/sites/all/themes/aovivo/images/tit_noticias.jpg" width="330" height="40" alt="Sobre o vídeo" /></div>
        <div class="noticias texto_noticias">
        </div>
</div><!--fim bloco direita-->
</div><!--fim conteudo-->
