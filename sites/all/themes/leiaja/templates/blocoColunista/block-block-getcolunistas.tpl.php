 <?php
 $arrColuna = api_getColunistasNodes(2);
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
      <span id="leiamais<?php print "90$count" ?>" class="lerNoticiasMenor seguirColunista">
        <a class="lerDepois" id="follow90<?php print $count ?>" title="Fixar Colunista no Mural" href="javascript:void(0);" follow="<?php print $GLOBALS['user']->uid . ';' . $tid . ';1' ?>"></a>
      </span>
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