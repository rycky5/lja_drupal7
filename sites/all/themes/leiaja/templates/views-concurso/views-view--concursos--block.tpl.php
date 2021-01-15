<?php
// FORMATO DA EXIBIÇÃO DO BLOCO
$formatoBloco = filter_input(INPUT_GET, 'formato', FILTER_SANITIZE_STRING);

/**
 * Caminho para os ícones na raiz do tema
 */
$path = "/" . drupal_get_path('theme', 'leiaja');

//Recuperando os valores da view
$arrObjConcurso = $view->result;
$arrCores = array("rosa", 'roxo', 'laranja');

header('Content-type: text/html; charset=UTF-8');
?>

<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>


 <?php if($formatoBloco != 'horizontal'): ?>
    <link href='<?php echo $path; ?>/css/bloco_embed_concursos.css' rel='stylesheet' type='text/css'>
 <?php else: ?>
    <link href='<?php echo $path; ?>/css/bloco_embed_concursos_horizontal.css' rel='stylesheet' type='text/css'>
 <?php endif; ?>


<div class="concursos_box <?php if ($formatoBloco == 'horizontal') { echo $formatoBloco; } ?>">
    <div class="concursos_box_titulo" >
        <h2>
            <a target="_parent" href="http://www.leiaja.com" title="LeiaJá">
                <span class="azul">Leia</span><span class="vermelho">J&aacute;</span>
            </a>
            <a target="_parent" href="http://www1.leiaja.com/carreiras/concursos" title="LeiaJá Concursos">
                <span>Concursos</span>
            </a>
        </h2>
        <div class="advertpro">
            <!-- BEGIN ADVERTPRO CODE  SELO CONCURSOS-->
            <script type="text/javascript">
                document.write('<scr' + 'ipt src="http://ads.leiaja.com/servlet/view/banner/javascript/zone?zid=41&pid=0&random=' + Math.floor(89999999 * Math.random() + 10000000) + '&millis=' + new Date().getTime() + '&referrer=' + encodeURIComponent(document.location) + '" type="text/javascript"></scr' + 'ipt>');
            </script>
            <!-- END ADVERTPRO CODE -->
        </div>
    </div>
    
    

    
    <div class="concurso_dia" id="concurso_dia">
        
        <?php if($formatoBloco != 'horizontal'): ?>
            <p>Procure os<br /><strong>Concursos</strong></p>
        <?php else: ?>
            <p><strong>Filtrar</strong></p>
        <?php endif; ?>
        
        <select id="localidade">
            <option>Todos os concursos</option>
            <?php
            $array = array();
            //imprimindo os options do select dinamicamente
            foreach ($arrObjConcurso as $value) {
                $objLocalidade = $value->_field_data["tid"]["entity"];

                if (!in_array($objLocalidade->field_localidade["und"][0]["value"], $array)) {
                    print '<option>';
                    print $objLocalidade->field_localidade["und"][0]["value"];
                    print '</option>';
                    $array[] = $objLocalidade->field_localidade["und"][0]["value"];
                }
            }
            ?>
        </select>         
            
        <?php if($formatoBloco == 'horizontal'): ?>
            <div class="ver-todos">
                <a class="bt-todos" target="_parent" href="http://www1.leiaja.com/carreiras/concursos" title="LeiaJá Concursos">
                    <span>Veja mais</span>
                </a>
            </div>
        <?php endif; ?>  
    </div>
    
    
    <?php if($formatoBloco != 'horizontal'): ?>
      
    
        <div class="concursos_box_scroll" style="<?php echo ($formatoBloco == 'appleiaja') ? "height: 488px" : "height: 436px"; ?>" >
            <?php
            foreach ($arrObjConcurso as $key => $value):

                $objConcurso = $value->_field_data["tid"]["entity"];

                $url = $objConcurso->field_url["und"][0]["value"];
                $path_node = preg_replace('/\//', '', parse_url($url, PHP_URL_PATH), 1);

                $size = strlen($path_node);
                $tratar_url = substr($path_node, $size - 1);

                if ($tratar_url == '/') {
                    $path_node = substr($path_node, 0, $size - 1);
                }

                $org_path = drupal_lookup_path("source", $path_node);
                $node = menu_get_object("node", 1, $org_path);
                ?>
                <div class="concurso concurso_box <?= strtolower($objConcurso->field_localidade["und"][0]["value"]); ?> node-<?= $key; ?>">

                    <?php if ($formatoBloco == 'appleiaja' && !empty($node)): ?>
                        <div class="concurso_categoria_cinza">
                            <h3>
                                <a target="_self" href="javascript:void(0);" onclick="nodeLoad('<?= $key; ?>')">  
                                    <?= $objConcurso->name; ?>
                                </a>
                            </h3>
                        </div>
                        <div class="concurso_desc">
                            <p>
                                <a target="_self" href="javascript:void(0);" onclick="nodeLoad('<?= $key; ?>')">  
                                    <?= truncate_utf8($objConcurso->description, 100); ?>
                                </a>
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="concurso_categoria_cinza">
                            <h3>
                                <a target="_parent" href="<?= ($objConcurso->field_url["und"][0]["value"]) ? $objConcurso->field_url["und"][0]["value"] : "javascript:void(0);"; ?>" title="<?= $objConcurso->name; ?>">
                                    <?= $objConcurso->name; ?>
                                </a>
                            </h3>
                        </div>
                        <div class="concurso_desc">
                            <p>
                                <a target="_parent" href="<?= ($objConcurso->field_url["und"][0]["value"]) ? $objConcurso->field_url["und"][0]["value"] : "javascript:void(0);"; ?>" title="<?= $objConcurso->name; ?>">                    
                                    <?= truncate_utf8($objConcurso->description, 100); ?>
                                </a>
                            </p>
                        </div>
                    <?php endif; ?>

                    <div class="concurso_infos">
                        <?php if (!empty($objConcurso->field_data_edital["und"][0]["value"]) && $objConcurso->field_data_edital["und"][0]["value"] >= time()): ?>
                            <div class="concurso_linha">
                                <span><img src="<?= $path ?>/images/data_icone.png" width="16" height="16" alt="Inscrições" /></span>
                                <span>&nbsp;Edital: <?= date("d/m/Y", $objConcurso->field_data_edital["und"][0]["value"]); ?></span>
                            </div>
                        <?php elseif (!empty($objConcurso->field_data_inscricao["und"][0]["value"]) && $objConcurso->field_data_inscricao["und"][0]["value"] <= time()): ?>
                            <div class="concurso_linha">
                                <span><img src="<?= $path ?>/images/data_icone.png" width="16" height="16" alt="Inscrições" /></span>
                                <span>&nbsp;Inscri&ccedil;&otilde;es: <?= date("d/m/Y", $objConcurso->field_data_inscricao["und"][0]["value"]); ?></span>
                            </div>
                        <?php else: ?>
                            <div class="concurso_linha">
                                <span><img src="<?= $path ?>/images/data_icone.png" width="16" height="16" alt="Inscrições" /></span>
                                <span>&nbsp;Inscri&ccedil;&otilde;es: Até <?= date("d/m/Y", $objConcurso->field_data_inscricao["und"][0]["value2"]); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($objConcurso->field_data_prova)): ?>
                            <div class="concurso_linha">
                                <span><img src="<?= $path ?>/images/data_icone.png" width="16" height="16" alt="Provas" /></span>
                                <span>
                                    &nbsp;Provas: 
                                    <?php
                                    foreach ($objConcurso->field_data_prova["und"] as $value) {
                                        print date("d/m/Y", $value["value"]) . "<br>";
                                    }
                                    ?>
                                </span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($objConcurso->field_vencimentos["und"][0]["value"])): ?>
                            <div class="concurso_linha">
                                <span><img src="<?= $path ?>/images/salario_icone.png" width="16" height="16" alt="Salário" /></span>
                                <span>&nbsp;Sal&aacute;rio: <?= $objConcurso->field_vencimentos["und"][0]["value"] ?></span>
                            </div>
                        <?php endif; ?>
                    </div><!--fim evento infos-->

                </div><!--fim evento box-->


                <?php if ($formatoBloco == 'appleiaja'): ?>
                <div class="content-nodes content-node-<?= $key; ?>" style="display: none;">
                    <div class="inner_content">
                        <div class="title">
                            <h1><?= stripslashes($node->title) ?></h1>
                            <?php
                            if (!empty($node->body[key($node->body)][0]['summary'])):
                                ?>
                                <h2><?= $node->body[key($node->body)][0]['summary'] ?></h2>
                                <?php
                            endif;
                            ?>
                            <div class="info">
                                <?php
                                $file = drupal_get_path('theme', 'leiaja2') . '/images/' . semAcentos($node->field_fonte[$node->language][0]['value']) . '.jpg';

                                if (!empty($node->field_fonte)) {
                                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . base_path() . $file)) {
                                        if ($node->field_fonte[$node->language][0]['value'] == 'LeiaJá' && !in_array('administrator', $vUserRoles)) {
                                            echo '<span class="author"><img height="18" src="/' . $file . '" title=""></span>';
                                        } else {
                                            echo '<span class="author"><img height="18" src="/' . $file . '" title=""></span>';
                                            echo '<span class="date fa fa-calendar">' . $date . '</span>';
                                        }
                                    } else {
                                        echo '<span class="author">' . $node->field_fonte[$node->language][0]['value'] . '</span>';
                                    }
                                }
                                ?>               

                                <?php if ($node->changed == $node->created): ?>
                                    <span class="author date-node fa"><?= date('d/m/Y - h:m', $node->changed); ?></span>
                                <?php else: ?>
                                    <span class="author date-node fa">Atualizado em: <?= date('d/m/Y - h:m', $node->changed); ?></span>
                                <?php endif; ?>

                            </div><!-- fim info -->
                        </div><!-- fim title -->

                        <div class="content_node">
                            <?php
                            if (!empty($node->field_imagem_topo)):
                                ?>
                                <img src="<?= file_create_url($node->field_imagem_topo[key($node->field_imagem_topo)][0]['uri']) ?>" class="align_center" alt="<?= $node->field_imagem_topo[key($node->field_imagem_topo)][0]['alt'] ?>" title="<?= $node->field_imagem_topo[key($node->field_imagem_topo)][0]['title'] ?>" />

                                <p>
                                    <span class="legendaFotoGrande">
                                        <?= ($node->field_imagem_topo[key($node->field_imagem_topo)][0]['title']) ? $node->field_imagem_topo[key($node->field_imagem_topo)][0]['title'] : '' ?> 
                                        <em><?= ($node->field_imagem_topo[key($node->field_imagem_topo)][0]['alt']) ? $node->field_imagem_topo[key($node->field_imagem_topo)][0]['alt'] : '' ?></em>
                                    </span>
                                </p>
                                <?php
                            endif;
                            ?>
                            <?php
                            if (count($node->field_image[key($node->field_image)]) == 1):
                                ?>
                                <div class="imgLeft">
                                    <img src="<?= image_style_url('400x300', $node->field_image[key($node->field_image)][0]['uri']) ?>"  alt="<?= $node->field_image[key($node->field_image)][0]['alt'] ?>" title="<?= $node->field_image[key($node->field_image)][0]['title'] ?>" />
                                    <?php
                                    if (!empty($node->field_image[key($node->field_image)][0]['title']) && !empty($node->field_image[key($node->field_image)][0]['alt'])):
                                        ?>
                                        <span class="legenda">
                                            <?= ($node->field_image[key($node->field_image)][0]['title']) ? $node->field_image[key($node->field_image)][0]['title'] : '' ?> 
                                            <em><?= ($node->field_image[key($node->field_image)][0]['alt']) ? $node->field_image[key($node->field_image)][0]['alt'] : '' ?></em>
                                        </span>
                                        <?php
                                    endif;
                                    ?>
                                </div>
                                <?php
                            endif;
                            ?>

                            <?php
                            //Verificando se o campo de galeria tem mais de uma foto e se existe a hash de galeria
                            if (count($node->field_image[key($node->field_image)]) > 1 && strpos($node->body[key($node->body)][0]['value'], '[@#galeria#@]')) {
                                ob_start();
                                getGaleriaFull($node);
                                $galeria = ob_get_contents();
                                ob_end_clean();
                                $node->body[key($node->body)][0]['value'] = str_replace('[@#galeria#@]', $galeria, $node->body[key($node->body)][0]['value']);
                            }
                            //hash de video
                            if (!empty($node->field_videost)) {
                                $embedVideo = ($scriptVideoEmbed[key($scriptVideoEmbed)]['value']) ? '<div class="embedvideobarra"><h5>Embed:</h5><input type="text" value="' . $node->field_videost[key($node->field_videost)][0]['safe_value'] . '"></div>' : '';
                                $scriptVideo = '<div class="embedvideoplayer">' . $node->field_videost[key($node->field_videost)][0]['value'] . $embedVideo . '</div>';
                                $node->body[key($node->body)][0]['value'] = str_replace('[@#video#@]', $scriptVideo, $node->body[key($node->body)][0]['value']);
                            }
                            //Hash de podcast
                            if (!empty($node->field_audiost)) {
                                $node->body[key($node->body)][0]['value'] = str_replace('[@#podcast#@]', $node->field_audiost[key($node->field_audiost)][0]['value'], $node->body[key($node->body)][0]['value']);
                            }
                            //Removendo a hash ##RECOMENDA##
                            $node->body[key($node->body)][0]['value'] = str_replace('##RECOMENDA##', '', $node->body[key($node->body)][0]['value']);
                            //Printando o corpo da node
                            print $node->body[key($node->body)][0]['value'];
                            ?>
                        </div><!-- fim content_node --> 
                    </div><!-- fim inner_content -->

                </div><!--fim node-ID -->
                <?php endif; ?>

            <?php endforeach; ?>
                
            <?php if ($formatoBloco == 'appleiaja'): ?>    
                <div class="ver-todos" style="display: none;">
                    <a class="bt-voltar" target="_self" href="javascript:void(0);" title="Voltar para LeiaJá Concursos">Voltar</a>
                </div>
            <?php endif; ?>
                
        </div><!--fim concursos_box_scroll-->
    
        <?php if ($formatoBloco != 'appleiaja'): ?> 
            <div class="ver-todos">
                <a class="bt-todos" target="_parent" href="http://www1.leiaja.com/carreiras/concursos" title="LeiaJá Concursos">
                    <span>Ver todos os <strong>Concursos</strong></span>
                </a>
            </div><!--fim ver-todos -->
        <?php endif; ?>
    
    <?php 
        //FORMATO HORIZONTAL
        else: 
    ?>
          
    
        <div class="concursos_box_scroll_horizontal">
            <?php
            foreach ($arrObjConcurso as $key => $value):

                $objConcurso = $value->_field_data["tid"]["entity"];

                $url = $objConcurso->field_url["und"][0]["value"];
                $path_node = preg_replace('/\//', '', parse_url($url, PHP_URL_PATH), 1);

                $size = strlen($path_node);
                $tratar_url = substr($path_node, $size - 1);

                if ($tratar_url == '/') {
                    $path_node = substr($path_node, 0, $size - 1);
                }

                $org_path = drupal_lookup_path("source", $path_node);
                $node = menu_get_object("node", 1, $org_path);
                ?>
                <div class="concurso concurso_box <?= strtolower($objConcurso->field_localidade["und"][0]["value"]); ?> node-<?= $key; ?>">
                    <div class="concurso_categoria_cinza">
                        <h3>
                            <a target="_parent" href="<?= ($objConcurso->field_url["und"][0]["value"]) ? $objConcurso->field_url["und"][0]["value"] : "javascript:void(0);"; ?>" title="<?= $objConcurso->name; ?>">
                                <?= $objConcurso->name; ?>
                            </a>
                        </h3>
                    </div>
                    <div class="concurso_desc">
                        <p>
                            <a target="_parent" href="<?= ($objConcurso->field_url["und"][0]["value"]) ? $objConcurso->field_url["und"][0]["value"] : "javascript:void(0);"; ?>" title="<?= $objConcurso->name; ?>">                    
                                <?= truncate_utf8($objConcurso->description, 100); ?>
                            </a>
                        </p>
                    </div>
                    <div class="concurso_infos">
                        <?php if (!empty($objConcurso->field_data_edital["und"][0]["value"]) && $objConcurso->field_data_edital["und"][0]["value"] >= time()): ?>
                            <div class="concurso_linha">
                                <span><img src="<?= $path ?>/images/data_icone.png" width="16" height="16" alt="Inscrições" /></span>
                                <span>&nbsp;Edital: <?= date("d/m/Y", $objConcurso->field_data_edital["und"][0]["value"]); ?></span>
                            </div>
                        <?php elseif (!empty($objConcurso->field_data_inscricao["und"][0]["value"]) && $objConcurso->field_data_inscricao["und"][0]["value"] <= time()): ?>
                            <div class="concurso_linha">
                                <span><img src="<?= $path ?>/images/data_icone.png" width="16" height="16" alt="Inscrições" /></span>
                                <span>&nbsp;Inscri&ccedil;&otilde;es: <?= date("d/m/Y", $objConcurso->field_data_inscricao["und"][0]["value"]); ?></span>
                            </div>
                        <?php else: ?>
                            <div class="concurso_linha">
                                <span><img src="<?= $path ?>/images/data_icone.png" width="16" height="16" alt="Inscrições" /></span>
                                <span>&nbsp;Inscri&ccedil;&otilde;es: Até <?= date("d/m/Y", $objConcurso->field_data_inscricao["und"][0]["value2"]); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($objConcurso->field_data_prova)): ?>
                            <div class="concurso_linha">
                                <span><img src="<?= $path ?>/images/data_icone.png" width="16" height="16" alt="Provas" /></span>
                                <span>
                                    &nbsp;Provas: 
                                    <?php
                                    foreach ($objConcurso->field_data_prova["und"] as $value) {
                                        print date("d/m/Y", $value["value"]) . "<br>";
                                    }
                                    ?>
                                </span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($objConcurso->field_vencimentos["und"][0]["value"])): ?>
                            <div class="concurso_linha">
                                <span><img src="<?= $path ?>/images/salario_icone.png" width="16" height="16" alt="Salário" /></span>
                                <span>&nbsp;Sal&aacute;rio: <?= $objConcurso->field_vencimentos["und"][0]["value"] ?></span>
                            </div>
                        <?php endif; ?>
                    </div><!--fim evento infos-->

                </div><!--fim evento box-->
            <?php endforeach; ?>
        </div><!--fim concursos_box_scroll-->
    
       
    <?php endif; ?>
    
    
 

</div><!--fim concursos_box-->


<script src="http://www.leiaja.com/sites/all/themes/leiaja2/css/boxes/jquerycapa.min.js"></script>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="<?php echo $path; ?>/js/jquery.jscrollpane.min.js"></script>
<script src="<?php echo $path; ?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript">
    $("document").ready(function () {

        $(".concursos_box_scroll").jScrollPane({autoReinitialise: true});

        $("#localidade").change(function () {
            if ($(this).val() == "Todos os concursos") {
                $(".concurso").show();
                $(".content-nodes").hide();
            } else {
                $(".concurso").hide();
                $(".content-nodes").hide();
                $(".concursos_box").find("." + $(this).val().toLowerCase()).show();
                $('.concursos_box_scroll').jScrollPane({autoReinitialise: true});
            }
            $('.concursos_box_scroll').css('height', '488px');
        });

    });

    var element = $('.concursos_box_scroll').jScrollPane();
    var api = element.data('jsp');

    function nodeLoad(alvo) {
        $(".concurso_box").hide();
        $(".ver-todos").show();
        $(".content-node-" + alvo).show();
        $('.concursos_box_scroll').jScrollPane({autoReinitialise: true});
        api.scrollTo(0, 0);
    }

    $(".bt-voltar").click(function () {
        $(".ver-todos").hide();
        $(".concurso").show();
        $(".content-nodes").hide();
        $('.concursos_box_scroll').jScrollPane({autoReinitialise: true});
        api.scrollTo(0, 0);
    });
</script>