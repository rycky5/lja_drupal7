<?php
//Variavel com a lista de ids ignorados
$strIgnoredIds = "";

//Incluindo o arquivo para o uso da função q renderiza o bloco manualmente
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'leiaja') .'/template.api.inc';

?>
<div class="tudo">
    <div class="topo">
        
        <h1 class="logo">
            <a href="/eleicoes">Especial Eleições</a>
        </h1>
        <div class="logoLeiaja">
            <a href="/"></a>
        </div>
        <div class="menuEbusca">
            <div class="menu">
                <?php require 'menu.php'; ?>
            </div>
            <div class="busca">
                <form id="search-form" action="http://www1.leiaja.com/search/node" method="get" accept-charset="UTF-8">
                    <input  type="text" id="campoBusca" name="keys" class="itemBusca" value="procura algo?" />
                    <input type="button" class="btBuscar" />
                </form>
            </div>
        </div>
    </div>
    <div class="centro">
        <div class="anuncio728"><?php print render($page["publicidade_top"]) ?></div>
        <div class="bloco01">
            <div class="left">
                <div class="slider">
                    
                    <?php
                    
                    //Recuperando a view eleicoes
                    $objViewSlider = views_get_view('Eleicoes2013');
                    //Selecionando o display slider
                    $objViewSlider->set_display('slider');
                    //Executando o display
                    $objViewSlider->execute();
                    //Renderizando o conteúdo
                    $output = $objViewSlider->render();
                    
                    //Printando o conteúdo renderizado
                    print $output;
                    
                    //Recuperando os ids para ignorar
                    $strIgnoredIds = getIgnoreNidEleicoes($objViewSlider->result);

                    ?>

                </div>
                <div class="bloco02_news">
                    
                    <?php
                    
                    //Recuperando a view eleicoes
                    $objViewSemImg = views_get_view('Eleicoes2013');
                    //Selecionando o displa sem_imagem
                    $objViewSemImg->set_display('sem_imagem');
                    //Ignorando os ids
                    $objViewSemImg->args = array($strIgnoredIds);
                    //Executando o display
                    $objViewSemImg->execute();
                    //Renderizando o conteúdo
                    $output = $objViewSemImg->render();
                    
                    //Printando o conteúdo renderizado
                    print $output;
                    
                    //Recuperando os ids para ignorar
                    $strIgnoredIds = getIgnoreNidEleicoes($objViewSemImg->result, $strIgnoredIds);
                    ?>                    
                    
                </div>
            </div>
            <div class="right">
                <div class="noticiaDestaque">
                    <?php
            
                    //Recuperando a view nodequeue4
                    $objViewFixo = views_get_view('nodequeue_4');
                    //Selecionando o display
                    $objViewFixo->set_display('bloco_estatico');
                    
                    //Executando o display
                    $objViewFixo->execute();
                    //Renderizando o conteúdo
                    $output = $objViewFixo->render();

                    //Printando o conteúdo renderizado
                    print $output;

                    //Recuperando os ids para ignorar
                    $strIgnoredIds = getIgnoreNidEleicoes($objViewFixo->result, $strIgnoredIds);

                    ?>
                </div>
                
            </div>
        </div>
        <div class="bloco3noticiasFoto">
            
            <?php
            
            //Recuperando a view eleicoes
            $objViewComImg = views_get_view('Eleicoes2013');
            //Selecionando o display
            $objViewComImg->set_display('com_imagem');
            //Ignorando os IDs
            $objViewComImg->args = array($strIgnoredIds);
            //Executando o display
            $objViewComImg->execute();
            //Renderizando o conteúdo
            $output = $objViewComImg->render();
            
            //Printando o conteúdo renderizado
            print $output;
            
            //Recuperando os ids para ignorar
            $strIgnoredIds = getIgnoreNidEleicoes($objViewComImg->result, $strIgnoredIds);
            
            ?>            
            
            <div class="anuncio200">
                <?php print render($page["sidebar_first"]) ?>
            </div>
        </div>   
        <div class="caixacinza3noticias">
            
            <?php
            
            //Recuperando a view eleicoes
            $objView3sImagem = views_get_view('Eleicoes2013');
            //Selecionando o display
            $objView3sImagem->set_display('tres_sem_imagem');
            //Ignorando os ids
            $objView3sImagem->args = array($strIgnoredIds);
            //Executando o display
            $objView3sImagem->execute();
            //Renderizando o conteúdo
            $output = $objView3sImagem->render();
            
            //Printando o conteúdo
            print $output;
            
            //Recuperando os ids para ignorar
            $strIgnoredIds = getIgnoreNidEleicoes($objView3sImagem->result, $strIgnoredIds);
            
            ?>
            
        </div>
        <div class="container demo-3">

            <ul class="grid cs-style-3">
                <h2>V&Iacute;DEOS</h2>
                
                <?php
                //Recuperando a view eleicoes
                $objViewVideos = views_get_view('Eleicoes2013');
                //Selecionando do display
                $objViewVideos->set_display('video');
                //Ignorando os ids
                $objViewVideos->args = array($strIgnoredIds);
                //Executando o display
                $objViewVideos->execute();
                //Renderizando o conteúdo
                $output = $objViewVideos->render();
                
                //Printando o conteúdo
                print $output;
                
                //Recuperando os ids para ignorar
                $strIgnoredIds = getIgnoreNidEleicoes($objViewVideos->result, $strIgnoredIds);
                
                ?>
                                
            </ul>
        </div><!-- /container -->
        <script src="sites/all/themes/eleicoes/imagesjs/toucheffects.js"></script>
        <div class="caixacinza3noticias">
            <?php
            
            //Recuperando a view eleicoes
            $objViewPromovido = views_get_view('Eleicoes2013');
            //Selecionando o display
            $objViewPromovido->set_display('promovido');
            //Ignorando os ids
            $objViewPromovido->args = array($strIgnoredIds);
            //Executando o display
            $objViewPromovido->execute();
            //Renderizando o conteúdo
            $output = $objViewPromovido->render();
            
            //Printando o conteúdo
            print $output;
            
            //Recuperando os ids para ignorar
            $strIgnoredIds = getIgnoreNidEleicoes($objViewPromovido->result, $strIgnoredIds);
            
            ?>
            
        </div>
    </div>
    <div class="lista03noticias">
        <div class="top">
            
            <?php
            
            //Recuperando a view eleicoes
            $objViewCronTop = views_get_view('Eleicoes2013');
            //Selecionando o display
            $objViewCronTop->set_display('ordem_cron_top');
            //Ignorando os ids
            $objViewCronTop->args = array($strIgnoredIds);
            //Executando o display
            $objViewCronTop->execute();
            //Renderizando o conteúdo
            $output = $objViewCronTop->render();
            
            //Printando o conteúdo
            print $output;
            
            //Recuperando os ids para ignorar
            $strIgnoredIds = getIgnoreNidEleicoes($objViewCronTop->result, $strIgnoredIds);
            
            ?>
            
        </div>
        <div class="bottom">
            
            <?php
            
            //Recuperando a view eleicoes
            $objViewCronBot = views_get_view('Eleicoes2013');
            //Selecionando o display
            $objViewCronBot->set_display('ordem_cron_top');
            //Ignorando os ids
            $objViewCronBot->args = array($strIgnoredIds);
            //Executando o display
            $objViewCronBot->execute();
            //Renderizando o conteúdo
            $output = $objViewCronBot->render();
            
            //Printando o conteúdo
            print $output;
            
            //Recuperando os ids para ignorar
            $strIgnoredIds = getIgnoreNidEleicoes($objViewCronTop->result, $strIgnoredIds);

            ?>
            
        </div>
    </div>
</div><!-- fim div centro -->
<div class="rodape">
<div class="rodapecentro">
    <p>LEIAJA | ELEIÇÕES</p>
    <div class="menuRodape">
    	<?php require 'menu.php'; ?>
    </div>
</div>

<script>
    (function($){
        $("document").ready(function(){
            
            //Verifica o valor do campo de busca quando ele receber o foco
            $("#campoBusca").focus(function(){
                if($(this).val() == "procura algo?"){
                    $(this).val("");
                }
            });
            
            //Verifica o valor do campo de busca quando ele perder o foco
            $("#campoBusca").blur(function(){
                if($(this).val() == ""){
                    $(this).val("procura algo?");
                }
            });
            
            //Dispara o evendo quando o form for enviado
            $("#search-form").submit(function(){
                if($("#campoBusca").val() == "" || $("#campoBusca").val() == "procura algo?"){
                    alert("Preencha o campo com pelo menos uma palavra relevante!");
                    return false;
                }else{
                    return true;
                }
            });
            
        });
    })(jQuery);
</script>