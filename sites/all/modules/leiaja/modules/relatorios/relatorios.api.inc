<?
setlocale(LC_ALL, "pt_BR", "ptb");

// includes
module_load_include('inc','relatorios','relatorios.db');

## relatorios de publicacoes ##
## cadernos
// filtro e relatorio
/**
 * @param   [int $mes], [int $ano]
 * @author  Inaldo Nogueira <inaldo.nogueira@leiaja.com.br>
 * @return  theme form HTML, theme table HTML
 */
function relatorios_de_publicacoes_api_cadernos($mes = false,$ano = false){
  
  $html = '';
  $arr  = array();
  $rows = array();
  
  drupal_add_js(drupal_get_path('module','relatorios').'/relatorios.js');
  
  // Renderiza o form de filtros.
  $html = '<style>.form-item-mes{float:left} .form-item-ano{float:left;padding-left:10px;}</style>';
  $html .= drupal_render(drupal_get_form('relatorios_de_publicacoes_api_cadernos_form_filtro',$mes,$ano));
  
  if((bool)$mes && (bool)$ano){
    
    $cadernos = relatorios_de_publicacoes_db_get(array('lista_de_cadernos'=>true));
    
    // cabeçalho da tabela HTML
    $header = array(
      array('data'=>'Dia'),
    );
    foreach($cadernos as $caderno){
      $header[] = array('data'=>str_replace('caderno_','',$caderno->nome));
    }
    $header[] = array('data'=>'total');
    
    // relatorio 
    $relatorio = relatorios_de_publicacoes_db_get(array('relatorio'=>true,'cadernos'=>$cadernos,'mes'=>$mes,'ano'=>$ano));
    
    // $rows[]
    foreach ($relatorio as $relatorio_dia){

      $linha = array();
      $linha[] = $relatorio_dia['dia'].' - '.ucfirst(utf8_encode(strftime('%a',mktime(0,0,0,$mes,$relatorio_dia['dia'],$ano))));;
      
      $total_dia      = 0;
      foreach($relatorio_dia['cadernos'] as $relatorio_dia_caderno){
        if(is_object($relatorio_dia_caderno)){
          $linha[]    = (int)$relatorio_dia_caderno->qtd_publicoes;
          $total_dia += $relatorio_dia_caderno->qtd_publicoes; 
        }else{
          $linha[] = $relatorio_dia_caderno; //0
        }
      }
      $linha[] = $total_dia;
      $rows[]  = array('data' => $linha);
    }
    
    // $total_cadernos[]
    $total_cadernos = array('total');
    foreach($rows as $row){
    
      $count = count($row['data']);
      
      for($x = 1;$x < $count;$x++){
        if(empty($total_cadernos[$x])){
          $total_cadernos[$x] = 0;
        }
        $total_cadernos[$x] += $row['data'][$x];
      }
    }
    $rows[]  = array('data' => $total_cadernos);
    
    // $medias_diaria
    $medias_diaria = array('média diária');
    $dias          = count($rows)-1;
    array_shift($total_cadernos);
    foreach($total_cadernos as $total_caderno){
      $medias_diaria[] = number_format($total_caderno/$dias,1);
    }
    $rows[]  = array('data' => $medias_diaria);
    
    // theme 'table'
    $arr['header'] = $header;
    $arr['rows'] = $rows;

    $caption  = 'Relatório de publicações em cadernos para o mês '.$mes.'/'.$ano;
    $empty    = 'Nenhuma publicação em cadernos no mês '.$mes.'/'.$ano.'...';
    
    $html .= theme('table',
                  array('header' => $arr['header'],
                        'rows' => $arr['rows'],
                        'caption' => $caption,
                        'sticky' => TRUE,
                        'empty' => $empty,
                  )
              );
    // theme 'pager'
    $html .= theme('pager',array('tags' => array()));
  }
  
  return $html;
}
// filtro
/**
 * @param   arr $form, arr &$form_state
 * @author  Inaldo Nogueira <inaldo.nogueira@leiaja.com.br>
 * @return  arr
 */
function relatorios_de_publicacoes_api_cadernos_form_filtro($form,&$form_state){
  
  $mes = $form_state['build_info']['args'][0];
  $ano = $form_state['build_info']['args'][1];
  
  $form['#action'] = '/admin/reports/relatorios_de_publicacoes/cadernos';
  // Formulário para filtros 
  $form['filtro'] = array(
    '#type' => 'fieldset',
    '#title' => t('Filtro'),
  );
  
  // mes
  $options_mes = array();
  for($x1 = 1;$x1 <= 12;$x1++){
    $options_mes[$x1] = $x1;
  }
  $form['filtro']['mes'] = array(
    '#type' => 'select',
    '#title' => 'Mês',
    '#options' => $options_mes,
    '#default_value' => date('n')
  );
  // ano
  $options_ano = array();
  for($x2 = 2011;$x2 <= date('Y');$x2++){
    $options_ano[$x2] = $x2;
  }
  $form['filtro']['ano'] = array(
    '#type' => 'select',
    '#title' => 'Mês',
    '#options' => $options_ano,
    '#default_value' => date('Y')  
  );
  // submit
  $form['filtro']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Filtrar'),
    '#prefix' => '<div style="float:left;padding-top:33px;margin-left:8px;">',
    '#suffix' => '</div>',
    '#attributes' => array(
      'style' => array('cursor:pointer'),
    ),  
  );
  
  // com parâmetro
  if(!empty($mes) && !empty($ano)){
    // mes
    $form['filtro']['mes']['#default_value'] = $mes;
    // ano
    $form['filtro']['ano']['#default_value'] = $ano;
  }

  return $form;
}
## cadernos detalhe
// filtro e relatorio
/**
 * @param   [int $mes], [int $ano]
 * @author  Inaldo Nogueira <inaldo.nogueira@leiaja.com.br>
 * @return  theme form HTML, theme table HTML
 */
function relatorios_de_publicacoes_api_cadernos_detalhe($mes = false,$ano = false){
  
  $html = '';
  $arr  = array();
  $rows = array();
  
  drupal_add_js(drupal_get_path('module','relatorios').'/relatorios.js');
  
  // Renderiza o form de filtros.
  $html = '<style>.form-item-mes{float:left} .form-item-ano{float:left;padding-left:10px;}</style>';
  $html .= drupal_render(drupal_get_form('relatorios_de_publicacoes_api_cadernos_detalhe_form_filtro',$mes,$ano));
  
  if((bool)$mes && (bool)$ano){
    
    $cadernos = relatorios_de_publicacoes_db_get(array('lista_de_cadernos'=>true));
    
    // cabeçalho da tabela HTML
    $header = array(
      array('data'=>'Dia'),
    );
    foreach($cadernos as $caderno){
      $header[] = array('data'=>str_replace('caderno_','',$caderno->nome));
    }
    $header[] = array('data'=>'total');
    
    // relatorio 
    $relatorio = relatorios_de_publicacoes_db_get(array('relatorio'=>true,'cadernos'=>$cadernos,'mes'=>$mes,'ano'=>$ano));
    
    // $rows[]
    foreach ($relatorio as $relatorio_dia){

      $linha = array();
      $linha[] = $relatorio_dia['dia'].' - '.ucfirst(utf8_encode(strftime('%a',mktime(0,0,0,$mes,$relatorio_dia['dia'],$ano))));;
      
      $total_dia_qtd_publicoes = 0;
      $total_dia_leiaja        = 0;  
      foreach($relatorio_dia['cadernos'] as $relatorio_dia_caderno){
        if(is_object($relatorio_dia_caderno)){
          $linha[]                  = (int)$relatorio_dia_caderno->qtd_publicoes.' / '.(int)$relatorio_dia_caderno->leiaja.' ('.round(($relatorio_dia_caderno->leiaja/$relatorio_dia_caderno->qtd_publicoes)*100).'%)';
          $total_dia_qtd_publicoes += $relatorio_dia_caderno->qtd_publicoes; 
          $total_dia_leiaja        += $relatorio_dia_caderno->leiaja;
        }else{
          $linha[] = $relatorio_dia_caderno; //0
        }
      }
      $linha[] = $total_dia_qtd_publicoes.' / '.$total_dia_leiaja.' ('.round(($total_dia_leiaja/$total_dia_qtd_publicoes)*100).'%)';
      $rows[]  = array('data' => $linha);
    }
    
    // $total_cadernos[]
    $total_cadernos                 = array('total');
    $total_cadernos_qtd_publicacoes = array(' ');
    $total_cadernos_leiaja          = array(' ');
    foreach($rows as $row){
    
      $count = count($row['data']);
      
      for($x = 1;$x < $count;$x++){
        if(empty($total_cadernos_qtd_publicacoes[$x])){
          $total_cadernos_qtd_publicacoes[$x] = 0;
          $total_cadernos_leiaja[$x]          = 0;
        }
        $total_cadernos_qtd_publicacoes[$x] += $row['data'][$x];
        $total_cadernos_leiaja[$x]          += substr($row['data'][$x],strpos($row['data'][$x],'/')+2);
      }
    }
    
    $count2 = count($total_cadernos_qtd_publicacoes);
    for($y = 1;$y < $count2;$y++){
      $total_cadernos[$y] = $total_cadernos_qtd_publicacoes[$y].' / '.$total_cadernos_leiaja[$y].' ('.round(($total_cadernos_leiaja[$y]/$total_cadernos_qtd_publicacoes[$y])*100).'%)';
    }
    
    $rows[]  = array('data' => $total_cadernos);
    
    // $medias_diaria
    $medias_diaria        = array('média diária');
    $medias_diaria_leiaja = array(' ');
    $dias          = count($rows)-1;
    // $total_cadernos_qtd_publicacoes
    array_shift($total_cadernos_qtd_publicacoes);
    foreach($total_cadernos_qtd_publicacoes as $total_caderno){
      $medias_diaria[] = number_format($total_caderno/$dias,1);
    }
    
    // $total_cadernos_qtd_publicacoes
    array_shift($total_cadernos_leiaja);
    foreach($total_cadernos_leiaja as $total_caderno_leiaja){
      $medias_diaria_leiaja[] = number_format($total_caderno_leiaja/$dias,1);
    }
    $count3 = count($medias_diaria);
    for($z = 1;$z < $count3;$z++){
      $medias_diaria[$z] = $medias_diaria[$z].' / '.$medias_diaria_leiaja[$z];
    }
    
    
    $rows[]  = array('data' => $medias_diaria);
    
    // theme 'table'
    $arr['header'] = $header;
    $arr['rows'] = $rows;

    $caption  = 'Relatório de publicações em cadernos para o mês '.$mes.'/'.$ano;
    $empty    = 'Nenhuma publicação em cadernos no mês '.$mes.'/'.$ano.'...';
    
    $html .= theme('table',
                  array('header' => $arr['header'],
                        'rows' => $arr['rows'],
                        'caption' => $caption,
                        'sticky' => TRUE,
                        'empty' => $empty,
                  )
              );
    // theme 'pager'
    $html .= theme('pager',array('tags' => array()));
  }
  
  return $html;
}
// filtro
/**
 * @param   arr $form, arr &$form_state
 * @author  Inaldo Nogueira <inaldo.nogueira@leiaja.com.br>
 * @return  arr
 */
function relatorios_de_publicacoes_api_cadernos_detalhe_form_filtro($form,&$form_state){
  
  $mes = $form_state['build_info']['args'][0];
  $ano = $form_state['build_info']['args'][1];
  
  $form['#action'] = '/admin/reports/relatorios_de_publicacoes/cadernos_detalhe';
  // Formulário para filtros 
  $form['filtro'] = array(
    '#type' => 'fieldset',
    '#title' => t('Filtro'),
  );
  
  // mes
  $options_mes = array();
  for($x1 = 1;$x1 <= 12;$x1++){
    $options_mes[$x1] = $x1;
  }
  $form['filtro']['mes'] = array(
    '#type' => 'select',
    '#title' => 'Mês',
    '#options' => $options_mes,
    '#default_value' => date('n')
  );
  // ano
  $options_ano = array();
  for($x2 = 2011;$x2 <= date('Y');$x2++){
    $options_ano[$x2] = $x2;
  }
  $form['filtro']['ano'] = array(
    '#type' => 'select',
    '#title' => 'Mês',
    '#options' => $options_ano,
    '#default_value' => date('Y')  
  );
  // submit
  $form['filtro']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Filtrar'),
    '#prefix' => '<div style="float:left;padding-top:33px;margin-left:8px;">',
    '#suffix' => '</div>',
    '#attributes' => array(
      'style' => array('cursor:pointer'),
    ),  
  );
  
  // com parâmetro
  if(!empty($mes) && !empty($ano)){
    // mes
    $form['filtro']['mes']['#default_value'] = $mes;
    // ano
    $form['filtro']['ano']['#default_value'] = $ano;
  }

  return $form;
}
## blogs da redacao
// filtro e relatorio
/**
 * @param   [int $mes], [int $ano]
 * @author  Inaldo Nogueira <inaldo.nogueira@leiaja.com.br>
 * @return  theme form HTML, theme table HTML
 */
function relatorios_de_publicacoes_api_blogs_da_redacao($mes = false,$ano = false){
  
  $html = '';
  $arr  = array();
  $rows = array();
  
  drupal_add_js(drupal_get_path('module','relatorios').'/relatorios.js');
  
  // Renderiza o form de filtros.
  $html = '<style>.form-item-mes{float:left} .form-item-ano{float:left;padding-left:10px;}</style>';
  $html .= drupal_render(drupal_get_form('relatorios_de_publicacoes_api_blogs_da_redacao_form_filtro',$mes,$ano));
  
  if((bool)$mes && (bool)$ano){
    
    $blogs_da_redacao = relatorios_de_publicacoes_db_get(array('lista_de_blogs_da_redacao'=>true));
    
    // cabeçalho da tabela HTML
    $header = array(
      array('data'=>'Dia'),
    );
    foreach($blogs_da_redacao as $blog_da_redacao){
      $header[] = array('data'=>$blog_da_redacao->nome);
    }    
    //adiciona ao header os nomes dos blogs/tipos de conteúdos da base
    foreach(db_getConteudoBlogs() as $nomeBlog){
      $header[] = array('data'=>$nomeBlog['nome']);
    }    
    
    $header[] = array('data'=>'total');
    
    // $relatorio
    $relatorio = relatorios_de_publicacoes_db_get(array('relatorio'=>true,'blogs_da_redacao'=>$blogs_da_redacao,'mes'=>$mes,'ano'=>$ano));    
    
    $relatorioBaseNova = db_getQtdPublicacaoBlogs($mes,$ano);
        
    foreach ($relatorio as $key=>$relatorio_dia){
      
      $linha = array();
      $linha[] = $relatorio_dia['dia'].' - '.ucfirst(utf8_encode(strftime('%a',mktime(0,0,0,$mes,$relatorio_dia['dia'],$ano))));
      
      $total_dia  = 0;

      foreach($relatorio_dia['blogs_da_redacao'] as $relatorio_dia_blog_da_redacao){
        if(is_object($relatorio_dia_blog_da_redacao)){
          $linha[]    = (int)$relatorio_dia_blog_da_redacao->qtd_publicoes;
          $total_dia += $relatorio_dia_blog_da_redacao->qtd_publicoes; 
        }else{
          $linha[] = $relatorio_dia_blog_da_redacao; //0
        }
      }
      
      $relatorioBaseNova[$key];
      
      $total_dia;
      
      
      
      $linha[] = $total_dia;
      $rows[]  = array('data' => $linha);
    }
    
    // $total_blogs_da_redacao 
    $total_blogs_da_redacao = array('total');
    foreach($rows as $row){
    
      $count = count($row['data']);
      
      for($x = 1;$x < $count;$x++){
        if(empty($total_blogs_da_redacao[$x])){
          $total_blogs_da_redacao[$x] = 0;
        }
        $total_blogs_da_redacao[$x] += $row['data'][$x];
      }
    }
    $rows[]  = array('data' => $total_blogs_da_redacao);
    
    // $medias_diaria
    $medias_diaria = array('média diária');
    $dias          = count($rows)-1;
    array_shift($total_blogs_da_redacao);
    foreach($total_blogs_da_redacao as $total_blog_da_redacao){
      $medias_diaria[] = number_format($total_blog_da_redacao/$dias,1);
    }
    $rows[]  = array('data' => $medias_diaria);
    
    // theme 'table'
    $arr['header'] = $header;
    $arr['rows'] = $rows;

    $caption  = 'Relatório de publicações nos blogs da redação para o mês '.$mes.'/'.$ano;
    $empty    = 'Nenhuma publicação nos blogs da redação no mês '.$mes.'/'.$ano.'...';
    
    $html .= theme('table',
                  array('header' => $arr['header'],
                        'rows' => $arr['rows'],
                        'caption' => $caption,
                        'sticky' => TRUE,
                        'empty' => $empty,
                  )
              );
    // theme 'pager'
    $html .= theme('pager',array('tags' => array()));
  }
  
  return $html;
}
// filtro
/**
 * @param   arr $form, arr &$form_state
 * @author  Inaldo Nogueira <inaldo.nogueira@leiaja.com.br>
 * @return  arr
 */
function relatorios_de_publicacoes_api_blogs_da_redacao_form_filtro($form,&$form_state){
  
  $mes = $form_state['build_info']['args'][0];
  $ano = $form_state['build_info']['args'][1];
  
  $form['#action'] = '/admin/reports/relatorios_de_publicacoes/blogs_da_redacao';
  // Formulário para filtros 
  $form['filtro'] = array(
    '#type' => 'fieldset',
    '#title' => t('Filtro'),
  );
  
  // mes
  $options_mes = array();
  for($x1 = 1;$x1 <= 12;$x1++){
    $options_mes[$x1] = $x1;
  }
  $form['filtro']['mes'] = array(
    '#type' => 'select',
    '#title' => 'Mês',
    '#options' => $options_mes,
    '#default_value' => date('n')
  );
  // ano
  $options_ano = array();
  for($x2 = 2011;$x2 <= date('Y');$x2++){
    $options_ano[$x2] = $x2;
  }
  $form['filtro']['ano'] = array(
    '#type' => 'select',
    '#title' => 'Mês',
    '#options' => $options_ano,
    '#default_value' => date('Y')  
  );
  // submit
  $form['filtro']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Filtrar'),
    '#prefix' => '<div style="float:left;padding-top:33px;margin-left:8px;">',
    '#suffix' => '</div>',
    '#attributes' => array(
      'style' => array('cursor:pointer'),
    ),  
  );
  
  // com parâmetro
  if(!empty($mes) && !empty($ano)){
    // mes
    $form['filtro']['mes']['#default_value'] = $mes;
    // ano
    $form['filtro']['ano']['#default_value'] = $ano;
  }

  return $form;
}
## especiais
// filtro e relatorio
/**
 * @param   void
 * @author  Inaldo Nogueira <inaldo.nogueira@leiaja.com.br>
 * @return  theme form HTML, theme table HTML
 */
function relatorios_de_publicacoes_api_especiais(){
  
  $html = '';
  $arr  = array();
  $rows = array();
  
  drupal_add_js(drupal_get_path('module','relatorios').'/relatorios.js');
  
  // Renderiza o form de filtros.
  $html = '<style>.form-item-mes{float:left} .form-item-ano{float:left;padding-left:10px;}</style>';
  $html .= drupal_render(drupal_get_form('relatorios_de_publicacoes_api_especiais_form_filtro',$mes,$ano));
  
  // cabeçalho da tabela HTML
  $rows     = array();
  $header   = array();
  $header[] = array('data'=>'Especias');
  $header[] = array('data'=>'Total de publicações');

  // $especiais
  $especiais = relatorios_de_publicacoes_db_get(array('lista_de_especiais'=>true));

  // $dados
  $dados = relatorios_de_publicacoes_db_get(array('relatorio'=>true,'especiais'=>$especiais));

  foreach ($dados as $dado) {
    $rows[] = array('data' => array(
        $dado->nome,
        $dado->qtd_publicoes
    ));
  }

  // theme 'table'
  $arr['header'] = $header;
  $arr['rows'] = $rows;

  $caption  = 'Relatório de publicações em especiais';
  $empty    = 'Nenhuma publicação em especiais...';

  $html .= theme('table',
                array('header' => $arr['header'],
                      'rows' => $arr['rows'],
                      'caption' => $caption,
                      'sticky' => TRUE,
                      'empty' => $empty,
                )
            );
  // theme 'pager'
  $html .= theme('pager',array('tags' => array()));
  
  return $html;
}
