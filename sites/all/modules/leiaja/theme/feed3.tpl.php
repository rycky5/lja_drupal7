
<div id="paginaRSS">

<h4><a href="<?= url('feed3/rss/', array('absolute' => TRUE)) ?>" title="Leia J&aacute;"><img src="<?= LEIAJAURL ?>/sites/all/themes/leiaja2/images/rss.png" width="32" /><span>Leia J&aacute;</span></a></h4>
<p>Assine nosso conteúdo! Clicando em um ícone RSS (<img src="<?= LEIAJAURL ?>/sites/all/themes/leiaja2/images/rss.png" width="16" />), você terá acesso ao endereço RSS da área desejada.</p>



<?php
$cont = 3;
$colunistas = '';

$array_str_vocabulary = array('noticias', 'carreiras', 'esportes', 'cultura', 'tecnologia', 'blogs', 'colunistas');
$array_obj_vocabulary = array();
foreach ($array_str_vocabulary as $str_vocabulary) {
    $array_obj_vocabulary[] = db_query("SELECT name, machine_name, vid FROM {taxonomy_vocabulary} WHERE machine_name = '$str_vocabulary'")->fetchAll();
}

//var_dump($array_obj_vocabulary);

foreach ($array_obj_vocabulary as $vocabulary) {
    $vocabulary = $vocabulary[0];
    //var_dump($vocabulary);
    //echo '<br />';
    if (!in_array($vocabulary->machine_name, array('noticias',
                'carreiras',
                'esportes',
                'cultura',
                'tecnologia',
                'blogs',
                'colunistas'))) {
        continue;
    }
    if ($cont % 3 == 0) {
        ?>
        <div class="colunas3">  
            <?php
        }
        ?>
        <div class="listaRss">
            <h5>
                <a href="<?= base_path() . 'feed3/rss/' . $vocabulary->machine_name; ?>" title="<?= $vocabulary->name; ?>"><img src="<?= LEIAJAURL ?>/sites/all/themes/leiaja2/images/rss.png" width="24" /><span><?= $vocabulary->name; ?></span></a>
            </h5>
            <ul>
                <?php
                $objVocabulary = taxonomy_vocabulary_machine_name_load($vocabulary->machine_name);
                $terms = taxonomy_get_tree($objVocabulary->vid);
                foreach ($terms as $term) {
                    $alias = db_query("SELECT alias FROM url_alias WHERE source LIKE '%taxonomy/term/" . $term->tid . "%'")->fetchField();
                    //var_dump($alias);
                    ?>
                    <li><a href="<?= base_path() . 'feed3/rss/' . $alias ?>" title="<?= $term->name ?>"><?= $term->name ?></a></li>
                            <?php
                        }
                        ?>
            </ul>

        </div><!-- fecha lista -->
        <?php
        if (($cont - 2) % 3 == 0) {
            ?>
        </div><!-- fecha coluna3 -->
        <?php
    }
    $cont++;
}
?>

</div> <!-- fecha ultima .coluna3 -->

</div><!-- fecha paginaRSS -->