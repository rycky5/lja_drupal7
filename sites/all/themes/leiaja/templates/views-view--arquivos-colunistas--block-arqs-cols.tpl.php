<?php

$resultViews = views_get_view_result('arquivos_colunistas', 'block_arqs_cols');
$vars = get_defined_vars();
$tid = $vars['variables']['view']->args[0];
$linkTerm  =  drupal_lookup_path('alias','taxonomy/term/'.$tid);
$meses = array('01' => 'Janeiro','02' => 'Fevereiro','03' => 'Março','04' => 'Abril','05' => 'Maio','06' => 'Junho','07' => 'Julho','08' => 'Agosto','09' => 'Setembro','10' => 'Outubro','11' => 'Novembro','12' =>'Dezembro');
print '<div class="contentDireitaColunistas">
<h3><a href="javascript:void(0);" title="Arquivos" class="cinza" style="margin-top:25px">Arquivo</a></h3>  
<ul class="colunistas">';
foreach ($resultViews as $value) {
    $mes  = substr($value->created_year_month, -2);
    $ano = substr($value->created_year_month, 0, -2);
    if($ano == date('Y')){
        echo "<li><span>&raquo;</span><a title='{$meses[$mes]} {$ano}' href='/{$linkTerm}?mes={$mes}&ano={$ano}'>{$meses[$mes]} {$ano} ({$value->num_records})</a></li>";
    }elseif($count == 0){
        echo "<li><span>&raquo;</span><a title='Posts de {$ano}' href='/{$linkTerm}?ano={$ano}'>Posts de {$ano}</a></li>";
        $count ++;
    }
}
print '</ul></div>';
?>