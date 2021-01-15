<?php
//$colunistas = views_get_view_result('colunistas_taxonomy', 'colunista');
$colunistas = $view->result;

// Realizando a interação para selecionar a ultima notícia 
// de cada colunista do resultado da views
foreach ($colunistas as $key => $value) {
  
  // TID do colunista
  $tid = $value->tid;
  
  // Recuperando a ultima notícia do colunista
  $conteudo = views_get_view_result('ultimas_de_colunista', 'conteudo', $tid);
  
  // Recuperanod o link da notícia
  $url_coluna = drupal_lookup_path('alias', 'taxonomy/term/' . $tid);
  
  // Criando o link da notícia
  $url_node = drupal_lookup_path('alias', 'node/' . $conteudo[0]->nid);
  
  // Recuperando o parentesco da taxonomia para indentificar a qual caderno ela pertence
  $parent = getParentByTid($tid);
  
  // Recuperando a data da node e definindo em padrão americano
  $node_created = date("Y-m-d H:i:s", $conteudo[0]->node_created);
  
  // Criando o array com as notícias
  $arrColuna[$key]["title_colunista"] = $value->taxonomy_term_data_name;
  $arrColuna[$key]["title_node"] = $conteudo[0]->node_title;
  $arrColuna[$key]["node_created"] = $node_created;
  $arrColuna[$key]["parent"] = $parent;
  $arrColuna[$key]["url_coluna"] = $url_coluna;
  $arrColuna[$key]["url_node"] = $url_node;
  $arrColuna[$key]["tid"] = $tid;
}

// Verificando qual é a maior data de criação
usort($arrColuna, 'sortByNodeColunaCreated');

$totalCol = count($arrColuna);
$count = 0;
$pathTema = drupal_get_path('theme', 'leiaja');
//$cores = $GLOBALS['cores'];
?>
  <div class="colunas4 divColunistasBloco">  
    <h2 class="tituloH2 tituloH2Colunista cinza"><a title="Colunistas" class="cinza" href="/colunistas">Colunistas</a></h2>
    <div class="passador">
      <img id="loading" src="<?php print $pathTema; ?>/images/loader.gif" alt="Carregando" style="display:none;" />
      <a href="javascript:void(0);" id="voltaCol" class="passaLeft passaLeftFim"><span>Colunistas anteriores</span></a> 
      <a href="javascript:void(0);" id="passaCol" class="passaRight"><span>Próximos colunistas</span></a>
    </div>
    <?php
    foreach ($arrColuna as $value) {
      $title_colunista = $value["title_colunista"];
      $title_node = $value["title_node"];
      $value["node_created"];
      $parent = $value["parent"];
      $urlColuna = $value["url_coluna"];
      $urlNode = $value["url_node"];
      $tid = $value["tid"];
      ?>
      <div class="contentCol <?php print ($count % 4 == 0) ? '' : ' margin-left25'; ?>" id="contentCol<?php print $count + 1; ?>" <?php print (($count <= 3) ? '' : 'style="display:none;"'); ?>>
        <a class="previewmodal<?php print "90$count" ?>" href="/<?php print $urlColuna; ?>" id="linkImg<?php print $count; ?>" title="<?php print $subcategoria ?>">
          <img src="<?php print 'http://static1.leiaja.com/sites/all/themes/leiaja/images/foto-coluna-' . $tid . '.jpg' ?>" 
               alt="<?php print $subcategoria ?>" class="imgH6Pequena" id="imgSrc<?php print $count ?>" />
        </a>
        <strong><a class="linksStrong <?php print getCores($parent); ?>" href="/<?php print $urlColuna ?>"><?php print $title_colunista; ?></a></strong>
        <h6 class="colunistaH6">
          <a class="previewmodal<?php print "90$count" ?> links cinza" href="/<?php print $urlNode ?>" id="linkNot<?php print $count; ?>">
            <?php print $title_node; ?>
          </a>
        </h6>
      </div>     
      <?php
      $count++;
    }
    ?>
  </div>

<script type="text/javascript">

  var page = 0;
  (function($) {
    $(document).ready(function() {
      $('#voltaCol').click(function() {
        if (!$('#voltaCol').hasClass('passaLeftFim')) {
          for (i = 1; i < 5; i++) {
            $('#contentCol' + (page * 4 + i)).hide();
            $('#contentCol' + (page * 4 - (4 - i))).fadeIn();
          }
          page = page - 1;
          if (page == 0) {
            $('#voltaCol').addClass('passaLeftFim');
          }
          if (<?php print $totalCol ?> >= (page + 1) * 4) {
            $('#passaCol').removeClass('passaRightFim');
          }
        }
      });

      $('#passaCol').click(function() {
        if (!$('#passaCol').hasClass('passaRightFim')) {
          page = page + 1;
          for (i = 1; i < 5; i++) {
            $('#contentCol' + (page * 4 - (4 - i))).hide();
            $('#contentCol' + (page * 4 + i)).fadeIn();
          }
          if (page > 0) {
            $('#voltaCol').removeClass('passaLeftFim');
          }
          if (<?php print $totalCol ?> <= (page + 1) * 4) {
            $('#passaCol').addClass('passaRightFim');
          }
        }
      });
    });

  })(jQuery);

</script>