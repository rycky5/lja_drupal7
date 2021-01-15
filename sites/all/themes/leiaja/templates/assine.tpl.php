
<div class="colunas1">
    <div class="contentCol listaRss">
        <h4><span class="rssGra"></span><a href="<?= url(base_path() . 'assinar', array('absolute' => TRUE)) ?>" title="Leia J&aacute;">Leia J&aacute;<span class="addRss"></span></a></h4>
    </div>

</div>

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
        <div class="contentCol listaRss">
            <h5><span class="rssMed"></span>
                <a href="<?= base_path() . 'assinar/' . $vocabulary->machine_name; ?>" title="<?= $vocabulary->name; ?>"><?= $vocabulary->name; ?><span class="addRss"></span></a>
            </h5>
            <ul>
                <?php
                $objVocabulary = taxonomy_vocabulary_machine_name_load($vocabulary->machine_name);
                $terms = taxonomy_get_tree($objVocabulary->vid);
                foreach ($terms as $term) {
                    $alias = db_query("SELECT alias FROM url_alias WHERE source LIKE '%taxonomy/term/" . $term->tid . "%'")->fetchField();
                    //var_dump($alias);
                    ?>
                    <li><span class="rssPeq"></span><a href="<?= base_path() . 'assinar/' . $alias ?>" title="<?= $term->name ?>"><?= $term->name ?><span class="addRss"></span></a></li>
                            <?php
                        }
                        ?>
            </ul>

        </div>
        <?php
        if (($cont - 2) % 3 == 0) {
            ?>
        </div>
        <?php
    }
    $cont++;
}
?>    