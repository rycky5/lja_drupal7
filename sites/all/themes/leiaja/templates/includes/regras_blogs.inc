<?php

function getClasseBlogs(){
    
    $vars = get_defined_vars();
    //obtendo o tipo do blog
    $tipoBlog = strtolower($vars['variables']['node']->field_catblog['pt-br'][0]['taxonomy_term']->name);
    $tipoHomeBlog = strtolower($vars['variables']['page']['content2']['system_main']['term_heading']['term']['#term']->name);

    if(!empty($tipoBlog)){$classes_v2 = 'blog_'.$tipoBlog;}
    elseif(!empty($tipoHomeBlog)){$classes_v2 = 'blog_'.$tipoHomeBlog;}
        
return $classes_v2;
} 
   
?>