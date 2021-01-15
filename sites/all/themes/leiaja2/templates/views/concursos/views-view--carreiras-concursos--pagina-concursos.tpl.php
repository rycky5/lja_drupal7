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

// Criando a lsta de ignore
$nidPass = "";

// Recuperando as nodes do carrocel
$arrNodePromoDestaComImagem = $view->result;

// add os nids para o ignore
$nidPass = getNidsByViews($arrNodePromoDestaComImagem);

// Recuperando os concursos abertos
$arrObjConcurso = views_get_view_result("concursos", "block");

/**
 * Caminho para os ícones na raiz do tema
 */
$path = "/".drupal_get_path('theme', 'leiaja2');
$caminho_tema = LEIAJAURL.base_path().$path;

?>

<!------------------------------------------------------------------------------------------------------------>
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
<style>
.concursos {width:630px;float:left;font-family: 'Roboto Condensed', sans-serif;}
.concursos .header {width:630px;height:150px;float:left;background:url(<?= $caminho_tema; ?>/images/bg_header_concurso.jpg) no-repeat 0px 3px;}
.concursos .header h2 {text-align: right;font-weight: bold;font-size: 30px;color: #7a7979;margin: 40px 0 5px 0;width: 100% !important;}
.concursos .header h2 .azul {color:#43b5e4;}
.concursos .header h2 .vermelho {color:#ec1c24;}
.concursos .header p {text-align: right;color: #7a7979;font-weight: lighter;width: 340px;position: relative;float: right;line-height: 18px!important;}
.concursos .select {width:630px;background:#20a8e0;height:65px;float:left;}
.concursos .select span {font-size:18px;font-weight:lighter;color:#fff;margin:20px 0 0 20px;float:left;}
.concursos .select select {float: right;margin: 17px 20px 0 0;width: 200px;height: 30px;border: none;text-transform: uppercase;color: #7a7979;font-weight: bold;font-size: 14px;}
.concursos .lista {float:left; margin-bottom: 50px;}
.concursos .lista .item {width:630px;float:left;margin:25px 0 0 0;border:1px solid #ccc;}
.concursos .lista .item:hover {width: 627px;border: 3px solid #ccc;margin:23px 26px -2px -2px;}
.concursos .lista .item.nomargin {margin-right:0!important;}
.concursos .lista .item h3.titulo {width:630px;border-bottom:1px solid #ccc;padding: 20px;float: left;font-size: 16px;font-weight: lighter;width: 590px}
.concursos .lista .item:hover h3.titulo {background:#f6f6f6;width:587px;}
.concursos .lista .item:hover h3.titulo a {color:#135c7a;}
.concursos .lista .item p a {text-decoration:none;color: #7a7979;}
.concursos .lista .item:hover p a {color:#000;}
 .concursos .lista .item p {padding: 20px;float: left;font-size: 16px;font-weight: lighter;width: 590px;border-bottom:1px #ccc solid;}
.concursos .lista .item h3.titulo a {display:block;font-weight:bold;font-size:20px;color:#4c95b3;text-decoration:none;}
.concursos .lista .item span.data, .concursos .lista .item span.edital, .concursos .lista .item span.salario, .concursos .lista .item span.provas {color: #7a7979;font-weight: lighter;padding: 10px 0px 10px 40px;margin: 0 10px;float: left;}
.concursos .lista .item span.data {background: url(<?= $caminho_tema; ?>/images/icon_calendario_small.png) no-repeat 15px 10px;}
.concursos .lista .item span.edital {background: url(<?= $caminho_tema; ?>/images/icon_calendario_small.png) no-repeat 15px 10px;}
.concursos .lista .item span.salario {background: url(<?= $caminho_tema; ?>/images/icon_valor.png) no-repeat 15px 10px;}
.concursos .lista .item span.provas {background: url(<?= $caminho_tema; ?>/images/icon_hora.png) no-repeat 15px 10px;border-bottom:none!important;}
.concursos .lista .banner{position: absolute; width: 90px; height: 40px; margin: 17px 0 0 525px; z-index: 1;}
</style>

<div class="concursos">
	<div class="header">
		<h2><span class="azul">Leia</span><span class="vermelho">Já</span> Concursos</h2>
		<p>Fique por dentro de tudo que você precisa saber sobre as principais seleções públicas locais e nacionais.</p>
	</div>
	<div class="select">
		<span>Procure os concursos:</span>
		<select id="localidade">
                    <option value="all" selected="selcted">Todos</option>
                    <?php
                        $array = array();
                        //imprimindo os options do select dinamicamente
                        foreach ($arrObjConcurso as $value){
                            $objLocalidade = $value->_field_data["tid"]["entity"];

                            if(!in_array($objLocalidade->field_localidade["und"][0]["value"], $array)){
                                print '<option value="' . strtolower($objLocalidade->field_localidade["und"][0]["value"]) . '">';
                                print $objLocalidade->field_localidade["und"][0]["value"];
                                print '</option>';
                                $array[] = $objLocalidade->field_localidade["und"][0]["value"];
                            }
                        }
                    ?>
		</select>
	</div>
	<div class="lista">
		<!------------------------>
            <?php
            //echo '<pre>'; print_r($arrObjConcurso);die;

            foreach($arrObjConcurso as $key => $value):
            $objConcurso = $value->_field_data["tid"]["entity"];
            ?>
                <div class="item <?= strtolower($objConcurso->field_localidade["und"][0]["value"]) ?>">
                    <?php if($objConcurso->field_script_banner["und"][0]["value"]): ?>
                    <div class="banner">
                            <?= $objConcurso->field_script_banner["und"][0]["value"]; ?>
                    </div>
                    <?php endif; ?>				
                    <h3 class="titulo"><a href="<?= (empty($objConcurso->field_url["und"][0]["value"])) ? "javascript:void(0)" : $objConcurso->field_url["und"][0]["value"]; ?>"><?= $objConcurso->name; ?></a></h3>
                    <p><a href="<?= (empty($objConcurso->field_url["und"][0]["value"])) ? "javascript:void(0)" : $objConcurso->field_url["und"][0]["value"]; ?>"><?= strip_tags($objConcurso->description) ?></a></p>
                    <?php if(!empty($objConcurso->field_data_edital["und"][0]["value"]) && $objConcurso->field_data_edital["und"][0]["value"] >= time()): ?>
                    <span class="edital"><strong>Edital</strong>&nbsp;&nbsp;<?= date("d/m/Y", $objConcurso->field_data_edital["und"][0]["value"]); ?></span>		 
                    <?php elseif(!empty($objConcurso->field_data_inscricao["und"][0]["value"]) && $objConcurso->field_data_inscricao["und"][0]["value"] <= time()): ?>
                    <span class="data"><strong>Inscrições</strong>&nbsp;&nbsp;<?= date("d/m/Y", $objConcurso->field_data_inscricao["und"][0]["value"]); ?></span>
                    <?php else: ?>
                    <span class="data"><strong>Inscrições</strong>&nbsp;&nbsp;Até <?= date("d/m/Y", $objConcurso->field_data_inscricao["und"][0]["value2"]); ?></span>
                    <?php endif; ?>

                    <?php if(!empty($objConcurso->field_vencimentos["und"][0]["value"])): ?>
                    <span class="salario"><strong>Salário</strong>&nbsp;&nbsp;<?= $objConcurso->field_vencimentos["und"][0]["value"] ?></span>
                    <?php endif; ?>

                     <?php if(!empty($objConcurso->field_data_prova)): ?>
                    <span class="provas"><strong>Provas</strong>&nbsp;&nbsp;
                    <?php 
                    foreach ($objConcurso->field_data_prova["und"] as $value){
                            print date("d/m/Y", $value["value"]) . "&nbsp;&nbsp;";
                    } 
                    ?></span>
                    <?php endif; ?>

                </div>
		<!------------------------>
            <?php
                endforeach;
            ?>
	</div>
</div>
<!------------------------------------------------------------------------------------------------------------>


<script type="text/javascript">
(function ($) {
	$("document").ready(function(){
		$("#localidade").change(function(){
                    if($(this).val() == "all"){
                        $(".item").show();
                    }else{
                        $(".item").hide();
                        $("." + $(this).val()).show();
                    }
		});
	});
})(jQuery);
</script>