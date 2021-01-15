<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        [##@title@##]
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0, user-scalable=yes, width=990px" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="white" />
        <meta name="description" content="Tudo que você precisa saber. Notícias, Politica, Carreiras, Esportes, Cultura, Tecnologia, Multimídia e muito mais | LeiaJá" />
        <meta name="og:title" content="Leiaja.com Tudo que você precisa saber" />
        <meta name="og:description" content="Tudo que você precisa saber. Notícias, Politica, Carreiras, Esportes, Cultura, Tecnologia, Multimídia e muito mais" />
        <meta name="og:image" content="http://www.leiaja.com/images/leiaja_acento.jpg" />
        <link rel="image_src" href="http://www.leiaja.com/images/leiaja_acento.jpg" title="Leiajá | Tudo que você precisa saber" />
        <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
        <meta http-equiv="PRAGMA" content="NO-CACHE">
        <meta name="copyright" content="LeiaJá">
        <meta name="keywords" content="notícia, politica, carreiras, educação, esporte, cultura, tecnologia, multimidía, rádio, tv leiajá, empreendedorismo, leiajáimagens, vestibular, empregos, opinião, hallsocial, f1team, acerto de contas,revistas, compras, computador, corpo, saúde, moda, carros, cinema, crianças, diversão, arte, economia, internet, jogos, novelas, tempo, trânsito, últimas notícias, viagem, jornalismo, informação, entretenimento, lazer, análise, internet, televisão, fotografia, imagem, som, áudio, vídeo, fotos, humor, música, Eleições, Pesquisa Eleitoral, Eleições Municipais, Política, eleitores, urnas, TRE, Prefeitos, <?= @$vMetaKeyWords ?>" />
        <meta name="robots" content="ALL" />
        <meta name="distribution" content="Global" />
        <meta name="rating" content="General" />
        <meta name="author" lang="pt-br" content="LeiaJá" />
        <meta property="fb:app_id" content="224681850906688"/>
        <meta property="fb:page_id" content="205069329518304" />
        <meta property="fb:pages" content="205069329518304" /> 
        <meta name="google-site-verification" content="rAsZePaDPDq7vSPxpqus1jGbqHpQ9fnv3ugcrmPLwIY" />
        <meta http-equiv="refresh" content="300" /> 
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/estilo.css">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/boxes/grid.css">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/novacapa.css">
        <link rel="stylesheet" type="text/css" href="/sites/all/themes/leiaja2/css/font-awesome.css">
        <script type="text/javascript" src="/sites/all/themes/leiaja2/css/boxes/jquerycapa.min.js"></script>
        <script type="text/javascript" src="/sites/all/themes/leiaja2/css/boxes/boxes.js"></script>
        <script type="text/javascript" src="/sites/all/themes/leiaja2/js/script.js"></script>
        <link rel="shortcut icon" href="http://static1.leiaja.com/misc/favicon.ico" type="image/vnd.microsoft.icon" />

        <?php 
        include_once 'scripts-ne10.php'; 
        ?>		
    </head>

    <body>
        <?php
        include_once 'header.php';
        ?>
    <section id="content">
        <div class="containerCapa">
            <?php
            //Printando o a região banner_float 
            if (getenv('APPLICATION_ENV') == 'production') {
                $vBlocs = block_list('banner_float');
                echo $vBlocs[key($vBlocs)]->content['#markup'];
            }
            ?>
            ##@content@##
        </div>
    </section>
    <?php
    include_once 'footer.php';
    include_once 'scripts.php';
    ?>
</body>
</html>

