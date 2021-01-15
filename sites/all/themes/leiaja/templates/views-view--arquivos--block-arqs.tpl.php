<?php
$resultViews = views_get_view_result('arquivos', 'block_arqs');
//echo '<pre>';
//var_dump($resultViews);
//die;
$vars = get_defined_vars();
$term = $vars['variables']['view']->args[0];

$linkTerm  =  'blogs/'.$term;
$meses = array('01' => 'Janeiro','02' => 'Fevereiro','03' => 'Março','04' => 'Abril','05' => 'Maio','06' => 'Junho','07' => 'Julho','08' => 'Agosto','09' => 'Setembro','10' => 'Outubro','11' => 'Novembro','12' =>'Dezembro');
?>

<div class="contentDireitaColunistas">
<h3>Arquivo</h3>  
<ul class="colunistas">
    
<?php
foreach ($resultViews as $value) {
    
    $mes  = substr($value->created_year_month, -2);
    $ano = substr($value->created_year_month, 0, -2);
    $texto = $meses[$mes].' de '.$ano.' ('.$value->num_records.')';
?>
  <li><!--<span>&raquo;</span>--><a title='<?= $texto?>' href='<? print '/blogs/'.$term.'/'. $value->created_year_month?> '><? print $texto;?></a></li>
  
<?php } ?>
  
</ul></div>