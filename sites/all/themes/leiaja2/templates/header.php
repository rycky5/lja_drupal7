<?php
module_load_include('inc', 'widget', 'widget');
//$vSubConteudos = initContentMenuRecentes();
//$vSubMaisLida = initContentMenuMaisLida();

$arg = arg(0);

if(!empty($node->type)){
  $corCaderno = getCadernoNode($node->type);    
}else{
  $corCaderno = array('cor' => '');
}
?>
<script type="text/javascript" src="http://barra.ne10.uol.com.br/parceiro/leia-ja-418.js"></script>
<header>
    <div class="banner_top top">
        <div class="banner">
            <div class="wsz">

                <?php
                /*
                 * Recuperando e printando a região banner_topo
                 */
                if (getenv('APPLICATION_ENV') == 'production') {
                    $vBlocs = block_list('banner_topo');

                    echo $vBlocs[key($vBlocs)]->content['#markup'];
                }
                ?>

            </div>
        </div>
    </div>
</div>
<div class="container bottom">
    <h1 class="logo">
        <a href="<?= LEIAJAURL ?>"><img src="http://<?= $_SERVER['SERVER_NAME'] ?>/sites/all/themes/leiaja2/images/logo2.png"></a>
    </h1>
    <div class="search ">
        <form action="<?= LEIAJAURL ?>/search/node" id="search-form-topo" method="get" accept-charset="UTF-8">
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
<div class="menumob"><a id="mobmenu" href="javascript:void(0)"></a></div>
<div id="menumobdiv" class="menu">
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
            $vBlocs = block_list('skyscraper');
            ?>

            <!-- Banner Skyscrapper (160x600)-->
            <div id="skyscrapper">
                <div id="skycontainer">
                    <?php
                    echo $vBlocs[key($vBlocs)]->content['#markup'];
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





<section id="menucaderno" class="<?= (!empty($arg) && $arg == 'nodeestatica') ? "{css_cor}" : $corCaderno['cor']; ?>">
<div class="containerInterna">
<h5>Cadernos:</h5>
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
</section>




<script type="text/javascript">
    /* Script <header> */
    var isMobile = navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry)/);
    var resolucao = Math.max(document.documentElement["clientWidth"], document.body["scrollWidth"], document.documentElement["scrollWidth"], document.body["offsetWidth"], document.documentElement["offsetWidth"]);
    var menuchave = false;
    if (!document.getElementById("Linha0")) {
        if (isMobile || resolucao < 800) {
            document.getElementsByTagName('body')[0].className = 'mobiled';
            document.getElementById("mobmenu").addEventListener("click", function () {
                if (!menuchave) {
                    document.getElementById("menumobdiv").style.display = "block";
                    menuchave = true;
                } else {
                    document.getElementById("menumobdiv").style.display = "none";
                    menuchave = false;
                }
            });
            document.getElementById("search-form-topo").getElementsByTagName('input')[0].setAttribute("placeholder", "Pesquise aqui");
        }
    } else {
        document.getElementsByTagName('body')[0].className = 'bodycapa';
    }
</script>