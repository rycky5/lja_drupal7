<?php
//Template da Página dos Blogs da Redação

$pathTema = path_to_theme();
drupal_add_css($pathTema.'/css/estiloBlogsRedacao.css');

$resultViewsPagPost  = views_get_view_result('post_blog', 'post_blogs');
$resultViewsHomePost = views_get_view_result('post_blog', 'home_blogs');
$setArray = array();

if(!empty($resultViewsPagPost)){
    $setArray = $resultViewsPagPost;
    $pagincao=1;
    
}else{
    $setArray = $resultViewsHomePost;
    
}

$colunaTid = $setArray[0]->_field_data['nid']['entity']->field_catblog['pt-br'][0]['tid'];
$urlTaxy = drupal_lookup_path('alias','taxonomy/term/'.$colunaTid);
?>
<!--<script type="text/javascript" src="https://apis.google.com/js/plusone.js"> {lang: 'pt-BR'}</script>-->

<!-- CHAMADAS DOS SCRIPTS -->
<script type="text/javascript" src="<?= '/'.path_to_theme().'/js/jquery.textareaCounter.js'; ?>"></script>
<script type="text/javascript" src="<?= '/'.path_to_theme().'/js/jquery.validate.min.js'; ?>"></script>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<link rel="stylesheet" media="screen" type="text/css" href="/sites/all/modules/galleryformatter/gallerystyles/greenarrows/greenarrows.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/sites/all/modules/galleryformatter/theme/galleryformatter.css" />
<!-- FIM DAS CHAMADAS DOS SCRIPTS -->

<div id="page-wrapper" class="<?php print $tipoBlog;?>">
  <div id="page">
        <script type="text/javascript">
        (function ($) {
              $('#div-barraLeiaja').prepend('<iframe scrolling="no" height="26" frameborder="0" width="100%" src="http://barra.leiaja.com?blogsredacao"></iframe>'); 
        })(jQuery);
    </script>
	<div class="divTopContainer">
	<div class="divTopContent">
            <a title="Blog da Redação" href="/<?php print $urlTaxy;?>"></a>
	</div>
        </div>

  <div id="divContainer" class="divContainer bgBranco">
	<div class="divContainerContent">
  	<div class="colunaEsquerda">
           <div id="baseBoxes"></div> 
          <?php
        if($setArray or !empty($setArray)){
            foreach($setArray as $key => $node){
               print render(node_view($node->_field_data["nid"]["entity"]));
            }
        }else{
            print '<h2>Não há resultados para esse endereço!</h2>';
        }
        ?>
            
      <div class="divPaginacao">
          <div class="paginacao2">
            <?
            if($pagincao != 1){
                print theme_pager(array('element' => 0, 'quantity' => 10));
            }
            ?>
          </div>
      </div>
    </div>
    <div class="colunaDireita">
      <?php print render($page['colunaDireita']); ?>
    </div>    
  </div>
</div>
<?php require_once $pathTema.'/templates/rodape.tpl.php'; ?>
<script type="text/javascript">
//script especifico para os botões de topo (recomendar e fixar) nas páginas com listagem de nodes
(function ($) {
    $(document).ready(function(){
        $("#aRecomendarTop, .btCompartilhar").bind('click',function(){
            $('.recomendarTop').show();
            subir();
        })
    });
    
    $(".fechar").bind("click", function(){
        $(this).parent().hide();
        $("#divConteudoExibir,.tagsExibir,#divComentario").fadeIn();
    })
    
    function subir(){
        compartilhaBottom = $('#baseBoxes').offset().top;
        compartilha = compartilhaBottom - 50;
        $('html, body').animate({scrollTop:compartilha}, 'slow');
  }
})(jQuery);
</script>