 <?php
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'eleicoes').'/template.db.inc';
require_once $_SERVER['DOCUMENT_ROOT'].'/'.drupal_get_path('theme', 'eleicoes').'/template.api.inc';

/**
 * Implementação do hook_preprocess_html
 *
 * @param type $vars
 */
function eleicoes_preprocess_html(&$vars)
{
    
    //Verifica se é uma notícia
    if($node = menu_get_object()){
        
        //Recuperando a image de capa caso ela não vazia
        if(!empty($node->field_capa[key($node->field_capa)][0]["uri"])){
            
            $vars['vMetaImagem'] = image_style_url('large', $node->field_capa[key($node->field_capa)][0]["uri"]);
            
        }elseif($node->field_image[key($node->field_image)][0]["uri"]){
            
            //Recuperando a primeira imagem da galeiria
            $vars['vMetaImagem'] = image_style_url('large', $node->field_image[key($node->field_image)][0]["uri"]);
            
        }
        
        $vars['vMetaTitulo'] = $node->title;
        $vars['vMetaDescription'] = (!empty($node->body[key($node->body)][0]["summary"])) ? $node->body[key($node->body)][0]["summary"] : retiraHash($node->body[key($node->body)][0]["value"]);
       
    }else{
        
        if(arg(0) == 'eleicoes' && arg(1) == null){
            $vars['head_title'] = implode(' | ', array('Eleições', 'Leiajá'));
        }elseif(arg(0) == 'eleicoes' && arg(1) == 'noticias'){
            $vars["head_title"] = implode(" | ", array('Eleições', 'Leiajá - Notícias'));
        }elseif(arg(0) == 'eleicoes' && arg(1) == 'pesquisas'){
            $vars["head_title"] = implode(" | ", array('Eleições', 'Leiajá - Pesquisas'));
        }
        
        $vMetaImagem = '';
        $vMetaTitle = '';
        $vMetaDescription = '';
        $vMetaRefresh = '';
        
        $vMetaImagem = array(
            '#tag' => 'meta', 
            '#attributes' => array(
                'property' => 'og:image',
                'content' => url('sites/all/themes/eleicoes/images/logo.png', array('absolute' => true))
            )
        );
        
        drupal_add_html_head($vMetaImagem, 'meta_image');
        
        $vMetaTitle = array(
            '#tag' => 'meta',
            'atributes' => array(
                'property' => 'og:title',
                'content' => 'Especial Eleições - LeiaJá'
            )
        );
        
        drupal_add_html_head($vMetaTitle, 'meta_title');
        
        $vMetaDescription = array(
            '#tag' => 'meta',
            'atributes' => array(
                'property' => 'og:description',
                'content' => 'Especial do Portal LeiaJá focado na cobertura das eleições municipais.'
            )
        );
        
        drupal_add_html_head($vMetaDescription, 'meta_description');
        
        $vMetaRefresh = array(
            '#tag' => 'meta',
            '#attributes' => array(
                'http-equiv' => 'refresh',
                'content' => '180'
            )
        );
        
        drupal_add_html_head($vMetaRefresh, 'meta-refresh');
    }
    
}


/**
 * Override or insert variables into the page template.
 */
function eleicoes_preprocess_page(&$vars) {
    
    //Incluindo os css
    drupal_add_css(drupal_get_path('theme', 'eleicoes'). '/css/default.css');
    drupal_add_css(drupal_get_path('theme', 'eleicoes'). '/css/component.css');
    drupal_add_css(drupal_get_path('theme', 'eleicoes'). '/css/style.css');
    
    //Incluindo os js
    drupal_add_js(drupal_get_path('theme', 'eleicoes').'/js/modernizr.custom.js');
    
    if((arg(0) == "eleicoes" && arg(1) == NULL) || (arg(0) == "eleicoes-2012") && arg(1) == NULL){
        $vars['theme_hook_suggestions'][] = 'page__front';
    }
    if($_GET['debug'] == 'true'){
      var_dump($vars['theme_hook_suggestions']);
    }
//    else{
//        $vars['theme_hook_suggestions'][] = 'page';
//    }
}