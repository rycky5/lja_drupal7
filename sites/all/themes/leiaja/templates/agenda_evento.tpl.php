<div class="containerFestas">
    <? if(!empty($_GET['filtro'])): ?>
     <div class="dataFestas">
       <h2><?= $_GET['filtro'] ?></h2>
     </div>
    <? endif; ?>
    <?     
      $vData = null;
      foreach($vAgenda as $age): 
        $vLinkNode = url(drupal_lookup_path('alias','node/'.$age->nid),array('absolute' => TRUE));
        if($vData != $age->grupo):
          $vData = $age->grupo;
   ?>
      	  <div class="dataFestas">
	    <h3><?= $age->grupo ?></h3>
  	    <h2>Sexta-feira</h2>
          </div>
    <?  endif; ?>   
        <div class="contentFestas bgZebrado">
          <? if(!empty($age->uri)): ?>
            <img src="<?= image_style_url('home_cadernos', $age->uri); ?>" />
          <? endif; ?>
          <h4><a href="<?= $vLinkNode ?>"><?= $age->title ?></a></h4>
          <p><?= $age->body_value ?></p>
        </div>
    <? endforeach; ?>
</div>