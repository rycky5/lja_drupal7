<?php

/**
 * Função responsável por gerar um embed com o conteudo de uma notícia
 * 
 * @param GET node
 * @param GET utf8
 * 
 * @return HTML | JSON
 */
function noticia_embed()
{
    
  if(!empty($_GET['node'])){
    
    // Lendo a notícia
    $node = node_load($_GET['node']);
    
    // Link para notícia
    $strLink = url(drupal_lookup_path('alias',"node/".$node->nid), array("absolute"=>true));
    
    // Criando a url Canonica
    $strURL = (!empty ($node->field_redireciona)) ? $node->field_redireciona[key($node->field_redireciona)][0]["value"] : $strLink;
    
    
    // Criando as metatags
    $strMetatag = '<meta property="og:title" content="' . $node->title . ' - LeiaJá" />
                   <meta property="og:description" content="' . strip_tags(str_replace("\"", "'", str_replace('##RECOMENDA##', '', limitaTextoTags($node->body['pt-br'][0]["value"], 250) ))). '" />
                   <meta property="og:url" content="'.$strURL.'" />';
    
    // Verificando quando campo d eimagem será usado
    $strImagem = key($node->field_image);
    $strImagemCapa = key($node->field_capa);
    
    // Pegando a imagem a ser usada
    $strLinkIMagem = (!empty ($node->field_capa[$strImagemCapa][0]['uri'])) ? $node->field_capa[$strImagemCapa][0]['uri'] : $node->field_image[$strImagem][0]['uri'];
    
    // Verificando se existe imagem se não seto a original
    if(!empty($strLinkIMagem))
      $strMetatag .= '<meta property="og:image" content="'. image_static_url ("large", $strLinkIMagem) .'" />';
    else
      $strMetatag .= '<meta property="og:image" content="http://www.leiaja.com/images/leiaja_acento.jpg" />';
    
    //var_dump($node);
    $texto = '<html><head><style>#divContainer p{
    color: #333;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 14px;
    line-height: 17px;
    margin: 10px 0 0;padding:0;
}
	.compartilhamentos  { width:100%;float:left;height:35px; }
		.compartilhamentos ul, .compartilhamentos li { float:left;padding:0;margin:0;overflow:hidden; }
		.googleplus { width:200px }
		.twitter-button { width:90px; }
		.facebook-button { width:90px; }
		#divContainer h1 { font:bold 18px arial;text-align:center;color:#3c2219 }
		#divContainer a { color:#51a0c4; }
</style> ' . $strMetatag . '</head><body>


              <div class="compartilhamentos">
                  <ul>
                    <!-- comments -->
                    <li class="googleplus">
                      <!-- Coloque esta tag onde você deseja que o botão +1 seja renderizado -->
                      <g:plusone annotation="inline"></g:plusone>

                      <!-- Coloque esta chamada de renderização conforme necessário -->
                      <script type="text/javascript">
                        window.___gcfg = {lang: \'pt-BR\'};

                        (function() {
                          var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
                          po.src = \'https://apis.google.com/js/plusone.js\';
                          var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
                        })();
                      </script>
                    </li>  
                    <!-- facebook -->
                    <!--twitter -->
                    <li class="twitter-button"><iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.1331069346.html#_=1331126405826&amp;count=horizontal&amp;id=twitter-widget-12&amp;lang=en&amp;original_referer='.urlencode($strURL).'&amp;size=m&amp;text='. $node->title .' @LeiaJaOnline&amp;url='. urlencode($strURL) .'" class="twitter-share-button twitter-count-horizontal" style="width: 110px; height: 20px; " title="Twitter Tweet Button"></iframe><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></li>
                    <li class="facebook-button">
                      <div id="fb-root"></div>

                      <fb:like href="" send="false" layout="button_count" width="450" show_faces="false" font="" class=" fb_edge_widget_with_comment fb_iframe_widget">
                        <span>
                          <iframe src="http://www.facebook.com/plugins/like.php?href='. urlencode('http://www.leiaja.com/embed/noticia?node=' . $node->nid . '&body=true&title=true&summary=true?v=99999') .'&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px; margin: -1px 0 0;" allowTransparency="true"></iframe>
                      <!--
                      <script src="http://connect.facebook.net/pt_BR/all.js#appId=218858281492606&amp;xfbml=1"></script>
                          <iframe id="f14571f11" name="f16e86a77c" scrolling="no" style="border-width: initial; border-color: initial; overflow-x: hidden; overflow-y: hidden; border-width: initial; border-color: initial; height: 20px; width: 450px; border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; border-width: initial; border-color: initial; border-image: initial; " title="Like this content on Facebook." class="fb_ltr" src="http://www.facebook.com/plugins/like.php?api_key=218858281492606&amp;channel_url=https%3A%2F%2Fs-static.ak.fbcdn.net%2Fconnect%2Fxd_proxy.php%3Fversion%3D3%23cb%3Df2738c6268%26origin%3Dhttp%253A%252F%252Fwww4.hallsocial.com%252Ffad4c7afc%26relation%3Dparent.parent%26transport%3Dpostmessage&amp;extended_social_context=false&amp;href=http%3A%2F%2Fwww4.hallsocial.com%2F&amp;layout=button_count&amp;locale=pt_BR&amp;node_type=link&amp;sdk=joey&amp;send=true&amp;show_faces=false&amp;width=450"></iframe>
                      -->
                        </span>
                      </fb:like>
                    </li>
                    <li class="facebook2-button">
                      <a href="http://www.facebook.com/sharer/sharer.php?u='.$strURL.'" target="_blank"><img src="http://hallsocial.leiaja.com/misc/fb.png?a0ds98"></a>
                    </li>
                  </ul>
                </div>
              <div id="divContainer">';
    
   if(strstr($_SERVER['REQUEST_URI'],'title=true')){
      $texto .= '<h1>'.$node->title.'</h1>';
   }
   if(strstr($_SERVER['REQUEST_URI'],'summary=true')){
      $texto .= $node->body[$node->language][0]["safe_summary"];
   }
   if(strstr($_SERVER['REQUEST_URI'],'body=true')){
      $texto .= str_replace('##RECOMENDA##', '', retiraHash($node->body[$node->language][0]["value"]));
   }
   
   $texto .= '</div></body></html>';
    if(empty($_GET['utf8'])){
        echo $texto;
    }else{
        echo utf8_encode($texto);
    }
  }
}