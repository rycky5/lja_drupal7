<?php
//Template Principal da capa multimidia
//VERSAO

drupal_add_js(drupal_get_path('module', 'capa') . '/js/abas.js');
module_load_include('inc', 'capa', 'capa');

$pathTema = path_to_theme('multimidia');
require_once $pathTema.'/template/includes/monta_capa_multimidia.inc';

api_montagem_capa();

?>
