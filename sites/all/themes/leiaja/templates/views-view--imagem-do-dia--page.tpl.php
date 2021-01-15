<?php
/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
//importando o modulo capa em que há a função filtrarCampos();
module_load_include('inc', 'capa', 'capa.api');

// Lendo as bibliotecas
$arrLibraries = libraries_get_libraries();
// Incluindo o arquivo necessário
$scriptGalleria = "/" . $arrLibraries["galleria"] . "/galleria-1.2.8.min.js";
$scriptThemeGalleria = "/" . $arrLibraries["galleria"] . "/themes/azur/galleria.azur.min.js";
$nid = (isset($_REQUEST['idNode'])) ? $_REQUEST['idNode'] : arg(1);

$numero = is_numeric($nid);
if ($nid == null):
  $nid = "all";
elseif (!$numero):
  $nid = base64_decode($nid);
endif;
$ignore = "all";
//verifica se está na pagina inicial.
if (pager_find_page() == 0):
  $cobertura = views_get_view_result('imagem_do_dia', 'cobertura', $nid);
  $ignore = $cobertura[0]->nid;
  ?>
  <script src="<? print $scriptGalleria; ?>" type="text/javascript"></script>
  <?php
endif; //fim verifica se é pagina inicial

$maisNoticias = views_get_view_result('imagem_do_dia', 'page', $ignore);
?>
<style>
  .interna_topo{margin: 10px 0;border-bottom: 1px solid rgb(214, 214, 214);}
  #galleria{height: 650px;}
  .hidden{clear: both;visibility: hidden;}
  .compartilhaTop{width:100%}
  .compartilhaTop * {vertical-align: middle;}
  h5.autorNoticia{margin:0 0 10px 0}
  .divContainerContent .divMapeamento{display: none!important}
</style>
<?php if (pager_find_page() != 0): ?>
  <div class="divSubCadernos">
    <h2>
      <a class="cinza" href="<?= url('/imagens', array('absolute' => TRUE)) ?>">Imagens do Dia</a>
    </h2>
  </div>
<?php else: ?>
  <div class="interna_topo">
    <?php $destaque = filtrarCampos($cobertura[0]); ?>
    <h5 class="autorNoticia">
      <?php
      $dataCriacao = date('d/m/Y Gxi', $destaque['criacao']);
      $dataCriacao = strtr($dataCriacao, 'x', 'h');
      $dataAtualizacao = date('d/m/Y Gxi', $destaque['atualizacao']);
      $dataAtualizacao = strtr($dataAtualizacao, 'x', 'h');
      print $dataCriacao;

      //verifica se a data de atualização é diferente da data de criação.
      if ($destaque['criacao'] != $destaque['atualizacao']) {
        ?>
        - Atualizado em
        <?php print $dataAtualizacao;
      }
      ?></h5>
    <h1><?php print $destaque['titulo']; ?></h1>
    <h2>Clique no ícone no canto inferior esquerdo da galeria para ver as fotos em tamanho maior.</h2>
    <!--  compartilhamento-->
    <div class="compartilhaTop">
  <?php $destaque['link'] = $_SERVER['SERVER_NAME'] . url(drupal_lookup_path('alias', 'node/' . $destaque['nid']), array('absolute'), array('absolute' => TRUE)); ?>
      <!--      <div class="fb-like" data-send="false" data-layout="standard" data-width="250" data-show-faces="false" data-colorscheme="light" data-action="recommend"></div>-->
      <iframe src="//www.facebook.com/plugins/like.php?href=<?php print $destaque['link']; ?>&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>
      <a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php print $destaque['titulo']; ?>" data-via="leiajaonline" data-lang="pt" data-hashtags="leiaja">Tweetar</a>
      <script>!function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = "//platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);
          }
        }(document, "script", "twitter-wjs");</script>

      <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
        {
          lang: 'pt-BR'
        }
      </script>

      <!-- Place this tag where you want the +1 button to render. -->
      <div class="g-plusone" data-size="medium" ></div>
    </div> <!-- redes sociais-->
    <!--fim compartilhamento-->
    <hr class="hidden"/>
    <div id="galleria">
      <?php
      $arrImagens = $cobertura[0]->_field_data["nid"]["entity"]->field_image["pt-br"];
      foreach ($arrImagens as $key => $item) :
        $item['title'] = empty($item['title']) ? $destaque['titulo'] : $item['title'];
        $item['alt'] = empty($item['alt']) ? $destaque['conteudo'] : $item['alt'];
        ?>
        <a href="<?= image_style_url('original', $item["uri"]); ?>">
          <img 
            <?php if (!empty($item['title'])): ?>
              title="<?= $item['title']; ?>"
            <?php endif; ?>
            <?php if (!empty($item['alt'])): ?>
              alt="<?= $item['alt']; ?>"
    <?php endif; ?>
            src="<?= image_style_url('thumbnail', $item["uri"]); ?>" />
        </a>
  <?php endforeach; ?>
    </div>
    <p class="descricao-destaque"><?php print $destaque['conteudo']; ?></p>
  </div>

<?php endif; //fim da verificação se é a pagina inicial;  ?>
<div class="interna_conteudo">
  <div class="colunaEsquerda">
    <ul class="listaResultado resultadoBusca">
      <h2 class="maisNoticiasH2 cinza" style="color: gray">Mais Imagens</h2>
      <!--looping -->
      <?
      foreach ($maisNoticias AS $key => $node):
        $value = filtrarCampos($node);
        $value['link'] = url(drupal_lookup_path('alias', 'node/' . $value['nid']), array('absolute' => TRUE));
        ?>
        <li <?= ($value['uri'] != null ) ? 'class="ljhasimg"' : '' ?>>
          <?php
          if (!empty($value['uri'])) {
            ?>
            <a href="<? print $value['link']; ?>">
              <img src="<?= image_style_url('home_cadernos', $value['uri']); ?>" height="143" width="191"  alt="<?= $value['titulo'] ?>" class="imgH6Grande" />
            </a>  
            <?
          }
          ?>
          <h4><a href="<? print $value['link']; ?>"><?= $value['titulo']; ?></a></h4>
          <p><a href="<? print $value['link']; ?>"><? print $value['conteudo']; ?></a></p>
          <div class="tagsExibir">
          </div>
        </li>        
<? endforeach; ?>   
      <!--end looping -->
    </ul>
    <?php if ($pager): ?>
      <?php print $pager; ?>
<?php endif; ?>
  </div>
</div>

<?php if (pager_find_page() == 0): ?>
  <script>

    // Load the Azur theme
    Galleria.loadTheme('<?php print $scriptThemeGalleria; ?>');

    //configurando a Galleria
    Galleria.configure({
      _locale: {
        show_captions: 'Mostrar legendas',
        hide_captions: 'Ocultar legendas',
        play: 'Iniciar slideshow',
        pause: 'Parar slideshow',
        enter_fullscreen: 'Ver em fullscreen',
        exit_fullscreen: 'Sair do  fullscreen',
        next: 'Próxima imagem',
        prev: 'Imagem anterior',
        showing_image: 'Mostrando imagem %s a %s'
      }
    });
    // Initialize Galleria
    Galleria.run('#galleria', {
      autoplay: 7000 // will move forward every 7 seconds
    });

  </script>
<?php endif; ?>
