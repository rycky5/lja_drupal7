<?php
/**
 * @file
 * Main view template.
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
 *
 * @ingroup views_templates
 */

//pegando o caderno que é passado pela url 
$tipoCaderno = arg(1);
//Tipos dos cadernos para pagina de ultimas noticias
$cadernos = array('noticias', 'politica', 'carreiras', 'esportes', 'cultura', 'tecnologia', 'multimidia');
if (in_array($tipoCaderno, $cadernos) && filter_var($tipoCaderno, FILTER_SANITIZE_STRING)) {
    //nome da view:
    $nameView = "ultimas_noticias";
    //displayName da view:
    $displayName = 'cadernos';
    //array de cadernos
    //setando o caderno a qual os nodes devem ser retornados;
    $caderno = "caderno_" . (in_array($tipoCaderno, $cadernos) ? $tipoCaderno : "noticias");
    //setando a view;
    $view = views_get_view($nameView);
    //setando o caderno a ser retornado
    $view->display[$displayName]->display_options["arguments"]["type"]["default_argument_options"]["argument"] = $caderno;
    //setando o display a ser executado;
    $view->set_display($displayName);
    $view->pre_execute();
    $view->execute();
    //setando o resultado da consulta em uma variavel;
    $objViewResult = $view->result;
} else {
    $objViewResult = $view->result;
}
?>
<ul>
    <?php
    foreach ($objViewResult as $objNode):
        
        $objData = $objNode->_field_data['nid']['entity'];

        //Objeto conteúdo corpo
        $objDataBody = $objData->body[key($objNode->_field_data['nid']['entity']->body)][0];
        //Objeto tags
        $objDataTags = $objData->field_tags[key($objNode->_field_data['nid']['entity']->field_tags)];
        //Recuperando os tids
        $arrTid = array();
        foreach ($objDataTags as $value) {
            $arrTid[] = $value['tid'];
        }
        //Carregando o objeto dos termos
        $objTermos = taxonomy_term_load_multiple($arrTid);
        //Recuperando a imagem de capa
        $uriCapa = (!empty($objData->field_capa)) ? $objData->field_capa[key($objData->field_capa)][0]['uri'] : '';
        $uriImage = (!empty($objData->field_image)) ? $objData->field_image[key($objData->field_image)][0]['uri'] : '';
        $uriTopo = (!empty($objData->field_imagem_topo)) ? $objData->field_imagem_topo[key($objData->field_imagem_topo)][0]['uri'] : '';
        //Uri da imagem
        $strUri = '';
        if (!empty($uriCapa)) {
            $strUri = $uriCapa;
        } elseif (!empty($uriImage)) {
            $strUri = $uriImage;
        } elseif (!empty($uriTopo)) {
            $strUri = $uriTopo;
        } else {
            $strUri = '';
        }
        //Url da node
        $urlNode = url('node/' . $objNode->nid);
        
        ?>
        <li class="<?= !empty($strUri) ? 'destaque' : '' ?>">
            <?php
            if (!empty($strUri)):
                ?>
                <div class="thumb">
                    <a href="<?= $urlNode ?>"><img src="<?= image_style_url('100x100', $strUri) ?>" /></a>
                </div>
                <?php
            endif;
            ?>
            <div class="cont">          
                <h6 class="created-date"><?= format_date($objNode->node_created, 'long'); ?></h6>
                <h4><a href="<?= $urlNode ?>"><?= $objNode->node_title ?></a></h4>
                <p><?= (!empty($objDataBody['summary'])) ? $objDataBody['summary'] : strip_tags(truncate_utf8($objDataBody['value'], '60', TRUE)) ?></p>
                <div class="tags"><strong>Tags:</strong>
                    <?php
                    foreach ($objTermos as $value) :
                        ?>
                        <a href="<?= url("taxonomy/term/" . $value->tid); ?>"><?= $value->name ?></a>
                        <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </li>
        <?php
    endforeach;
    ?>
</ul>
<?php if ($pager): ?>
    <?php print $pager; ?>
    <?php
 endif;
 