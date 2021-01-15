<?php
// $Id: comment-wrapper.tpl.php,v 1.2 2010/09/25 02:05:51 dries Exp $

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
?>
<div class="listarComentarios">
  <?php if($node->comment_count == 0): ?>
    <h3>Seja o primeiro a comentar!</h3>
  <?php else: ?>
    <h3> COMENTÁRIOS</h3>
    <div class="comment clearfix">
        <?php print render(array_reverse($content['comments'])); ?>
    </div>
    <div class="ulPagiComent">
      <?print theme('pager',array('tags' => array()));?>
    </div>
  <?php endif; ?>
</div>

<?php if($logged_in): ?>
<!--Escrever Comentário-->
<div class="contentAcoes">
<h3>Escrever seu coment&aacute;rio</h3>
<form action="<?= base_path().'comment/reply/'.$node->nid ?>" method="post" accept-charset="UTF-8" id="frmComment" onsubmit="return validComment();">
  <input type="hidden" name="form_token" value="<?= $content['comment_form']['form_token']['#value']; ?>" />
  <input type="hidden" name="form_build_id" value="<?= $content['comment_form']['form_build_id']['#value']; ?>" />
  <input type="hidden" name="form_id" value="<?= $content['comment_form']['form_id']['#value']; ?>">
  <div class="contentFormEsquerda">
    <div class="inputGeral">
      <label>Seu nome</label>
      <div class="bgInputGeralDisabled"><input title="Seu nome" value="<?= $user->name ?>" disabled="disabled" type="text" /></div>
    </div>
      <p>Ao enviar qualquer coment&aacute;rio &agrave;s not&iacute;cias, o usu&aacute;rio declara-se ciente e aceita integralmente o <a href="<?=base_path()?>/alteracao" title="termo de uso">termo de uso</a>.</p>
  </div>
  <div class="contentFormDireita">
    <div class="textAreaCorrigir">
      <label>Seu coment&aacute;rio</label>
      <div class="bgTextAreaCorrigir"><textarea class="required" id="inpComentarioMensagem" name="comment_body[und][0][value]" title="Mensagem"></textarea></div>
    </div>
    <button type="submit" class="form"><span>Comentar</span></button>
  </div>
</form>
</div>
<!--Fim Escrever Comentário-->
<?php endif; ?>
