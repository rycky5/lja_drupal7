<?php

function leiaja2_preprocess_page(&$variables, $hook)
{
    
    if (arg(0)=='nodeestatica' && arg(1) == 'htmlestrutura') 
    {
      $variables['theme_hook_suggestions'][] = 'page__node';
    }
}

