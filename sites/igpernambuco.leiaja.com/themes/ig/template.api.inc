<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'template.db.inc';
/*
 * Retorna conteudo HTML processado dos blocos passados no parametro.
 * 
 */
function getBlocos($delta)
{
  $vBlocos = array();
  foreach($delta AS $key => $value){
    if(is_array($value)){
      $vBlocos[] = block_load($value[0],$value[1]);
    }else{
      $vBlocos[] = block_load('block',$value);
    }
  }
     
  return _block_get_renderable_array(_block_render_blocks($vBlocos));
}


/**
 * Retira acentos e Espa;os de uma String
 */
function semAcentos($string)
{
	$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
	$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	$string = utf8_decode($string);
	$string = strtr($string, utf8_decode($a), $b); //substitui letras acentuadas por &quot;normais&quot;
	$string = str_replace(' ', '', $string); // retira espaco
	$string = strtolower($string); // passa tudo para minusculo
	return utf8_encode($string); //finaliza, gerando uma saída para a funcao
}

/**
 * Método que irá receber a notícia e o content por parâmetro e ira retornar o conteúdo multimídia da node
 * 
 * @param array $content
 * @param stdClass $node 
 * @return void
 */
//function api_rederMultimidia(&$content, &$node){
////  echo "<pre>";
////  var_dump($node);
////  die;
//  hide($content['field_image']);
//  // Caso esteja marcado alguma posição de galeria 
//  if(preg_match("/\[\@\#galeria\#\@\]/",  $content["body"][0]["#markup"])){
//    // Array que conterá as hash para ser bustituida
//    $strBucaGaleria   = "[@#galeria#@]";
//
//    // Array que conterá os valores que a serem subistituidos
//    $strSubstituicaoGaleria      = render($content['field_image']) . getEmbedNoticia($node, "imagem");
//
//    // Substituindo a hash de galeria pela própria galeria rederizada
//    $content["body"][0]["#markup"] = str_replace($strBucaGaleria,(empty($strSubstituicaoGaleria)) ? '' : $strSubstituicaoGaleria, $content["body"][0]["#markup"]);
//  }else{
//    
//    // Liguagem
//    $strLinguagem = (!empty ($node->field_image[$node->language])) ? $node->language : "und";
//    
//    // Caso tenha um campo de imagem setada
//    if(!empty ($node->field_image) && count($node->field_image[$strLinguagem]) > 1){
//      // Array que conterá os valores que a serem subistituidos
//      $strSubstituicaoGaleria      = render($content['field_image']) . getEmbedNoticia($node, "imagem");
//
//      // Concatenando a galeria mais o copor da notícia
//      $content["body"][0]["#markup"] =  $strSubstituicaoGaleria  . $content["body"][0]["#markup"];
//    }
//  }
//
//  // Caso esteja marcado alguma posição e vídeo sambatech
//  if(preg_match("/\[\@\#video\#\@\]/", $content["body"][0]["#markup"])){
//
//    // Array que conterá as hash para ser bustituida
//    $strBucaVideo     = "[@#video#@]";
//
//    // linguagem
//    $strLinguagem = (!empty ($node->field_videost[$node->language][0]["value"])) ? $node->language : "und";
//
//    // Embed de vídeo
//    $strSubstituicaoVideo        = $node->field_videost[$strLinguagem][0]["value"] . getEmbedNoticia($node, "videost");
//
//    // realizando a substituição
//    $content["body"][0]["#markup"] = str_replace($strBucaVideo,(empty($strSubstituicaoVideo)) ? '' : $strSubstituicaoVideo, $content["body"][0]["#markup"]);
//  }else{
//    
//    // Liguagem
//    $strLinguagem = (!empty ($node->field_videost[$node->language][0]["value"])) ? $node->language : "und";
//    
//    // Caso tenha algum vídeo
//    if(!empty ($node->field_videost)){
//      // Embed de vídeo
//      $strSubstituicaoVideo        = $node->field_videost[$strLinguagem][0]["value"] . getEmbedNoticia($node, "videost");
//
//      // realizando a substituição
//      $content["body"][0]["#markup"] = $content["body"][0]["#markup"] . $strSubstituicaoVideo;
//    }
//  }
//
//  // Caso esteja marcado alguma posição e audio sambatech
//  if(preg_match("/\[\@\#podcast\#\@\]/", $content["body"][0]["#markup"])){
//
//    // Array que cont=erá as hash para ser bustituida
//    $strBucaVideo     = "[@#podcast#@]";
//
//    // linguagem
//    $strLinguagem = (!empty ($node->field_audiost[$node->language][0]["value"])) ? $node->language : "und";
//    $audioST= "<div class='audio-sambatech'>".$node->field_audiost[$strLinguagem][0]["value"]."</div>";
//    // Embed de vídeo
//    $strSubstituicaoVideo        = $audioST . getEmbedNoticia($node, "audiost");
//
//    // realizando a substituição
//    $content["body"][0]["#markup"] = str_replace($strBucaVideo,(empty($strSubstituicaoVideo)) ? '' : $strSubstituicaoVideo, $content["body"][0]["#markup"]);
//  }else{
//    // linguagem
//    $strLinguagem = (!empty ($node->field_audiost[$node->language][0]["value"])) ? $node->language : "und";
//    
//    // Caso tenha algum podcast
//    if(!empty ($node->field_audiost)){
//      
//      // div de audio st
//      $audioST= "<div class='audio-sambatech'>".$node->field_audiost[$strLinguagem][0]["value"]."</div>";
//     
//      // Embed de vídeo
//      $strSubstituicaoVideo        = $audioST . getEmbedNoticia($node, "audiost");
//
//      // realizando a substituição
//      $content["body"][0]["#markup"] = $strSubstituicaoVideo . $content["body"][0]["#markup"];
//    }
//    
//  }
  
  
  
//}

/**
 * Método que ira receber a node e irá retornar o embed conforme seu tipo
 * 
 * @param String $node
 * @param String $strTipo
 * @return string 
 */
function getEmbedNoticia($node, $strTipo){
  $strEmbed = "";
  switch ($strTipo){
    case 'imagem':
          $strEmbed = '<div class="detalhesVideo detalhesGaleria">
                        <span>Embed</span>
                        <div class="bgInputEmbed">
                            <input name="embed" type="text" value="<iframe src=\'http://'.$_SERVER['HTTP_HOST'].'/galeria/'.urlencode(base64_encode($node->nid)).'\' scrolling=\'no\' frameborder=\'0\' width=\'625\' height=\'590\'></iframe>" onclick="this.focus();this.select();" />
                        </div>
                        <span class="views">Views:<strong>'. getNodeViewsIg($node->nid).'</strong></span>
                      </div>';
          break;
   case 'videost':
          // incluindo os arquivos necessários
          module_load_include('inc', 'videosambatech', 'videosambatech.api');

          // Liguagem
          $strLinguagem = (!empty ($node->field_videost[$node->language][0]["value"])) ? $node->language : "und";

          // Embed para Vídeo Samba TECH
          $strEmbed = '<div class="detalhesVideo">
                          <span>Embed</span>
                          <div class="bgInputEmbed">
                              <input name="embed" type="text" value=\'' . $node->field_videost[$strLinguagem][0]["value"] . '\' onclick="this.focus();this.select();" />
                          </div>
                          <span class="views">Views:<strong>' . api_view_videos($node->field_videost[$strLinguagem][0]["value"]) . '</strong></span>
                        </div>';

          break;
    case 'audiost':
            // incluindo os arquivos necessários
            module_load_include('inc', 'videosambatech', 'videosambatech.api');

            // Liguagem
            $strLinguagem = (!empty ($node->field_videost[$node->language][0]["value"])) ? $node->language : "und";

            // Embed para Vídeo Samba TECH
            $strEmbed = '<div class="detalhesAudioST">
                            <span>Embed</span>
                            <div class="bgInputEmbed">
                                <input name="embed" type="text" value=\'' . $node->field_audiost[$strLinguagem][0]["value"] . '\' onclick="this.focus();this.select();" />
                            </div>
                            <span class="views">Views:<strong>' . api_view_videos($node->field_audiost[$strLinguagem][0]["value"]) . '</strong></span>
                          </div>';

            break;
      case 'video':
            $strEmbed = '<div class="detalhesVideo">
                          <span>Embed</span>
                                                      <div class="detalhesAudioST">
                          <div class="bgInputEmbed">
                              <input name="embed" type="text" value=\'<iframe src="http://'.$_SERVER['HTTP_HOST'].'/galeria/'.urlencode(base64_encode($node->nid)).'\' scrolling=\'no\' frameborder=\'0\' width=\'625\' height=\'590\'></iframe>" onclick="this.focus();this.select();" />
                          </div>
                                                      </div>
                          <span class="views">Views:<strong>' . getNodeViewsIg($node->nid) . ' </strong></span>
                        </div>';
            break;
  }
  
  // Retornando o Embed
  return $strEmbed;
}


/**
 * Método que irá recuperar e retornar qua o browser do usuário
 * 
 * @return Array 
 */
function api_getBrowser(){
  // Recuperando o user agente
  $useragent = $_SERVER['HTTP_USER_AGENT'];

    if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
      $browser_version=$matched[1];
      $browser = 'IE';
    } elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)) {
      $browser_version=$matched[1];
      $browser = 'Opera';
    } elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
      $browser_version=$matched[1];
      $browser = 'Firefox';
    } elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
      $browser_version=$matched[1];
      $browser = 'Chrome';
    } elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
      $browser_version=$matched[1];
      $browser = 'Safari';
    } else {
      // browser not recognized!
      $browser_version = 0;
      $browser= 'other';
    }
    
    // Array retorno
    $arrDadosBrowser = array();
    $arrDadosBrowser["strVersao"] = $browser_version;
    $arrDadosBrowser["strNome"] = $browser;

    // Retornando o browser
    return $arrDadosBrowser;
}