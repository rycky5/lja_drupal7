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

<?php
foreach($arrObjNodes as $key=>$node):
     $node = filtrarCampos($node);
     if($key == 0){$classe='wgd4 hgd4';}else{$classe='wgd2 hgd4';}
?>
    <li class="<?php echo $classe; ?>">
      <h1><a href="<?php echo $node['link'];?>"><?php print $node['titulo']; ?></a></h1>
    </li>

<?php endforeach; ?>

