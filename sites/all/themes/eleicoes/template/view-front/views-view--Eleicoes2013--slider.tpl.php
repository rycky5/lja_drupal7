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
?>

<!--<div class="passadores">
    <a href="javascript:void(0);" class="passadorLeft"></a>
    <a href="javascript:void(0);" class="passadorRight"></a>
</div>-->
<div class="legendaSlider">
    <ul>
        <?php
            foreach ($arrObjNode as $node) :
                
                //Recuperando a url da node
                $strUrlNode = url("node/" . $node->nid);
                
                //Recuperando o título da node
		$strTitulo = strtoupper($node->node_title);
            
                //Recuperando a imagem de capa
                $strImagemCapa = $node->field_field_capa[0]["rendered"]["#item"]["uri"];
                //Recuperando a primeira imagem da galeria
                $strGaleriaImagem = $node->field_field_image[0]["rendered"]["#item"]["uri"];
                
                //Imagem a ser printada
                $strImg = (!empty($strImagemCapa)) ? $strImagemCapa : $strGaleriaImagem;
                
                //Recuperando o sumario
                $strSummary = $node->field_body[0]["raw"]["summary"];
                //Recuperando o body
                $strBody = $node->field_body[0]["rendered"]["#markup"];
                
                //Texto a ser printado
                $strTexto = "";
                
                if(!empty($strSummary)){
                    //Atribuindo o summary com limite de caracteres
                    $strTexto = truncate_utf8($strSummary, 282, true, true);
                    
                }else{
                    
                    // Retirando as hash de marcação
                    $strTexto = str_replace("[@#podcast#@]", "",  $strBody);
                    $strTexto = str_replace("[@#video#@]",   "",  $strTexto);
                    $strTexto = str_replace("[@#galeria#@]", "",  $strTexto);
                    
                    //removendo todas as tags
                    $strTexto = strip_tags($strTexto);
                    //Limitando o quantitativo de caracteres
                    $strTexto = truncate_utf8($strTexto, 282, true, true);
                    
                }
                                
        ?>
        
                <li>
                    <a href="<?= $strUrlNode ?>"><img src="<?= image_style_url("eleicoes_slide", $strImg) ?>"  /></a>
                    <div class="content-legendaSlider">
                        <h2><a href="<?= $strUrlNode ?>"><?= $strTitulo ?></a></h2>
                        <p><a href="<?= $strUrlNode ?>"><?= $strTexto ?></a></p>
                    </div>
                </li>
            
        <?php
            endforeach;
        ?>
    </ul>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="sites/all/themes/eleicoes/js/jquery.bxslider.js"></script>
	<script>
		$(document).ready(function(){

			$('.legendaSlider ul').bxSlider({ pager: false, auto: true });
	
		}); 
	</script>
</div>
