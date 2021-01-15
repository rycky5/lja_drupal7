    <!-- box -->
    <div class="wgd12 hgd9 box3d">
   <ul>
     <li> 
       <a href="#"><img src="" width="243" height="159" /></a>
       <span><a href="#"></a></span>	
       <p><a href="#"></a></p>
     </li>
     <li> 
       <a href="#"><img src="" width="280" height="177" /></a>
       <span><a href="#"></a></span>	
       <p><a href="#"></a></p>
     </li>
     <li> 
       <a href="#"><img src="" width="243" height="159" /></a>
       <span><a href="#"></a></span>	
       <p><a href="#"></a></p>
     </li>                    
   </ul>               
    </div>
    <!-- paginacao-->    
    <div class="wgd12 hgd1 box3dPag">
                     <!-- paginacao-->
                     <div class="paginacao">
                       <ul>
                         <li><a href="#" class="ativo">&nbsp;</a></li>
                         <li><a href="#">&nbsp;</a></li>
                         <li><a href="#">&nbsp;</a></li>
                         <li><a href="#">&nbsp;</a></li>
                         <li><a href="#">&nbsp;</a></li>
                         <li><a href="#">&nbsp;</a></li>
                       </ul>
                     </div>
    <!-- paginacao-->             
    </div>
    <!-- box-->
       
<script>
  <?php
  $json =Array();
  foreach($arrObjNodes as $key=>$node):
    $node  = filtrarCampos($node);
    $node['titulo'] = limitaTexto($node['titulo'], 55);
    $node['conteudo'] = limitaTexto($node['conteudo'], 90);
    $json[]  = $node;
  endforeach;?>
  json = <?=json_encode($json);?>;
  (function($){
    indice = 0;
    //popular os campos em cada elemento.
    $colectionLi  = $(".containerBox3d .box3d li");
    populaCampos();
    $(".containerBox3d .paginacao a").click(function(e){
      $self = $(this);
      indice = $(".containerBox3d .paginacao a").index($self);
      
      flag =false;
      populaCampos();
      $(".containerBox3d .box3d li").hide().fadeIn();
      return false;
    });//click() paginacao do box 3D
    function populaCampos(){
      for (var i=0;i<3;i++)
      { 
        if(indice==json.length){
          indice =0;
        }
        $colectionLi.eq(i).find('img').attr("src",json[indice].urlImg);
        $colectionLi.eq(i).find('a').attr("href",json[indice].link);
        $colectionLi.eq(i).find('span a').text(json[indice].titulo);
        $colectionLi.eq(i).find('p a').html(json[indice].conteudo);
        indice++;
      }
    }
  })(jQuery);
</script>