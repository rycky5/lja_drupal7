<?php
$vTmp = file_get_contents('http://api.getclicky.com/api/stats/4?site_id=66504528&sitekey=dc304fb62ab3a783&type=visitors-online');
$xml = new SimpleXMLElement($vTmp);
echo $xml->type->date->item->value[0];
