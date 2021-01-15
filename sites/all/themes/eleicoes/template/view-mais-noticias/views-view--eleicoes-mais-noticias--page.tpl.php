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
<div class="noticia">
    <ul class="listagem">
        <?php
            foreach ($arrObjNode as $node) :
                
                //Recuperando a url da node
                $strUrlNode = url("node/" . $node->nid);
                
                //Recuperando a data formatada da publicação do post
                $strData = format_date($node->node_created, $type);

                //Recuperando o titulo e limitando a quantidade de caracteres
                $strTitulo = $node->node_title;

                //Recuperando a uri da imagem de capa
                $strUriCapa = image_style_url('eleicoes_media',$node->field_field_image[0]["rendered"]["#item"]["uri"]);
                //Recuperando a primeira imagem da galeria
                $strUriGaleria = image_style_url('eleicoes_media',$node->field_field_capa[0]["rendered"]["#item"]["uri"]);
                //Imagem que vai ser imprimida na pagina
                $strUriImagem = (!empty($strUriCapa)) ? $strUriCapa : $strUriGaleria;

                //Recuperando o summary
                $strSummary = $node->field_body[0]["raw"]["summary"];
                //Recuperando o body
                $strBody = $node->field_body[0]["rendered"]["#markup"];

                //Texto a ser printado
                $strTexto = "";

                if(!empty($strSummary)){

                    //Atribuindo o summary com limite de caracteres
                    $strTexto = $strSummary;

                }else{

                    // Retirando as hash de marcação
                    $strTexto = str_replace("[@#podcast#@]", "", $strBody);
                    $strTexto = str_replace("[@#video#@]",   "", $strTexto);
                    $strTexto = str_replace("[@#galeria#@]", "", $strTexto);
                    $strTexto = str_replace("##RECOMENDA##", "", $strTexto);

                    //removendo todas as tags
                    $strTexto = strip_tags($strTexto);
                    //Limitando o quantitativo de caracteres
                    $strTexto = truncate_utf8($strTexto, 330, true, true);

                }
        ?>
        
                <li class="itemLista">
                    <h3><a href="<?= $strUrlNode ?>"></a><?= $strData ?></h3>
                    <h1 class="tituloListagem"><a href="<?= $strUrlNode ?>"><?= $strTitulo ?></a></h1>

                    <?php
                        if(!empty($strUriCapa) || !empty($strUriGaleria)):
                    ?>

                        <span>
                            <a href="<?= $strUrlNode ?>">
                                <img src="<?= $strUriImagem ?>" />
                            </a>
                        </span>

                    <?php
                        endif;
                    ?>

                    <p><a href="<?= $strUrlNode ?>"><?= $strTexto ?></a></p>
                    <div class="tags">
                        <ul>
                            <?php
                                foreach ($node->field_field_tags as $tags) :
                            ?>
                                
                                <li><a href="<?= url($tags["rendered"]["#href"]) ?>"><?= $tags["rendered"]["#title"] ?></a></li>
                            
                            <?php
                                endforeach;
                            ?>
                        </ul>
                    </div>
                </li>

        <?php
            endforeach;
        ?>
    </ul>
            
</div>
<div class="paginacao">
    <?php print $pager ?>
</div>