<div class="texto">
  <?php
  // print str_replace('##RECOMENDA##','',render($content['body']));
  ?>
<?php
    if (!empty($node->field_audio[$node->language])){
      foreach($node->field_audio[$node->language] as $info):
        if($info['filemime'] == 'audio/mpeg') {
          echo "<audio src='".file_create_url($info['uri'])."' class='mediaelement-formatter-identifier-1312981640-0' controls='controls'></audio>";
        }else{
          echo '<img src="'.file_create_url($info['uri']).'" title="'.$info['description'].'" />';
        }
      endforeach; 
    }elseif(!empty($node->field_image[$node->language])){
      echo "<script type='text/javascript' src='".base_path(false).drupal_get_path('theme', 'mobileleiaja')."/js/mobilegaleria.js'></script>";
        echo "<div id='multimidia' class='galeria'>
            <h1 class='cabecalho2'><span>Multim&iacute;dia</span></h1>
        <div class='principal'>
            <p class='titulo'>{$title}</p>
            <p class='foto'><img id='fotoview' src='".image_style_url('medium', $node->field_image[$node->language][0]['uri'])."' alt='".$node->field_image[$node->language][0]['title']."' /><span id='fotografo'>Foto: ".$node->field_image[$node->language][0]['alt']."</span></p>
            <p class='chamada'><em>{$node->body[$node->language][0]["summary"]}</em></p>
        </div>
            <div id='mobilegaleria' class='galeria'>
            <h1 class='cabecalho2'>Todas as fotos</h1>
            <div id='galerialista'>
              <table class='table lista' cellpadding=0 cellspacing=0><tr>";
       $count = 0;
      foreach($node->field_image[$node->language] as $key => $info){
        echo "<td><a href='#'><img src='".image_style_url('home_thumb', $info['uri'])."' /></a></td>";
        if($count >=2){
          break;
        }
        echo (($key+1)%3 == 0) ? '</tr><tr>' : '';
        $count++;
      }
       echo '</tr></table>
          </div>
       </div>
    </div>';

     //[['imagem thumb', 'imagem g','fotografo'],['imagem thumb', 'imagem g','fotografo'],['imagem thumb', 'imagem g','fotografo']]
     echo '<script type="text/javascript">';
       $count = 1;
       $total = count($node->field_image[$node->language]);
     echo "paginacao.fotoArr = [ ";
       foreach($node->field_image[$node->language] as $info){
         echo "['".image_style_url('home_thumb', $info['uri'])."', '".image_style_url('medium', $info['uri'])."','{$info['alt']}']";
         if($total > $count){
             echo ',';
         }
        $count++;
      }
    echo "];";
    echo 'paginacao.init(3);';
    echo '</script>';

    }elseif(!empty($node->field_video[$node->language])){

    }
  ?>
</div>