<?
//var_dump($termos[25861]->field_data_encerra["und"][0]["value"]);
//echo '<br>'.date('Y-m-d H:i:s')
//var_dump(module_list());
            //<script type="text/javascript" src="/sites/all/libraries/colorbox/jquery.colorbox-min.js"></script>
            //<style type="text/css" media="all">@import url("/sites/all/libraries/colorbox/colorbox.css");</style>

?>


<div class="containerFestas">
  <?
  if(!empty($termos)){
  foreach($termos AS $key => $value){?>
      <script type="text/javascript">
        var shareUrl    = 'http://<?= $_SERVER['SERVER_NAME'].urlencode(url(drupal_lookup_path('alias',"taxonomy/term/".$value->tid))) ?>';
        var shareId     = <?= $value->tid ?>;
        var shareSocial = {facebook : {url    : 'http://www.facebook.com/share.php?u='+shareUrl,
                                      params : 'toolbar=no,width=700,height=400',
                                      name   : 'facebook'},
                          twitter  : {url    : 'http://twitter.com/intent/tweet?original_referer=' + shareUrl + '&url=' + shareUrl + '&text=<?= $value->name; ?>&via=leiajaonline',
                                      params : 'toolbar=no,width=550,height=420',
                                      name:'Twitter'}
                          };
        function shareIt(net)
        {
          jQuery.post('http://<?= $_SERVER['SERVER_NAME']?>/ajax/node/share', 
                      {id:shareId,network:net}, function(rs){}, 'json');
        }
    </script>
        <div class="contentFestas bgZebrado">
          <?if(!empty($value->field_imagecrop["und"][0]["uri"])){?>
          <img src="<?= image_style_url('home_cadernos', $value->field_imagecrop["und"][0]["uri"]); ?>">
          <?}?>
          <div class="compartilhaRedes">
            <span>Compartilhar:</span>
            <a href="javascript:void(0);" class="facebook" onclick="window.open(shareSocial.facebook.url, shareSocial.facebook.name, shareSocial.facebook.params);shareIt('facebook');"></a>
        		<a href="javascript:void(0);" class="twitter" onclick="window.open(shareSocial.twitter.url, shareSocial.twitter.name, shareSocial.twitter.params);shareIt('twitter');"></a>
          </div>
          <h4><?=$value->name;?></h4>
          <h6>Sorteio <?= date('d/m', strtotime($value->field_data_sorteio["und"][0]["value"]));?></h6>
          <p><?=$value->description;?></p>
          <div class="participe">
            <?if(strtotime($value->field_data_sorteio["und"][0]["value"]) <= strtotime(date('Y-m-d H:i:s')) && !empty($value->field_vencedores["und"][0]["value"])){?>
            <a href="#vencedores-<?=$value->tid;?>" class="vencedores">Vencedores</a>
            <div style='display:none'>
              <div id="vencedores-<?=$value->tid;?>" style='background:#fff;padding:15px;border-radius:10px;'>
                <?=$value->field_vencedores["und"][0]["value"]?>
              </div>
            </div>
            <?}elseif($value->field_externa["und"][0]["value"]){?>
            <a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$value->tid)); ?>">Ir para a promoção</a>
            <?}elseif(in_array($value->tid, $participando)){?>
            <button class="concorrendo" type="button" onclick="javascript:alert('Você já está concorrendo a esta promoção.')">Concorrendo</button>
            <?}elseif(!in_array($value->tid, $participando) && strtotime($value->field_data_encerra["und"][0]["value"]) < strtotime(date('Y-m-d H:i:s'))){?>
            <button class="encerrada" type="button" onclick="javascript:alert('Esta promoção está encerrada.')">Promo&ccedil;&atilde;o encerrada</button>
            <?}elseif(!in_array($value->tid, $participando) && strtotime($value->field_data_encerra["und"][0]["value"]) >= strtotime(date('Y-m-d H:i:s'))){?>
            <button class="concorrer" type="button" onclick="concorrerpromo(<?=$value->tid;?>);">Quero concorrer</button>
            <?}?>
            <a href="#regulamento-<?=$value->tid;?>" class="button regulamento">Ler regulamento</a>
            <div style='display:none'>
              <div id='regulamento-<?=$value->tid;?>' style='background:#fff;padding:15px;border-radius:10px;'>
              <h2 style="font:bold 18px arial;padding-bottom:10px;">Regulamento</h2>
              <div><?=$value->field_regulamento["und"][0]["value"]?></div>
              </div>
            </div>

          </div>
        </div>
  <?
    }
  }else{
    echo '<p>Não existe nenhuma promoção ativa.</p>';
  }
  ?>
</div>
<script type="text/javascript">
    new Image(1,1).src = 'http://ads.leiaja.com/servlet/track?aid=13&referrer='+encodeURIComponent(document.location);
</script>