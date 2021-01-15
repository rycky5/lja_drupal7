<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html>
<head>
<title>LeiaJa</title>
<style type="text/css" media="all"> 
     @import url("http://static1.leiaja.com/sites/all/modules/video/css/video.css");
     @import url("http://static1.leiaja.com/sites/all/libraries/mediaelement/build/mediaelementplayer.min.css");
</style> 
<style type="text/css" media="all">
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section {
	display: block;
}
body {
	line-height: 1;
}
ol, ul {
	list-style: none;
}
blockquote, q {
	quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
}   
</style>
</head>
<body>
<script type="text/javascript" src="<?= base_path(true).'/misc/jquery.js?v=1.4.4' ?>"></script>    
<script type="text/javascript" src="<?= base_path(true).'/misc/jquery.once.js?v=1.2' ?>"></script>    
<script type="text/javascript" src="<?= base_path(true).'/misc/drupal.js' ?>"></script>
<script type="text/javascript" src="<?= base_path(true).'/sites/all/libraries/mediaelement/build/mediaelement-and-player.min.js?v=2.1.6' ?>"></script>
<script type="text/javascript" src="<?= base_path(true).'/sites/all/modules/mediaelement/mediaelement.js' ?>"></script>
<script type="text/javascript" src="<?= base_path(true).'/sites/all/modules/video/js/video.js' ?>"></script>
<script type="text/javascript"> 
  <!--//--><![CDATA[//><!--
   jQuery.extend(Drupal.settings, {"basePath":"\/","pathPrefix":"","ajaxPageState":{"theme":"leiaja","theme_token":"lMrtsYh3vLw0sySb3eAJ4bm6503bEQ7hpUDCYJk-At0","js":{"misc\/jquery.js":1,"misc\/jquery.once.js":1,"misc\/drupal.js":1,"sites\/all\/libraries\/mediaelement\/build\/mediaelement-and-player.min.js":1,"public:\/\/languages\/pt-br_k9zRh2CMdM8HbskxEqS3oXX-BGywatKCCQBdnyMXCuY.js":1,"sites\/all\/modules\/mediaelement\/mediaelement.js":1,"sites\/all\/modules\/video\/js\/video.js":1,"sites\/all\/themes\/leiaja\/js\/script.js":1,"sites\/all\/modules\/social_connect\/social_connect.js":1,"http:\/\/connect.facebook.net\/en_US\/all.js":1,"0":1,"sites\/all\/themes\/leiaja\/js\/css_browser_selector.js":1,"sites\/all\/themes\/leiaja\/js\/jquery.ui.js":1,"sites\/all\/modules\/views\/js\/jquery.ui.dialog.patch.js":1},"css":{"modules\/system\/system.base.css":1,"modules\/system\/system.menus.css":1,"modules\/system\/system.messages.css":1,"modules\/system\/system.theme.css":1,"sites\/all\/libraries\/mediaelement\/build\/mediaelementplayer.min.css":1,"modules\/comment\/comment.css":1,"modules\/field\/theme\/field.css":1,"modules\/node\/node.css":1,"modules\/search\/search.css":1,"modules\/user\/user.css":1,"sites\/all\/modules\/views\/css\/views.css":1,"sites\/all\/modules\/ctools\/css\/ctools.css":1,"sites\/all\/modules\/video\/css\/video.css":1,"sites\/all\/themes\/leiaja\/css\/estilo.css":1,"sites\/all\/themes\/leiaja\/css\/print.css":1}},"mediaelementAll":true});
  //--><!]]>
  
  (function ($) {
      $(document).ready(function(){
       if (window!=window.top){
          vWidth  = window.document.documentElement.clientWidth;
          vHeight = window.document.documentElement.clientHeight;  
        }else{
          vWidth  = (querySt('width') != undefined) ? querySt('width') : 625;
          vHeight = (querySt('height') != undefined) ? querySt('height') : 352;            
        }          
        $('video').attr('width', vWidth);
        $('video').attr('height', vHeight);
      })
  })(jQuery);
</script>
<?php
   $content = $node->content;
   hide($content['comments']);
   hide($content['links']);
   hide($content['field_tags']);
   hide($content['field_fonte']);
   hide($content['field_capa']);
   hide($content['field_infografico']);
   hide($content['field_permlink']);
   hide($content['body']);

   print render($content);
?>
</body>
</html>