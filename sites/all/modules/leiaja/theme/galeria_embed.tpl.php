<script type='text/javascript' src="<?=base_path(false).drupal_get_path('theme', 'mobileleiaja') ?>/js/mobilegaleria.js"></script>
<style type='text/css' media='all'>
    @import url('/sites/all/themes/leiaja/css/css.css');
</style>
<?php
if(@$_GET["carnaval"] == "true"){
?>
<style type='text/css' media='all'>
    #multimidia .principal, #multimidia li {
            border:0px;
            border-top:0px;
            border-bottom:0px;
    }
    #multimidia .principal p.titulo, #multimidia .foto, #multimidia .chamada, #multimidia #paginafoto li {
            background-color: #0472af;
    }
    #multimidia .principal span { background:none; }
</style>
<?php } ?>



 <div id='multimidia' class='galeria'>
    <div class='principal'>
        <p class='titulo'><?=$node->title ?></p>
            <p class='foto'><img id='fotoview' src='<?=image_style_url('large', $node->field_image[$node->language][0]['uri']) ?>' alt='<?=$node->field_image[$node->language][0]['title'] ?>' /><span id='fotografo'>Foto: <?=$node->field_image[$node->language][0]['alt'] ?></span></p>
            <p class='chamada'><em><?=$node->body[$node->language][0]["summary"] ?></em></p>
        </div>
            <div id='mobilegaleria' class='galeria' style="display:none;">
            <h1 class='cabecalho2'>Todas as fotos</h1>
            <div id='galerialista'>
              <table class='table lista' cellpadding=0 cellspacing=0><tr>
<?php
   $count = 0;
   foreach($node->field_image[$node->language] as $key => $info){
?>
                <td><a href='#'><img src='<?=image_style_url('home_thumb', $info['uri']) ?>' /></a></td>
<?php
        if($count >=2){
          break;
        }
        echo (($key+1)%3 == 0) ? '</tr><tr>' : '';
        $count++;
      }
?>
            </tr></table>
          </div>
       </div>
    </div>
<?php
     //[['imagem thumb', 'imagem g','fotografo'],['imagem thumb', 'imagem g','fotografo'],['imagem thumb', 'imagem g','fotografo']]
     echo '<script type="text/javascript">';
       $count = 1;
       $total = count($node->field_image[$node->language]);
     echo "paginacao.fotoArr = [ ";
       foreach($node->field_image[$node->language] as $info){
         echo "['".image_style_url('home_thumb', $info['uri'])."', '".image_style_url('large', $info['uri'])."','{$info['alt']}']";
         if($total > $count){
             echo ',';
         }
        $count++;
      }
    echo "];";
    echo 'paginacao.init(3);';
    echo '</script>';
?>