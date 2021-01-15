<?php

/**
 * Arquivo que conterá as pages call back do módulo
 * 
 * @author Alberto Medeiros
 * @version 1.1
 */
// Includes necessários
module_load_include('inc', 'nodeestatica', 'nodeestatica.api');

/**
 * Método que irá receber a notícia e irá retornar apenas o conteúdo da mesma
 * 
 * @param int $nid 
 */
function page_htmlnode() {
    try {
        // Recuperando a hash
        $idNode = (isset($_REQUEST['idNode'])) ? $_REQUEST['idNode'] : null;

        $objNode = node_load($idNode);

        // Validando pra ver se a notícia foi informada
        if (!$objNode) {
            $idNode = (isset($idNode)) ? $idNode : 0;
            watchdog('Node Estática', "[page_htmlnode] Node não encontrado, erro na geração do node: " . $idNode, null, WATCHDOG_WARNING);
            return false;
        }

        // Exibindo o view da node
        $node_view = node_view($objNode, "full");
        
        // Renderizado a notícia
        echo drupal_render($node_view);
    } catch (Exception $exc) {
        watchdog('Node Estática', "[page_htmlnode] ".$exc->getMessage() . $exc->getTraceAsString(), null, WATCHDOG_ERROR);
    }
}

/**
 * Método que irá retornar a estrutura para montar o conteúdo da notícia
 * 
 * @return Theme 
 */
function page_htmlestrutura() 
{
    // Retornando a estrutura da notícia
    return theme("estrutura-node");
}

/**
 * Método que irá gerar as capas de cada caderno
 * 
 */
function page_cronestrutura() 
{
    // Geração do topo e footer da estrutura das nodes estáticas
    api_gerarEstruturaNode();
    
    // Geração de estáticos para nodes agendados.
    api_executaCron();
}