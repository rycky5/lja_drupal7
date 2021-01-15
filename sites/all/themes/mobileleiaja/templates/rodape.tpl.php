  <div id="rodape">
	<ul id="rodapeMenu" class="ul">
	  <? foreach ($main_menu AS $menu){?>
            <li class="rodape<?=$menu['href']?>"><a href="<?=base_path().'caderno/'.$menu['href'];?>"><span><?=$menu['title'];?></span></a></li>
	  <? }?>
            <li class="rodapecolunistas"><a href="<?=base_path().'caderno/colunistas';?>"><span>Colunistas</span></a></li>
            <li class="rodapeblogs"><a href="<?=base_path().'caderno/colunistas#blogs';?>"><span>Blogs</span></a></li>
	</ul>     
  </div>
  <div id="copyright">
	<p>Todos os direitos reservados</p>
  </div>

  
  