<?php
$noticias = views_get_view_result('enviar_email_ig','page_1');

// Pegando o titulo
$titulo = $noticias[0]->_field_data["nid"]["entity"]->title;
$nid = $noticias[0]->nid;
$vPass = (array)$noticias[0]->_field_data['nid']['entity'];
$tidChapeu = getChapeuNoticia($vPass);
$objChapeu = taxonomy_term_load($tidChapeu);
$nomeChapeu = $objChapeu->name;
$texto = $frotUrl = '';
$campoIg = $noticias[0]->_field_data['nid']['entity']->field_ig['und'][0]['value'];

$pNode = $noticias[0]->_field_data['nid']['entity'];
$vMarcIg = verificaConteudoMultimidia($pNode);

if($vMarcIg->abrirLeiaja === TRUE OR ($campoIg == '0' OR !$campoIg)){
    $frotUrl = 'http://www.leiaja.com/';
}else{
    $frotUrl = 'http://pernambuco.ig.com.br/';
}
$linkNode = $frotUrl.drupal_lookup_path('alias',"node/".$nid);

$titulo = @$titulo;
$texto.= '<b>Título:</b> '.$titulo.'<br />';
$texto.= '<b>Chapeu:</b> '.$nomeChapeu.'<br />';
$texto.= '<b>Link:</b> '.$linkNode;

//chamando método para tratar o envio de email
enviar_email_ig('alberto.medeiros@sereducacional.com', $titulo, $texto);
enviar_email_ig("homes <homes@igcorp.com.br>", $titulo, $texto);
enviar_email_ig("brasil <brasil@igcorp.com.br>", $titulo, $texto);
enviar_email_ig("Editores Executivos <editoresexecutivos@igcorp.com.br>", $titulo, $texto);
enviar_email_ig("Editores IG <editoresig@igcorp.com.br>", $titulo, $texto);
enviar_email_ig("redacao@leiaja.com.br", $titulo, $texto);

//redirecionando para a página inicial de envio de email para o ig
$form_state['redirect'] = 'admin/enviar-email-ig';
drupal_redirect_form($form_state);
