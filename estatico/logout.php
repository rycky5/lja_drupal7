<?php
/**
 * Arquivo que conterá a função de destruir a sessão do usuário tanto para o drupal quanto para sessão estatica
 * 
 * 
 * @author Alberto Medeiros <alberto.medeiros@sereducacional.com>
 */
// Iniciando a sessão
session_start();

// Destruindo a sessão do usuário
session_destroy();