<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//echo "<pre>";
//var_dump($arrDadosUsuario);
//die();
?>
<style type="text/css">
    #listaocovest2012 {
        width:625px;
        float:left;

    }
    #listaocovest2012 li, #listaocovest2012 ul {
        float:left;
        list-style:none;
        margin:0px;
        padding:0px;
    }
    .blocohomecovest2012 {
        float:left;
        width:625px;
        border: 1px solid #aaaaaa;
        background-color:#f8f8f8;
        padding-bottom:20px;
    }
    .blocohomecovest2012 .tituloNoticia {
        width:360px;
        text-align:center;
        padding:0px 10px;
    }
    #buscacovest2012, #resultadocovest2012  {
        float:left;
        width:100%;
        margin-top:20px;
        padding-bottom:20px;
        margin-bottom:-20px;
        border-top:1px dotted #aaa;
        background-color:#fff;
    }
    #buscacovest2012 { margin-top: 0px !important; }
    #resultadocovest2012  {
        background-color:#fffff6;	
    }
    #listaocovest2012 form { margin-left:50px; }
    #listaocovest2012 #buscacovest2012 ul { width:580px;position:absolute;margin: -40px 0px 0px -90px;}
    #listaocovest2012 #buscacovest2012 li { font:16px arial;padding:5px; }
    #listaocovest2012 #buscacovest2012 .titulo { font:bold 16px arial;width:110px; }
    #listaocovest2012 .busca { margin-top:50px;border-bottom:1px solid #aaa; }
    #listaocovest2012 .busca li label { float:right;padding-left:3px; }
    #listaocovest2012 .busca li input { margin:0px;width:auto;height:auto;border:medium;float:right;margin-top:3px }
    #listaocovest2012 .busca div input { height:26px; }

    #resultadocovest2012 {
        text-align:center;
        padding-top:20px;
        font:16px arial;
    }
    #resultadocovest2012 p.texto { display:block;height:40px;}
    #resultadocovest2012 p.textofim { float:left;width:100%;margin-top:15px;}
    #resultadocovest2012 ul { width:100%;border-top:1px solid #aaa;font:14px arial; }
    #resultadocovest2012 li { padding:2% 1% 0 1%;border-bottom:1px solid #eeeeee;height:30px;overflow:hidden; }
    #resultadocovest2012 .w100 { width:98%;text-align:left; }
    #resultadocovest2012 .w50 { width:48%; }
    #resultadocovest2012 .w40 { width:38% }
    #resultadocovest2012 .w60 { width:58%;text-align:left; }
    #resultadocovest2012 .w20 { width:18% }
    #resultadocovest2012 .w33 { width:31% }
    #resultadocovest2012 .aprovado .w33 { width:30% }
    #resultadocovest2012 ul.even { background-color:#fff; }
    #resultadocovest2012 .vestnome { font:14px arial;background-color:#f1f1f1;border-bottom:1px solid #aaa; }
    #resultadocovest2012 .aprovado .vestnome { background-color:#f0f0de; }
    #resultadocovest2012 li div {
        font:12px arial;
        margin-top:-7px;
        float:left;
        width:30%;
    }
    #resultadocovest2012 li div p {
        float:left;
        width:50%;
    }
    #resultadocovest2012 .vestsnota .nota1 { margin-top:-12px; }
    #resultadocovest2012 .vestsnota p { text-align:left;font:13px arial;padding:3px 0px;margin-left:10px;float:left; }
    #resultadocovest2012 li div p strong { width:100%;padding-bottom:2px;}
    #resultadocovest2012 ul .veststatus { font:12px arial}
    #resultadocovest2012 ul.classificado .veststatus { color: #137100;font: bold 16px arial;background-color:#f7fef6;border-left:1px solid #eeeeee;border-right:1px solid #eeeeee; }
    #resultadocovest2012 ul.classificavel .veststatus { color: #003be2 ;font: bold 16px arial;background-color:#f3f6ff;border-left:1px solid #eeeeee;border-right:1px solid #eeeeee; }
</style>
<div id="listaocovest2012">
    <div class="blocohomecovest2012">
        <img src="/listaoufpe.jpg" />
        <div id="buscacovest2012">
            <div class="busca">
                <form class="search-form" action="" method="post" accept-charset="UTF-8">
                    <ul>
                        <li class="titulo">Busca por:</li>
                        <li><label for="covest2012tipo_inscricao" style="font:16px arial">N&ordm; de inscri&ccedil;&atilde;o</label> <input type="radio" id="covest2012tipo_inscricao" name="intTipoFiltro" value="1" checked="checked" /></li>
                        <li><label for="covest2012tipo_nome" style="font:16px arial">Nome do candidato</label> <input type="radio" id="covest2012tipo_nome" name="intTipoFiltro" value="2" /></li>
                        <li><label for="covest2012tipo_rg" style="font:16px arial">Doc. de identidade</label> <input type="radio" id="covest2012tipo_rg" name="intTipoFiltro" value="3" /></li>
                    </ul>
                    <div>
                        <input type="text" name="keys" class="search_box">
                        <button type="submit" name="op" value="search">Buscar</button>
                        <input type="hidden" name="form_id" value="search_theme_form">
                        <input type="hidden" name="form_token" value="f6JPrCjW9QYk8pcKRj0ZHrbBJI6_6rGRJPyAxAlZ3Yc">
                    </div>
                </form>
            </div>
        </div>
        <div id="resultadocovest2012">    
            <p class="texto"><?= $strMensagem;?></p>
        <?php
            if(!empty ($arrDadosUsuario)){
                foreach($arrDadosUsuario as $objusuario){
                  $situacao = str_replace('*', '', $objusuario->SITUACAODE);
        ?>
                <ul class="odd <?php if(!empty($situacao)){ echo "classificado"; }?> ">
                    <li class="vestnome w60"><strong><?= $objusuario->CANDDET ?></strong></li>
                    <li class="vestnome w40"><strong>Inscri&ccedil;&atilde;o:</strong> <?= $objusuario->INSCDET ?></li>
                    <li class="vestcurso w40"><?= $objusuario->NCURDET?></li>
                    <li class="vestturno w20"><?= $objusuario->TURNDET ?> </li>
                    <li class="vestcampus w40"><?= $objusuario->CAMPUSDET ?> </li>
                    <li class="veststatus w60"><?php if(!empty($situacao)){ echo  "Classificado - ".$objusuario->SITUACAODE; }?></li>
                        <!--
                        <li class="vestsnota w33">
 <strong>Nota 1&ordf; fase:</strong>
                    </li>
                         -->
                    <li class="vestsnota w33">
                       <strong>Arg. Classifica&ccedil;&atilde;o:</strong> <?= $objusuario->ARGCDET ?>
                    </li>
                </ul>
        <?php
                }
             
           echo "<p class='textofim'>Fim dos resultados encontrados.</p> ";
            }
        ?>
        </div>
    </div>
</div>