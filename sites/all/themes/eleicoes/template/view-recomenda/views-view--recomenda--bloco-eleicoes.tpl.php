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

//Recuperando o resultado da view
$arrObjNode = $view->result;

?>

<ul class="noticiasRelacionadas">
    <?php
        foreach ($arrObjNode as $node):
            
            //Recuperando o título e limitando a quantidade de caracter
            $strTitulo = $node->node_title;
            //Recuperando a imagem de capa
            $strUriCapa = $node->field_field_image[0]["rendered"]["#item"]["uri"];
            //Recuperando a primeira imagem da galeria
            $strUriGaleria = $node->field_field_capa[0]["rendered"]["#item"]["uri"];
            //Imagem que vai ser imprimida na pagina
            $strUriImagem = (!empty($strUriCapa)) ? $strUriCapa : $strUriGaleria;
            //Recuperando o summary
            $strSummary = $node->field_body[0]["raw"]["summary"];
            //Recuperando o texdo do corpo
            $strBody = $node->field_body[0]["rendered"]["#markup"];
            
            //Texto a ser printado
            $strTexto = "";

            if(!empty($strSummary)){

                //Atribuindo o summary com limite de caracteres
                $strTexto = truncate_utf8($strSummary, 40, true, true);

            }else{

                // Retirando as hash de marcação
                $strTexto = str_replace("[@#podcast#@]", "", $strBody);
                $strTexto = str_replace("[@#video#@]",   "", $strTexto);
                $strTexto = str_replace("[@#galeria#@]", "", $strTexto);

                //removendo todas as tags
                $strTexto = strip_tags($strTexto);
                //Limitando o quantitativo de caracteres
                $strTexto = truncate_utf8($strTexto, 40, true, true);

            }
    ?>
    
            <li>
                
                <?php
                    if(!empty($strUriCapa) || !empty($strUriGaleria)):
                ?>
                    
                        <img src="<?= $strUriImagem ?>" />
                
                <?php
                    endif;
                ?>
                        
                <div class="relacionadasBox">
                    <h2 class="titulo"><?= $strTitulo ?></h2>
                    <p class="resumo"><?= $strTexto ?></p>
                </div>
            </li>
    
    <?php
        endforeach;
    ?>
</ul>