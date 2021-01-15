<?php
$pathTema = path_to_theme();
drupal_add_css($pathTema.'/css/estiloBlogsRedacao.css');

if(arg(1)){$params1 = arg(1);}
else{$params1 = NULL;}
if(arg(2)){$params2 = arg(2);}
else{$params2 = NULL;}
$setArray = views_get_view_result('arquivos', 'page', $params1, $params2);

$colunaTid = $setArray[0]->_field_data['nid']['entity']->field_catblog['pt-br'][0]['tid'];
$urlTaxy = drupal_lookup_path('alias','taxonomy/term/'.$colunaTid);
?>

<script type="text/javascript" src="https://apis.google.com/js/plusone.js"> {lang: 'pt-BR'}</script>
<div id="page-wrapper" class="<?php print $tipoBlog;?>">
  <div id="page">
  <script type="text/javascript">
  (function ($) {
	$('body').prepend('<iframe scrolling="no" height="26" frameborder="0" width="100%" src="http://barra.leiaja.com?blogsredacao"></iframe>'); 
  })(jQuery);
	</script>
	<div class="divTopContainer">
	<div class="divTopContent">
  	  <a title="Blog da Redação" href="/<?php print $urlTaxy;?>"></a>
	</div>
        </div>
 
  <div id="divContainer" class="divContainer bgBranco">
	<div class="divContainerContent">
    <script type="text/javascript" src="<?= base_path(true).'/'.path_to_theme().'/js/jquery.textareaCounter.js'; ?>"></script>
    <script type="text/javascript" src="<?= base_path(true).'/'.path_to_theme().'/js/jquery.validate.min.js'; ?>"></script>
    <div class="colunaEsquerda">
        
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
            <? print theme_pager(array('element' => 0, 'quantity' => 10));?>
          </div>
      </div>
        
    </div>
    <div class="colunaDireita">
      <?php print render($page['colunaDireita']); ?>
    </div>    
  </div>
</div>
<?php require_once $pathTema.'/templates/rodape.tpl.php'; ?>