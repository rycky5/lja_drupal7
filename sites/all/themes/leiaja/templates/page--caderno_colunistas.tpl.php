<?php
//Template das Colunas dos Colunistas do site
?>

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

<?php
global $user;
$resultViewsPagPost = views_get_view_result('posts_de_colunistas', 'pag_posts_colunista');
$resultViewsHomePost = views_get_view_result('posts_de_colunistas', 'home_posts_colunistas');

$setArray = array();
if(!empty($resultViewsPagPost)){$setArray = $resultViewsPagPost;$pagincao = 1;}
else{$setArray = $resultViewsHomePost;}

$colunaTid = $setArray[0]->_field_data['nid']['entity']->field_catcolunista['pt-br'][0]['tid'];
$objTaxy = taxonomy_term_load($colunaTid);
$colunaTt = $objTaxy->name;
$colunaDesc = $objTaxy->description;
$colunaEstilo = 'caderno_'.$objTaxy->field_parent['und'][0]['value'];
$urlColuna = drupal_lookup_path('alias','taxonomy/term/'.$colunaTid);
$script = (empty($objTaxy->field_script[key($objTaxy->field_script)][0]['value'])) ? '' : $objTaxy->field_script[key($objTaxy->field_script)][0]['value'];
?>
<div id="page-wrapper"><div id="page">
  <div class="divBannerTop">
	<div class="divBannerTopContent">
    <div class="banner1"><?php print render($page['banner1']); ?><!-- /.section, /#banner1 --></div>
    <div class="publicidadeTop"><b></b></div>
  </div>
  </div>

  <?php include 'menu.tpl.php'; ?>

<div id="divContainer" class="divContainer bgBranco">
    <div class="divContainerContent <?= $colunaEstilo?>">
    <div class="divMapeamento">
      <ul>
      	<li><a href="javascript:void(0);" title="Leia J&aacute;">LeiaJ&aacute;</a><span class="seta"></span></li>
        <li><a href="<?= base_path() ?>colunistas/" title="Not&iacute;cias">Colunistas</a><span class="seta"></span></li>
        <li><a href="javascript:void(0);" title="Mundo" class="active"><?= $colunaTt ?></a></li>
      </ul>
      <div class="divContentMapeamento">
      	<a href="javascript:void(0);" title="Recomendar" id="aRecomendarTop" >Recomendar</a>
        <a href="javascript:void(0);" title="Recomendar" id="imgRecomendar" class="btCompartilhar btCompartilharTop"></a>
        <?php if(isset($node)):?>
        <span>|</span>
        <a href="javascript:void(0);" class="fixarMural" title="Seguir" follow="<?=$user->uid?>;<?=$node->nid?>">Fixar no Mural</a>
        <a href="javascript:void(0);" class="lerDepois" title="Seguir" follow="<?=$user->uid?>;<?=$node->nid?>"></a>
        <?php endif;?>
      </div>
    </div>
    <div class="topColunistas">
    	<a href="/<?php print $urlColuna?>"><img src="/<?= $directory ?>/images/foto-colunista-<?=$colunaTid; ?>.jpg" alt="<?= $colunaTt ?>" /></a>
        <h2><a href="/<?php print $urlColuna?>"><?= $colunaTt; ?></a></h2>
        <?= $colunaDesc; ?>
        <h5>Os Blogs Parceiros e Colunistas do Portal LeiaJ&aacute;.com s&atilde;o formados por autores convidados pelo dom&iacute;nio not&aacute;vel das mais diversas &aacute;reas de conhecimento. Todos as publica&ccedil;&otilde;es s&atilde;o de inteira responsabilidade de seus autores, da mesma forma que os coment&aacute;rios feitos pelos internautas.</h5>
    </div>
                
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
            if($pagincao !== 1){
                 print theme_pager(array('element' => 0, 'quantity' => 10));
             }
            ?>
          </div>
      </div>
    </div>      
    <div class="colunaDireita">
      <?php print render($page['colunaDireita']); ?><!-- /.section, ./#colunaDireita -->          
    </div>    
    <?= render($page['shop']) ?><!-- /.section, /#shop -->
  </div>
</div>
    </div>
</div>
<?php include 'rodape.tpl.php'; ?>
<?php
//Verificando se a variável $script está vazia para imprimir o script desejado na página
if(!empty($script)){
    print $script;
}
?>