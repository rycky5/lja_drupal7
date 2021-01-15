<script type="text/javascript" src="http://static1.leiaja.com/sites/all/libraries/colorbox/jquery.colorbox-min.js?mpf9bm"></script>
<script type="text/javascript" src="http://static1.leiaja.com/sites/all/modules/colorbox/js/colorbox.js?mpf9bm"></script>
<script type="text/javascript" src="http://static1.leiaja.com/sites/all/modules/colorbox/styles/default/colorbox_style.js?mpf9bm"></script>

<div id="page-wrapper"><div id="page">
  <div class="divBannerTop">
	<div class="divBannerTopContent">
      <div class="banner1"><?php print render($page['banner1']); ?><!-- /.section, /#banner1 --></div>
      <div class="publicidadeTop"><b></b></div>
    </div>
  </div>
  <?php require_once 'menu.tpl.php'; // Carrega Menu. ?>
    <div <?=(!empty($cobertura))?'':'id="divContainer"';?> class="divContainer bgBranco <?= (@$node->type) ?  $node->type : '';?> caderno_<?=@semAcentos(strtolower($vCadernoNome));?>">
	<div class="divContainerContent">
    <?php if(@$is_caderno) : ## Verifica se é capa do caderno.?>
     <div class="divSubCadernos">
       <h2 class="cinza"><?= $vCadernoNome ?></h2>
     </div>
    <?php endif; ?>

    <div class="colunaEsquerda" <?= (!empty($sem_colunadireita)? 'style="width:950px;"' : '');?>>
      <?php
      if(arg(2) == null){
        print render($page['content']); 
      }else{
        $value = $page['content']["system_main"]["term_heading"]["term"]["#term"];
      ?>
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
        <div class="containerFestas">
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
              <div id="vencedores-<?=$value->tid;?>">
                <?=$value->field_vencedores["und"][0]["value"]?>
              </div>
            </div>
            <?}elseif($value->field_externa["und"][0]["value"]){?>
            <a href="<?= url(drupal_lookup_path('alias',"taxonomy/term/".$value->tid)); ?>">Ir para a promoção</a>
            <?}elseif(in_array($value->tid, $participando)){?>
            <button class="concorrendo" type="button" onclick="javascript:alert('Você já está concorrendo a esta promoção.')">Concorrendo</button>
            <?}elseif(!in_array($value->tid, $participando) && strtotime($value->field_data_encerra["und"][0]["value"]) < strtotime(date('Y-m-d H:i:s'))){?>
            <input value=" Encerrada " disabled="disabled" type="button" onclick="javascript:alert('Esta promoção está encerrada.')" />
            <?}elseif(!in_array($value->tid, $participando) && strtotime($value->field_data_encerra["und"][0]["value"]) >= strtotime(date('Y-m-d H:i:s'))){?>
            <button class="concorrer" type="button" onclick="concorrerpromo(<?=$value->tid;?>);">Quero concorrer</button>
            <?}?>
              
            </>

          </div>
        </div>
        </div>
        <div class="containerFestas">
          <div class="contentFestas bgZebrado">
            <div id='regulamento-<?=$value->tid;?>' style='background:#fff;'>
            <h2>Regulamento</h2>
            <p><?=$value->field_regulamento["und"][0]["value"]?></p>
            </div>
          </div>
        </div>
          <?
//        var_dump($page['content']["system_main"]["term_heading"]["term"]["#term"]);
      }
      ?><!-- /.section, /#content -->
      <?= render($vBlocos['ultimasNoticias']); ?>
      <?php print render($page['content2']); ?><!-- /.section, ./#content2 -->
    </div>
    <?php if(empty($sem_colunadireita)): ?>
      <div class="colunaDireita">
        <?php print render($page['colunaDireita']); ?><!-- /.section, ./#colunaDireita -->
      </div>
    <?php endif; ?>
    <?= render($page['shop']) ?><!-- /.section, /#shop -->
    <style>
      .Widget960x300{width:948px;}
      .Widget960x300 .footer{width:928px;}
      .Widget960x300 .offers li{margin:0 8px;}
      .tabs{margin:0 10px 0 0;}
      #buscaofertas-373865{float:left;}
    </style>
        <style type="text/css">
      .divFecharModal{
        background: url(/sites/all/themes/leiaja/images/image.png) no-repeat -272px -124px;
        float: right;
        margin: -28px 10px 0 0;
        padding: 20px 0 0 23px;
      }
      
      .modal-promo {
        position: fixed;
        z-index: 602;
        width: 626px;
        height: 400px;
        left: 50%;
        top: 50%;
        margin: -200px 0 0 -313px;
        border: 5px #8C56C7 solid;
        background: url(/sites/all/themes/leiaja/images/bgLoginCenter.png) repeat -30px +30px;
      }
      
    </style>
  <script type="text/javascript">
    var concorrerpromo = null;
    function showModal(divId){
      jQuery('.telaEscura').show();
      jQuery(divId).show();
      
    }
    function divFecharModal(){
      jQuery('.telaEscura').hide();
      jQuery('.modal-promo').hide();
      
    }
  (function ($) {
    concorrerpromo = function(tid){
      if(<?=$GLOBALS['user']->uid?> == '0'){
        $('#user-login-ajax').append('<input type="hidden" value="' + tid + '" name="tidPromo">');
        modalLogin();
      }else{
        //alert(tid);
        $.post('<?= base_path() ?>participarpromo/'+tid, function(t){
          if(t == 'true'){
            alert('Obrigado. Você está participando desta promoção.\nBoa Sorte.');
          }else{
            alert('Você já está participando desta promoção.');
          }
        });
        
      }
    }
  $(document).ready(function () {
    $(".regulamento").colorbox({inline:true, width:"50%"});
    $(".vencedores").colorbox({inline:true, width:"50%"});
  });
})(jQuery);
  </script>
  
  
  </div>
</div>
<?php require_once 'rodape.tpl.php'; ?>