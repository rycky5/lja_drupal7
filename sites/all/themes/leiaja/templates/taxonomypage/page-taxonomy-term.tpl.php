<style>
  .bloco-topo-taxonomia{font-family:arial}
  .bloco-topo-taxonomia ul li a img{display:none}
  .bloco-topo-taxonomia ul li.views-row-1 a img,.bloco-topo-taxonomia ul li.views-row-5 a img,.bloco-topo-taxonomia ul li.views-row-8 a img{display:block}
  .bloco-topo-taxonomia ul li a{color: #4C4B4C;text-decoration:none}
  .topicos-taxonomia{font-size:11px;}
  .topicos-taxonomia a{color:#000}
  .topicos-taxonomia a:hover{text-decoration: underline}
  .bloco-topo-taxonomia .views-row-1 .imagem-destaque img{margin-right: 25px;}
  .bloco-topo-taxonomia .views-row-1 .titulo-noticia,.bloco-topo-taxonomia .views-row-2 .titulo-noticia{border-bottom: 1px dotted #AAA;width: 300px;float: left;padding-bottom: 15px;font-size: 26px}
  .bloco-topo-taxonomia .titulo-noticia a{}
  .bloco-topo-taxonomia .views-row.views-row-2,.bloco-topo-taxonomia .views-row.views-row-1{border-bottom:none;margin:0;}
  .bloco-topo-taxonomia .views-row-3,.bloco-topo-taxonomia .views-row-6{clear: both;}
  .bloco-topo-taxonomia .views-row.views-row-3,.bloco-topo-taxonomia .views-row.views-row-6{margin:25px 0 0 0;}
  .bloco-topo-taxonomia .views-row{border-bottom: 1px dotted #AAA;margin: 25px 0 0 25px;padding-bottom: 15px;min-height: 80px;}
  .bloco-topo-taxonomia .views-row-3,.bloco-topo-taxonomia  .views-row-4,.bloco-topo-taxonomia .views-row-6,.bloco-topo-taxonomia .views-row-7{width: 137px;float: left;font-size: 12.3px;line-height: 19px}
  .bloco-topo-taxonomia .views-row-5,.bloco-topo-taxonomia .views-row-8{font-size: 17px;width: 300px;float:left;}
  .bloco-topo-taxonomia .views-row-5 img,.bloco-topo-taxonomia .views-row-8 img{width:100px;height:75px;margin-right: 15px;}
  
  /*listagem*/
  .maisNoticiasH2 {font-family: Arial,Helvetica,sans-serif;font-size: 20px;margin: 15px 0;color:#EA0C25}
  .listagem-mais-noticias-por-taxonomia{clear:both;font-family: arial;color:#000;float: left;}
  .listagem-mais-noticias-por-taxonomia a{text-decoration: none}
  .listagem-mais-noticias-por-taxonomia a:hover{text-decoration:underline}
  .listagem-mais-noticias-por-taxonomia .titulo-noticia-taxonomia a{color: black;font-size: 16px;}
  .listagem-mais-noticias-por-taxonomia p{font-size: 12px;color: #666;}
  .listagem-mais-noticias-por-taxonomia .tagsExibir a{font-size: 12px;color: #EA0C25;text-decoration: none; font-weight: bold;margin: 0 5px;}
  .listagem-mais-noticias-por-taxonomia .tagsExibir h5{margin-right: 10px}
</style>
<?php
//echo "<pre>";
//var_dump('$variavel');
//die;
/**
 * @file
 * Default theme implementation to display a term.
 *
 * Available variables:
 * - $name: the (sanitized) name of the term.
 * - $content: An array of items for the content of the term (fields and
 *   description). Use render($content) to print them all, or print a subset
 *   such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $term_url: Direct url of the current term.
 * - $term_name: Name of the current term.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - taxonomy-term: The current template type, i.e., "theming hook".
 *   - vocabulary-[vocabulary-name]: The vocabulary to which the term belongs to.
 *     For example, if the term is a "Tag" it would result in "vocabulary-tag".
 *
 * Other variables:
 * - $term: Full term object. Contains data that may not be safe.
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $page: Flag for the full page state.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the term. Increments each time it's output.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_taxonomy_term()
 * @see template_process()
 */
?>
<div id="taxonomy-term-<?php print $term->tid; ?>" class="<?php print $classes; ?>">
    <?php
    $objTax = taxonomy_term_load($term->tid);
    $term->tid = ($objTax->name=="")?"all":$term->tid;
    $viewTopo = views_get_view('taxonomy_term_rewrite');
    $displayName = 'topo';
    //setando o $id_taxonomia no display do campo correto
    $viewTopo->display[$displayName]->display_options["arguments"]['term_node_tid_depth']["default_argument_options"]["argument"] = $term->tid;
    //setando o display desejado.
    $viewTopo->set_display($displayName);
    $viewTopo->pre_execute();
    $viewTopo->execute();
    //setando o resultado da view na variavel vUltimasSubcategoria;
    $nodes = $viewTopo->result;

    //array de nid's separados por vírgula;
    $arrayNids = array();
    foreach($nodes as $key=>$node):
      $arrayNids[]= $node->nid;
    endforeach;
    $nids = implode(',', $arrayNids);
    //listagem
    $view = views_get_view('taxonomy_term_rewrite');
    $displayName = 'page';
    //setando o $id_taxonomia no display do campo correto
    $view->display[$displayName]->display_options["arguments"]["tid"]["default_argument_options"]["argument"] = $term->tid;
   
    if(pager_find_page()!= 0):
      //setando o valor 'all' para retornar todos os resultados;
      $nids = 'all';
      //alterando o numero de views por pagina
      $view->display[$displayName]->display_options["pager"]["options"]["items_per_page"] = '20';
    endif;
    //setando os nids que devem ser ignorados pela view;
    $view->display[$displayName]->display_options["arguments"]["nid"]["default_argument_options"]["argument"] = $nids;
    
    //setando o display desejado.
    $view->set_display($displayName);
    $view->pre_execute();
    $view->execute();
    //views_embed_view($name)
  ?>
  <?php if (!$page): ?>
    <h2><a href="<?php print $term_url; ?>"><?php print $term_name; ?></a></h2>
  <?php endif; ?>
  <?php 
    //para o topo ser exibido apenas na pagina 0 - inicial de tags;
    if(pager_find_page()== 0):
        print $viewTopo->render('topo');
    endif; 
  ?>
  <?php 
    //renderizando a view com o display desejado;
    print retiraHash($view->render($displayName));
  ?>
</div>