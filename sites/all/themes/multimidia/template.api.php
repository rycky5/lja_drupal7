<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Função que prepara array e envia para o template as avariaves para montagem do MENU.
 *
 * @param type $vars
 */
function init_menu(&$vars)
{

    $vSubCategoriasCache = cache_get('cacheSubCategorias');

    if(true){
        db_set_active("default"); //"default"
        // Popular variável com as subcategorias de acordo com a taxonomia.
        $result = db_query("SELECT t.tid,t.name,tv.machine_name
                       FROM taxonomy_term_data t
                       INNER JOIN taxonomy_vocabulary as tv ON tv.vid = t.vid
                       WHERE tv.machine_name <> 'tags'
                       ORDER BY t.weight ASC;");

        $vSubCategorias = $result->fetchAll();

       foreach ($vSubCategorias as $sub){
   	$arrSubCategorias[$sub->machine_name][] = array('tid' => $sub->tid, 'title' => $sub->name);
       }

       // Grava ou atualiza o cache.
       cache_set('cacheSubCategorias',$arrSubCategorias,'cache',60*30);
    }else{
      $arrSubCategorias = $vSubCategoriasCache->data;
    }

    $vars['vSubCategorias'] = $arrSubCategorias;


    $vSubMaisLidasCache = cache_get('cacheSubMaisLidas');
    if(empty($vSubMaisLidasCache)){

        // Recuperando as notícias mais lidas
        $vSubMaisLidas = getMaisLidasCadernos("");
//        echo "<pre>";
//        var_dump($vSubMaisLidas);
//        die;
        $arrSubMaisLidas = array();
        foreach ($vSubMaisLidas as $mais){
   	  $arrSubMaisLidas[$mais->machine_name][] = $mais;
        }
        // Grava ou atualiza o cache
        cache_set('cacheSubMaisLidas',$arrSubMaisLidas,'cache',60*30);
    }else{
      $arrSubMaisLidas = $vSubMaisLidasCache->data;
    }
    $vars['vSubMaisLida'] = $arrSubMaisLidas;
    
    //para ser utilizado em multimidia
    $vars['maisLidasMultimidia']=$vSubMaisLidas;

    $vUltimasNoticiasCache = cache_get('cacheSubConteudos');

    if(empty($vUltimasNoticiasCache)){

        // Carrega os conteudos do submenu.
        $vUltimasNoticias['noticias']   = getConteudoMenu("caderno_noticias", array('pQtd' => 3));
        $vUltimasNoticias['carreiras']  = getConteudoMenu("caderno_carreiras", array('pQtd' => 3));
        $vUltimasNoticias['esportes']   = getConteudoMenu("caderno_esportes", array('pQtd' => 3));
        $vUltimasNoticias['politica']   = getConteudoMenu("caderno_politica", array('pQtd' => 3));
        $vUltimasNoticias['cultura']    = getConteudoMenu("caderno_cultura", array('pQtd' => 3));
        $vUltimasNoticias['tecnologia'] = getConteudoMenu("caderno_tecnologia", array('pQtd' => 3));
        $vUltimasNoticias['multimidia'] = getSubmenuMultimidia();

        cache_set('cacheSubConteudos', $vUltimasNoticias, 'cache_page', CACHE_TEMPORARY);
    }else{
       $vUltimasNoticias = $vUltimasNoticiasCache->data;
    }

    $vars['vSubConteudos'] = $vUltimasNoticias;
    $vars['corCategoria']  = array('noticias' => 'vermelho',
                                  'carreiras' => 'roxo',
                                  'esportes' => 'verde',
                                  'tecnologia' => 'azulClaro',
                                  'cultura' => 'laranja',
                                  'multimidia' => 'azulClaro');
}


?>