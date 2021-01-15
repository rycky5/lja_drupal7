<?php
/**
 * Arquivo que conterá o bloco títulos sem fotos
 * 
 * @author Weydson Fraga
 */
//
//echo '<pre>';
//var_dump($arrObjNodes[0]);
//die;
?>

<!-- box -->
<div class="wgd4 hgd9 boxGridlines">
    <ul>

<?php
foreach($arrObjNodes as $key=>$node):
     $node = filtrarCampos($node);
?>
      <li class="wgd4">
        <span><a href="#"><?php print $key+1; ?></a></span>
        <h1><a href="<?php echo $node['link'];?>"> <?php print limitaTexto($node['titulo'],50); ?> </a></h1>
      </li>

<?php endforeach; ?>

    </ul>
</div>
<!-- box --> 

