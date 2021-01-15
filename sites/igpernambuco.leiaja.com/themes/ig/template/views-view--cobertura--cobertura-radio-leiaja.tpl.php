<?php
$titulo = $view->result[0]->node_title;
$texto = $view->result[0]->_field_data ["nid"]["entity"]->body["pt-br"][0] ["safe_summary"];
$imagem = $view->result[0]->_field_data ["nid"]["entity"]->field_capa["pt-br"][0]["uri"];
if (!empty($imagem)) {
  $url_imagem = image_style_url('113_45', $imagem);
}
$link = drupal_lookup_path('alias', 'node/'.$view->result[0]->nid);
//$background = $view->result[0]->_field_data ["nid"]["entity"]->field_background["pt-br"][0]["uri"]
//if (!empty($background)) {
//  $url_background = ;
//}
?>
<style type="text/css">
/**FAIXA**/
 .faixa_aovivo_ig .faixa_urgente_pai { width:986px !important;margin-left:10px }
 .faixa_aovivo_ig .faixa_urgente { width:986px !important}
  .faixa_urgente_pai {
	border: 0 none;
	height: 45px;
	margin:20px 0 0 0;
	padding-bottom: 0;
	float:left;
	font-family:Arial, Helvetica, sans-serif;
	width:940px;
}
.faixa_urgente {
	background: none no-repeat scroll 10px 6px transparent;
	border:1px solid lightgray;
	border-radius: 3px 3px 3px 3px;
	height: 100%;
	height:45px;
	width:940px;
	line-height:45px;
}
.faixa_urgente .faixa_box {
	background: #fefefe;
	background: -moz-linear-gradient(top,#fefefe 0,#f8f8f8 100%);
	background: -webkit-gradient(linear,left top,left bottom,color-stop(0%,#fefefe),color-stop(100%,#f8f8f8));
	background: -webkit-linear-gradient(top,#fefefe 0,#f8f8f8 100%);
	background: -o-linear-gradient(top,#fefefe 0,#f8f8f8 100%);
	background: -ms-linear-gradient(top,#fefefe 0,#f8f8f8 100%);
	background: linear-gradient(to bottom,#fefefe 0,#f8f8f8 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fefefe',endColorstr='#f8f8f8',GradientType=0);
	color: #666666;
	display: block;
	font-size: 14px;
	height: 45px;
}
.faixa_urgente .logo_faixa {
	float:left;
	margin-left:15px;
}
.faixa_urgente .titulo_faixa {
	font-weight:bold;
	font-size:16px;
	float:left;
	margin-left:15px;
}
.faixa_urgente .titulo_faixa a{
	text-decoration:none;
	color: #666666;
}
.faixa_urgente .title_faixa {
	float: left;
	margin-left:15px;
}
.faixa_urgente .title_faixa a{
	text-decoration:none;
	color: #666666;
}
.faixa_urgente .title_faixa a {
	text-decoration:none;
	color: #666666;
}
.faixa_urgente .subtitle_faixa {
	float: right;
	letter-spacing: -0.5px;
	padding-right: 14px;
	text-transform: lowercase;
	white-space: nowrap;
}
 a.faixa_box:hover{
   background:white;
 }
</style>
<div class="divContainerContent faixa_aovivo_ig">
  <div class="faixa_urgente_pai">
    <div class="faixa_urgente"> 
        <span class="logo_faixa"> 
          <img src="<?php print $url_imagem; ?>" border="0" /> 
        </span> 
        <span class="titulo_faixa"> 
          <?php print $titulo; ?> 
        </span> 
        <span class="title_faixa"> 
          <?php print $texto; ?> 
        </span> 
        <span style="color: #0074BC;" class="subtitle_faixa"> 
         <?=  trim($view->result[0]->_field_data ["nid"]["entity"]->body["pt-br"][0] ["value"]) ?>
        </span> 
    </div>
  </div>
</div>
