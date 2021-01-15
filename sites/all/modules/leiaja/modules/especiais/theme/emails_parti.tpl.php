<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//echo "<pre>";
//var_dump($arrObjUf);
//die();
?>
<form action="/admin/people/sorteio" method="post">
  <br />
  <div id="promo">
    Promoções: <select id="promos" name="promos">
      <option value="">-- Favor Selecionar --</option>
      <?php
        foreach($arrPromos as $value){
      ?>
          <option value="<?= $value->tid ?>"><?= $value->name; ?></option>
      <?php
        }
      ?>
    </select>
  </div>
  <br />
  <input type="submit" value="Gerar CVS" />
</form>


<script type="text/javascript">
/*
(function ($) {

  $(document).ready(function(){
    
    $("#checkCidade").click(function(){
      $("#estado").hide();
      $("#cidade").show(200);
    });
    
    $("#checkUf").click(function(){
      $("#cidade").hide();
      $("#estado").show(200);
    });
    
  });
  
})(jQuery);
*/
 </script>
