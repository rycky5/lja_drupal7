<?php 
//pegando os dados da view
$main_menu  = views_get_view_result('rodape');
?>
<div class="divFooter">
	<div class="divFooterContent">
  	<div class="mapaSite">
          <ul style="display:none">
      <?php 
      //DECLARAÇÃO DAS VARIÁVEIS
      $caderno = "";  
      $cont = 0;  
      $arrMenuMulti = array('fotos','../imagens','infograficos','podcasts','tv','videos');
      //INICIO #MENU - ITERAÇÃO DO MENU
      foreach($main_menu as $menu):?>
        <?php 
      //INICIO #COLUNA CONDIÇÃO APLICADA SE O CADERNO FOR DIFERENTE INICIAR OUTRA COLUNA
        if($caderno !=  $menu->taxonomy_vocabulary_name):?>
          <?php 
           // INICIO #CARREIRAS: Condição para manter os itens de carreira na mesma coluna de Politica
          if($menu->taxonomy_vocabulary_name !=  "Carreiras"):?>
            </ul>
            <ul class="coluna">
          <?php endif; //FIM #CARREIRAS?>
            <li class="sessaoMapa">
              <a href="/<?php print $menu->taxonomy_vocabulary_machine_name; ?>">
                <?php print $menu->taxonomy_vocabulary_name;?>
              </a>
            </li>
        <?php
        //FIM #COLUNA
        endif;  
        //Setando o nome do caderno à variável.
        $caderno = $menu->taxonomy_vocabulary_name;
        ?>
        <?php
        //CONDIÇÃO QUE VERIFICA SE NÃO É O CADERNO POLITICA E MULTIMIDIA PARA LISTAR OS TERMOS DA TAXONOMIA;
        if($menu->taxonomy_vocabulary_name !=  "Política"):
          //CUSTOMIZACAO DO SUBMENU DE MULTIMIDIA.
          if($menu->taxonomy_vocabulary_name ==  "Multimídia"):
            $url  = "/multimidia/".$arrMenuMulti[$cont++];
          else:
            $url = url(drupal_lookup_path('alias',"taxonomy/term/".$menu->tid));
          endif;//FIM CUSTOMIZACAO SUBMENU MULTIMIDIA
        //SUBMENUS?>
        <li>
          <a href="<?php print $url; ?>" class="itemMapa">
            - <?php print $menu->taxonomy_term_data_name;?>
          </a>
        </li>
        <?php endif;//FIM VERIFICACAO SE É DO CADERNO POLITICA?>
      <?php 
      //FIM #MENU - ITERAÇÃO
      endforeach;?>
          </ul>
          
      <ul>
        <li class="sessaoMapa"><a href="/colunistas">Colunistas</a></li>
        <li class="sessaoMapa"><a href="/blogs">Blogs</a></li>
        <li class="sessaoMapa"><a href="/promocoes">Promo&ccedil;&otilde;es</a></li>
      </ul>
    </div>
    <ul class="institucional">
      <li><a href="/editorial">EDITORIAL</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</li>
      <li><a href="/expediente">EXPEDIENTE</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</li>

      <li><a href="/fale-conosco">FALE CONOSCO</a></li>
    </ul>
    <p>Copyright. <?php echo date('Y');?>. LEIAJ&Aacute;. Todos os direitos reservados.</p>
  </div>	
</div>