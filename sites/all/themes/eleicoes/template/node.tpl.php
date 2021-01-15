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
//Incluindo arquivo template.api.inc com as funções necessárias
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja') .'/template.api.inc';

//Recuperando as tags
$tags = render($content['field_tags']);

?>

<span class="chapeu"><?= strtoupper($node->field_tags[key($node->field_tags)][0]["taxonomy_term"]->name) ?></span>
<h2 class="tituloInterna"><?= $title ?></h2>
<h2 class="resumoInterna"><?= (!empty($node->body[key($node->body)]["0"]["summary"])) ? truncate_utf8($node->body[key($node->body)]["0"]["summary"], 150, true, true) : truncate_utf8($node->body, 150, true)  ?></h2>
<h3 class="autorEdata">por <strong><?= $name . " | " . $date ?></strong></h3>

<!--social-->
<div class="socialPost">
    <div class="facebook">
        <div class="fb-like" data-href="<?= 'http://'.$_SERVER['SERVER_NAME'].$node_url ?>" data-width="250" data-show-faces="false" data-send="false"></div>
    </div>
    <div class="twitter">
        <a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php print $node->title;?>" data-via="leiajaonline" data-lang="pt" data-hashtags="HallSocial">Tweetar</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </div>
    <div class="googleplus">
        <!-- Place this tag in your head or just before your close body tag. Teste -->
        <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
            {lang: 'pt-BR'}
        </script>
        <!-- Place this tag where you want the +1 button to render. -->
        <div class="g-plusone" data-size="medium" ></div>
    </div>
</div>
<!--/social-->

<?php
if(!empty($node->field_image) && count($node->field_image[key($node->field_image)]) == 1):
?>
    <div class="imagemInterna">
        <span class="tituloImg"><?= $node->field_image[key($node->field_image)][0]["title"] ?></span>
        <img src="<?= image_style_url('eleicoes_large', $node->field_image[key($node->field_image)][0]["uri"]) ?>">
        <span class="creditoImg"><?= $node->field_image[key($node->field_image)][0]["alt"] ?></span>
    </div>
<?php
endif;
?>
<div class="textoNoticia">
    
    <?php
    
        hide($content['comments']);
        hide($content['links']);
        hide($content['field_tags']);
        hide($content['field_tags']['printed']);
        hide($content['field_fonte']);
        hide($content['field_capa']);
        hide($content['field_infografico']);
        hide($content['field_permlink']);
        hide($content['field_videost']);
        hide($content['field_audiost']);
        hide($content['body']);

        // Exibindo o conteúdo multimídia
        api_rederMultimidia($content, $node);

        print render($content["body"]);
    ?>
    
</div>

<!--social-->
<div class="socialPost">
    <div class="facebook">
        <div class="fb-like" data-href="<?= 'http://'.$_SERVER['SERVER_NAME'].$node_url ?>" data-width="250" data-show-faces="false" data-send="false"></div>
    </div>
    <div class="twitter">
        <a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php print $node->title;?>" data-via="leiajaonline" data-lang="pt" data-hashtags="HallSocial">Tweetar</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </div>
    <div class="googleplus">
        <!-- Place this tag in your head or just before your close body tag. Teste -->
        <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
            {lang: 'pt-BR'}
        </script>
        <!-- Place this tag where you want the +1 button to render. -->
        <div class="g-plusone" data-size="medium" ></div>
    </div>
</div>
<!--/social-->

<!--Tags da node-->
<div class="tags">
    <h2 class="tituloTags">Tags: </h2>
    <?= render($content['field_tags']) ?>
</div>
<?php
//    echo '<pre>';
//print_r($content['field_tags']);
//die();
?>
<div>
    <h3 class="noticiasRelacionadasTit">Not&iacute;cias Relacionadas</h3>
    
    <?php
        // Criando variavel que conterÃ¡ o array de TIDs
        $arrTid = array();

        // Recuperando o tid das tags
        foreach($node->field_tags[$node->language] as $objTag){
         if(!empty($objTag['taxonomy_term']->tid)){
           $arrTid[] = $objTag['taxonomy_term']->tid;
         }
        }

        //Recuperando a view eleicoes
        $objViewSemImg = views_get_view('recomenda');
        //Selecionando o displa sem_imagem
        $objViewSemImg->set_display('bloco_eleicoes');
        //Ignorando os ids
        $objViewSemImg->args = array($arrTid, array($node->nid));
        //Executando o display
        $objViewSemImg->execute();
        //Renderizando o conteúdo
        $output = $objViewSemImg->render();

        //Printando o conteúdo renderizado
        print $output;
    ?>
    
</div>

<!--Comentários do facebook-->
<div class="comentarios">
    <h4 class="comentariosTit">coment&aacute;rios</h4>            
    <div class="fb-comments" data-href="<?= 'http://'.$_SERVER['SERVER_NAME'].$node_url ?>" data-width="620" data-num-posts="10"></div>
</div>