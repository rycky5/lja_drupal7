  <div id="areaTopo">
    <div id="imgLogo">
      <a href="<?=base_path()?>" title="Página inicial">
        <img src="<?= base_path().drupal_get_path('theme', 'mobileleiaja').'/'?>images/logo.png" alt="LeijaJá" />
      </a>
    </div>
    <form id="areaBusca" action="<?=base_path()?>search/node/" method="get">
      <input type="hidden" id="noticias" value="caderno_noticias" name="type[caderno_noticias]" />
      <input type="hidden" id="negocios" value="caderno_carreiras" name="type[caderno_carreiras]"/>
      <input type="hidden" id="esportes" value="caderno_esportes" name="type[caderno_esportes]">
      <input type="hidden" id="politica" value="caderno_politica" name="type[caderno_politica]">
      <input type="hidden" id="lazer" value="caderno_cultura" name="type[caderno_cultura]">
      <input type="hidden" id="tecnologia" value="caderno_tecnologia" name="type[caderno_tecnologia]">
      <input type="hidden" id="colunistas" value="caderno_colunistas" name="type[caderno_colunistas]">
      <input type="hidden" value="form-JWqKy27we9D7AHVxPApVsFRL4Ukcw_ou0OvPup8P6L8" name="form_build_id">
      <input type="hidden" value="<?php print drupal_get_token('search_form');?>" name="form_token">
      <input type="hidden" value="search_form" name="form_id">
      <input type="hidden" name="op" value="Busca avançada">
      <ul class="ul">
        <li class="campoBusca"><input id="campoBusca" name="keys" maxlength="25" /></li>
        <li class="submit"><input type="submit" value="Buscar"></li>
      </ul>
    </form>
    <ul id="topoMenu" class="ul">
      <? foreach ($main_menu AS $menu){?>
        <li><a href="<?=base_path().'caderno/'.$menu['href'];?>"><span><?=$menu['title'];?></span></a></li>
      <? }?>
        <li><a href="<?=base_path().'caderno/colunistas';?>"><span>Colunistas</span></a></li>
        <li><a href="<?=base_path().'caderno/colunistas#blogs';?>"><span>Blogs</span></a></li>
    </ul>
  </div>
<!--
  <ul class="ul" id="breadcumb">
    <li class="home"><a href="#">Home</a><span>&gt;</span></li>
    <li><a href="#">Multimídia</a><span>&gt;</span></li>
    <li><a href="#">Vídeos</a><span>&gt;</span></li>
    <li><a href="#">Visualização</a></li>
  </ul>
-->