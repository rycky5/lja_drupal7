<?php
module_load_include('inc', 'widget', 'widget');
//$vSubConteudos = initContentMenuRecentes();
//$vSubMaisLida = initContentMenuMaisLida();
$cadernoSettings = getCadernoNode('caderno_' . $objVocabulario->machine_name)

?>
<header>
    <div class="banner_top top">
        <div class="banner">
            <div class="wsz">

                <?php
                /*
                 * Recuperando e printando a região banner_topo
                 */
                if (getenv('APPLICATION_ENV') == 'production') {

                    print render($page['banner_topo']);
                }
                ?>

            </div>
        </div>
    </div>
</div>
<div class="container bottom">
    <h1 class="logo"><a href="<?= LEIAJAURL ?>"><img src="http://<?= $_SERVER['SERVER_NAME'] ?>/sites/all/themes/leiaja2/images/logo.png"></a></h1>
    <div class="search ">
        <form action="<?= LEIAJAURL ?>/search/node" id="search-form" method="get" accept-charset="UTF-8">
            <ul>
                <li><input type="text" name="keys" placeholder="Procure aqui o que voc&ecirc; precisa saber." value="" /></li>
                <li class="fa fa-search"><input type="submit" value=""  /></li>
            </ul>
            <input type="hidden" name="form_id" value="search_theme_form" />
            <input type="hidden" name="form_token" value="<?php print drupal_get_token('search_theme_form'); ?>" />
        </form>
    </div>
    <div class="social">
        <ul>
            <li class="fa fa-rss"><a href="<?= LEIAJAURL ?>/assine" target="_blank"></a></li>
            <li class="fa fa-facebook"><a href="https://www.facebook.com/LeiaJaOnline" target="_blank"></a></li>
            <li class="fa fa-twitter"><a href="https://twitter.com/leiajaonline" target="_blank"></a></li>
        </ul>
    </div>
</div>
<div class="menu">
    <a href="#" class="respo_menu fa fa-navicon"></a>
    <div class="container">
        <ul>
            <li class="vermelho">
                <a href="/noticias/">notícias</a>
            </li>
            <li class="azulescuro">
                <a href="/politica/">política</a>
            </li>
            <li class="cinza">
                <a href="/carreiras/">carreiras</a>
            </li>
            <li class="verde">
                <a href="/esportes/">ESPORTES</a>
            </li>
            <li class="amarelo">
                <a href="/cultura/">ENTRETENIMENTO</a>
            </li>
            <li class="azul">
                <a href="/tecnologia/">tecnologia</a>
            </li>
        </ul>



        <?php
        /*
         * Recuperando e printando a região skyscraper
         */
        if (getenv('APPLICATION_ENV') == 'production') :
            ?>
            <!-- Banner Skyscrapper (160x600)-->
            <div id="skyscrapper">
                <div id="skycontainer">
                    <?php
                    print render($page['skyscraper']);
                    ?>
                </div>
            </div>
            <!-- FIM Banner Skyscrapper (160x600)-->

            <?php
        endif;
        ?>

    </div>
</div>
</header>