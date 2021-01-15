<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>
<!-- Termina Modal Comentários -->
<nav class="navbar navbar-leiaja navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle x collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php if ($logo): ?>
                <a class="navbar-brand" href="/index_mobile.html">
                    <img src="<?php print $logo; ?>">
                </a>
            <?php endif; ?>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <!-- Campo de busca -->
            <div class="input-group campo-busca">
                <input type="text" class="form-control" placeholder="Buscar">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <img src="/sites/all/themes/mleiaja/img/icon_search.svg">
                    </button>
                </span>
            </div>
            <ul class="nav navbar-nav">
                <li class="noticias"><a href="/index_mobile.html?p=caderno_noticias">Notícias</a></li>
                <li class="politica"><a href="/index_mobile.html?p=caderno_politica">Política</a></li>
                <li class="carreiras"><a href="/index_mobile.html?p=caderno_carreiras">Carreiras</a></li>
                <li class="esportes"><a href="/index_mobile.html?p=caderno_esportes">Esportes</a></li>
                <li class="entretenimento"><a href="/index_mobile.html?p=caderno_cultura">Entretenimento</a></li>
                <li class="tecnologia"><a href="/index_mobile.html?p=caderno_tecnologia">Tecnologia</a></li>
                <li class="colunista"><a href="/index_mobile.html?p=caderno_colunistas">Colunistas</a></li>
            </ul>
        </div>
    </div>
</nav>

<div id="main-container" class="container">
    <?php print render($page['content']); ?>
</div>
<div id="loading-icon"><img class="loading-icon" src="/<?php print drupal_get_path('theme', $GLOBALS['theme']) ?>/img/icon_loading.svg"></div>