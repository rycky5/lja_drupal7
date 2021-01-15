<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/estilo.css"/>
<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/grid.css"/>
<link rel="stylesheet" href="/sites/all/themes/leiaja2/css/boxes/box0019_4x8_1_iframe/css/box.css"/>

<style>
body .box0019 h1 a { color:#91a810;}
body .box0019 h1 b { border-bottom:5px solid #91a810}
</style>
<div id="carnavalbox0019" class="zbox wgd4 hgd13 box0019 ultimasNoticias iframeinterna box0019" style="margin:0px;">
	<h1>
	<a href="http://carnaval.leiaja.com" target="_parent">
		<b>Últimas&nbsp;</b><span>Notícias <img src="http://www.leiaja.com/sites/all/themes/leiaja2/images/logocarnavalultimas.png" style="float:right;" /></span>
	</a>
	</h1>
 	<ul class="ultimasNoticiasLista cinza" style="padding-top:3px">
        <?php foreach ($arrXML as $value): ?>
            <li><a target="_blank" title="<?= $value['title'][0] ?>" href="<?= $value['link'][0]; ?>"><strong><?= date('G:i', $value['pubDate'][0]) ?></strong> - <?= $value['title'][0] ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>




