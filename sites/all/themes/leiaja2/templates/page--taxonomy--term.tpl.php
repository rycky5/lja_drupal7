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
//Carregando o objeto termo
$objTermo = taxonomy_term_load(arg(2));
//Carregando o objeto vocabulario
$objVocabulario = taxonomy_vocabulary_load($objTermo->vid);
//Opcoes de configurações do caderno
$cadernoSettings = getCadernoNode('caderno_' . $objVocabulario->machine_name);
?>
<!-- header -->
<?php
include_once 'header.php';
?>
<div class="region region-content">
    <div id="block-system-main" class="block block-system">

        <div class="content"><!-- section -->
            <section id="content">

                <div class="containerInterna ">
                    <div  class="colLeft">
                        <div class="inner_top <?= $cadernoSettings['cor'] ?>">
                            <div class="breadcrumb">
                                <span><a href="http://www.leiaja.com">www.<strong>leiaja</strong>.com/</a></span>
                                <h2><a href="/<?= $objVocabulario->machine_name ?>"><?= $objVocabulario->name ?></a></h2>
                                <h3><div class="seta-direita"></div><a href="#"><?= $objTermo->name ?></a></h3>
                            </div>
                        </div>
                        <div class="inner_content">
                            <div class="content_list">
                                <?php print render($page['content']) ?>
                            </div>
                        </div>
                    </div>
                    <aside>
                        <div class="colRight">






<div id="menulocal" class=" sub_<?= str_replace("field_cat","",$cadernoSettings['field']) ?> <?= $cadernoSettings['cor'] ?>">
<h3>Cadernos</h3>
<ul class="menunoticias vermelho">
    <li><a href="<?= LEIAJAURL ?>/noticias/brasil"><div class="seta-direita"></div> Brasil</a></li>
    <li><a href="<?= LEIAJAURL ?>/noticias/cidades"><div class="seta-direita"></div> Cidades</a></li>
    <li><a href="<?= LEIAJAURL ?>/noticias/cienciasesaude"><div class="seta-direita"></div> Ciência e Saúde</a></li>
    <li><a href="<?= LEIAJAURL ?>/noticias/economia"><div class="seta-direita"></div> Economia</a></li>
    <li><a href="<?= LEIAJAURL ?>/noticias/mundo"><div class="seta-direita"></div> Mundo</a></li>
</ul>
<ul class="menupolitica azulescuro">
    <li><a href="<?= LEIAJAURL ?>/eleicoes"><div class="seta-direita"></div> Eleições</a></li>
    <li><a href="<?= LEIAJAURL ?>/politica/politica"><div class="seta-direita"></div> Política</a></li>
</ul>
<ul class="menucarreiras cinza">
    <li><a href="<?= LEIAJAURL ?>/carreiras/concursos"><div class="seta-direita"></div> Concursos</a></li>
    <li><a href="<?= LEIAJAURL ?>/carreiras/cursos"><div class="seta-direita"></div> Qualificação</a></li>
    <li><a href="http://www.leiaja.com/tags/vestibular"><div class="seta-direita"></div> Vestibular</a></li>
    <li><a href="<?= LEIAJAURL ?>/carreiras/educacao"><div class="seta-direita"></div> Educação</a></li>
    <li><a href="<?= LEIAJAURL ?>/carreiras/empregos"><div class="seta-direita"></div> Empregos</a></li>
    <li><a href="<?= LEIAJAURL ?>/carreiras/empreendedorismo"><div class="seta-direita"></div> Empreendedorismo</a></li>
</ul>
<ul class="menuesportes verde">
    <li><a href="<?= LEIAJAURL ?>/esportes/esportesolimpicos"><div class="seta-direita"></div> Esportes Olímpicos</a></li>
    <li><a href="<?= LEIAJAURL ?>/esportes/basquete"><div class="seta-direita"></div> Basquete</a></li>
    <li><a href="<?= LEIAJAURL ?>/esportes/amador"><div class="seta-direita"></div> Esporte Amador</a></li>
    <li><a href="<?= LEIAJAURL ?>/esportes/tenis"><div class="seta-direita"></div> Tênis</a></li>
    <li><a href="<?= LEIAJAURL ?>/esportes/volei"><div class="seta-direita"></div> Vôlei</a></li>
    <li><a href="<?= LEIAJAURL ?>/esportes/geral"><div class="seta-direita"></div> Geral</a></li>
    <li><a href="<?= LEIAJAURL ?>/esportes/futebol"><div class="seta-direita"></div> Futebol</a></li>
    <li><a href="<?= LEIAJAURL ?>/esportes/vidasaudavel"><div class="seta-direita"></div> Vida Saudável</a></li>
    <li class="noborder"><a href="http://copa.leiaja.com"><div class="seta-direita"></div> Copa</a></li>
    <li><a href="<?= LEIAJAURL ?>/esportes/automobilismo"><div class="seta-direita"></div> Automobilismo</a></li>
</ul>
<ul class="menucultura amarelo">
    <li><a href="http://carnaval.leiaja.com"><div class="seta-direita"></div> Carnaval</a></li>
    <li><a href="<?= LEIAJAURL ?>/cultura/cinema"><div class="seta-direita"></div> Cinema</a></li>
    <li><a href="http://saojoao.leiaja.com/"><div class="seta-direita"></div> São João</a></li>
    <li><a href="<?= LEIAJAURL ?>/cultura/m%C3%BAsica"><div class="seta-direita"></div> Música</a></li>
    <li><a href="<?= LEIAJAURL ?>/cultura/artes-cenicas"><div class="seta-direita"></div> Artes Cênicas</a></li>
    <li><a href="<?= LEIAJAURL ?>/cultura/moda"><div class="seta-direita"></div> Moda</a></li>
    <li><a href="<?= LEIAJAURL ?>/cultura/artesvisuais"><div class="seta-direita"></div> Artes Visuais</a></li>
    <li><a href="<?= LEIAJAURL ?>/cultura/literatura"><div class="seta-direita"></div> Literatura</a></li>
    <li><a href="<?= LEIAJAURL ?>/cultura/gastronomia"><div class="seta-direita"></div> Gastronomia</a></li>
    <li><a href="<?= LEIAJAURL ?>/cultura/tvefamosos"><div class="seta-direita"></div> TV e Famosos</a></li>
    <li class="noborder"><a href="<?= LEIAJAURL ?>/cultura/revista"><div class="seta-direita"></div> (re)vista</a></li>
    <li><a href="<?= LEIAJAURL ?>/multimidia/videos"><div class="seta-direita"></div> Vídeos</a></li>
</ul>
<ul class="menutecnologia azul">
    <li><a href="<?= LEIAJAURL ?>/tecnologia/gadgets"><div class="seta-direita"></div> Gadgets</a></li>
    <li><a href="<?= LEIAJAURL ?>/tecnologia/games"><div class="seta-direita"></div> Games</a></li>
    <li><a href="<?= LEIAJAURL ?>/tecnologia/internet"><div class="seta-direita"></div> Internet</a></li>
    <li><a href="<?= LEIAJAURL ?>/tecnologia/mercado"><div class="seta-direita"></div> Mercado</a></li>
    <li><a href="<?= LEIAJAURL ?>/tecnologia/robotica"><div class="seta-direita"></div> Robotica</a></li>
    <li><a href="<?= LEIAJAURL ?>/tecnologia/seguranca"><div class="seta-direita"></div> Segurança</a></li>
    <li><a href="<?= LEIAJAURL ?>/tecnologia/dicas"><div class="seta-direita"></div> Dicas</a></li>
</ul>
</div>








                            <?php print render($page['sidebar']) ?>
                        </div>
                    </aside>
                </div>

            </section>
            <!-- /section -->
        </div>
    </div>
</div>
<?php
include_once 'footer.php';
?>
<!-- /footer -->
