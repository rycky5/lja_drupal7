<?php
//Recuperando o menu
$arrMenu = menu_tree_page_data('menu-eleicoes');
?>

<ul class="itemmenu">
    <?php
    foreach ($arrMenu as $value) :       
        if($value["link"]["hidden"] == 0):
            $linkNome = $value['link']['link_title'];
            $linkPath = $value['link']['link_path'];
    ?>
    
            <li><a href="/<?= $linkPath ?>"><?= $linkNome ?></a></li>
    
    <?php
        endif;
    endforeach;
    ?>
</ul>