
<?php 
 $path = '.';
 $files = scandir($path);
 $string = 'var listBoxes = [';

 foreach ($files as $value) {
 	$string .=  '"'.$value . '", ';
 }
 $string .= ']';
 print $string; 

?>