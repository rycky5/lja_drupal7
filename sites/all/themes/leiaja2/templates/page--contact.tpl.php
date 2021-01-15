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
 */
?>
<!-- header -->
<?php
include_once 'header.php';
?>
<!-- /header -->









<!-- section -->
<section id="content">
    <div class="containerInterna">
        <div class="inner_top <?= $cadernoSettings['cor'] ?>">
            <div class="breadcrumb">
                <span><a href="<?= LEIAJAURL ?>">www.<strong>leiaja</strong>.com/</a></span>        
            </div>
            <div class="share">
                <ul>
                    <li>
                        <div class="fb-like" data-href="<?= $full_node_url ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
                    </li>
                    <li><script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
                    <g:plusone></g:plusone></li>
                    <li><a href="<?= $full_node_url ?>" class="twitter-share-button">Tweet</a>
                        <script>!function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                if (!d.getElementById(id)) {
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = p + '://platform.twitter.com/widgets.js';
                                    fjs.parentNode.insertBefore(js, fjs);
                                }
                            }(document, 'script', 'twitter-wjs');</script></li>
                </ul>
                <!--<a href="javascript:void(0);" class="print"><span class="fa fa-print"></span>Imprimir</a>-->
            </div>
        </div>

        <div class="inner_content template-page">
            <div class="title">
                <h1><?= stripslashes($title) ?></h1>
            </div>
            <div class="bottom_inner">
                <div class="col full">
                    <?
                    //echo '<pre>';				 
                    //var_dump($page);die;			
                    //Printando o corpo da node
                    // print $page['content']; 
                    ?>  
                    <p>Preencha os campos corretamente!</p>
                    <?= render($page['content']) ?>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- /section -->







<!-- footer -->
<?php
include_once 'footer.php';
?>
<!-- /footer -->
