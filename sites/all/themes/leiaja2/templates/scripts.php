<?php
/*
 * Scripts de analytics e afins que serão incluídos no footer da página
 */
if (getenv('APPLICATION_ENV') == 'production') :
    ?>

    <!-- GA Leiajá -->
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-24818943-1']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>    

    <script type="text/javascript">
        window._taboola = window._taboola || [];
        _taboola.push({article: 'auto'});
        !function (e, f, u, i) {
            if (!document.getElementById(i)) {
                e.async = 1;
                e.src = u;
                e.id = i;
                f.parentNode.insertBefore(e, f);
            }
        }(document.createElement('script'),
                document.getElementsByTagName('script')[0],
                '//cdn.taboola.com/libtrc/leiaja/loader.js',
                'tb_loader_script');
    </script>

    <!-- GetClicky -->
    <script src="//static.getclicky.com/js" type="text/javascript"></script>
    <script type="text/javascript">try {
            clicky.init(66504528);
        } catch (e) {
        }</script>
    <!-- Navegg -->
    <script id="navegg" type="text/javascript" src="http://tag.navdmp.com/tm12723.js"></script>    
    <!--<script type="text/javascript" src="//cdn.trugaze.io/bootstrap/LE3G3SOG.js"></script>-->
    <script type="text/javascript" class="teads" async="true" src="//a.teads.tv/page/6091/tag"></script>

    <!-- BEGIN ADVERTPRO CODE SWIPE -->
    <script type="text/javascript">
        if (!document.cookie || document.cookie.indexOf('AVPDCAP=') == -1) {
            document.write('<scr' + 'ipt src="http://ads.leiaja.com/servlet/view/dynamic/javascript/zone?zid=49&pid=0&resolution=' + screen.width + 'x' + screen.height + '&random=' + Math.floor(89999999 * Math.random() + 10000000) + '&millis=' + new Date().getTime() + '&referrer=' + encodeURIComponent((window != top && window.location.ancestorOrigins) ? window.location.ancestorOrigins[window.location.ancestorOrigins.length - 1] : document.location) + '" type="text/javascript"></scr' + 'ipt>');
        }
    </script>
    <!-- END ADVERTPRO CODE -->

    <!--<script async src="https://cdn.onthe.io/io.js/T3weeogGa8eX"></script>-->

    <script type="text/javascript">
        window._taboola = window._taboola || [];
        _taboola.push({flush: true});
    </script>

    <?php
endif;
?>