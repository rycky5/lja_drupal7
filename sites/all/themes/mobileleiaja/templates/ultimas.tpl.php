<?php
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */
$count = 0;
?>
<div id="ultimasNoticias">
  <h1 class="cabecalho">
    <span>Últimas Notícias</span>
    <!--
    <a href="#">Ir para Últimas Notícias</a>
    -->
  </h1>
  <ul class="ul">
    <? foreach($noticias AS $key => $value){?>
      <li class="<?=$value->machine_name;?>">
        <a href="<?= url(drupal_lookup_path('alias',"node/".$value->nid));?>">
          <?= $value->hora?> - <?=$value->title?>
        </a>
      </li>
    <? }?>
  </ul>
</div>