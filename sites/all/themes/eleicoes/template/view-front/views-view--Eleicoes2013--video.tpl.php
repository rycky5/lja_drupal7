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

//Recuperando os resultados da view
$arrObjNode = $view->result;

//Percorrendo os resultados da view
foreach ($arrObjNode as $node) :
    
    //Recuperando o título da node
    $strTitulo = $node->node_title;
    
    //Recuperando a url da node
    $strUrlNode = url("node/" . $node->nid);
   
    //Recuperando a uri da imagem de capa
    $strUriCapa = $node->field_field_capa[0]["rendered"]["#item"]["uri"];

    //Recuperando a uri primeira imagem da galeira
    $strUriGaleria = $node->field_field_image[0]["rendered"]["#item"]["uri"];
    
    //Imagem que vai ser printada
    $strUriImagem = (!empty($strUriCapa)) ? $strUriCapa : $strUriGaleria;
    
?>

    <li>
        <figure>
            <img src="<?= image_style_url('eleicoes_video', $strUriImagem) ?>">
            <figcaption>
                <h3><?= $strTitulo ?></h3>
                <a href="<?= $strUrlNode ?>">Ver Vídeo</a>
            </figcaption>
        </figure>
    </li>

<?php
endforeach;
?>