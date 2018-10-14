<?php
require "vendor/autoload.php";
use PHPHtmlParser\Dom;
$count = 1;
$myExcel = fopen("Result.csv", "w") or die("Unable to open file!");

$result = " , LINK, DESCRIPCIÓN, ETAPA, FECHA PUBLICACIÓN, PROYECTO CONTRATADO, ESTADO, LOCALIZACIÓN, INVERSIÓN, TIPO DESARROLLO, MUNICIPIO, COLONIA, C.P.:, SECTOR, CATEGORÍA, FECHA INICIO PROBABLE, "
."FECHA TERMINO PROBABLE, CONSTRUCCIÓN, TERRENO, SUCURSAL, Observaciones, Clasificación, Detalles, Descripción extra\n";

fwrite($myExcel, $result);

$row = 1;
if (($handle = fopen("in.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle)) !== FALSE) {
		// echo $data[0];
		writeExcel($data[0]);
    }
    fclose($handle);
}

echo "OK, End";

function writeExcel($url){
	// create curl resource 
	$ch = curl_init(); 
	// echo $url; exit;
	// set url 
	curl_setopt($ch, CURLOPT_URL, trim($url)); 
	// echo $url."\n";
	// echo "http://www.construleads.com/cl20/ficha-obra/?muestra=1&claveProyecto=OC192415";
	// curl_setopt($ch, CURLOPT_URL, "http://www.construleads.com/cl20/ficha-obra/?muestra=1&claveProyecto=OC192415"); 
	

	//return the transfer as a string 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	// $output contains the output string 
	$output = curl_exec($ch);
	
	// close curl resource to free up system resources 
	curl_close($ch);

	$output = substr($output, strpos($output, "<"));
	$output = substr($output, strpos($output, '<div class="row txt-gris">'));
	$output = substr($output, 0, strpos($output, '<!--/row txt-gris-->'));
	// echo $output; exit;
	$dom = new Dom;
	// $dom->loadFromUrl($url);
	// echo $dom;exit;
	// echo $url; exit;
	$opts = array(
		"enforceEcoding" => "utf8",
		"cleanupInput" => true,
		"removeScripts" => true);

	$dom->loadStr($output, $opts);
	// echo $dom;exit;
	$contents = $dom->find('table');

	// var_dump($contents);exit;

	$result = "";

	$result = $GLOBALS['count'].", ".$url;

	$a1 = $dom->find('table')[0]->find('tr')[1]->find('td')[1]->find('h2')->innerHtml ;
	// echo $a1; exit;
	$a2 = $dom->find('table')[0]->find('tr')[1]->find('td')[2]->firstChild()-> nextSibling()-> nextSibling()->innerHtml ;
	$a3 = $dom->find('table')[0]->find('tr')[3]->find('td')[0]->firstChild()-> nextSibling()-> nextSibling()->innerHtml ;
	$a4 = $dom->find('table')[0]->find('tr')[1]->find('td')[3]->firstChild()-> nextSibling()-> nextSibling()->innerHtml ;

	$a5 = $dom->find('table')[1]->find('tr')[1]->find('td')[1]->firstChild()-> nextSibling()-> nextSibling()->innerHtml ;
	$a6 = $dom->find('table')[1]->find('tr')[1]->find('td')[2]->firstChild()-> nextSibling()-> nextSibling()->innerHtml ;
	$a7 = $dom->find('table')[1]->find('tr')[1]->find('td')[3]->firstChild()-> nextSibling()-> nextSibling()->innerHtml ;
	$a8 = $dom->find('table')[1]->find('tr')[1]->find('td')[4]->firstChild()-> nextSibling()-> nextSibling()->innerHtml ;
	$a9 = $dom->find('table')[1]->find('tr')[3]->find('td')[0]->firstChild()-> nextSibling()-> nextSibling()->innerHtml ;
	$a10 = $dom->find('table')[1]->find('tr')[3]->find('td')[1]->firstChild()-> nextSibling()-> nextSibling()->innerHtml ;
	$a11 = $dom->find('table')[1]->find('tr')[3]->find('td')[2]->firstChild()-> nextSibling()-> nextSibling()->innerHtml ;
	$a12 = $dom->find('table')[1]->find('tr')[3]->find('td')[3]->firstChild()-> nextSibling()-> nextSibling()->innerHtml ;

	$a13 = $dom->find('table')[2]->find('tr')[0]->find('td')[0]->find('h4')[0]-> nextSibling()->innerHtml ;
	$a14 = $dom->find('table')[2]->find('tr')[0]->find('td')[0]->find('h4')[1]-> nextSibling()->innerHtml ;
	$a15 = $dom->find('table')[2]->find('tr')[0]->find('td')[0]->find('h4')[2]-> nextSibling()->innerHtml ;
	$a16 = $dom->find('table')[2]->find('tr')[0]->find('td')[0]->find('h4')[3]-> nextSibling()->innerHtml ;
	$a17 = $dom->find('table')[2]->find('tr')[0]->find('td')[0]->find('h4')[4]-> nextSibling()->innerHtml ;

	$a18 = $dom->find('table')[2]->find('tr')[0]->find('td')[1]->find('h4')[1]-> nextSibling()->innerHtml ;
	$a18 = $a18 . $dom->find('table')[2]->find('tr')[0]->find('td')[1]->find('h4')[1]-> nextSibling()-> nextSibling()-> nextSibling()->innerHtml ;	
	$a19 = $dom->find('table')[2]->find('tr')[0]->find('td')[1]->find('h4')[3]-> nextSibling()->innerHtml ;
	$a20 = $dom->find('table')[2]->find('tr')[0]->find('td')[2]->find('h4')[0]-> nextSibling()->innerHtml ;
	$a21 = $dom->find('table')[2]->find('tr')[0]->find('td')[2]->find('h4')[1]-> nextSibling()->innerHtml ;
	$a22 = $dom->find('table')[2]->find('tr')[0]->find('td')[2]->find('h4')[2]-> nextSibling()->innerHtml ;

	$result = $result . makeDot($a1).makeDot($a2).makeDot($a3).makeDot($a4).makeDot($a5).makeDot($a6).makeDot($a7).makeDot($a8).makeDot($a9).makeDot($a10).makeDot($a11).makeDot($a12)
				.makeDot($a13).makeDot($a14).makeDot($a15).makeDot($a16).makeDot($a17).makeDot($a18).makeDot($a19).makeDot($a20).makeDot($a21).makeDot($a22)."\n";

	// $result = $result.makeDot($a19)."\n";
	// echo $result;exit;
	fwrite($GLOBALS["myExcel"], $result);
	$GLOBALS['count'] = $GLOBALS['count']+1;
}

function makeDot($str){
	return ','.str_replace(",", ".", $str);
}