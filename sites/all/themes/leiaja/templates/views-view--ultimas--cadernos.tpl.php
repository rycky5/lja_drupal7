<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// Caso tenha argumento 
$strCaderno = (arg(1) != "") ? "caderno_" . arg(1) : "all";

// Criando a views
$viewVertical = views_get_view('ultimas');
$viewVertical->set_display('bloco_conteudo');
$viewVertical->args = array($strCaderno);
$viewVertical->execute();

// Renderizando o conteúdo da views
$output = $viewVertical->render('bloco_conteudo');

// Renderizando o conteudo
print $output;