<?php
/**
 * Description of LeitorXML
 *
 * @author 010106227
 */
class LeitorXML {
  protected $title;
	protected $link;
	protected $itens;
	protected $info;
	protected $description;

	function __construct($file){
		$this->info = simplexml_load_file($file);
		$this->title = $this->info->channel->title; //titulo do RSS
		$this->link = $this->info->channel->link; //link para a pagina do RSS
		$this->itens = $this->info->channel->item;
		$this->description = $this->info->channel->description;
                $this->description = str_replace('[@#galeria#@]', '', $this->info->channel->description);
                $this->textoNews = '';
}

	function reader(){
            echo "<ul>";
		//echo "<h5><a href=\"" . $this->link . "\"> ".utf8_decode($this->title)." </a></h5>";
		//echo "<p><a href=\"". $this->link . "\">" . $this->link . "</a></p>";
		for ($i = 0; $i < 3; $i++){
                    $this->textoNews = limitaTexto(strip_tags($this->itens[$i]->description), '100');
                    echo "<li>";
                    echo "<h2><a target='_blank' href=\"" . $this->itens[$i]->link . "\">". $this->itens[$i]->title .'</a></h2>';
                    $x = strtotime($this->itens[$i]->pubDate);
                    echo '<h2>' . date('d/m/Y') . '</h2>';
                    echo "<p>" .str_replace('##RECOMENDA##','',$this->textoNews)."</p><br>";
                    echo "</li>";
		}
                echo"</ul>";
	}
}
$xml = new LeitorXML("http://www.leiaja.com/assinar");
$xml->reader();


function limitaTexto($string, $limit, $break=" ", $pad="...") {
	// return with no change if string is shorter than $limit
	if(strlen($string) <= $limit)
		return $string; 
 
	// is $break present between $limit and the end of the string?
	if(false !== ($breakpoint = strpos($string, $break, $limit))) {
		if($breakpoint < strlen($string) - 1) {
			$string = substr($string, 0, $breakpoint) . $pad;
		}
	}
    return $string;
}